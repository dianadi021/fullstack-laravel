<?php

namespace App\Services\Api\V1;

use Illuminate\Support\Facades\DB;

use App\Traits\Tools;

class SearchService
{
    use Tools;

    public function params($req)
    {
        try {
            $fxdResultReturn = [];

            switch ($req->get_data) {
                case 'provinsi':
                    $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->q) ? " LOWER(prov.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                    $qry = "SELECT prov.id, prov.name FROM provinsi prov $wheres ORDER BY prov.name ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'kabupaten':
                    $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->id_kabupaten) ? " kab.id = $req->id_kabupaten AND " : "");
                    $wheres .= ($this->IsValidVal($req->q) ? " LOWER(kab.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                    $qry = "SELECT kab.id, kab.name, kab.type, prov.name AS provinsi FROM kabupaten kab JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kab.name ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'kecamatan':
                    $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->id_kabupaten) ? " kab.id = $req->id_kabupaten AND " : "");
                    $wheres .= ($this->IsValidVal($req->id_kecamatan) ? " kec.id = $req->id_kecamatan AND " : "");
                    $wheres .= ($this->IsValidVal($req->q) ? " LOWER(kec.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                    $qry = "SELECT kec.id, kec.name, kab.name AS kabupaten, prov.name AS provinsi FROM kecamatan kec JOIN kabupaten kab ON kab.id = kec.id_kabupaten JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kec.name ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'kelurahan':
                    $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->id_kabupaten) ? " kab.id = $req->id_kabupaten AND " : "");
                    $wheres .= ($this->IsValidVal($req->id_kecamatan) ? " kec.id = $req->id_kecamatan AND " : "");
                    $wheres .= ($this->IsValidVal($req->id_kelurahan) ? " kel.id = $req->id_kelurahan AND " : "");
                    $wheres .= ($this->IsValidVal($req->q) ? " LOWER(kel.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                    $qry = "SELECT kel.id, kel.name, kel.postal_code, kec.name AS kecamatan, kab.name AS kabupaten, prov.name AS provinsi FROM kelurahan kel JOIN kecamatan kec ON kec.id = kel.id_kecamatan JOIN kabupaten kab ON kab.id = kec.id_kabupaten JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kel.name ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'golongan_darah':
                    $wheres = ($this->IsValidVal($req->id_goldar) ? " WHERE goldar.id = $req->id_goldar AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->q) ? " LOWER(goldar.name) LIKE LOWER('$req->q%') " : " 1=1 ");

                    $qry = "SELECT goldar.id, goldar.name FROM golongan_darah goldar $wheres ORDER BY goldar.name ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'roles':
                    $wheres = ($this->IsValidVal($req->id_role) ? " WHERE rol.id = $req->id_role AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->q) ? " LOWER(rol.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                    $qry = "SELECT * FROM roles rol $wheres ORDER BY rol.level ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'users':
                    $wheres = ($this->IsValidVal($req->id_user) ? " WHERE usr.id = $req->id_user AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->id_role) ? " usr.id_role = $req->id_role AND " : "");
                    $wheres .= ($this->IsValidVal($req->id_client) ? " usr.id_client = $req->id_client AND " : "");
                    $wheres .= ($this->IsValidVal($req->q) ? " LOWER(usr.username) LIKE LOWER('%$req->q%') " : " 1=1 ");

                    $qry = "SELECT usr.username, usr.email, usr.is_actived, usr.id_role, rol.name AS role_name, pdd.fullname, usr.id_client FROM users usr JOIN penduduk pdd ON pdd.id = usr.id_penduduk JOIN roles rol ON rol.id = usr.id_role $wheres ";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'list_pasien_lama':
                    $wheres = ($this->IsValidVal($req->id_pasien) ? " WHERE pas.id = $req->id_pasien AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->q) ? " LOWER(pas.fullname) LIKE LOWER('%$req->q%') " : " 1=1 ");

                    $qry = "SELECT pas.id AS id_pasien, pas.id AS norm, ppas.nik, ppas.fullname, ppas.handphone, ppas.whatsapp, ppas.telegram, ppas.birthdate, ppas.address, ppas.gender, ppas.gender AS jenis_kelamin, goldar.id AS id_goldar, goldar.name AS goldar, ppas.id_provinsi, prov.name AS provinsi, ppas.id_kabupaten, kab.name AS kabupaten, ppas.id_kecamatan, kec.name AS kecamatan, ppas.id_kelurahan, kel.name AS kelurahan FROM pasien pas LEFT JOIN penduduk ppas ON ppas.id = pas.id_penduduk LEFT JOIN golongan_darah goldar ON goldar.id = ppas.id_golongan_darah LEFT JOIN provinsi prov ON prov.id = ppas.id_provinsi LEFT JOIN kabupaten kab ON kab.id = ppas.id_kabupaten LEFT JOIN kecamatan kec ON kec.id = ppas.id_kecamatan LEFT JOIN kelurahan kel ON kel.id = ppas.id_kelurahan $wheres ORDER BY ppas.fullname ASC ";
                    $fxdResultReturn = DB::select("$qry");
                    $fxdResultReturn = json_decode(json_encode($fxdResultReturn), true);

                    for ($i=0; $i < count($fxdResultReturn); $i++) {
                        $fxdResultReturn[$i]["norm"] = $this->reformatNoRM($fxdResultReturn[$i]["norm"]);
                    }

                    for ($i=0; $i < count($fxdResultReturn); $i++) {
                        $fxdResultReturn[$i]["birthdate"] = $this->ReformatDateTime($fxdResultReturn[$i]["birthdate"], false, "d-m-Y");
                    }

                    for ($i=0; $i < count($fxdResultReturn); $i++) {
                        $fxdResultReturn[$i]["jenis_kelamin"] = $fxdResultReturn[$i]["jenis_kelamin"] == "L" ? "Laki-laki" : "Perempuan";
                    }

                    break;

                default:
                    break;
            }

            return $fxdResultReturn;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
