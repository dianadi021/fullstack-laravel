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
        Schema::create('list_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->default('assets/images/icons/12087772.png');
            $table->string('route_name')->nullable();
            $table->string('link')->nullable();
            $table->string('type')->nullable();
            $table->integer('is_parent')->default(0)->comment("0 Tidak, 1 Ya");
            $table->unsignedBigInteger('id_parent')->nullable();
            $table->foreign('id_parent')->references('id')->on('list_menus')->onDelete('cascade');
            $table->unsignedBigInteger('id_tier_level')->default(1);
            $table->foreign('id_tier_level')->references('id')->on('tier_level')->onDelete('cascade');
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
        Schema::dropIfExists('list_menus');
    }
};
