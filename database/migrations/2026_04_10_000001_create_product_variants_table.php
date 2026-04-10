<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('nama_variant'); // e.g. "Small", "Medium", "Large"
            $table->string('kode_variant', 10); // e.g. "S", "M", "L"
            $table->decimal('harga_tambahan', 12, 2)->default(0); // price modifier on top of base price
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0); // display order
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
