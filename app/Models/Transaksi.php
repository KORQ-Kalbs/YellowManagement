<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_invoice',
        'user_id',
        'total_harga',
        'status',
        'tanggal_transaksi',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'total_harga' => 'decimal:2',
    ];

    /**
     * Boot method untuk auto-generate invoice number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            if (empty($transaksi->no_invoice)) {
                $transaksi->no_invoice = 'INV-' . date('Ymd') . '-' . str_pad(
                    Transaksi::whereDate('created_at', today())->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    /**
     * Relasi ke User (Kasir).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke DetailTransaksi.
     */
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    /**
     * Relasi ke Pembayaran.
     */
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'transaksi_id');
    }

    /**
     * Hitung total dari detail transaksi
     */
    public function hitungTotal()
    {
        return $this->details()->sum('subtotal');
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_transaksi', today());
    }
}