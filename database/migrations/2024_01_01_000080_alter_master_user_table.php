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
        $listTables = [
            "configs",
            "tier_level",
            "list_menus",
            "roles",
            "role_permissions",
            "provinsi",
            "kabupaten",
            "kecamatan",
            "kelurahan",
            "icd_9",
            "icd_10",
            "profesi",
            "spesialisasi",
            "gender",
            "golongan_darah",
            "metode_bayar",
            "jenis_penjualan",
            "kelas",
            "unit",
            "bed",
            "perusahaan_asuransi",
            "produk_asuransi",
            "penduduk"
        ];
        foreach ($listTables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $this->SetUser($table);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_clients');
    }

    public function SetUser($table)
    {
        $table->unsignedBigInteger('id_user_created')->nullable();
        $table->foreign('id_user_created')->references('id')->on('users')->onDelete('cascade');
        $table->unsignedBigInteger('id_user_updated')->nullable();
        $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('cascade');
    }
};
