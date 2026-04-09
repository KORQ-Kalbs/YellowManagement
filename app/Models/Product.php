<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'nama_produk',
        'kategori_id',
        'harga',
        'gambar_produk',
        'stok',
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    /**
     * Relasi ke Kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi ke Transaksi.
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'product_id');
    }

    /**
     * Relasi ke DetailTransaksi.
     */
    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'product_id');
    }
}
