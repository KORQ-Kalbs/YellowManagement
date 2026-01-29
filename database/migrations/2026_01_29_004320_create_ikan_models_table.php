<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ikan_models', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ikan');
            $table->decimal('harga_ikan', 10, 2);
            $table->integer('stok_ikan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ikan_models');
    }
};
