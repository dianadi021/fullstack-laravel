<?php

namespace App\Services\V1;

use App\Traits\Tools;

use App\Repositories\V1\PendaftaranPasienRepository;

class PendaftaranPasienService
{
    use Tools;

private $dateNow, $repos, $userSession;
    public function __construct()
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        $this->dateNow = now(env('APP_TIMEZONE', 'Asia/Jakarta'));

        $this->userSession = session('user_login');
        // $sessionId = session()->getId();
        // $this->userSessionRedis = json_decode(Redis::get("session:$sessionId"), true);

        $this->repos = new PendaftaranPasienRepository();
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
        $req->dateNow = $this->ReformatDateTime($this->dateNow, true);
        $req->id_client = $this->GetClientIDFromRequest($req, $this->userSession);
        $req->id_user = $this->GetUserIDFromRequest($req, $this->userSession);
        $req->birthdate_user = (isset($req->tanggal_lahir) && !empty($req->tanggal_lahir) ? $this->ReformatDateTime($req->tanggal_lahir, true) : null);

        return $this->repos->store($req);
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
}
