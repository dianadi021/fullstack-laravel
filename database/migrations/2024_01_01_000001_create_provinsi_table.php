<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// https://github.com/ibnux/data-indonesia
// https://github.com/cahyadsn/db_rajaongkir
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('provinsi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('code');
            $table->string('name');
            $table->timestamp("deleted_at")->nullable();
            $table->integer('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinsi');
    }
};
