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
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('nik')->unique()->nullable();
            $table->string('nomor_identitas_lain')->unique()->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->datetime('birthdate')->nullable();
            $table->string('agama')->nullable();
            $table->string('suku_ras')->nullable();
            $table->string('goldar')->nullable();

            $table->jsonb('alamat_domisili')->nullable();
            $table->jsonb('alamat_ktp')->nullable();
            $table->jsonb('dinamis_penduduk')->nullable();

            // ENUM SET START
            $table->enum('pendidikan', ['Tidak Diketahui', 'Tidak Sekolah', 'SD', 'SLTP', 'SLTA', 'D1-D3', 'D4', 'S1', 'S2', 'S3'])->comment("Tidak Diketahui, Tidak Sekolah, SD, SLTP, SLTA, D1-D3, D4, S1, S2, S3")->nullable();
            $table->enum('pekerjaan', ['Tidak Diketahui', 'Tidak Bekerja', 'PNS', 'TNI/POLRI', 'BUMN', 'Pegawai', 'Swasta/Wirausaha', 'Buruh', 'Lain-lain'])->comment("Tidak Diketahui, Tidak Bekerja, PNS, TNI/POLRI, BUMN, Pegawai, Swasta/Wirausaha, Buruh, Lain-lain")->nullable();
            $table->enum('status_pernikahan', ['Tidak Diketahui', 'Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])->comment("Tidak Diketahui, Belum Kawin, Kawin, Cerai Hidup, Cerai Mati")->nullable();
            $table->enum('gender', ['Tidak Diketahui', 'Laki-Laki', 'Perempuan', 'Tidak Dapat Ditentukan', 'Tidak Mengisi'])->comment("Tidak Diketahui, Laki-Laki, Perempuan, Tidak Dapat Ditentukan, Tidak Mengisi");

            // Anomali/Entitas Tidak Dikenal Start
            $table->enum('perkiraan_umur', ['Tidak Tau', '0 - 5', '6 - 11', '12 - 17', '18 - 40', '41 - 65', '> 65'])->comment("Tidak Tau, 0 - 5, 6 - 11, 12 - 17, 18 - 40, 41 - 65, > 65")->nullable();
            $table->string('lokasi_ditemukan')->nullable();
            $table->datetime('tanggal_ditemukan')->nullable();
            // Anomali/Entitas Tidak Dikenal End
            // ENUM SET END

            $table->unsignedBigInteger('id_provinsi')->nullable();
            $table->foreign('id_provinsi')->references('id')->on('provinsi')->onDelete('cascade');
            $table->unsignedBigInteger('id_kabupaten')->nullable();
            $table->foreign('id_kabupaten')->references('id')->on('kabupaten')->onDelete('cascade');
            $table->unsignedBigInteger('id_kecamatan')->nullable();
            $table->foreign('id_kecamatan')->references('id')->on('kecamatan')->onDelete('cascade');
            $table->unsignedBigInteger('id_kelurahan')->nullable();
            $table->foreign('id_kelurahan')->references('id')->on('kelurahan')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
