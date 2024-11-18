<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class KabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setlocale(LC_TIME, 'id_ID.utf8');

        $jsonPath = database_path("seeders/wilayah_idn/kabupaten.json");
        $jsonDataKabs = File::get($jsonPath);
        $kabs = json_decode($jsonDataKabs, true);

        $arryDatas = [];
        foreach ($kabs as $kab) {
            $data = [
                "id" => $kab['id'],
                "type" => $kab['type'],
                "name" => $kab['name'],
                "code" => $kab['code'],
                "full_code" => $kab['full_code'],
                "id_provinsi" => $kab['provinsi_id'],
            ];
            array_push($arryDatas, $data);
        };

        DB::table('kabupaten')->insert($arryDatas);
    }
}
