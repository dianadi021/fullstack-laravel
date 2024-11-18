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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_visit');
            $table->foreign('id_visit')->references('id')->on('visit')->onDelete('cascade');
            $table->integer('status_lunas')->default(0);
            $table->decimal('sisa_tagihan', 15, 2)->nullable(); // *sisa_tagihan merupakan nilai tagihan id_riwayat_pembayaran terakhir/terbaru/max di id_pembayaran yg sama
            $table->decimal('total_tagihan', 15, 2)->nullable(); // *Merupakan nilai SUM(Tagihan)  id_riwayat_pembayaran terakhir/terbaru/max di id_pembayaran yg sama
            $table->decimal('total_bayar', 15, 2)->nullable(); // *Merupakan nilai SUM(Bayar)  id_riwayat_pembayaran terakhir/terbaru/max di id_pembayaran yg sama
            $table->timestamp("deleted_at")->nullable();
            $table->integer('is_deleted')->default(0);
            $table->timestamps();
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
