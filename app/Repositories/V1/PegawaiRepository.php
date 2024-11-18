<?php

namespace App\Repositories\V1;

use Illuminate\Support\Facades\DB;

use App\Traits\Tools;

use App\Models\Pegawai;

class PegawaiRepository
{
    use Tools;
    private $selectColmn, $pegawaiModel;
    public function __construct()
    {
        $this->pegawaiModel = new Pegawai();

        $this->selectColmn = [
            'pegawai.*',
            "usr.username",
            "usr.email",
            "usr.is_actived",
            "rol.name AS role_name",
            "pdd.nik",
            "pdd.fullname",
            "lc.name AS client_name",
            "prof.name AS profesi",
            "pdd.gender",
            "pdd.tempat_lahir",
            "pdd.goldar",
            "pdd.agama",
            "pdd.alamat_ktp",
            "pdd.birthdate",
            "prov.name AS provinsi",
            "kab.name AS kabupaten",
            "kec.name AS kecamatan",
            "kel.name AS kelurahan"
        ];
    }

    public function index($req = null)
    {
        $rawQry = Pegawai::query();
        if ($req->filled('get_data')) { // Nama Kolom yang mau di car by
            $params = strtolower($req->input('params'));
            $colName = strtolower($req->input('get_data'));

            $rawQry->select($this->selectColmn)
                ->join('users AS usr', 'usr.id', '=', 'pegawai.id_user')
                ->join('penduduk AS pdd', 'pdd.id', '=', 'usr.id_penduduk')
                ->join('list_client AS lc', 'lc.id', '=', 'usr.id_client')
                ->join('provinsi AS prov', 'prov.id', '=', 'pdd.id_provinsi')
                ->join('kabupaten AS kab', 'kab.id', '=', 'pdd.id_kabupaten')
                ->join('kecamatan AS kec', 'kec.id', '=', 'pdd.id_kecamatan')
                ->join('kelurahan AS kel', 'kel.id', '=', 'pdd.id_kelurahan')
                ->join("roles AS rol", "rol.id", "=", "usr.id_role")
                ->leftJoin('profesi AS prof', 'prof.id', '=', 'pegawai.id_profesi')
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
        $data = $this->pegawaiModel->SchemaDataModel($req);

        unset($data['deleted_at']);

        return DB::table('pegawai')->insertGetId($data);
    }

    public function show(string $id)
    {
        $rawQry = Pegawai::query();
        $rawQry->select($this->selectColmn)
            ->join('users AS usr', 'usr.id', '=', 'pegawai.id_user')
            ->join('penduduk AS pdd', 'pdd.id', '=', 'usr.id_penduduk')
            ->join('list_client AS lc', 'lc.id', '=', 'usr.id_client')
            ->join('provinsi AS prov', 'prov.id', '=', 'pdd.id_provinsi')
            ->join('kabupaten AS kab', 'kab.id', '=', 'pdd.id_kabupaten')
            ->join('kecamatan AS kec', 'kec.id', '=', 'pdd.id_kecamatan')
            ->join('kelurahan AS kel', 'kel.id', '=', 'pdd.id_kelurahan')
            ->join("roles AS rol", "rol.id", "=", "usr.id_role")
            ->leftJoin('profesi AS prof', 'prof.id', '=', 'pegawai.id_profesi')
            ->where('pegawai.id', $id);

        return $rawQry->first();
    }

    public function update(object $req, string $id)
    {
        $pegawai = Pegawai::find($id);

        $data = $this->pegawaiModel->SchemaDataModel($req);

        unset($data['deleted_at']);
        unset($data['created_at']);
        unset($data['id_user_created']);

        return $pegawai->update($data);
    }

    public function destroy(string $id)
    {
        $pegawai = Pegawai::find($id);

        return $pegawai->delete();
    }
}
