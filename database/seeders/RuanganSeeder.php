<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setlocale(LC_TIME, 'id_ID.utf8');

        $datas = [
            [
                "name" => "IGD / UGD",
                "jenis_unit" => "Rawat Darurat"
            ],
        ];

        DB::table('unit')->insert($datas);
    }
}
