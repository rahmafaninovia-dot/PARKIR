<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * ==================================================
     * DAFTAR AKUN YANG BOLEH MENGGUNAKAN
     * FITUR LUPA PASSWORD
     * ==================================================
     */

    private function akunForgotPassword()
    {
        return [
            'admin@parkir.com' => [
                'nama' => 'Super Admin',
                'password_key' => 'password_admin',
            ],

            'petugas@parkir.com' => [
                'nama' => 'Petugas',
                'password_key' => 'password_petugas',
            ],
        ];
    }


    /**
     * ==================================================
     * STEP 1
     * CEK EMAIL + KIRIM OTP WHATSAPP
     * ==================================================
     */

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);


        // ==================================================
        // RAPKAN EMAIL
        // ==================================================

        $email = strtolower(
            trim($request->email)
        );


        // ==================================================
        // AMBIL DAFTAR AKUN YANG DIIZINKAN
        // ==================================================

        $akun = $this->akunForgotPassword();


        // ==================================================
        // CEK EMAIL
        // ==================================================

        if (!isset($akun[$email])) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Email tidak terdaftar untuk fitur lupa password.'
            ], 404);
        }


        // ==================================================
        // GENERATE OTP 6 DIGIT
        // ==================================================

        $otp = random_int(
            100000,
            999999
        );


        // ==================================================
        // AMBIL NOMOR WHATSAPP
        // ==================================================

        $nomor = trim(
            config('services.fonnte.target')
        );


        if (!$nomor) {

            Log::error(
                'NOMOR WHATSAPP FONNTE TIDAK DITEMUKAN'
            );

            return response()->json([
                'success' => false,
                'message' =>
                    'Nomor WhatsApp Fonnte belum dikonfigurasi.'
            ], 500);
        }


        // ==================================================
        // NORMALISASI NOMOR INDONESIA
        // ==================================================

        if (str_starts_with($nomor, '0')) {

            $nomor =
                '62' .
                substr($nomor, 1);
        }


        // ==================================================
        // PESAN WHATSAPP
        // ==================================================

        $message =
            "🅿️ PARKIR PLAZA ANDALAS\n\n" .
            "Kode OTP untuk reset password {$akun[$email]['nama']} adalah:\n\n" .
            "*{$otp}*\n\n" .
            "Kode OTP berlaku selama 5 menit.\n" .
            "Jangan berikan kode ini kepada siapapun.";


        // ==================================================
        // AMBIL KONFIGURASI FONNTE
        // ==================================================

        $fonnteToken =
            config('services.fonnte.token');

        $fonnteUrl =
            config('services.fonnte.url');


        // ==================================================
        // CEK TOKEN
        // ==================================================

        if (!$fonnteToken) {

            Log::error(
                'FONNTE TOKEN TIDAK DITEMUKAN'
            );

            return response()->json([
                'success' => false,
                'message' =>
                    'Token Fonnte belum dikonfigurasi.'
            ], 500);
        }


        // ==================================================
        // CEK URL
        // ==================================================

        if (!$fonnteUrl) {

            Log::error(
                'FONNTE URL TIDAK DITEMUKAN'
            );

            return response()->json([
                'success' => false,
                'message' =>
                    'URL Fonnte belum dikonfigurasi.'
            ], 500);
        }


        // ==================================================
        // KIRIM OTP KE FONNTE
        // ==================================================

        try {

            $response = Http::withHeaders([
                'Authorization' => $fonnteToken,
            ])
                ->timeout(30)
                ->post(
                    $fonnteUrl,
                    [
                        'target' =>
                            $nomor,

                        'message' =>
                            $message,

                        'countryCode' =>
                            '62',
                    ]
                );


            // ==================================================
            // CEK RESPONSE FONNTE
            // ==================================================

            if (!$response->successful()) {

                Log::error(
                    'FONNTE GAGAL MENGIRIM OTP',
                    [
                        'status' =>
                            $response->status(),

                        'response' =>
                            $response->body(),
                    ]
                );

                return response()->json([
                    'success' => false,
                    'message' =>
                        'OTP gagal dikirim ke WhatsApp.',
                ], 500);
            }


            // ==================================================
            // SIMPAN OTP KE CACHE
            // BERLAKU 5 MENIT
            // ==================================================

            Cache::put(
                'forgot_password_otp_' . $email,

                Hash::make($otp),

                now()->addMinutes(5)
            );


            // ==================================================
            // BERHASIL
            // ==================================================

            return response()->json([
                'success' => true,
                'message' =>
                    'OTP berhasil dikirim ke WhatsApp.'
            ]);


        } catch (\Throwable $e) {

            Log::error(
                'ERROR FONNTE',
                [
                    'message' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' =>
                    'Terjadi kesalahan saat menghubungi Fonnte.',
            ], 500);
        }
    }


    /**
     * ==================================================
     * STEP 2
     * VERIFIKASI OTP
     * ==================================================
     */

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);


        // ==================================================
        // RAPKAN EMAIL
        // ==================================================

        $email = strtolower(
            trim($request->email)
        );


        // ==================================================
        // CEK EMAIL
        // ==================================================

        $akun = $this->akunForgotPassword();


        if (!isset($akun[$email])) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Email tidak terdaftar untuk fitur lupa password.'
            ], 404);
        }


        // ==================================================
        // AMBIL OTP DARI CACHE
        // ==================================================

        $storedOtp = Cache::get(
            'forgot_password_otp_' . $email
        );


        if (!$storedOtp) {

            return response()->json([
                'success' => false,
                'message' =>
                    'OTP sudah kadaluarsa. Silakan minta OTP baru.'
            ], 400);
        }


        // ==================================================
        // CEK OTP
        // ==================================================

        if (!Hash::check(
            $request->otp,
            $storedOtp
        )) {

            return response()->json([
                'success' => false,
                'message' =>
                    'OTP salah.'
            ], 400);
        }


        // ==================================================
        // HAPUS OTP
        // ==================================================

        Cache::forget(
            'forgot_password_otp_' . $email
        );


        // ==================================================
        // BUAT TOKEN RESET
        // ==================================================

        $resetToken =
            Str::random(64);


        // ==================================================
        // SIMPAN TOKEN RESET
        // ==================================================

        Cache::put(
            'forgot_password_verified_' . $email,

            $resetToken,

            now()->addMinutes(10)
        );


        // ==================================================
        // BERHASIL
        // ==================================================

        return response()->json([
            'success' => true,
            'message' =>
                'OTP benar. Silakan buat password baru.',

            'reset_token' =>
                $resetToken,
        ]);
    }


    /**
     * ==================================================
     * STEP 3
     * RESET PASSWORD
     * ==================================================
     */

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'reset_token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);


        // ==================================================
        // RAPKAN EMAIL
        // ==================================================

        $email = strtolower(
            trim($request->email)
        );


        // ==================================================
        // CEK EMAIL
        // ==================================================

        $akun = $this->akunForgotPassword();


        if (!isset($akun[$email])) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Email tidak terdaftar untuk fitur lupa password.'
            ], 404);
        }


        // ==================================================
        // AMBIL TOKEN RESET
        // ==================================================

        $storedToken = Cache::get(
            'forgot_password_verified_' . $email
        );


        // ==================================================
        // CEK TOKEN
        // ==================================================

        if (
            !$storedToken ||
            !hash_equals(
                $storedToken,
                $request->reset_token
            )
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Akses reset password tidak valid atau sudah kadaluarsa.'
            ], 400);
        }


        // ==================================================
        // HAPUS TOKEN
        // ==================================================

        Cache::forget(
            'forgot_password_verified_' . $email
        );


        // ==================================================
        // BERHASIL
        // ==================================================

        return response()->json([
            'success' => true,
            'message' =>
                'Password berhasil diubah.',

            /*
            |--------------------------------------------------------------------------
            | KEY INI AKAN DIPAKAI FRONTEND
            | UNTUK MENYIMPAN PASSWORD BARU
            |--------------------------------------------------------------------------
            */

            'password_key' =>
                $akun[$email]['password_key'],
        ]);
    }
}