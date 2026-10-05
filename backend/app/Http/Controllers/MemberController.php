<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberController extends Controller
{
    // =========================================================
    // MENAMPILKAN SEMUA MEMBER
    // =========================================================

    public function index()
    {
        $members = Member::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $members
        ]);
    }


    // =========================================================
    // TAMBAH MEMBER
    // =========================================================

    public function store(Request $request)
    {
        $request->validate([
            'nama_member' => 'required',
            'nama_perusahaan' => 'required',
            'uang_bayar' => 'required|numeric|min:0'
        ]);

        $harga_member = 150000;

        $uang_bayar = (int) $request->uang_bayar;

        $kembalian = $uang_bayar - $harga_member;

        if ($kembalian < 0) {
            $kembalian = 0;
        }

        $status = $uang_bayar >= $harga_member
            ? 'lunas'
            : 'belum lunas';

        $member = Member::create([
            'kode_member' => $this->generateKodeMember(),
            'token' => (string) Str::uuid(),
            'nama_member' => $request->nama_member,
            'nama_perusahaan' => $request->nama_perusahaan,
            'total_harga' => $harga_member,
            'jumlah_bayar' => $uang_bayar,
            'kembalian' => $kembalian,
            'status' => $status,
            'tanggal_mulai' => Carbon::now()->startOfMonth(),
            'tanggal_bayar' => $status === 'lunas'
                ? Carbon::now()
                : null,
            'tanggal_expired' => Carbon::now()->endOfMonth()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Member berhasil dibuat',
            'data' => $member
        ], 201);
    }


    // =========================================================
    // GENERATE KODE MEMBER
    // =========================================================

    private function generateKodeMember()
    {
        do {
            $kode = 'MBR-' . strtoupper(Str::random(6));
        } while (
            Member::where('kode_member', $kode)->exists()
        );

        return $kode;
    }


    // =========================================================
    // DETAIL MEMBER + QR CODE
    // =========================================================

    public function show($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'status' => false,
                'message' => 'Member tidak ditemukan'
            ], 404);
        }

        // QR berisi token member
        $qr = base64_encode(
            QrCode::format('svg')
                ->size(300)
                ->generate($member->token)
        );

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $member->id,
                'kode_member' => $member->kode_member,
                'token' => $member->token,
                'nama_member' => $member->nama_member,
                'nama_perusahaan' => $member->nama_perusahaan,
                'total_harga' => $member->total_harga,
                'jumlah_bayar' => $member->jumlah_bayar,
                'kembalian' => $member->kembalian,
                'status' => $member->status,
                'tanggal_mulai' => $member->tanggal_mulai,
                'tanggal_bayar' => $member->tanggal_bayar,
                'tanggal_expired' => $member->tanggal_expired,
                'qr' => 'data:image/svg+xml;base64,' . $qr
            ]
        ]);
    }


    // =========================================================
    // UPDATE MEMBER / PEMBAYARAN
    // =========================================================

    public function update(Request $request, $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'status' => false,
                'message' => 'Member tidak ditemukan'
            ], 404);
        }

        // Kalau sudah lunas tidak boleh diedit
        if ($member->status === 'lunas') {
            return response()->json([
                'status' => false,
                'message' => 'Member yang sudah lunas tidak dapat diedit'
            ], 400);
        }

        $request->validate([
            'nama_member' => 'required',
            'nama_perusahaan' => 'required',
            'uang_bayar' => 'required|numeric|min:0'
        ]);

        $harga = 150000;

        $uang_bayar = (int) $request->uang_bayar;

        $kembalian = $uang_bayar - $harga;

        if ($kembalian < 0) {
            $kembalian = 0;
        }

        if ($uang_bayar >= $harga) {
            $status = 'lunas';
            $tanggal_bayar = Carbon::now();
            $tanggal_expired = Carbon::now()->endOfMonth();
        } else {
            $status = 'belum lunas';
            $tanggal_bayar = null;
            $tanggal_expired = $member->tanggal_expired;
        }

        $member->update([
            'nama_member' => $request->nama_member,
            'nama_perusahaan' => $request->nama_perusahaan,
            'total_harga' => $harga,
            'jumlah_bayar' => $uang_bayar,
            'kembalian' => $kembalian,
            'status' => $status,
            'tanggal_bayar' => $tanggal_bayar,
            'tanggal_expired' => $tanggal_expired
        ]);

        $member->refresh();

        return response()->json([
            'status' => true,
            'message' => $status === 'lunas'
                ? 'Pembayaran berhasil. Member sekarang lunas.'
                : 'Pembayaran berhasil diperbarui.',
            'data' => $member
        ]);
    }


    // =========================================================
    // HAPUS MEMBER
    // =========================================================

    public function destroy($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'status' => false,
                'message' => 'Member tidak ditemukan'
            ], 404);
        }

        // Member lunas tidak boleh dihapus
        if ($member->status === 'lunas') {
            return response()->json([
                'status' => false,
                'message' => 'Member yang sudah lunas tidak dapat dihapus'
            ], 400);
        }

        $member->delete();

        return response()->json([
            'status' => true,
            'message' => 'Member berhasil dihapus'
        ]);
    }


    // =========================================================
    // CEK MEMBER
    // BISA MENGGUNAKAN QR/TOKEN ATAU KODE MEMBER
    // =========================================================

    public function check(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $input = trim($request->token);

        // Cari berdasarkan token QR ATAU kode member
        $member = Member::where('token', $input)
            ->orWhere('kode_member', $input)
            ->first();

        if (!$member) {
            return response()->json([
                'status' => false,
                'message' => 'QR atau kode member tidak ditemukan'
            ], 404);
        }

        // Cek expired
        if (
            Carbon::now()->greaterThan(
                Carbon::parse($member->tanggal_expired)
            )
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Member sudah expired'
            ], 400);
        }

        // Cek pembayaran
        if ($member->status !== 'lunas') {
            return response()->json([
                'status' => false,
                'message' => 'Member belum melakukan pembayaran',
                'data' => $member
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Member valid',
            'data' => $member
        ]);
    }


    // =========================================================
    // RESET PEMBAYARAN BULANAN
    // =========================================================

    public function resetBulanan()
    {
        Member::query()->update([
            'status' => 'belum lunas',
            'jumlah_bayar' => 0,
            'kembalian' => 0,
            'tanggal_bayar' => null,
            'tanggal_mulai' => Carbon::now()->startOfMonth(),
            'tanggal_expired' => Carbon::now()->endOfMonth()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Semua pembayaran member berhasil direset untuk bulan baru'
        ]);
    }
}