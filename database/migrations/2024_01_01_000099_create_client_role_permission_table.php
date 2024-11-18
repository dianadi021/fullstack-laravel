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
        Schema::create('client_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_menu')->comment("Didapat dari tabel client_premission");
            $table->foreign('id_menu')->references('id')->on('list_menu')->onDelete('cascade');
            $table->unsignedBigInteger('id_client_role');
            $table->foreign('id_client_role')->references('id')->on('client_roles')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->foreign('id_user_created')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('client_role_permissions');
    }
};
