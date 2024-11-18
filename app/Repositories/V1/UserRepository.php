<?php

namespace App\Repositories\V1;

use Error;

use App\Services\V1\ClientService;
use App\Services\V1\PegawaiService;
use App\Services\V1\PendudukService;

use App\Traits\Tools;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Exception;

class UserRepository
{
    use Tools;
    private $selectColmn, $userModel;
    private $clientService, $pendudukService, $pegawaiService;
    public function __construct()
    {
        $this->userModel = new User();

        $this->selectColmn = [
            "users.*",
            "rol.name AS role_name",
            "pdd.nik",
            "pdd.fullname",
            "pdd.birthdate",
            "pdd.gender",
            "pdd.goldar",
            "prov.name AS provinsi",
            "kab.name AS kabupaten",
            "kec.name AS kecamatan",
            "kel.name AS kelurahan",
            "pdd.alamat_ktp"
        ];

        $this->clientService = new ClientService();
        $this->pegawaiService = new PegawaiService();
        $this->pendudukService = new PendudukService();
    }

    public function index($req = null)
    {
        $rawQry = User::query();
        if ($req->filled('get_data')) { // Nama Kolom yang mau di car by
            $params = strtolower($req->input('params'));
            $colName = strtolower($req->input('get_data'));

            $rawQry->select($this->selectColmn)
                ->join('provinsi AS prov', 'prov.id', '=', 'list_client.id_provinsi')
                ->join('kabupaten AS kab', 'kab.id', '=', 'list_client.id_kabupaten')
                ->join('kecamatan AS kec', 'kec.id', '=', 'list_client.id_kecamatan')
                ->join('kelurahan AS kel', 'kel.id', '=', 'list_client.id_kelurahan')
                ->join("roles AS rol", "rol.id", "=", "users.id_role")
                ->join("penduduk AS pdd", "pdd.id", "=", "users.id_penduduk")
                ->where(function ($qryI) use ($colName, $params) {
                    $qryI->whereRaw("LOWER($colName) LIKE ?", ["%$params%"]);
                });
        }

        $sortable = [
            "id",
            "username",
            "fullname",
            "role_name",
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
        try {
            Log::info("START SIMPAN USER: " . json_encode($req->all(), JSON_PRETTY_PRINT));
            DB::beginTransaction();
            $req->id_client = $this->clientService->store($req);
            $req->id_penduduk = $this->pendudukService->store($req);

            $dataUsr = $this->userModel->SchemaDataModel($req);

            unset($dataUsr['deleted_at']);
            unset($dataUsr['id_user_created']);

            $req->id_user = DB::table('users')->insertGetId($dataUsr);

            $id_pegwai = $this->pegawaiService->store($req);
            $pegwai = $this->pegawaiService->show($id_pegwai);

            if (!$this->IsValidVal($pegwai)) {
                throw new Exception("Gagal menyimpan data ke database, terdapat kesalahan data.");
            }

            DB::commit();
            return $pegwai;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("GAGAL SIMPAN USER: " . $th);
            throw $th;
        }
    }

    public function show(string $id)
    {
        $rawQry = User::query();
        $rawQry->select($this->selectColmn)
            ->join('provinsi AS prov', 'prov.id', '=', 'list_client.id_provinsi')
            ->join('kabupaten AS kab', 'kab.id', '=', 'list_client.id_kabupaten')
            ->join('kecamatan AS kec', 'kec.id', '=', 'list_client.id_kecamatan')
            ->join('kelurahan AS kel', 'kel.id', '=', 'list_client.id_kelurahan')
            ->join("roles AS rol", "rol.id", "=", "users.id_role")
            ->join("penduduk AS pdd", "pdd.id", "=", "users.id_penduduk")
            ->where('users.id', $id);

        return $rawQry->first();
    }

    public function update(object $req, string $id)
    {
        try {
            $user = User::find($id);

            if ($this->IsValidVal($user->id)) {
                Log::info("START UPDATE USER: " . $req->all());
                $this->pendudukService->update($req, $user->id_penduduk);

                $data = $this->userModel->SchemaDataModel($req);

                unset($data['deleted_at']);
                unset($data['created_at']);
                unset($data['id_user_created']);

                $result = $user->update($data);

                if (!$this->IsValidVal($result)) {
                    throw new Exception("Gagal menyimpan data ke database, terdapat kesalahan data.");
                }
            }

            return $user;
        } catch (\Throwable $th) {
            Log::error("GAGAL UPDATE USER: " . $th->getMessage());
            throw $th;
        }
    }

    public function destroy(string $id) {}
}
