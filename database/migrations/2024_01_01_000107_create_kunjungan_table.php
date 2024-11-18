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
            $table->foreign('id_client')->references('id')->on('list_clients')->onDelete('cascade');

            // ENUM SET START
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                DB::statement("DROP TYPE IF EXISTS status_kunjungan_pasien");
                DB::statement("CREATE TYPE status_kunjungan_pasien AS ENUM ('Batal', 'Masuk', 'Mutasi Rajal', 'Ranap', 'Mutasi Ranap', 'Keluar', 'Selesai')");
                $table->string('status_kunjungan')->default('Belum')->comment("Batal, Masuk, Mutasi Rajal, Ranap, Mutasi Ranap, Keluar, Selesai");
            }

            if ($dbDriver === 'mysql') {
                $table->enum('status_kunjungan', ['Batal', 'Masuk', 'Mutasi Rajal', 'Ranap', 'Mutasi Ranap', 'Keluar', 'Selesai'])->default('Masuk');
            }
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
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('kunjungan')->whereNotIn('status_kunjungan', ['Belum', 'Lunas', 'Dicicil', 'Batal'])->update(['status_kunjungan' => 'Masuk']);
    }

    public function down()
    {
        Schema::table('kunjungan', function (Blueprint $table) {
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                DB::statement("DROP TYPE IF EXISTS status_kunjungan_pasien");
            }

            if ($dbDriver === 'mysql') {
                $table->dropColumn(['status_kunjungan']);
            }
        });

        Schema::dropIfExists('kunjungan');
    }
};
