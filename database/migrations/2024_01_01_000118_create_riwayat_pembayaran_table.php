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
            $table->unsignedBigInteger('id_metode_bayar');
            $table->foreign('id_metode_bayar')->references('id')->on('metode_bayar')->onDelete('cascade');
            $table->decimal('sisa_tagihan', 15, 2)->default(0)->comment("Merupakan nilai terbaru dari total_sisa_tagihan Or (Total Tagihan - Total Bayar) pada Tabel Pembayaran Or Transaksi terakhir (sisa_tagihan - sub_total_bayar) Tabel Riwayat Pembayaran (*yang tidak batal/is not deleted)");
            $table->decimal('sub_total_bayar', 15, 2)->default(0)->comment("Nilai Rupiah yang user bayarkan, Check Validasi Total Tagihan = sisa_ragihan + sub_total_bayar (*yang tidak batal/is not deleted)");
            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->foreign('id_user_created')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
            $table->softDeletes();
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
