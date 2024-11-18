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
        Schema::create('list_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('biodata')->nullable();
            $table->unsignedBigInteger('id_provinsi');
            $table->foreign('id_provinsi')->references('id')->on('provinsi')->onDelete('cascade');
            $table->unsignedBigInteger('id_kabupaten');
            $table->foreign('id_kabupaten')->references('id')->on('kabupaten')->onDelete('cascade');
            $table->unsignedBigInteger('id_kecamatan');
            $table->foreign('id_kecamatan')->references('id')->on('kecamatan')->onDelete('cascade');
            $table->unsignedBigInteger('id_kelurahan')->nullable();
            $table->foreign('id_kelurahan')->references('id')->on('kelurahan')->onDelete('cascade');
            $table->string('address')->nullable();
            $table->integer('status')->default(1); // Status user aktif/non-aktif
            $table->timestamp('expired_date')->nullable();
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
        Schema::dropIfExists('list_clients');
    }
};
