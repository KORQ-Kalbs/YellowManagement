<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Fix: Rename id_transaksi to transaksi_id for consistency
     */
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            // Drop old foreign key
            $table->dropForeign(['id_transaksi']);
            
            // Rename column
            $table->renameColumn('id_transaksi', 'transaksi_id');
        });
        
        // Add foreign key with new name
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->foreign('transaksi_id')
                ->references('id')
                ->on('transaksis')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropForeign(['transaksi_id']);
            $table->renameColumn('transaksi_id', 'id_transaksi');
        });
        
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->foreign('id_transaksi')
                ->references('id')
                ->on('transaksis')
                ->cascadeOnDelete();
        });
    }
};