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
        Schema::table('products', function (Blueprint $table) {
            $table->index('kategori_id', 'idx_products_kategori');
            $table->index('status', 'idx_products_status');
            $table->index(['status', 'stok'], 'idx_products_status_stok');
        });

        Schema::table('transaksis', function (Blueprint $table) {
            $table->index('user_id', 'idx_transaksis_user');
            $table->index('status', 'idx_transaksis_status');
            $table->index('tanggal_transaksi', 'idx_transaksis_tanggal');
            $table->index(['user_id', 'tanggal_transaksi'], 'idx_transaksis_user_tanggal');
            $table->index(['status', 'tanggal_transaksi'], 'idx_transaksis_status_tanggal');
        });

        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->index('transaksi_id', 'idx_detail_transaksi');
            $table->index('product_id', 'idx_detail_product');
        });

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->index('transaksi_id', 'idx_pembayaran_transaksi');
            $table->index('tanggal_pembayaran', 'idx_pembayaran_tanggal');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('role', 'idx_users_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_kategori');
            $table->dropIndex('idx_products_status');
            $table->dropIndex('idx_products_status_stok');
        });

        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropIndex('idx_transaksis_user');
            $table->dropIndex('idx_transaksis_status');
            $table->dropIndex('idx_transaksis_tanggal');
            $table->dropIndex('idx_transaksis_user_tanggal');
            $table->dropIndex('idx_transaksis_status_tanggal');
        });

        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->dropIndex('idx_detail_transaksi');
            $table->dropIndex('idx_detail_product');
        });

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropIndex('idx_pembayaran_transaksi');
            $table->dropIndex('idx_pembayaran_tanggal');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_role');
        });
    }
};
