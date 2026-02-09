<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',  // FIXED: was id_transaksi
        'metode_pembayaran',
        'jumlah_bayar',
        'kembalian',
    ];

    protected $casts = [
        'jumlah_bayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    /**
     * Relasi ke Transaksi
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}