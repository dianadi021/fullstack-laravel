<?php

namespace App\Services\V1;

use App\Repositories\V1\UserRepository;

use App\Traits\Tools;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class UserService
{
    use Tools;

    private $repos, $userSession, $userSessionRedis, $dateNow, $selectColmn, $checkForm;
    public function __construct()
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        $this->repos = new UserRepository();

        $sessionId = session()->getId();
        $this->userSession = session('user_login');
        $this->userSessionRedis = json_decode(Redis::get("session:$sessionId"), true);
    }

    public function index()
    {
        return $this->repos->index();
    }

    public function store(object $req)
    {
        $data = [
            // List Client
            'company_name' => $req->company_name,

            // Penduduk
            'nik' => $req->user_nik,
            'fullname' => $req->fullname,
            'handphone' => $req->handphone,
            'whatsapp' => $req->whatsapp,
            'telegram' => $req->telegram,
            'birthdate' => $this->ReformatDateTime($req->tanggal_lahir, true),
            'address' => $req->address,
            'gender' => $req->user_gender,
            'goldar' => $req->goldar,
            'id_provinsi' => $req->id_provinsi,
            'id_kabupaten' => $req->id_kabupaten,
            'id_kecamatan' => $req->id_kecamatan,
            'id_kelurahan' => $req->id_kelurahan,

            // User
            'username' => $req->username,
            'email' => $req->email,
            'password' => $req->password,
            'password_confirmation' => $req->password_confirmation,

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
        return $this->repos->show($id);
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
