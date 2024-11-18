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
        Schema::create('billing', function (Blueprint $table) {
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
                DB::statement("DROP TYPE IF EXISTS status_billing_pasien");
                DB::statement("CREATE TYPE status_billing_pasien AS ENUM ('Belum', 'Lunas', 'Dicicil', 'Batal')");
                $table->string('is_lunas')->default('Belum')->comment("Belum, Lunas, Dicicil, Batal");
            }

            if ($dbDriver === 'mysql') {
                $table->enum('is_lunas', ['Belum', 'Lunas', 'Dicicil', 'Batal'])->default('Belum');
            }
            // ENUM SET END

            $table->decimal('total_tagihan', 15, 2)->default(0)->comment("Total Tagihan = SUM(Sub Total Tagihan Detail Billing)");
            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->foreign('id_user_created')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('billing')->whereNotIn('is_lunas', ['Belum', 'Lunas', 'Dicicil', 'Batal'])->update(['is_lunas' => 'Belum']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billing', function (Blueprint $table) {
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                DB::statement("DROP TYPE IF EXISTS status_billing_pasien");
            }

            if ($dbDriver === 'mysql') {
                $table->dropColumn(['is_lunas']);
            }
        });

        Schema::dropIfExists('billing');
    }
};
