<?php

namespace App\Services\Api;

use Error;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

use App\Traits\Tools;
use App\Traits\ResponseCode;

use App\Models\Visit;
use App\Models\Pasien;
use App\Models\Penduduk;
use App\Models\Kunjungan;

class PasienRegisterService
{
    use ResponseCode, Tools;
    private $dateNow, $selectColmn, $checkForm;
    public function __construct()
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        $this->dateNow = now(env('APP_TIMEZONE', 'Asia/Jakarta'));

        $this->selectColmn = [
        ];

        $this->checkForm = [
        ];
    }

    public function index()
    {
        try {
            $qry = "SELECT pas.id AS norm, ppas.nik, ppas.fullname, ppas.handphone, ppas.whatsapp, ppas.telegram, ppas.birthdate, ppas.address, gndr.name AS jenis_kelamin, goldar.name AS goldar, ppas.id_provinsi, prov.name AS provinsi, ppas.id_kabupaten, kab.name AS kabupaten, ppas.id_kecamatan, kec.name AS kecamatan, ppas.id_kelurahan, kel.name AS kelurahan FROM PASIEN pas JOIN penduduk ppas ON ppas.id = pas.id_penduduk JOIN GENDER gndr ON gndr.id = ppas.id_gender JOIN GOLONGAN_DARAH goldar ON goldar.id = ppas.id_golongan_darah JOIN PROVINSI prov ON prov.id = ppas.id_provinsi JOIN KABUPATEN kab ON kab.id = ppas.id_kabupaten JOIN KECAMATAN kec ON kec.id = ppas.id_kecamatan JOIN KELURAHAN kel ON kel.id = ppas.id_kelurahan ORDER BY ppas.nama ASC";
            return DB::select("$qry");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function store(Request $req)
    {
        try {
            if (!$this->IsValidAddress($req)) {
                throw new Error("alamat tidak valid");
            }

            DB::beginTransaction();
            if (!$this->isValidVal($req->norm_pasien)) {
                $penduduk = Penduduk::create([
                    'nik' => $req->nik_pasien,
                    'fullname' => $req->nama_pasien,
                    'handphone' => $req->handphone_pasien,
                    'whatsapp' => $req->whatsapp_pasien,
                    'telegram' => $req->telegram_pasien,
                    'birthdate' => $req->tanggal_lahir,
                    'address' => $req->address_pasien,
                    'id_gender' => $req->gender,
                    'id_golongan_darah' => $req->goldar,
                    'id_provinsi' => $req->id_provinsi,
                    'id_kabupaten' => $req->id_kabupaten,
                    'id_kecamatan' => $req->id_kecamatan,
                    'id_kelurahan' => $req->id_kelurahan,
                    'id_user_created' => $req->id_user,
                    'created_at' => $this->dateNow
                ]);

                $pasien = Pasien::create([
                    'id_penduduk' => $penduduk->id,
                    'id_client' => $req->id_client,
                    'id_user_created' => $req->id_user,
                    'created_at' => $this->dateNow
                ]);
            }

            $id_pasien = ($this->IsValidVal($req->norm_pasien) ? $req->norm_pasien : $pasien->id);
            $visit = Visit::create([
                'id_pasien' => $id_pasien,
                'id_client' => $req->id_client,
                'id_user_created' => $req->id_user,
                'created_at' => $this->dateNow
            ]);

            $kunjungan = Kunjungan::create([
                'id_visit' => $visit->id,
                // 'id_nakes' => $req->nakes,
                // 'id_bed' => $req->bed,
                'id_pasien' => $id_pasien,
                'waktu_masuk' => $this->dateNow,
                'id_client' => $req->id_client,
                'id_user_created' => $req->id_user,
                'created_at' => $this->dateNow
            ]);

            DB::commit();

            return $kunjungan;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function show(string $id)
    {
        try {
            $qry = "SELECT pas.id AS norm, ppas.nik, ppas.fullname, ppas.handphone, ppas.whatsapp, ppas.telegram, ppas.birthdate, ppas.address, gndr.name AS jenis_kelamin, goldar.name AS goldar, ppas.id_provinsi, prov.name AS provinsi, ppas.id_kabupaten, kab.name AS kabupaten, ppas.id_kecamatan, kec.name AS kecamatan, ppas.id_kelurahan, kel.name AS kelurahan FROM PASIEN pas JOIN penduduk ppas ON ppas.id = pas.id_penduduk AND pas.id = $id JOIN GENDER gndr ON gndr.id = ppas.id_gender JOIN GOLONGAN_DARAH goldar ON goldar.id = ppas.id_golongan_darah JOIN PROVINSI prov ON prov.id = ppas.id_provinsi JOIN KABUPATEN kab ON kab.id = ppas.id_kabupaten JOIN KECAMATAN kec ON kec.id = ppas.id_kecamatan JOIN KELURAHAN kel ON kel.id = ppas.id_kelurahan ORDER BY ppas.nama ASC";
            return DB::select("$qry");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function update(Request $req, string $id)
    {
        try {
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function destroy(string $id)
    {
        try {
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
