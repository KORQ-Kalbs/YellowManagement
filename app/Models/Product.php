<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public const LOW_STOCK_THRESHOLD = 5;

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

    /**
     * Relasi ke ProductVariant (active only — used in POS).
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true)->orderBy('urutan');
    }

    /**
     * Semua variant termasuk inactive — used for admin CRUD.
     */
    public function allVariants()
    {
        return $this->hasMany(ProductVariant::class)->orderBy('urutan');
    }

    public function productImage()
    {
        return $this->hasOne(ProductImage::class);
    }

    /**
     * Cek apakah produk punya variant aktif.
     */
    public function hasVariants(): bool
    {
        return $this->variants()->exists();
    }
}
