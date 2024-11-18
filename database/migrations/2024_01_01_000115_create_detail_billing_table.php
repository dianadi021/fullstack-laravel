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
        Schema::create('detail_billing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_billing');
            $table->foreign('id_billing')->references('id')->on('billing')->onDelete('cascade');
            $table->decimal('sub_total_tagihan', 15, 2)->default(0)->comment("Sub Total Tagihan = Total Biaya Paket Tarif");
            $table->unsignedBigInteger('id_layanan')->nullable();
            $table->foreign('id_layanan')->references('id')->on('layanan')->onDelete('cascade');
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
        Schema::dropIfExists('detail_billing');
    }
};
