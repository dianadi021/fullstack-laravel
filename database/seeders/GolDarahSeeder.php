<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GolDarahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setlocale(LC_TIME, 'id_ID.utf8');

        $datas = [
            [
                "name" => "A"
            ],
            [
                "name" => "B"
            ],
            [
                "name" => "AB"
            ],
            [
                "name" => "O"
            ],
        ];

        DB::table('golongan_darah')->insert($datas);
    }
}
