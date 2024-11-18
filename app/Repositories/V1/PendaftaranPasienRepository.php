<?php

namespace App\Repositories\V1;

use Error;

use Illuminate\Support\Facades\DB;

use App\Traits\Tools;

use App\Models\Pasien;
use App\Models\Penduduk;
use App\Models\Pendaftaran;

use App\Services\V1\PasienService;
use App\Services\V1\PendudukService;
use App\Services\V1\KunjunganService;

class PendaftaranPasienRepository
{
    use Tools;
    private $selectColmn, $pndaftaranPasienModel;
    private $pendudukService, $pasienService, $kunjunganService;
    public function __construct()
    {
        $this->pndaftaranPasienModel = new Pendaftaran();
        $this->selectColmn = [];

        $this->pasienService = new PasienService();
        $this->pendudukService = new PendudukService();
        $this->kunjunganService = new KunjunganService();
    }

    public function index($req = null)
    {
        $rawQry = Pasien::query();
        if ($req->filled('get_data')) { // Nama Kolom yang mau di car by
            $params = strtolower($req->input('params'));
            $colName = strtolower($req->input('get_data'));

            $rawQry->select($this->selectColmn)
                ->join('penduduk AS pdd', 'pdd.id', '=', 'pasien.id_penduduk')
                ->join('provinsi AS prov', 'prov.id', '=', 'pdd.id_provinsi')
                ->join('kabupaten AS kab', 'kab.id', '=', 'pdd.id_kabupaten')
                ->join('kecamatan AS kec', 'kec.id', '=', 'pdd.id_kecamatan')
                ->join('kelurahan AS kel', 'kel.id', '=', 'pdd.id_kelurahan')
                ->where(function ($qryI) use ($colName, $params) {
                    $qryI->whereRaw("LOWER($colName) LIKE ?", ["%$params%"]);
                });
        }

        $sortable = [
            "id",
            "name",
            "created_at",
        ];
        $sortBy = (in_array($req->input('sort_by'), $sortable) ? $req->input('sort_by') : "id");
        $sorting = (in_array($req->input('sorting'), ['asc', 'desc']) ? $req->input('sorting') : "asc");

        $rawQry->orderBy($sortBy, $sorting);

        return $rawQry->get();
    }

    public function store(object $req)
    {

        if (!$this->IsValidAddress($req)) {
            throw new Error("Alamat tidak valid");
        }

        $nik = (isset($req->nik_pasien) && !empty($req->nik_pasien) ? $req->nik_pasien : $req->nik_user);
        $dataPenduduk = Penduduk::whereNotNull('nik')->where('nik', $nik)->first();

        DB::beginTransaction();

        if (!$this->IsValidVal($dataPenduduk)) {
            $req->id_penduduk = $this->pendudukService->store($req);
        } else {
            $this->pendudukService->update($req, $dataPenduduk->id);
            $req->id_penduduk = $dataPenduduk->id;
        }

        if (!$this->isValidVal($req->norm_pasien)) {
            $req->id_pasien = $this->pasienService->store($req);
        }

        $dataPendaftaran = $this->pndaftaranPasienModel->SchemaDataModel($req);

        $req->id_pendaftaran = (Pendaftaran::create($dataPendaftaran))->id;

        $kunjungan = $this->kunjunganService->store($req);

        if ($this->IsValidVal($kunjungan)) {
            DB::commit();
            return $kunjungan;
        } else {
            DB::rollBack();
            return new Error("Kesalahan insert ke database");
        }
    }

    public function show(string $id)
    {
        $qry = "SELECT pas.id AS id_pasien, pas.id AS norm, ppas.nik, ppas.fullname, ppas.handphone, ppas.whatsapp, ppas.telegram, ppas.birthdate, ppas.address, ppas.gender, goldar.id AS id_goldar, goldar.name AS goldar, ppas.id_provinsi, prov.name AS provinsi, ppas.id_kabupaten, kab.name AS kabupaten, ppas.id_kecamatan, kec.name AS kecamatan, ppas.id_kelurahan, kel.name AS kelurahan FROM pasien pas LEFT JOIN penduduk ppas ON ppas.id = pas.id_penduduk AND pas.id = $id LEFT JOIN provinsi prov ON prov.id = ppas.id_provinsi LEFT JOIN kabupaten kab ON kab.id = ppas.id_kabupaten LEFT JOIN kecamatan kec ON kec.id = ppas.id_kecamatan LEFT JOIN kelurahan kel ON kel.id = ppas.id_kelurahan ORDER BY ppas.fullname ASC";

        return DB::select("$qry");
    }

    public function update(object $req, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
