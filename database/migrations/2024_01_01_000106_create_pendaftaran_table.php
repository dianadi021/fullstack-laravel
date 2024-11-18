<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pasien');
            $table->foreign('id_pasien')->references('id')->on('pasien')->onDelete('cascade');
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id')->on('list_clients')->onDelete('cascade');

            // ENUM SET START
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                DB::statement("DROP TYPE IF EXISTS status_billing_pendaftaran");
                DB::statement("CREATE TYPE status_billing_pendaftaran AS ENUM ('Belum', 'Lunas', 'Dicicil', 'Batal')");
                $table->string('is_lunas')->default('Belum')->comment("Belum, Lunas, Dicicil, Batal");

                DB::statement("DROP TYPE IF EXISTS status_jenis_pasien");
                DB::statement("CREATE TYPE status_jenis_pasien AS ENUM ('Baru', 'Lama')");
                $table->string('jenis_pasien')->default('Baru')->comment("Baru, Lama");

                DB::statement("DROP TYPE IF EXISTS status_pendaftaran_pasien");
                DB::statement("CREATE TYPE status_pendaftaran_pasien AS ENUM ('Batal', 'Menunggu', 'Diperiksa', 'Resep', 'Ranap', 'Selesai', 'Booking')");
                $table->string('status_pendaftaran')->default('Menunggu')->comment("Batal, Menunggu, Diperiksa, Resep, Ranap, Selesai, Booking");
            }

            if ($dbDriver === 'mysql') {
                $table->enum('is_lunas', ['Belum', 'Lunas', 'Dicicil', 'Batal'])->default('Belum');
                $table->enum('jenis_pasien', ['Baru', 'Lama'])->default('Baru');
                $table->enum('status_pendaftaran', ['Batal', 'Menunggu', 'Diperiksa', 'Resep', 'Ranap', 'Selesai', 'Booking'])->default('Menunggu');
            }
            // ENUM SET END

            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->foreign('id_user_created')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('pendaftaran')->whereNotIn('is_lunas', ['Belum', 'Lunas', 'Dicicil', 'Batal'])->update(['is_lunas' => 'Belum']);
        DB::table('pendaftaran')->whereNotIn('jenis_pasien', ['Baru', 'Lama'])->update(['jenis_pasien' => 'Baru']);
        DB::table('pendaftaran')->whereNotIn('status_pendaftaran', ['Batal', 'Menunggu', 'Diperiksa', 'Resep', 'Ranap', 'Selesai', 'Booking'])->update(['status_pendaftaran' => 'Menunggu']);
    }

    public function down()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                DB::statement("DROP TYPE IF EXISTS status_billing_pendaftaran");
                DB::statement("DROP TYPE IF EXISTS status_jenis_pasien");
                DB::statement("DROP TYPE IF EXISTS status_pendaftaran_pasien");
            }

            if ($dbDriver === 'mysql') {
                $table->dropColumn(['is_lunas', 'jenis_pasien', 'status_pendaftaran']);
            }
        });

        Schema::dropIfExists('pendaftaran');
    }
};
