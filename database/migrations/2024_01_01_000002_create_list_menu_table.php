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
        Schema::create('list_menu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->default('assets/images/icons/12087772.png');
            $table->string('route_name')->nullable();
            $table->string('link')->nullable();
            $table->string('type')->nullable();
            $table->boolean('is_parent')->default(false);
            $table->unsignedBigInteger('id_parent')->nullable();
            $table->foreign('id_parent')->references('id')->on('list_menu')->onDelete('cascade');
            $table->unsignedBigInteger('id_tier_level')->default(1);
            $table->foreign('id_tier_level')->references('id')->on('tier_level')->onDelete('cascade');
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
        Schema::dropIfExists('list_menu');
    }
};
