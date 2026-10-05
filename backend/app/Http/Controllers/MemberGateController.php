<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\TiketParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MemberGateController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MEMBER MASUK
    |--------------------------------------------------------------------------
    */

    public function masuk(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $input = trim($request->token);

        $tiket = DB::transaction(function () use ($input) {

            // Kunci data member agar dua scan masuk bersamaan
            // tidak membuat dua tiket aktif.
            $member = Member::where('token', $input)
                ->orWhere('kode_member', $input)
                ->lockForUpdate()
                ->first();

            if (!$member) {
                return [
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'QR atau kode member tidak ditemukan.',
                ];
            }

            // Cek pembayaran.
            if (strtolower(trim((string) $member->status)) !== 'lunas') {
                return [
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'Member belum lunas. Silakan lakukan pembayaran terlebih dahulu.',
                ];
            }

            // Cek masa berlaku.
            if (
                $member->tanggal_expired &&
                Carbon::now('Asia/Jakarta')->greaterThan(
                    Carbon::parse($member->tanggal_expired)->setTimezone('Asia/Jakarta')
                )
            ) {
                return [
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'Member sudah expired.',
                ];
            }

            // Hanya satu tiket MASUK yang boleh aktif untuk satu member.
            $sudahMasuk = TiketParkir::where('member_id', $member->id)
                ->where('status', 'masuk')
                ->whereNull('waktu_keluar')
                ->latest('waktu_masuk')
                ->first();

            if ($sudahMasuk) {
                return [
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Member masih berada di area parkir. Harus keluar terlebih dahulu sebelum masuk lagi.',
                    'member' => $member,
                    'data' => $sudahMasuk,
                ];
            }

            // Buat kode tiket internal member.
            do {
                $kode =
                    'M' .
                    now('Asia/Jakarta')->format('YmdHis') .
                    rand(100, 999);

            } while (
                TiketParkir::where('kode_tiket', $kode)->exists()
            );

            $tiket = TiketParkir::create([
                'kode_tiket' => $kode,
                'qr_code' => (string) Str::uuid(),
                'member_id' => $member->id,
                'status' => 'masuk',
                'waktu_masuk' => now('Asia/Jakarta'),
                'waktu_keluar' => null,
                'durasi' => null,
                'jenis_kendaraan' => null,
                'no_polisi' => null,
            ]);

            return [
                'success' => true,
                'status_code' => 200,
                'message' => 'Member valid, pintu terbuka.',
                'member' => $member,
                'data' => $tiket,
            ];
        });

        return response()->json(
            $tiket,
            $tiket['status_code']
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CEK MEMBER UNTUK KELUAR
    |--------------------------------------------------------------------------
    |
    | Digunakan halaman /petugas/member/keluar.
    | Tujuannya hanya mengecek apakah member benar-benar sedang parkir.
    | Belum mengubah status tiket.
    |--------------------------------------------------------------------------
    */

    public function cekKeluar(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $input = trim($request->token);

        $member = Member::where('token', $input)
            ->orWhere('kode_member', $input)
            ->first();

        // Bukan member -> frontend boleh lanjut mencoba sebagai tiket non-member.
        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'QR atau kode member tidak ditemukan.',
            ], 404);
        }

        // Member ada, tetapi harus lunas.
        if (strtolower(trim((string) $member->status)) !== 'lunas') {
            return response()->json([
                'success' => false,
                'message' => 'Member belum lunas. Silakan lakukan pembayaran terlebih dahulu.',
            ], 403);
        }

        // Member yang sudah expired tidak boleh keluar sebagai member aktif.
        if (
            $member->tanggal_expired &&
            Carbon::now('Asia/Jakarta')->greaterThan(
                Carbon::parse($member->tanggal_expired)->setTimezone('Asia/Jakarta')
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Member sudah expired.',
            ], 403);
        }

        // INI PENTING:
        // Member hanya boleh masuk ke halaman konfirmasi keluar
        // jika masih punya tiket MASUK aktif.
        $tiket = TiketParkir::where('member_id', $member->id)
            ->where('status', 'masuk')
            ->whereNull('waktu_keluar')
            ->latest('waktu_masuk')
            ->first();

        if (!$tiket) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak sedang berada di area parkir. Silakan masuk terlebih dahulu.',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Member sedang berada di area parkir.',
            'member' => $member,
            'data' => $tiket,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | MEMBER KELUAR
    |--------------------------------------------------------------------------
    */

    public function keluar(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'jenis_kendaraan' => 'required|in:Motor,Mobil',
            'no_polisi' => 'required|string|max:20',
        ]);

        $input = trim($request->token);

        $hasil = DB::transaction(function () use ($input, $request) {

            // Kunci member selama proses keluar berlangsung.
            $member = Member::where('token', $input)
                ->orWhere('kode_member', $input)
                ->lockForUpdate()
                ->first();

            if (!$member) {
                return [
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'QR atau kode member tidak ditemukan.',
                ];
            }

            if (strtolower(trim((string) $member->status)) !== 'lunas') {
                return [
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'Member belum lunas. Silakan lakukan pembayaran terlebih dahulu.',
                ];
            }

            if (
                $member->tanggal_expired &&
                Carbon::now('Asia/Jakarta')->greaterThan(
                    Carbon::parse($member->tanggal_expired)->setTimezone('Asia/Jakarta')
                )
            ) {
                return [
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'Member sudah expired.',
                ];
            }

            // Hanya tiket MASUK aktif yang boleh keluar.
            $tiket = TiketParkir::where('member_id', $member->id)
                ->where('status', 'masuk')
                ->whereNull('waktu_keluar')
                ->latest('waktu_masuk')
                ->lockForUpdate()
                ->first();

            // Kalau tidak ada, berarti member belum masuk atau sudah keluar.
            if (!$tiket) {
                return [
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Member tidak sedang berada di area parkir. Silakan masuk terlebih dahulu.',
                ];
            }

            $waktuMasuk = Carbon::parse($tiket->waktu_masuk)
                ->setTimezone('Asia/Jakarta');

            $waktuKeluar = Carbon::now('Asia/Jakarta');

            $durasiMenit = $waktuMasuk->diffInMinutes($waktuKeluar);

            $durasiJam = max(
                1,
                (int) ceil($durasiMenit / 60)
            );

            $tiket->update([
                'status' => 'keluar',
                'waktu_keluar' => $waktuKeluar,
                'durasi' => $durasiJam,
                'jenis_kendaraan' => $request->jenis_kendaraan,
                'no_polisi' => strtoupper(trim($request->no_polisi)),
            ]);

            $tiket->refresh();

            return [
                'success' => true,
                'status_code' => 200,
                'message' => 'Member berhasil keluar dari area parkir. Pintu terbuka.',
                'gratis' => true,
                'member' => $member,
                'data' => $tiket,
            ];
        });

        return response()->json(
            $hasil,
            $hasil['status_code']
        );
    }
}
