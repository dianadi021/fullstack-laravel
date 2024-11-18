<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pendaftaran');
            $table->foreign('id_pendaftaran')->references('id')->on('pendaftaran')->onDelete('cascade');
            $table->unsignedBigInteger('id_pasien');
            $table->foreign('id_pasien')->references('id')->on('pasien')->onDelete('cascade');
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id')->on('list_client')->onDelete('cascade');

            // ENUM SET START
            $table->enum('status_kunjungan', ['Batal', 'Masuk', 'Menunggu', 'Diperiksa', 'Resep', 'Mutasi Rajal', 'Ranap', 'Mutasi Ranap', 'Keluar', 'Selesai', 'Booking'])->comment("Batal, Masuk, Menunggu, Diperiksa, Resep, Mutasi Rajal, Ranap, Mutasi Ranap, Keluar, Selesai");
            // ENUM SET END

            // $table->unsignedBigInteger('id_nakes');
            // $table->foreign('id_nakes')->references('id')->on('nakes')->onDelete('cascade');
            // $table->unsignedBigInteger('id_bed');
            // $table->foreign('id_bed')->references('id')->on('bed')->onDelete('cascade');
            $table->timestamp("waktu_masuk")->nullable();
            $table->timestamp("waktu_keluar")->nullable();

            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->foreign('id_user_created')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kunjungan');
    }
};
