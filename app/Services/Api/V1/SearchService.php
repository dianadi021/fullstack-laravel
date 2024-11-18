<?php

namespace App\Services\Api\V1;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Traits\Tools;

class SearchService
{
    use Tools;

    public function params($req)
    {
        try {
            $fxdResultReturn = [];

            $id_provinsi = $this->GetFlexibleRequest($req, 'provinsi');
            $id_kabupaten = $this->GetFlexibleRequest($req, 'kabupaten');
            $id_kecamatan = $this->GetFlexibleRequest($req, 'kecamatan');
            $id_kelurahan = $this->GetFlexibleRequest($req, 'kelurahan');
            $q = $req->q;

            switch ($req->get_data) {
                case 'provinsi':
                    $wheres = ($this->IsValidVal($id_provinsi) ? " WHERE prov.id = '$id_provinsi' AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($q) ? " LOWER(prov.name) LIKE LOWER('$q%') " : " 1=1 ");

                    $qry = "SELECT prov.id, prov.name FROM provinsi prov $wheres ORDER BY prov.name ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'kabupaten':
                    $wheres = ($this->IsValidVal($id_provinsi) ? " WHERE prov.id = '$id_provinsi' AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($id_kabupaten) ? " kab.id = '$id_kabupaten' AND " : "");
                    $wheres .= ($this->IsValidVal($q) ? " LOWER(kab.name) LIKE LOWER('$q%') " : " 1=1 ");

                    $qry = "SELECT kab.id, kab.name, kab.type, prov.name AS provinsi FROM kabupaten kab JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kab.name ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'kecamatan':
                    $wheres = ($this->IsValidVal($id_provinsi) ? " WHERE prov.id = '$id_provinsi' AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($id_kabupaten) ? " kab.id = '$id_kabupaten' AND " : "");
                    $wheres .= ($this->IsValidVal($id_kecamatan) ? " kec.id = '$id_kecamatan' AND " : "");
                    $wheres .= ($this->IsValidVal($q) ? " LOWER(kec.name) LIKE LOWER('$q%') " : " 1=1 ");

                    $qry = "SELECT kec.id, kec.name, kab.name AS kabupaten, prov.name AS provinsi FROM kecamatan kec JOIN kabupaten kab ON kab.id = kec.id_kabupaten JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kec.name ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'kelurahan':
                    $wheres = ($this->IsValidVal($id_provinsi) ? " WHERE prov.id = '$id_provinsi' AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($id_kabupaten) ? " kab.id = '$id_kabupaten' AND " : "");
                    $wheres .= ($this->IsValidVal($id_kecamatan) ? " kec.id = '$id_kecamatan' AND " : "");
                    $wheres .= ($this->IsValidVal($id_kelurahan) ? " kel.id = '$id_kelurahan' AND " : "");
                    $wheres .= ($this->IsValidVal($q) ? " LOWER(kel.name) LIKE LOWER('$q%') " : " 1=1 ");

                    $qry = "SELECT kel.id, kel.name, kel.postal_code, kec.name AS kecamatan, kab.name AS kabupaten, prov.name AS provinsi FROM kelurahan kel JOIN kecamatan kec ON kec.id = kel.id_kecamatan JOIN kabupaten kab ON kab.id = kec.id_kabupaten JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kel.name ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'goldar':
                    $wheres = ($this->IsValidVal($req->id_goldar) ? " WHERE goldar.id = '$req->id_goldar' AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($q) ? " LOWER(goldar.name) LIKE LOWER('$q%') " : " 1=1 ");

                    $qry = "SELECT goldar.id, goldar.name FROM goldar goldar $wheres ORDER BY goldar.name ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'roles':
                    $wheres = ($this->IsValidVal($req->id_role) ? " WHERE rol.id = '$req->id_role' AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($q) ? " LOWER(rol.name) LIKE LOWER('$q%') " : " 1=1 ");

                    $qry = "SELECT * FROM roles rol $wheres ORDER BY rol.level ASC";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'users':
                    $wheres = ($this->IsValidVal($req->id_user) ? " WHERE usr.id = '$req->id_user' AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->id_role) ? " usr.id_role = '$req->id_role' AND " : "");
                    $wheres .= ($this->IsValidVal($req->id_client) ? " usr.id_client = '$req->id_client' AND " : "");
                    $wheres .= ($this->IsValidVal($q) ? " LOWER(usr.username) LIKE LOWER('$q%') " : " 1=1 ");

                    $qry = "SELECT usr.username, usr.email, usr.is_actived, usr.id_role, rol.name AS role_name, pdd.fullname, usr.id_client FROM users usr JOIN penduduk pdd ON pdd.id = usr.id_penduduk JOIN roles rol ON rol.id = usr.id_role $wheres ";
                    $fxdResultReturn = DB::select("$qry");
                    break;

                case 'list_pasien_lama':
                    $wheres = ($this->IsValidVal($req->id_pasien) ? " WHERE pas.id = '$req->id_pasien' AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($q) ? " LOWER(pas.fullname) LIKE LOWER('$q%') " : " 1=1 ");

                    $qry = "SELECT pas.id AS id_pasien, pas.id AS norm, ppas.nik, ppas.fullname, ppas.goldar, ppas.birthdate, ppas.alamat_ktp, ppas.gender, ppas.gender AS jenis_kelamin, ppas.id_provinsi, prov.name AS provinsi, ppas.id_kabupaten, kab.name AS kabupaten, ppas.id_kecamatan, kec.name AS kecamatan, ppas.id_kelurahan, kel.name AS kelurahan FROM pasien pas LEFT JOIN penduduk ppas ON ppas.id = pas.id_penduduk LEFT JOIN provinsi prov ON prov.id = ppas.id_provinsi LEFT JOIN kabupaten kab ON kab.id = ppas.id_kabupaten LEFT JOIN kecamatan kec ON kec.id = ppas.id_kecamatan LEFT JOIN kelurahan kel ON kel.id = ppas.id_kelurahan $wheres ORDER BY ppas.fullname ASC ";
                    $fxdResultReturn = DB::select("$qry");
                    $fxdResultReturn = json_decode(json_encode($fxdResultReturn), true);

                    for ($i = 0; $i < count($fxdResultReturn); $i++) {
                        $fxdResultReturn[$i]["norm"] = $this->reformatNoRM($fxdResultReturn[$i]["norm"]);
                    }

                    for ($i = 0; $i < count($fxdResultReturn); $i++) {
                        $fxdResultReturn[$i]["birthdate"] = $this->ReformatDateTime($fxdResultReturn[$i]["birthdate"], false, "d-m-Y");
                    }

                    for ($i = 0; $i < count($fxdResultReturn); $i++) {
                        $fxdResultReturn[$i]["jenis_kelamin"] = $fxdResultReturn[$i]["jenis_kelamin"] == "L" ? "Laki-laki" : "Perempuan";
                    }

                    break;

                case 'list_pasien_pelaksanaan_pelayanan_kunjungan':
                    $wheres = ($this->IsValidVal($req->id_pasien) ? " WHERE pas.id = '$req->id_pasien' AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->tanggal_awal) && $this->IsValidVal($req->tanggal_akhir) ? " kun.waktu_masuk BETWEEN to_timestamp('$req->tanggal_awal 00:00:00', 'dd-mm-yyyy hh24:mi:ss') AND to_timestamp('$req->tanggal_akhir 23:59:59', 'dd-mm-yyyy hh24:mi:ss') AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->nama_pasien) ? " LOWER(pas.fullname) LIKE LOWER('$req->nama_pasien%') " : " 1=1 ");

                    $qry = "SELECT kun.id id_kunjungan, kun.id_pasien norm, ppas.nik, ppas.fullname nama_pasien, ppas.alamat_ktp alamat FROM kunjungan kun
                    JOIN pendaftaran pndftr ON pndftr.id = kun.id_pendaftaran
                    JOIN pasien pas ON pas.id = kun.id_pasien
                    JOIN penduduk ppas ON ppas.id = pas.id_penduduk $wheres";

                    $fxdResultReturn = DB::select("$qry");
                    $fxdResultReturn = json_decode(json_encode($fxdResultReturn), true);

                    for ($i = 0; $i < count($fxdResultReturn); $i++) {
                        $fxdResultReturn[$i]["norm"] = $this->reformatNoRM($fxdResultReturn[$i]["norm"]);
                    }

                    break;

                case 'data_pasien_by_kunjungan':
                    return $this->GetDataPasienByIdKunjungan($req->id_kunjungan);
                    break;

                default:
                    break;
            }

            return $fxdResultReturn;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function GetDataPasienByIdKunjungan($id_kunjungan)
    {
        try {
            $fxdResultReturn = [];

            if ($this->IsValidVal($id_kunjungan)) {
                $wheres = ($this->IsValidVal($id_kunjungan) ? " WHERE kun.id = '$id_kunjungan' " : "");

                $qry = "SELECT kun.created_at tanggal_kunjungan, pas.id AS id_pasien, pas.id AS norm, ppas.nik, ppas.fullname, ppas.goldar, ppas.birthdate, ppas.address, ppas.gender AS jenis_kelamin, ppas.id_provinsi, prov.name AS provinsi, ppas.id_kabupaten, kab.name AS kabupaten, ppas.id_kecamatan, kec.name AS kecamatan, ppas.id_kelurahan, kel.name AS kelurahan FROM kunjungan kun
                JOIN pasien pas ON pas.id = kun.id_pasien LEFT JOIN penduduk ppas ON ppas.id = pas.id_penduduk LEFT JOIN provinsi prov ON prov.id = ppas.id_provinsi LEFT JOIN kabupaten kab ON kab.id = ppas.id_kabupaten LEFT JOIN kecamatan kec ON kec.id = ppas.id_kecamatan LEFT JOIN kelurahan kel ON kel.id = ppas.id_kelurahan $wheres ORDER BY ppas.fullname ASC ";

                $fxdResultReturn = DB::selectOne("$qry");
                $fxdResultReturn = json_decode(json_encode($fxdResultReturn), true);
                $fxdResultReturn["tanggal_kunjungan"] = $this->ReformatDateTime($fxdResultReturn["tanggal_kunjungan"], false, "d-m-Y H:i:s");
                $fxdResultReturn["norm"] = $this->reformatNoRM($fxdResultReturn["norm"]);
                $fxdResultReturn["birthdate"] = $this->ReformatDateTime($fxdResultReturn["birthdate"], false, "d-m-Y");
                $fxdResultReturn["umur"] = $this->GetAgedByBirthDate($fxdResultReturn["birthdate"], "d-m-Y");
                $fxdResultReturn["jenis_kelamin"] = $fxdResultReturn["jenis_kelamin"] == "L" ? "Laki-laki" : "Perempuan";
                $fxdResultReturn["full_address"] = $fxdResultReturn["address"] . ", " . $fxdResultReturn["kelurahan"] . ", " . $fxdResultReturn["kecamatan"] . ", " . $fxdResultReturn["kabupaten"] . ", " . $fxdResultReturn["provinsi"];
            }

            return $fxdResultReturn;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function GetFlexibleRequest($req, $base)
    {
        return $req->input($base)
            ?: collect($req->all())->first(fn($v, $k) => Str::contains($k, $base) && Str::startsWith($k, 'id_') && $v);
    }
}
