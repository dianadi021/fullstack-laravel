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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->unsignedBigInteger('id_role')->default(8);
            $table->foreign('id_role')->references('id')->on('roles')->onDelete('cascade');
            $table->unsignedBigInteger('id_penduduk')->nullable();
            $table->foreign('id_penduduk')->references('id')->on('penduduk')->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('ip_address')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('cascade');
            $table->integer('is_active')->default(1)->comment("0 Tidak, 1 Ya");
            $table->integer('is_deleted')->default(0)->comment("0 Tidak, 1 Ya");$table->softDeletes();
            $table->timestamp('expired_date')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
