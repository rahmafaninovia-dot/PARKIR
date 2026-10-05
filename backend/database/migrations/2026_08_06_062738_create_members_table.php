<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {

            $table->id();

            $table->string('kode_member')->unique();

            $table->string('token')->unique();

            $table->string('nama_member');

            $table->string('nama_perusahaan');

            $table->integer('total_harga')
                ->default(150000);

            $table->integer('jumlah_bayar')
                ->default(0);

            $table->integer('kembalian')
                ->default(0);

            $table->enum('status', [
                'lunas',
                'belum lunas'
            ])->default('belum lunas');

            $table->date('tanggal_bayar')
                ->nullable();

            $table->date('tanggal_mulai');

            $table->date('tanggal_expired');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};