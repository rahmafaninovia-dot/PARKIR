<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Role pengguna
            $table->string('role')
                ->default('petugas')
                ->after('password');

            // Nomor HP petugas
            $table->string('no_hp')
                ->nullable()
                ->after('role');

            // Shift petugas
            $table->string('shift')
                ->nullable()
                ->after('no_hp');

            // Status petugas
            $table->string('status')
                ->default('aktif')
                ->after('shift');

        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'role',
                'no_hp',
                'shift',
                'status'
            ]);

        });
    }
};