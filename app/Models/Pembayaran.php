<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'metode_pembayaran',
        'jumlah_pembayaran',
        'tanggal_pembayaran',
        'referensi',
    ];

    protected $casts = [
        'jumlah_pembayaran' => 'decimal:2',
        'tanggal_pembayaran' => 'datetime',
    ];

    /**
     * Relasi ke Transaksi
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}