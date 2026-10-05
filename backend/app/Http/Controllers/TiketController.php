<?php

namespace App\Http\Controllers;

use App\Models\TiketParkir;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TiketController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HARGA PARKIR
    |--------------------------------------------------------------------------
    */

    private function getHargaPerJam($jenisKendaraan)
    {
        $jenis = strtolower(
            trim(
                (string) $jenisKendaraan
            )
        );

        if ($jenis === 'motor') {
            return 3000;
        }

        if ($jenis === 'mobil') {
            return 5000;
        }

        return 0;
    }


    /*
    |--------------------------------------------------------------------------
    | BUAT TIKET NON-MEMBER
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'nullable|in:Motor,Mobil',
            'no_polisi' => 'nullable|string|max:20',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CARI KODE TIKET TERAKHIR
        |--------------------------------------------------------------------------
        */

        $last = TiketParkir::whereRaw(
            "kode_tiket REGEXP '^A[0-9]{3}$'"
        )
        ->orderByRaw(
            "CAST(SUBSTRING(kode_tiket, 2, 3) AS UNSIGNED) DESC"
        )
        ->first();


        /*
        |--------------------------------------------------------------------------
        | NOMOR TIKET BERIKUTNYA
        |--------------------------------------------------------------------------
        */

        if ($last) {

            $angka = (int) substr(
                $last->kode_tiket,
                1,
                3
            );

            $nomor = $angka + 1;

        } else {

            $nomor = 1;

        }


        /*
        |--------------------------------------------------------------------------
        | FORMAT KODE TIKET
        |--------------------------------------------------------------------------
        */

        $kode =
            'A' .
            str_pad(
                $nomor,
                3,
                '0',
                STR_PAD_LEFT
            );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN TIKET
        |--------------------------------------------------------------------------
        |
        | QR CODE TETAP PANJANG / UUID
        |
        | Contoh:
        | kode_tiket = A028
        | qr_code    = 8f4b2d91-7a31-4c68-b9f2-xxxxxxxxxxxx
        |
        */

        $qrCode =
            Str::uuid()->toString();


        $tiket = TiketParkir::create([
            'kode_tiket' =>
                $kode,

            'qr_code' =>
                $qrCode,

            'jenis_kendaraan' =>
                $request->jenis_kendaraan,

            'no_polisi' =>
                $request->filled('no_polisi')
                    ? strtoupper(
                        trim(
                            $request->no_polisi
                        )
                    )
                    : null,

            'status' =>
                'masuk',

            'waktu_masuk' =>
                now('Asia/Jakarta'),

            'waktu_keluar' =>
                null,

            'durasi' =>
                null,

            'total_harga' =>
                null,
        ]);


        return response()->json([
            'success' =>
                true,

            'message' =>
                'Tiket berhasil dibuat',

            'data' =>
                $tiket
        ], 201);
    }


    /*
    |--------------------------------------------------------------------------
    | SEMUA TIKET
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $tiket = TiketParkir::latest()
            ->get()
            ->map(function ($item) {

                $hargaPerJam =
                    $this->getHargaPerJam(
                        $item->jenis_kendaraan
                    );


                $totalHarga =
                    $item->total_harga;


                if (
                    $totalHarga === null ||
                    $totalHarga === '' ||
                    (float) $totalHarga <= 0
                ) {

                    if (
                        $item->status === 'keluar' &&
                        $hargaPerJam > 0
                    ) {

                        $durasi =
                            max(
                                1,
                                (int) $item->durasi
                            );

                        $totalHarga =
                            $durasi *
                            $hargaPerJam;

                    } else {

                        $totalHarga = 0;

                    }
                }


                $item->harga_per_jam =
                    $hargaPerJam;

                $item->total_harga =
                    $totalHarga;


                return $item;
            });


        return response()->json([
            'success' =>
                true,

            'data' =>
                $tiket
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL TIKET
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $tiket =
            TiketParkir::find($id);


        if (!$tiket) {

            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Tiket tidak ditemukan'
            ], 404);
        }


        $hargaPerJam =
            $this->getHargaPerJam(
                $tiket->jenis_kendaraan
            );


        $totalHarga =
            $tiket->total_harga;


        if (
            (
                $totalHarga === null ||
                $totalHarga === '' ||
                (float) $totalHarga <= 0
            ) &&
            $tiket->status === 'keluar' &&
            $hargaPerJam > 0
        ) {

            $durasi =
                max(
                    1,
                    (int) $tiket->durasi
                );

            $totalHarga =
                $durasi *
                $hargaPerJam;
        }


        $tiket->harga_per_jam =
            $hargaPerJam;

        $tiket->total_harga =
            $totalHarga;


        return response()->json([
            'success' =>
                true,

            'data' =>
                $tiket
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SCAN / CARI TIKET
    |--------------------------------------------------------------------------
    */

    public function scan(Request $request)
    {
        $qrCode =
            trim(
                (string) $request->input(
                    'qr_code',
                    ''
                )
            );

        $kodeTiket =
            strtoupper(
                trim(
                    (string) $request->input(
                        'kode_tiket',
                        ''
                    )
                )
            );

        $noPolisi =
            strtoupper(
                trim(
                    (string) $request->input(
                        'no_polisi',
                        ''
                    )
                )
            );

        $inputScanner =
            trim(
                (string) (
                    $request->input('code')
                    ?: $request->input('barcode')
                    ?: $request->input('value')
                    ?: $request->input('scan')
                    ?: $request->input('data')
                    ?: ''
                )
            );

        /*
        |--------------------------------------------------------------------------
        | INPUT SCANNER
        |--------------------------------------------------------------------------
        */

        if ($inputScanner !== '') {

            if ($qrCode === '') {
                $qrCode = $inputScanner;
            }

            if ($kodeTiket === '') {
                $kodeTiket =
                    strtoupper(
                        $inputScanner
                    );
            }

            if ($noPolisi === '') {
                $noPolisi =
                    strtoupper(
                        $inputScanner
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN INPUT
        |--------------------------------------------------------------------------
        */

        $qrCode =
            trim(
                preg_replace(
                    '/[\r\n\t]+/',
                    '',
                    $qrCode
                )
            );

        $kodeTiket =
            strtoupper(
                trim(
                    preg_replace(
                        '/[\r\n\t]+/',
                        '',
                        $kodeTiket
                    )
                )
            );

        $noPolisi =
            strtoupper(
                trim(
                    preg_replace(
                        '/[\r\n\t]+/',
                        '',
                        $noPolisi
                    )
                )
            );

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        if (
            $qrCode === '' &&
            $kodeTiket === '' &&
            $noPolisi === ''
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Data scan tidak ditemukan. Silakan scan ulang.',
            ], 422);
        }

        $tiket = null;

        /*
        |--------------------------------------------------------------------------
        | CARI QR CODE
        |--------------------------------------------------------------------------
        |
        | QR non-member harus berisi qr_code UUID asli.
        |
        */

        if ($qrCode !== '') {

            $tiket =
                TiketParkir::where(
                    'qr_code',
                    $qrCode
                )
                ->where(
                    'status',
                    'masuk'
                )
                ->latest(
                    'waktu_masuk'
                )
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | CARI KODE TIKET
        |--------------------------------------------------------------------------
        */

        if (
            !$tiket &&
            $kodeTiket !== ''
        ) {
            $tiket =
                TiketParkir::where(
                    'kode_tiket',
                    $kodeTiket
                )
                ->where(
                    'status',
                    'masuk'
                )
                ->latest(
                    'waktu_masuk'
                )
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | CARI NOMOR POLISI
        |--------------------------------------------------------------------------
        */

        if (
            !$tiket &&
            $noPolisi !== ''
        ) {
            $tiket =
                TiketParkir::where(
                    'no_polisi',
                    $noPolisi
                )
                ->where(
                    'status',
                    'masuk'
                )
                ->latest(
                    'waktu_masuk'
                )
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | SCANNER MEMBACA TEKS PANJANG
        |--------------------------------------------------------------------------
        |
        | Misalnya scanner lama mengirim:
        | Kode Tiket : A028
        |
        | Sistem akan mengambil A028.
        |
        */

        if (
            !$tiket &&
            $inputScanner !== ''
        ) {

            $scannerBersih =
                trim(
                    preg_replace(
                        '/[\r\n\t]+/',
                        '',
                        $inputScanner
                    )
                );

            $scannerUpper =
                strtoupper(
                    $scannerBersih
                );

            preg_match(
                '/\bA\d{3}\b/i',
                $scannerBersih,
                $hasilKode
            );

            $kodeDariScanner =
                isset($hasilKode[0])
                    ? strtoupper(
                        $hasilKode[0]
                    )
                    : '';

            if (
                $kodeDariScanner !== ''
            ) {
                $tiket =
                    TiketParkir::where(
                        'kode_tiket',
                        $kodeDariScanner
                    )
                    ->where(
                        'status',
                        'masuk'
                    )
                    ->latest(
                        'waktu_masuk'
                    )
                    ->first();
            }

            /*
            |----------------------------------------------------------------------
            | KALAU BUKAN KODE TIKET, COBA UUID QR ASLI
            |----------------------------------------------------------------------
            */

            if (!$tiket) {
                $tiket =
                    TiketParkir::where(
                        'qr_code',
                        $scannerBersih
                    )
                    ->where(
                        'status',
                        'masuk'
                    )
                    ->latest(
                        'waktu_masuk'
                    )
                    ->first();
            }

            /*
            |----------------------------------------------------------------------
            | COBA NOMOR POLISI
            |----------------------------------------------------------------------
            */

            if (!$tiket) {
                $tiket =
                    TiketParkir::where(
                        'no_polisi',
                        $scannerUpper
                    )
                    ->where(
                        'status',
                        'masuk'
                    )
                    ->latest(
                        'waktu_masuk'
                    )
                    ->first();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CEK TIKET YANG SUDAH KELUAR
        |--------------------------------------------------------------------------
        */

        if (!$tiket) {

            $tiketSudahKeluar = null;

            if ($qrCode !== '') {
                $tiketSudahKeluar =
                    TiketParkir::where(
                        'qr_code',
                        $qrCode
                    )
                    ->where(
                        'status',
                        'keluar'
                    )
                    ->latest(
                        'waktu_keluar'
                    )
                    ->first();
            }

            if (
                !$tiketSudahKeluar &&
                $kodeTiket !== ''
            ) {
                $tiketSudahKeluar =
                    TiketParkir::where(
                        'kode_tiket',
                        $kodeTiket
                    )
                    ->where(
                        'status',
                        'keluar'
                    )
                    ->latest(
                        'waktu_keluar'
                    )
                    ->first();
            }

            if (
                !$tiketSudahKeluar &&
                $noPolisi !== ''
            ) {
                $tiketSudahKeluar =
                    TiketParkir::where(
                        'no_polisi',
                        $noPolisi
                    )
                    ->where(
                        'status',
                        'keluar'
                    )
                    ->latest(
                        'waktu_keluar'
                    )
                    ->first();
            }

            if (
                !$tiketSudahKeluar &&
                $inputScanner !== ''
            ) {

                $scannerBersih =
                    trim(
                        preg_replace(
                            '/[\r\n\t]+/',
                            '',
                            $inputScanner
                        )
                    );

                preg_match(
                    '/\bA\d{3}\b/i',
                    $scannerBersih,
                    $hasilKode
                );

                if (
                    isset($hasilKode[0])
                ) {

                    $kodeDariScanner =
                        strtoupper(
                            $hasilKode[0]
                        );

                    $tiketSudahKeluar =
                        TiketParkir::where(
                            'kode_tiket',
                            $kodeDariScanner
                        )
                        ->where(
                            'status',
                            'keluar'
                        )
                        ->latest(
                            'waktu_keluar'
                        )
                        ->first();
                }

                if (!$tiketSudahKeluar) {
                    $tiketSudahKeluar =
                        TiketParkir::where(
                            'qr_code',
                            $scannerBersih
                        )
                        ->where(
                            'status',
                            'keluar'
                        )
                        ->latest(
                            'waktu_keluar'
                        )
                        ->first();
                }
            }

            if ($tiketSudahKeluar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket sudah digunakan dan tidak dapat digunakan kembali. Silakan gunakan tiket baru.',
                ], 400);
            }

            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan atau kendaraan sudah keluar.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG DURASI
        |--------------------------------------------------------------------------
        */

        $masuk =
            Carbon::parse(
                $tiket->waktu_masuk
            )->setTimezone(
                'Asia/Jakarta'
            );

        $sekarang =
            Carbon::now(
                'Asia/Jakarta'
            );

        $selisihMenit =
            $masuk->diffInMinutes(
                $sekarang
            );

        $durasi =
            max(
                1,
                (int) ceil(
                    $selisihMenit / 60
                )
            );

        /*
        |--------------------------------------------------------------------------
        | HARGA
        |--------------------------------------------------------------------------
        */

        $hargaPerJam =
            $this->getHargaPerJam(
                $tiket->jenis_kendaraan
            );

        $totalHarga =
            $durasi *
            $hargaPerJam;

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'message' => 'Tiket berhasil ditemukan.',
            'data' => [
                'id' =>
                    $tiket->id,

                'kode_tiket' =>
                    $tiket->kode_tiket,

                'qr_code' =>
                    $tiket->qr_code,

                'jenis_kendaraan' =>
                    $tiket->jenis_kendaraan,

                'no_polisi' =>
                    $tiket->no_polisi,

                'status' =>
                    $tiket->status,

                'waktu_masuk' =>
                    $tiket->waktu_masuk,

                'durasi' =>
                    $durasi,

                'harga_per_jam' =>
                    $hargaPerJam,

                'total_harga' =>
                    $totalHarga
            ]
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | PROSES KELUAR
    |--------------------------------------------------------------------------
    */

    public function keluar(
        Request $request,
        $id
    ) {

        $request->validate([
            'jenis_kendaraan' =>
                'required|in:Motor,Mobil',

            'no_polisi' =>
                'required|string|max:20',
        ]);

        $hasil =
            DB::transaction(
                function () use (
                    $id,
                    $request
                ) {

                    $tiket =
                        TiketParkir::where(
                            'id',
                            $id
                        )
                        ->lockForUpdate()
                        ->first();

                    if (!$tiket) {

                        return [
                            'success' => false,
                            'status_code' => 404,
                            'message' => 'Tiket tidak ditemukan.',
                            'data' => null,
                        ];
                    }

                    if (
                        $tiket->status === 'keluar'
                    ) {

                        return [
                            'success' => false,
                            'status_code' => 400,
                            'message' =>
                                'Tiket sudah digunakan dan tidak dapat digunakan kembali. Silakan gunakan tiket baru.',
                            'data' => null,
                        ];
                    }

                    $masuk =
                        Carbon::parse(
                            $tiket->waktu_masuk
                        )->setTimezone(
                            'Asia/Jakarta'
                        );

                    $keluar =
                        Carbon::now(
                            'Asia/Jakarta'
                        );

                    $selisihMenit =
                        $masuk->diffInMinutes(
                            $keluar
                        );

                    $durasi =
                        max(
                            1,
                            (int) ceil(
                                $selisihMenit / 60
                            )
                        );

                    $hargaPerJam =
                        $this->getHargaPerJam(
                            $request->jenis_kendaraan
                        );

                    $totalHarga =
                        $durasi *
                        $hargaPerJam;

                    $tiket->update([
                        'jenis_kendaraan' =>
                            $request->jenis_kendaraan,

                        'no_polisi' =>
                            strtoupper(
                                trim(
                                    $request->no_polisi
                                )
                            ),

                        'status' =>
                            'keluar',

                        'waktu_keluar' =>
                            $keluar,

                        'durasi' =>
                            $durasi,

                        'total_harga' =>
                            $totalHarga,
                    ]);

                    $tiket->refresh();

                    return [
                        'success' => true,
                        'status_code' => 200,
                        'message' =>
                            'Transaksi berhasil. Tiket sudah keluar dan tidak dapat digunakan kembali.',
                        'data' => [
                            'id' =>
                                $tiket->id,

                            'kode_tiket' =>
                                $tiket->kode_tiket,

                            'jenis_kendaraan' =>
                                $tiket->jenis_kendaraan,

                            'no_polisi' =>
                                $tiket->no_polisi,

                            'waktu_masuk' =>
                                $tiket->waktu_masuk,

                            'waktu_keluar' =>
                                $tiket->waktu_keluar,

                            'durasi' =>
                                $durasi,

                            'harga_per_jam' =>
                                $hargaPerJam,

                            'total_harga' =>
                                $totalHarga,

                            'status' =>
                                $tiket->status
                        ]
                    ];
                }
            );

        return response()->json(
            [
                'success' =>
                    $hasil['success'],

                'message' =>
                    $hasil['message'],

                'data' =>
                    $hasil['data'],
            ],
            $hasil['status_code']
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS TIKET
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $tiket =
            TiketParkir::find($id);


        if (!$tiket) {

            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Tiket tidak ditemukan'
            ], 404);
        }


        $tiket->delete();


        return response()->json([
            'success' =>
                true,

            'message' =>
                'Tiket berhasil dihapus'
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | RINGKASAN DASHBOARD PETUGAS
    |--------------------------------------------------------------------------
    */

    public function dashboardPetugas()
    {
        $hariIni =
            Carbon::today(
                'Asia/Jakarta'
            );


        $totalMember =
            Member::count();


        $kendaraanMasuk =
            TiketParkir::whereDate(
                'waktu_masuk',
                $hariIni
            )->count();


        $sedangParkir =
            TiketParkir::where(
                'status',
                'masuk'
            )->count();


        $tiketKeluarHariIni =
            TiketParkir::where(
                'status',
                'keluar'
            )
            ->whereDate(
                'waktu_keluar',
                $hariIni
            )
            ->get();


        $pendapatan = 0;


        foreach (
            $tiketKeluarHariIni
            as $tiket
        ) {

            if (
                $tiket->total_harga !== null &&
                (float) $tiket->total_harga > 0
            ) {

                $pendapatan +=
                    (float) $tiket->total_harga;

            } else {

                $hargaPerJam =
                    $this->getHargaPerJam(
                        $tiket->jenis_kendaraan
                    );


                $durasi =
                    max(
                        1,
                        (int) $tiket->durasi
                    );


                $pendapatan +=
                    $durasi *
                    $hargaPerJam;
            }
        }


        return response()->json([
            'success' =>
                true,

            'data' => [

                'total_member' =>
                    $totalMember,

                'kendaraan_masuk' =>
                    $kendaraanMasuk,

                'sedang_parkir' =>
                    $sedangParkir,

                'pendapatan' =>
                    $pendapatan
            ]
        ]);
    }
}