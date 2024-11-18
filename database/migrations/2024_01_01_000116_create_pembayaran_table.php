<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pendaftaran');
            $table->foreign('id_pendaftaran')->references('id')->on('pendaftaran')->onDelete('cascade');
            $table->unsignedBigInteger('id_pasien');
            $table->foreign('id_pasien')->references('id')->on('pasien')->onDelete('cascade');
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id')->on('list_client')->onDelete('cascade');

            // ENUM SET START
            $table->enum('is_lunas', ['Belum', 'Lunas', 'Dicicil', 'Batal'])->comment("Belum, Lunas, Dicicil, Batal");
            // ENUM SET END

            $table->decimal('total_tagihan', 15, 2)->default(0)->comment("Total Tagihan = SUM(Sub Total Tagihan Detail Pembayaran)");
            $table->decimal('total_bayar', 15, 2)->default(0)->comment("Total Bayar = SUM(Sub Total Bayar Riwayat Pembayaran) yang tidak batal bayar/is not deleted");
            $table->decimal('total_sisa_tagihan', 15, 2)->default(0)->comment("Total Sisa Tagihan = (Total Tagihan - Total Bayar) Or (Total Tagihan - SUM(Sub Total Bayar Riwayat Pembayaran)) (If 0 = Lunas)");


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
        Schema::dropIfExists('pembayaran');
    }
};
