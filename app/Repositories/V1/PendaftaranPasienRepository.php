<?php

namespace App\Repositories\V1;

use Error;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

use App\Traits\Tools;
use App\Traits\ResponseCode;

use App\Models\Pasien;
use App\Models\Penduduk;
use App\Models\Kunjungan;
use App\Models\Pendaftaran;

class PendaftaranPasienRepository
{
    use ResponseCode, Tools;
    private $userSession, $userSessionRedis, $dateNow, $selectColmn, $checkForm;
    public function __construct()
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        $this->dateNow = now(env('APP_TIMEZONE', 'Asia/Jakarta'));

        $this->selectColmn = [];

        $this->checkForm = [];
    }

    public function index()
    {
        $qry = "SELECT pas.id AS id_pasien, pas.id AS norm, ppas.nik, ppas.fullname, ppas.handphone, ppas.whatsapp, ppas.telegram, ppas.birthdate, ppas.address, ppas.gender, goldar.id AS id_goldar, goldar.name AS goldar, ppas.id_provinsi, prov.name AS provinsi, ppas.id_kabupaten, kab.name AS kabupaten, ppas.id_kecamatan, kec.name AS kecamatan, ppas.id_kelurahan, kel.name AS kelurahan FROM pasien pas LEFT JOIN penduduk ppas ON ppas.id = pas.id_penduduk LEFT JOIN golongan_darah goldar ON goldar.id = ppas.id_golongan_darah LEFT JOIN provinsi prov ON prov.id = ppas.id_provinsi LEFT JOIN kabupaten kab ON kab.id = ppas.id_kabupaten LEFT JOIN kecamatan kec ON kec.id = ppas.id_kecamatan LEFT JOIN kelurahan kel ON kel.id = ppas.id_kelurahan ORDER BY ppas.fullname ASC";

        return DB::select("$qry");
    }

    public function store(object $req)
    {

        try {
            if (!$this->IsValidAddress($req)) {
                throw new Error("Alamat tidak valid");
            }

            $dataPenduduk = Penduduk::whereNotNull('nik')->where('nik', $req->nik)->first();

            DB::beginTransaction();

            if (!$this->IsValidVal($dataPenduduk)) {
                $penduduk = Penduduk::create($req);
            } else {
                $dataPenduduk->update((array) $req);
            }

            $id_penduduk = (isset($dataPenduduk->id)) ? $dataPenduduk->id : $penduduk->id;

            if (!$this->isValidVal($req->norm_pasien)) {
                $pasien = Pasien::create([
                    'id_penduduk' => $id_penduduk,
                    'id_client' => $req->id_client,
                    'id_user_created' => $req->id_user_created,
                    'created_at' => $this->dateNow
                ]);
            }

            $id_pasien = ($this->IsValidVal($req->norm_pasien) ? $req->norm_pasien : $pasien->id);

            $pendaftaran = Pendaftaran::create([
                'id_pasien' => $id_pasien,
                'id_client' => $req->id_client,
                'jenis_pasien' => $req->jenis_pasien,
                'id_user_created' => $req->id_user_created,
                'created_at' => $this->dateNow
            ]);

            $kunjungan = Kunjungan::create([
                'id_pendaftaran' => $pendaftaran->id,
                // 'id_nakes' => $req->nakes,
                // 'id_bed' => $req->bed,
                'id_pasien' => $id_pasien,
                'waktu_masuk' => $this->dateNow,
                'id_client' => $req->id_client,
                'id_user_created' => $req->id_user_created,
                'created_at' => $this->dateNow
            ]);

            DB::commit();

            return $this->OKE($kunjungan);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->SERVER_ERROR($th->getMessage());
        }
    }

    public function show(string $id)
    {
        $qry = "SELECT pas.id AS id_pasien, pas.id AS norm, ppas.nik, ppas.fullname, ppas.handphone, ppas.whatsapp, ppas.telegram, ppas.birthdate, ppas.address, ppas.gender, goldar.id AS id_goldar, goldar.name AS goldar, ppas.id_provinsi, prov.name AS provinsi, ppas.id_kabupaten, kab.name AS kabupaten, ppas.id_kecamatan, kec.name AS kecamatan, ppas.id_kelurahan, kel.name AS kelurahan FROM pasien pas LEFT JOIN penduduk ppas ON ppas.id = pas.id_penduduk AND pas.id = $id LEFT JOIN golongan_darah goldar ON goldar.id = ppas.id_golongan_darah LEFT JOIN provinsi prov ON prov.id = ppas.id_provinsi LEFT JOIN kabupaten kab ON kab.id = ppas.id_kabupaten LEFT JOIN kecamatan kec ON kec.id = ppas.id_kecamatan LEFT JOIN kelurahan kel ON kel.id = ppas.id_kelurahan ORDER BY ppas.fullname ASC";

        return DB::select("$qry");
    }

    public function update(object $req, string $id)
    {
        try {
            return $this->OKE();
        } catch (\Throwable $th) {
            return $this->SERVER_ERROR($th->getMessage());
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
