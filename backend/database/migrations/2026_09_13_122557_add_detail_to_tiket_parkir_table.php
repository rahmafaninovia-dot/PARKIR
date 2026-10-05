<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tiket_parkir', function (Blueprint $table) {
            $table->string('jenis_kendaraan')->nullable()->after('qr_code');
            $table->string('no_polisi')->nullable()->after('jenis_kendaraan');
            $table->integer('durasi')->nullable()->after('waktu_keluar');
        });
    }

    public function down(): void
    {
        Schema::table('tiket_parkir', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kendaraan',
                'no_polisi',
                'durasi'
            ]);
        });
    }
};