<?php

namespace App\Http\Libraries;

use Illuminate\Support\Facades\DB;

class Tools
{
    public function IsValidVal($val, $get = ["bool", "value", "equal"], $other = null, $key = null)
    {
        $tmpVal = (isset($key) && $key != null ? (isset($val[$key]) ? $val[$key] : "") : (isset($val) ? $val : ""));
        if (isset($tmpVal)) {
            if ($get == "value") {
                if (isset($other) && $other != null) {
                    return !empty($tmpVal) || $tmpVal == 0 ? $tmpVal : $other;
                } else {
                    return !empty($tmpVal) || $tmpVal == 0 ? $tmpVal : "";
                }
            } else if (isset($other) && $other != null && $get == "equal") {
                return $tmpVal == $other;
            } else if (!empty($tmpVal)) {
                return true;
            } else {
                return false;
            }
        }

        return $get == "value" ? "" : false;
    }

    public function isValidAddress($req)
    {
        $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
        $wheres .= ($this->IsValidVal($req->id_kabupaten) ? " kab.id = $req->id_kabupaten AND " : "");
        $wheres .= ($this->IsValidVal($req->id_kecamatan) ? " kec.id = $req->id_kecamatan AND " : "");
        $wheres .= ($this->IsValidVal($req->id_kelurahan) ? " kel.id = $req->id_kelurahan AND " : "");
        $wheres .= ($this->IsValidVal($req->q) ? " $wheres LOWER(kel.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

        $qry = "SELECT kel.id, kel.name, kel.postal_code, kec.name as kecamatan, kab.name as kabupaten, prov.name as provinsi FROM kelurahan kel JOIN kecamatan kec ON kec.id = kel.id_kecamatan JOIN kabupaten kab ON kab.id = kec.id_kabupaten JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kel.name ASC";
        $datas = DB::select("$qry");
        return $datas;
    }
}
