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
        Schema::create('tier_level', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('level')->unique();
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
        Schema::dropIfExists('tier_level');
    }
};
