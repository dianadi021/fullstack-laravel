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
        Schema::create('unit', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();

            // ENUM SET START
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                DB::statement("DROP TYPE IF EXISTS jenis_unit");
                DB::statement("CREATE TYPE jenis_unit AS ENUM ('Rawat Darurat', 'Rawat Jalan', 'Rawat Inap')");
                $table->string('jenis_unit')->comment("Rawat Darurat, Rawat Jalan, Rawat Inap");
            }

            if ($dbDriver === 'mysql') {
                $table->enum('jenis_unit', ['Rawat Darurat', 'Rawat Jalan', 'Rawat Inap'])->comment("Rawat Darurat, Rawat Jalan, Rawat Inap");
            }
            // ENUM SET END

            $table->string('description')->nullable();
            $table->boolean('is_actived')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('unit')->whereNotIn('jenis_unit', ['Rawat Darurat', 'Rawat Jalan', 'Rawat Inap']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit', function (Blueprint $table) {
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                DB::statement("DROP TYPE IF EXISTS jenis_unit");
            }

            if ($dbDriver === 'mysql') {
                $table->dropColumn(['jenis_unit']);
            }
        });


        Schema::dropIfExists('unit');
    }
};
