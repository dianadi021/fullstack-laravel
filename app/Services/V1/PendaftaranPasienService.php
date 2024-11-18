<?php

namespace App\Services\V1;

use App\Repositories\V1\PendaftaranPasienRepository;

use App\Traits\Tools;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PendaftaranPasienService
{
    use Tools;

    private $repos, $userSession, $userSessionRedis, $dateNow, $selectColmn, $checkForm;
    public function __construct()
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        $this->repos = new PendaftaranPasienRepository();

        $sessionId = session()->getId();
        $this->userSession = session('user_login');
        $this->userSessionRedis = json_decode(Redis::get("session:$sessionId"), true);
    }

    public function index()
    {
        $fxdResultReturn =  $this->repos->index();
        $fxdResultReturn = json_decode(json_encode($fxdResultReturn), true);

        for ($i = 0; $i < count($fxdResultReturn); $i++) {
            $fxdResultReturn[$i]["norm"] = $this->reformatNoRM($fxdResultReturn[$i]["norm"]);
        }

        for ($i = 0; $i < count($fxdResultReturn); $i++) {
            $fxdResultReturn[$i]["birthdate"] = $this->ReformatDateTime($fxdResultReturn[$i]["birthdate"], false, "d-m-Y");
        }

        for ($i = 0; $i < count($fxdResultReturn); $i++) {
            $fxdResultReturn[$i]["gender"] = $fxdResultReturn[$i]["gender"] == "L" ? "Laki-laki" : "Perempuan";
        }

        return $fxdResultReturn;
    }

    public function store(object $req)
    {
        $data = [
            // Penduduk
            'nik' => $req->nik_pasien,
            'fullname' => $req->nama_pasien,
            'handphone' => $req->handphone_pasien,
            'whatsapp' => $req->whatsapp_pasien,
            'telegram' => $req->telegram_pasien,
            'birthdate' => $this->ReformatDateTime($req->tanggal_lahir, true),
            'address' => $req->address_pasien,
            'gender' => $req->gender,
            'id_golongan_darah' => $req->goldar,
            'id_provinsi' => $req->id_provinsi,
            'id_kabupaten' => $req->id_kabupaten,
            'id_kecamatan' => $req->id_kecamatan,
            'id_kelurahan' => $req->id_kelurahan,

            // Pasien
            'norm_pasien' => $req->norm_pasien,

            // Pendaftaran
            'jenis_pasien' => $req->jenis_pasien,

            'id_client' => $this->GetClientIDFromRequest($req),
            'id_user_created' => $this->GetUserIDFromRequest($req),
            'id_user_updated' => $this->GetUserIDFromRequest($req),
        ];

        $data = json_encode($data);
        $data = json_decode($data);
        return $this->repos->store($data);
    }

    public function show(string $id)
    {
        $fxdResultReturn =  $this->repos->show($id);
        $fxdResultReturn = json_decode(json_encode($fxdResultReturn), true);

        for ($i = 0; $i < count($fxdResultReturn); $i++) {
            $fxdResultReturn[$i]["norm"] = $this->reformatNoRM($fxdResultReturn[$i]["norm"]);
        }

        for ($i = 0; $i < count($fxdResultReturn); $i++) {
            $fxdResultReturn[$i]["birthdate"] = $this->ReformatDateTime($fxdResultReturn[$i]["birthdate"], false, "d-m-Y");
        }

        for ($i = 0; $i < count($fxdResultReturn); $i++) {
            $fxdResultReturn[$i]["gender"] = $fxdResultReturn[$i]["gender"] == "L" ? "Laki-laki" : "Perempuan";
        }

        return $fxdResultReturn;
    }

    public function update(object $req, string $id) {}

    public function destroy(string $id) {}

    public function GetUserIDFromRequest($req)
    {
        $id_user = "";

        if ($req->is('api/*')) {
            $id_user = (isset($req->id_user) && !empty($req->id_user) ? $req->id_user : $id_user);
        } else {
            $id_user = (isset($this->userSessionRedis['id_user']) ? $this->userSessionRedis['id_user'] : null);
            $id_user = (isset($this->userSession['id_user']) ? $this->userSession['id_user'] : null);
            $id_user = (isset($id_user) ? $id_user : Auth::id());
        }

        return $id_user;
    }

    public function GetClientIDFromRequest($req)
    {
        $id_client = "";

        if ($req->is('api/*')) {
            $id_client = (isset($req->id_client) && !empty($req->id_client) ? $req->id_client : $id_client);
        } else {
            $id_client = (isset($this->userSessionRedis['id_client']) ? $this->userSessionRedis['id_client'] : null);
            $id_client = (isset($id_client) ? $id_client : $this->userSession['id_client']);
        }

        return $id_client;
    }
}
