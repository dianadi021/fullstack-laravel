<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setlocale(LC_TIME, 'id_ID.utf8');

        $datas = [
            [
                "name" => "Laki - Laki",
                "value" => "L"
            ],
            [
                "name" => "Perempuan",
                "value" => "P"
            ],
            [
                "name" => "Pria",
                "value" => "L"
            ],
            [
                "name" => "Wanita",
                "value" => "P"
            ],
        ];

        DB::table('gender')->insert($datas);
    }
}
