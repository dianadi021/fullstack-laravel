<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setlocale(LC_TIME, 'id_ID.utf8');

        $arryDatas = [
            [
                'name' => 'Free',
                'level' => 0,
                'description' => 'Pendaftaran & Rekam Medis'
            ],
            [
                'name' => 'Minimum Klinik',
                'level' => 1,
                'description' => 'Pendaftaran, Rekam Medis & Transaction (Billing & Penjualan) *No Logistik'
            ],
            [
                'name' => 'Full Klinik',
                'level' => 2,
                'description' => 'Pendaftaran, Rekam Medis, Informasi (Kunjungan, Penjualan) & Transaction (Billing & Penjualan) *No Logistik'
            ],
            [
                'name' => 'Minimum SIMRS',
                'level' => 3,
                'description' => 'Pendaftaran, Rekam Medis, Informasi (Kunjungan, Penjualan, Billing), Logistik & Transaction (Billing & Penjualan)'
            ],
            [
                'name' => 'Full SIMRS',
                'level' => 4,
                'description' => 'Pendaftaran, Rekam Medis, Informasi (Kunjungan, Penjualan, Billing, Outcome/Income), Logistik & Transaction (Billing & Penjualan)'
            ],
        ];

        DB::table('tier_level')->insert($arryDatas);
    }
}
