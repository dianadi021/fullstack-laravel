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
        Schema::create('client_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id')->on('list_clients')->onDelete('cascade');
            $table->unsignedBigInteger('id_menu');
            $table->foreign('id_menu')->references('id')->on('list_menus')->onDelete('cascade');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('client_permissions');
    }
};
