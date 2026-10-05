<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'kode_member',
        'token',
        'nama_member',
        'nama_perusahaan',
        'total_harga',
        'jumlah_bayar',
        'kembalian',
        'status',
        'tanggal_mulai',
        'tanggal_bayar',
        'tanggal_expired',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_bayar' => 'date',
        'tanggal_expired' => 'date',

        'total_harga' => 'integer',
        'jumlah_bayar' => 'integer',
        'kembalian' => 'integer',
    ];
}