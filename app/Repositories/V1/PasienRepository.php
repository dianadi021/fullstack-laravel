<?php

namespace App\Repositories\V1;

use Illuminate\Support\Facades\DB;

use App\Traits\Tools;

use App\Models\Pasien;

class PasienRepository
{
    use Tools;
    private $selectColmn, $pasienModel;
    public function __construct()
    {
        $this->pasienModel = new Pasien();

        $this->selectColmn = [
            'pasien.*',
        ];
    }

    public function index($req = null)
    {
        $rawQry = Pasien::query();
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
        $data = $this->pasienModel->SchemaDataModel($req);

        return DB::table('pasien')->insertGetId($data);
    }

    public function show(string $id)
    {
        $rawQry = Pasien::query();
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
            ->where('pasien.id', $id);

        return $rawQry->first();
    }

    public function update(object $req, string $id)
    {
        $pasien = Pasien::find($id);

        $data = $this->pasienModel->SchemaDataModel($req);

        unset($data['created_at']);
        unset($data['id_user_created']);

        return $pasien->update($data);
    }

    public function destroy(string $id)
    {
        $pasien = Pasien::find($id);

        return $pasien->delete();
    }
}
