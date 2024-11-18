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
        Schema::create('gender', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();

            // ENUM SET START
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                DB::statement("DROP TYPE IF EXISTS jenis_kelamin_penduduk");
                DB::statement("CREATE TYPE jenis_kelamin_penduduk AS ENUM ('L', 'P')");
                $table->string('value')->comment("Laki - Laki, Perempuan");
            }

            if ($dbDriver === 'mysql') {
                $table->enum('value', ['L', 'P'])->comment("Laki - Laki, Perempuan");
            }
            // ENUM SET END

            $table->boolean('is_actived')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('gender')->whereNotIn('value', ['L', 'P']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gender', function (Blueprint $table) {
            $dbDriver = DB::connection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                DB::statement("DROP TYPE IF EXISTS jenis_kelamin_penduduk");
            }

            if ($dbDriver === 'mysql') {
                $table->dropColumn(['value']);
            }
        });

        Schema::dropIfExists('gender');
    }
};
