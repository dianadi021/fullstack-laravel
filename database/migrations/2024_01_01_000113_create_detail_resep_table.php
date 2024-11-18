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
        Schema::create('detail_resep', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_resep');
            $table->foreign('id_resep')->references('id')->on('resep')->onDelete('cascade');
            $table->decimal('sub_total_resep', 15, 2)->default(0);
            $table->decimal('sub_diskon_percent', 15, 2)->default(0);
            $table->decimal('sub_diskon_currency', 15, 2)->default(0);
            $table->decimal('sub_pelayanan', 15, 2)->default(0);
            $table->decimal('sub_sarana', 15, 2)->default(0);
            $table->decimal('sub_tuslah', 15, 2)->default(0);
            $table->decimal('sub_embalase', 15, 2)->default(0);
            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->foreign('id_user_created')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('detail_resep');
    }
};
