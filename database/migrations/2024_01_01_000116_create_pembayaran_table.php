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
        Schema::create('pembayaran', function (Blueprint $table) {
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
                DB::statement("DROP TYPE IF EXISTS status_pembayaran_pasien");
                DB::statement("CREATE TYPE status_pembayaran_pasien AS ENUM ('Belum', 'Lunas', 'Dicicil', 'Batal')");
                $table->string('is_lunas')->default('Belum')->comment("Belum, Lunas, Dicicil, Batal");
            }

            if ($dbDriver === 'mysql') {
                $table->enum('is_lunas', ['Belum', 'Lunas', 'Dicicil', 'Batal'])->default('Belum');
            }
            // ENUM SET END

            $table->decimal('total_tagihan', 15, 2)->default(0)->comment("Total Tagihan = SUM(Sub Total Tagihan Detail Pembayaran)");
            $table->decimal('total_bayar', 15, 2)->default(0)->comment("Total Bayar = SUM(Sub Total Bayar Riwayat Pembayaran) yang tidak batal bayar/is not deleted");
            $table->decimal('total_sisa_tagihan', 15, 2)->default(0)->comment("Total Sisa Tagihan = (Total Tagihan - Total Bayar) Or (Total Tagihan - SUM(Sub Total Bayar Riwayat Pembayaran)) (If 0 = Lunas)");


            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->foreign('id_user_created')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('pembayaran')->whereNotIn('is_lunas', ['Belum', 'Lunas', 'Dicicil', 'Batal'])->update(['is_lunas' => 'Belum']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                DB::statement("DROP TYPE IF EXISTS status_pembayaran_pasien");
            }

            if ($dbDriver === 'mysql') {
                $table->dropColumn(['is_lunas']);
            }
        });

        Schema::dropIfExists('pembayaran');
    }
};
