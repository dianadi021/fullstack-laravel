<?php

namespace App\Repositories\V1;

use Illuminate\Support\Facades\DB;

use App\Traits\Tools;

use App\Models\ListClient;

class ClientRepository
{
    use Tools;
    private $selectColmn, $listClientModel;
    public function __construct()
    {
        $this->listClientModel = new ListClient();

        $this->selectColmn = [
            "list_client.*",
            "prov.name AS provinsi",
            "kab.name AS kabupaten",
            "kec.name AS kecamatan",
            "kel.name AS kelurahan"
        ];
    }

    public function index($req = null)
    {
        $rawQry = ListClient::query();
        if ($req->filled('get_data')) { // Nama Kolom yang mau di car by
            $params = strtolower($req->input('params'));
            $colName = strtolower($req->input('get_data'));

            $rawQry->select($this->selectColmn)
                ->join('provinsi AS prov', 'prov.id', '=', 'list_client.id_provinsi')
                ->join('kabupaten AS kab', 'kab.id', '=', 'list_client.id_kabupaten')
                ->join('kecamatan AS kec', 'kec.id', '=', 'list_client.id_kecamatan')
                ->join('kelurahan AS kel', 'kel.id', '=', 'list_client.id_kelurahan')
                ->where(function ($qryI) use ($colName, $params) {
                    $qryI->whereRaw("LOWER($colName) LIKE ?", ["%$params%"]);
                });
        }

        $sortable = [
            "id",
            "name",
            "provinsi",
            "kabupaten",
            "kecamatan",
            "kelurahan",
            "created_at",
        ];

        $sortBy = (in_array($req->input('sort_by'), $sortable) ? $req->input('sort_by') : "id");
        $sorting = (in_array($req->input('sorting'), ['asc', 'desc']) ? $req->input('sorting') : "asc");

        $rawQry->orderBy($sortBy, $sorting);

        return $rawQry->get();
    }

    public function store(object $req)
    {
        $dataClient = $this->listClientModel->SchemaDataModel($req);

        unset($dataClient['deleted_at']);

        return DB::table('list_client')->insertGetId($dataClient);
    }

    public function show(string $id)
    {
        $rawQry = ListClient::query();
        $rawQry->select($this->selectColmn)
            ->join('provinsi AS prov', 'prov.id', '=', 'list_client.id_provinsi')
            ->join('kabupaten AS kab', 'kab.id', '=', 'list_client.id_kabupaten')
            ->join('kecamatan AS kec', 'kec.id', '=', 'list_client.id_kecamatan')
            ->join('kelurahan AS kel', 'kel.id', '=', 'list_client.id_kelurahan')
            ->where('list_pasien.id', $id);

        return $rawQry->first();
    }

    public function update(object $req, string $id)
    {
        $client = ListClient::find($id);

        $data = $this->listClientModel->SchemaDataModel($req);

        unset($data['deleted_at']);
        unset($data['created_at']);
        unset($data['id_user_created']);

        return $client->update($data);
    }

    public function destroy(string $id)
    {
        $client = ListClient::find($id);

        return $client->delete();
    }
}
