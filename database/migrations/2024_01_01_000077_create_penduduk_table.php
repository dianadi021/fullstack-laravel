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
            $table->string('nik')->unique()->nullable();
            $table->string('fullname');
            $table->string('handphone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->datetime('birthdate')->nullable();

            // ENUM SET START
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                $table->string('gender')->comment("Laki - Laki, Perempuan");
            }

            if ($dbDriver === 'mysql') {
                $table->enum('gender', ['L', 'P'])->comment("Laki - Laki, Perempuan");
            }
            // ENUM SET END

            $table->unsignedBigInteger('id_golongan_darah')->nullable();
            $table->foreign('id_golongan_darah')->references('id')->on('golongan_darah')->onDelete('cascade');
            $table->unsignedBigInteger('id_provinsi')->nullable();
            $table->foreign('id_provinsi')->references('id')->on('provinsi')->onDelete('cascade');
            $table->unsignedBigInteger('id_kabupaten')->nullable();
            $table->foreign('id_kabupaten')->references('id')->on('kabupaten')->onDelete('cascade');
            $table->unsignedBigInteger('id_kecamatan')->nullable();
            $table->foreign('id_kecamatan')->references('id')->on('kecamatan')->onDelete('cascade');
            $table->unsignedBigInteger('id_kelurahan')->nullable();
            $table->foreign('id_kelurahan')->references('id')->on('kelurahan')->onDelete('cascade');
            $table->string('address')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('penduduk')->whereNotIn('gender', ['L', 'P']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
