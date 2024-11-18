<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use App\Http\Libraries\Tools;

class ICDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // https://github.com/LuChang-CS/icd_hierarchical_structure
        setlocale(LC_TIME, 'id_ID.utf8');

        $jsonPath = database_path('seeders/icd/ICD-10/diagnosis_codes.json');
        $jsonData = File::get($jsonPath);
        $icd10 = json_decode($jsonData, true);

        $arryDatasICD10 = [];
        foreach ($icd10 as $list) {
            if (isset($list["children"]) && !empty($list["children"])) {
                foreach ($list["children"] as $listI) {
                    if (isset($listI["children"]) && !empty($listI["children"])) {
                        foreach ($listI["children"] as $listII) {
                            $arryDatasICD10[] = ["kode" => $listII["code"], "name" => $listII["desc"]];

                            if (isset($listII["children"]) && !empty($listII["children"])) {
                                foreach ($listII["children"] as $listIII) {
                                    $arryDatasICD10[] = ["kode" => $listIII["code"], "name" => $listIII["desc"]];
                                }
                            }
                        }
                    }
                }
            }
        }

        DB::table('icd_10')->insert($arryDatasICD10);

        $jsonPath = database_path('seeders/icd/ICD-9/procedure_codes.json');
        $jsonData = File::get($jsonPath);
        $icd9 = json_decode($jsonData, true);

        $arryDatasICD9 = [];
        foreach ($icd9 as $list) {
            if (isset($list["children"]) && !empty($list["children"])) {
                foreach ($list["children"] as $listI) {
                    if (isset($listI["children"]) && !empty($listI["children"])) {
                        foreach ($listI["children"] as $listII) {
                            $arryDatasICD9[] = ["kode" => $listII["code"], "name" => $listII["desc"]];

                            if (isset($listII["children"]) && !empty($listII["children"])) {
                                foreach ($listII["children"] as $listIII) {
                                    $arryDatasICD9[] = ["kode" => $listIII["code"], "name" => $listIII["desc"]];
                                }
                            }
                        }
                    }
                }
            }
        }

        DB::table('icd_9')->insert($arryDatasICD9);
    }
}
