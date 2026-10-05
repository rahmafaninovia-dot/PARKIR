<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MemberController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\MemberGateController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ForgotPasswordController;


/*
|--------------------------------------------------------------------------
| MEMBER
|--------------------------------------------------------------------------
*/

Route::get('/member', [
    MemberController::class,
    'index'
]);

Route::post('/member', [
    MemberController::class,
    'store'
]);

Route::post('/member/check', [
    MemberController::class,
    'check'
]);

Route::post('/member/reset-bulanan', [
    MemberController::class,
    'resetBulanan'
]);

Route::get('/member/{id}', [
    MemberController::class,
    'show'
]);

Route::put('/member/{id}', [
    MemberController::class,
    'update'
]);

Route::delete('/member/{id}', [
    MemberController::class,
    'destroy'
]);


/*
|--------------------------------------------------------------------------
| MEMBER GATE
|--------------------------------------------------------------------------
*/

Route::post('/member-gate/masuk', [
    MemberGateController::class,
    'masuk'
]);

// Cek dulu apakah member masih berada di area parkir.
// Belum mengubah status tiket.
Route::post('/member-gate/cek-keluar', [
    MemberGateController::class,
    'cekKeluar'
]);

// Proses keluar yang benar-benar mengubah status menjadi keluar.
Route::post('/member-gate/keluar', [
    MemberGateController::class,
    'keluar'
]);


/*
|--------------------------------------------------------------------------
| DASHBOARD PETUGAS
|--------------------------------------------------------------------------
*/

Route::get('/dashboard/petugas', [
    TiketController::class,
    'dashboardPetugas'
]);


/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/

Route::get('/petugas', [
    PetugasController::class,
    'index'
]);

Route::post('/petugas', [
    PetugasController::class,
    'store'
]);

Route::get('/petugas/{id}', [
    PetugasController::class,
    'show'
]);

Route::put('/petugas/{id}', [
    PetugasController::class,
    'update'
]);

Route::delete('/petugas/{id}', [
    PetugasController::class,
    'destroy'
]);


/*
|--------------------------------------------------------------------------
| TIKET PARKIR
|--------------------------------------------------------------------------
*/

Route::post('/tiket', [
    TiketController::class,
    'create'
]);

Route::get('/tiket', [
    TiketController::class,
    'index'
]);

// Harus sebelum /tiket/{id}
Route::post('/tiket/scan', [
    TiketController::class,
    'scan'
]);

Route::get('/tiket/{id}', [
    TiketController::class,
    'show'
]);

Route::put('/tiket/{id}/keluar', [
    TiketController::class,
    'keluar'
]);

Route::delete('/tiket/{id}', [
    TiketController::class,
    'destroy'
]);


/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD
|--------------------------------------------------------------------------
*/

Route::post(
    '/forgot-password/check-email',
    [ForgotPasswordController::class, 'checkEmail']
);

Route::post(
    '/forgot-password/verify-otp',
    [ForgotPasswordController::class, 'verifyOtp']
);

Route::post(
    '/forgot-password/reset',
    [ForgotPasswordController::class, 'resetPassword']
);
