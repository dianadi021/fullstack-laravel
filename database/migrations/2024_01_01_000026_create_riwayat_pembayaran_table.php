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
        Schema::create('riwayat_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pembayaran');
            $table->foreign('id_pembayaran')->references('id')->on('pembayaran')->onDelete('cascade');
            $table->decimal('tagihan', 15, 2)->nullable(); // Merupakan nilai dari hasil pengurangan (tagihan_akhir - bayar), *tagihan_akhir didapat dari id_riwayat_pembayaran terakhir/terbaru/max di id_pembayaran yg sama
            $table->decimal('bayar', 15, 2)->nullable(); // Merupakan nilai untuk pembayaran ketika transaksi/insert data (tagihan_akhir - transaksi_sekarang/sekarang_bayar)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pembayaran');
    }
};
