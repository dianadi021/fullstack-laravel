<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bed', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('id_unit')->nullable();
            $table->foreign('id_unit')->references('id')->on('unit')->onDelete('cascade');
            $table->unsignedBigInteger('id_kelas')->nullable();
            $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('cascade');
            $table->integer('is_active')->default(1)->comment("0 Tidak, 1 Ya");
            $table->integer('is_deleted')->default(0)->comment("0 Tidak, 1 Ya");$table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bed');
    }
};
