<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    protected $fillable = [
        'title',
        'alt_text',
        'original_name',
        'file_name',
        'file_path',
        'mime_type',
        'size',
        'product_id',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    protected $appends = [
        'url',
        'human_size',
    ];

    public function getUrlAttribute(): string
    {
        return asset($this->file_path);
    }

    public function getHumanSizeAttribute(): string
    {
        $size = (int) $this->size;

        if ($size >= 1048576) {
            return number_format($size / 1048576, 1) . ' MB';
        }

        if ($size >= 1024) {
            return number_format($size / 1024, 1) . ' KB';
        }

        return $size . ' B';
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->title ?: pathinfo($this->original_name, PATHINFO_FILENAME);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}