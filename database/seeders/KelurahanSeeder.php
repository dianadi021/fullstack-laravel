<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setlocale(LC_TIME, 'id_ID.utf8');

        $jsonPath = database_path("seeders/wilayah_idn/kelurahan.json");
        $jsonDataKels = File::get($jsonPath);
        $kels = json_decode($jsonDataKels, true);

        $arryDatas = [];
        foreach (array_chunk($kels, 1000) as $chunk) {
            $arryDatas = [];
            foreach ($chunk as $kel) {
                $arryDatas[] = [
                    "id" => $kel['id'],
                    "name" => $kel['name'],
                    "postal_code" => $kel['pos_code'],
                    "code" => $kel['code'],
                    "full_code" => $kel['full_code'],
                    "id_kecamatan" => $kel['kecamatan_id'],
                ];
            }
            DB::table('kelurahan')->insert($arryDatas);
        }
    }
}
