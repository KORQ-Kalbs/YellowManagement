<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'nama_variant',
        'kode_variant',
        'harga_tambahan',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'harga_tambahan' => 'decimal:2',
        'is_active'      => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
