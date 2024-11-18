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
                "name" => "Laki - Laki"
            ],
            [
                "name" => "Perempuan"
            ],
            [
                "name" => "Pria"
            ],
            [
                "name" => "Wanita"
            ],
        ];

        DB::table('gender')->insert($datas);
    }
}
