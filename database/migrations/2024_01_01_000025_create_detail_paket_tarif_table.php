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
        Schema::create('detail_paket_tarif', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('id_paket_tarif');
            $table->foreign('id_paket_tarif')->references('id')->on('paket_tarif')->onDelete('cascade');
            $table->unsignedBigInteger('id_master_data_tarif');
            $table->foreign('id_master_data_tarif')->references('id')->on('master_data_tarif')->onDelete('cascade');
            $table->decimal('sub_total_biaya', 15, 2)->default(0)->comment("Sub Total Biaya = Biaya Master Data Tarif");
            $table->integer('is_active')->default(1)->comment("0 Tidak, 1 Ya");
            $table->integer('is_deleted')->default(0)->comment("0 Tidak, 1 Ya");$table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_paket_tarif');
    }
};
