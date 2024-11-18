<?php

namespace App\Repositories\V1;

use Error;

use Illuminate\Support\Facades\DB;

use App\Traits\Tools;

use App\Models\Penduduk;

class PendudukRepository
{
    use Tools;
    private $selectColmn, $pendudukModel;
    public function __construct()
    {
        $this->pendudukModel = new Penduduk();

        $this->selectColmn = [
            "penduduk.*",
            "prov.name AS provinsi",
            "kab.name AS kabupaten",
            "kec.name AS kecamatan",
            "kel.name AS kelurahan"
        ];
    }

    public function index($req = null)
    {
        $rawQry = Penduduk::query();
        if ($req->filled('get_data')) { // Nama Kolom yang mau di car by
            $params = strtolower($req->input('params'));
            $colName = strtolower($req->input('get_data'));

            $rawQry->select($this->selectColmn)
                ->join('provinsi AS prov', 'prov.id', '=', 'penduduk.id_provinsi')
                ->join('kabupaten AS kab', 'kab.id', '=', 'penduduk.id_kabupaten')
                ->join('kecamatan AS kec', 'kec.id', '=', 'penduduk.id_kecamatan')
                ->join('kelurahan AS kel', 'kel.id', '=', 'penduduk.id_kelurahan')
                ->where(function ($qryI) use ($colName, $params) {
                    $qryI->whereRaw("LOWER($colName) LIKE ?", ["%$params%"]);
                });
        }

        $sortable = [
            "penduduk.*",
            "address",
            "provinsi",
            "kabupaten",
            "kecamatan",
            "kelurahan",
        ];

        $sortBy = (in_array($req->input('sort_by'), $sortable) ? $req->input('sort_by') : "id");
        $sorting = (in_array($req->input('sorting'), ['asc', 'desc']) ? $req->input('sorting') : "asc");

        $rawQry->orderBy($sortBy, $sorting);

        return $rawQry->get();
    }

    public function store(object $req)
    {
        $data = $this->pendudukModel->SchemaDataModel($req);

        unset($data['deleted_at']);

        return DB::table('penduduk')->insertGetId($data);
    }

    public function show(string $id)
    {
        $rawQry = Penduduk::query();
        $rawQry->select($this->selectColmn)
            ->join('provinsi AS prov', 'prov.id', '=', 'penduduk.id_provinsi')
            ->join('kabupaten AS kab', 'kab.id', '=', 'penduduk.id_kabupaten')
            ->join('kecamatan AS kec', 'kec.id', '=', 'penduduk.id_kecamatan')
            ->join('kelurahan AS kel', 'kel.id', '=', 'penduduk.id_kelurahan')
            ->where('penduduk.id', $id);

        return $rawQry->first();
    }

    public function update(object $req, string $id)
    {
        $penduduk = Penduduk::find($id);

        $data = $this->pendudukModel->SchemaDataModel($req);

        unset($data['deleted_at']);
        unset($data['created_at']);
        unset($data['id_user_created']);

        return $penduduk->update($data);
    }

    public function destroy(string $id)
    {
        $penduduk = Penduduk::find($id);

        return $penduduk->delete();
    }
}
