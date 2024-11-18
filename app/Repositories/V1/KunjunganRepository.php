<?php

namespace App\Repositories\V1;

use Illuminate\Support\Facades\DB;

use App\Traits\Tools;

use App\Models\Kunjungan;

class KunjunganRepository
{
    use Tools;
    private $selectColmn, $kunjunganModel;
    public function __construct()
    {
        $this->kunjunganModel = new Kunjungan();

        $this->selectColmn = [
            'kunjungan.*',
        ];
    }

    public function index($req = null)
    {
        $rawQry = Kunjungan::query();
        if ($req->filled('get_data')) { // Nama Kolom yang mau di car by
            $params = strtolower($req->input('params'));
            $colName = strtolower($req->input('get_data'));

            $rawQry->select($this->selectColmn)
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
        $data = $this->kunjunganModel->SchemaDataModel($req);

        return DB::table('kunjungan')->insertGetId($data);
    }

    public function show(string $id)
    {
        return Kunjungan::find($id);
    }

    public function update(object $req, string $id)
    {
        $kunjungan = Kunjungan::find($id);

        $data = $this->kunjunganModel->SchemaDataModel($req);

        unset($data['created_at']);
        unset($data['id_user_created']);

        return $kunjungan->update($data);
    }

    public function destroy(string $id)
    {
        $kunjungan = Kunjungan::find($id);

        return $kunjungan->delete();
    }
}
