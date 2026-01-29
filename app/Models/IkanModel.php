<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IkanModel extends Model
{
    use HasFactory;

    protected $table = 'ikan';

    protected $fillable = [
        'nama_ikan',
        'harga_ikan',
        'stok_ikan',
    ];
}
