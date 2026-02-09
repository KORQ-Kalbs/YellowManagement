<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Fix: Remove redundant product_id and jumlah columns from transaksis table
     * Karena sudah ada di detail_transaksis
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['product_id']);
            
            // Drop redundant columns
            $table->dropColumn(['product_id', 'jumlah']);
            
            // Add invoice number for better tracking
            $table->string('no_invoice')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('no_invoice');
            
            $table->foreignId('product_id')
                ->after('user_id')
                ->constrained('products')
                ->cascadeOnDelete();
            
            $table->integer('jumlah')->after('product_id');
        });
    }
};