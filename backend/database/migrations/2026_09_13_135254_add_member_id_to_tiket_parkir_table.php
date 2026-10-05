<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tiket_parkir', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')
                ->nullable()
                ->after('qr_code');
        });
    }

    public function down(): void
    {
        Schema::table('tiket_parkir', function (Blueprint $table) {
            $table->dropColumn('member_id');
        });
    }
};