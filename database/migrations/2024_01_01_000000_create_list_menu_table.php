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
            $table->integer('is_parent')->nullable()->default(0);
            $table->unsignedBigInteger('id_parent')->nullable();
            $table->foreign('id_parent')->references('id')->on('list_menus')->onDelete('cascade');
            $table->integer('is_deleted')->default(0);
            $table->timestamp("deleted_at")->nullable();
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
