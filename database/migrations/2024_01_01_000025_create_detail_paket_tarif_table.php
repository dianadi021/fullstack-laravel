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
            $table->string('description')->nullable();
            $table->unsignedBigInteger('id_paket_tarif');
            $table->foreign('id_paket_tarif')->references('id')->on('paket_tarif')->onDelete('cascade');
            $table->unsignedBigInteger('id_master_data_tarif');
            $table->foreign('id_master_data_tarif')->references('id')->on('master_data_tarif')->onDelete('cascade');
            $table->decimal('sub_total_biaya', 15, 2)->default(0)->comment("Sub Total Biaya = Biaya Master Data Tarif");
            $table->boolean('is_actived')->default(true);
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
        Schema::dropIfExists('detail_paket_tarif');
    }
};
