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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pasien');
            $table->foreign('id_pasien')->references('id')->on('pasien')->onDelete('cascade');
            $table->unsignedBigInteger('id_visit');
            $table->foreign('id_visit')->references('id')->on('visit')->onDelete('cascade');
            $table->unsignedBigInteger('id_jenis_penjualan');
            $table->foreign('id_jenis_penjualan')->references('id')->on('jenis_penjualan')->onDelete('cascade');
            $table->integer('is_lunas')->default(0)->comment("0 Belum, 1 Lunas, 2 Dicicil");
            $table->decimal('total_penjualan', 15, 2)->default(0)->comment("Total Penjualan = SUM(Sub Total Penjualan Detail Penjualan)");
            $table->decimal('total_diskon_percent', 15, 2)->default(0)->comment("Total Diskon Persen = SUM(Sub Total Diskon Persen Detail Penjualan)");
            $table->decimal('total_diskon_currency', 15, 2)->default(0)->comment("Total Diskon Currency = SUM(Sub Total Diskon Currency Detail Penjualan)");
            $table->decimal('total_jasa_pelayanan', 15, 2)->default(0)->comment("Total Jasa Pelayanan = SUM(Sub Total Jasa Pelayanan Detail Penjualan)");
            $table->decimal('total_jasa_sarana', 15, 2)->default(0)->comment("Total Jasa Sarana = SUM(Sub Total Jasa Sarana Detail Penjualan)");
            $table->decimal('total_tuslah', 15, 2)->default(0)->comment("Total Tuslah = SUM(Sub Total Tuslah Detail Penjualan)");
            $table->decimal('total_embalase', 15, 2)->default(0)->comment("Total Embalase = SUM(Sub Total Embalase Detail Penjualan)");
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id')->on('list_clients')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->foreign('id_user_created')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('cascade');
            $table->integer('is_deleted')->default(0)->comment("0 Tidak, 1 Ya");$table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
