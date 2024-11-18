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
            $table->enum('jenis_unit', ['Rawat Darurat', 'Rawat Jalan', 'Rawat Inap'])->comment('Rawat Darurat', 'Rawat Jalan', 'Rawat Inap');
            // ENUM SET END

            $table->string('description')->nullable();
            $table->boolean('is_actived')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit');
    }
};
