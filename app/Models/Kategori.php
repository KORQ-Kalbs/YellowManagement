<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori', 
        'deskripsi'
    ];

    /**
     * Relasi ke Product.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'kategori_id');
    }
}
