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
            $table->unsignedBigInteger('id_menu')->comment("Didapat dari level tier di tabel list_menu berdasarkan tier level");
            $table->foreign('id_menu')->references('id')->on('list_menus')->onDelete('cascade');
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id')->on('list_clients')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->foreign('id_user_created')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('client_permissions');
    }
};
