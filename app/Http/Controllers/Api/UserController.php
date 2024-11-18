<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Penduduk;
use App\Models\ListClient;
use App\Http\Libraries\Tools;
use App\Models\ClientConfigs;
use App\Http\Libraries\ResponseCode;
use Error;

class UserController extends Controller
{
    private $resCode, $tools, $userAgent;
    public function __construct()
    {
        $this->tools = new Tools;
        $this->resCode = new ResponseCode;
        $this->userAgent = request()->header('User-Agent');
    }

    private function isValidVal($val, $get = ["bool", "value", "equal"], $other = null, $key = null) {
        return $this->tools->isValidVal($val, $get, $other, $key);
    }

    private function isValidAddress($req) {
        return $this->tools->isValidAddress($req);
    }

    private function checkValidation($req)
    {
        $req->validate([
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

    public function index()
    {
        try {
            $qry = "SELECT usr.id, usr.username, usr.email, usr.status, rol.name AS role_name, pdd.fullname, pdd.nik, pdd.birthdate, usr.created_at FROM users usr JOIN roles rol ON rol.id = usr.id_role
            JOIN penduduks pdd ON pdd.id = usr.id_penduduk";
            $datas = DB::select("$qry");
            if ($this->IsValidVal($datas)) {
                return $this->resCode->OKE("berhasil mengambil data", $datas);
            }
            return $this->resCode->OKE("tidak ada data");
        } catch (Exception $th) {
            return $this->resCode->SERVER_ERROR("kesalahan dalam mengambil data!", $th->getMessage());
        }
    }

    public function create() {}

    public function store(LoginRequest $req)
    {
        setlocale(LC_TIME, 'id_ID.utf8');

        if (strpos($this->userAgent, 'Mozilla') !== false) {
            $this->checkValidation($req);
        }

        try {
            if (strpos($this->userAgent, 'Postman') !== false) {
                $this->checkValidation($req);
            }

            if (!$this->isValidAddress($req)) {
                throw new Error("alamat tidak valid");
            }

            DB::beginTransaction();

            $listClient = ListClient::create([
                'name' => $req->company_name,
                'id_provinsi' => $req->id_provinsi,
                'id_kabupaten' => $req->id_kabupaten,
                'id_kecamatan' => $req->id_kecamatan,
                'id_kelurahan' => $req->id_kelurahan,
                'expired_date' => now(env('APP_TIMEZONE', 'UTC'))->addDays(30)->toDateTimeString(),
            ]);

            $listClient->save();

            $clientsConfig = ClientConfigs::create([
                'id_client' => $listClient->id,
            ]);

            $clientsConfig->save();

            $penduduk = Penduduk::create([
                'fullname' => $req->fullname,
            ]);

            $penduduk->save();

            $user = User::create([
                'username' => $req->username,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'id_client' => $listClient->id,
                'id_penduduk' => $penduduk->id,
                'expired_date' => now(env('APP_TIMEZONE', 'UTC'))->addDays(30)->toDateTimeString(),
            ]);

            $user->save();

            $pegawai = Pegawai::create([
                'id_user' => $user->id,
                'id_client' => $listClient->id,
                'id_penduduk' => $penduduk->id,
            ]);

            $pegawai->save();

            DB::commit();

            event(new Registered($user));
            Auth::login($user);

            return $this->resCode->CREATED("berhasil menyimpan data", $user);
        } catch (ValidationException $th) {
            DB::rollBack();
            return $this->resCode->SERVER_ERROR("kesalahan dalam menyimpan data!", $th->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $wheres = ($this->IsValidVal($id) ? " WHERE usr.id = $id " : "");
            $qry = "SELECT usr.id, usr.username, usr.email, usr.status, rol.name AS role_name, pdd.fullname, pdd.nik, pdd.birthdate, usr.created_at FROM users usr JOIN roles rol ON rol.id = usr.id_role
            JOIN penduduks pdd ON pdd.id = usr.id_penduduk $wheres";
            $datas = DB::select("$qry");
            if ($this->IsValidVal($datas)) {
                return $this->resCode->OKE("berhasil mengambil data", $datas);
            }
            return $this->resCode->OKE("tidak ada data");
        } catch (Exception $th) {
            return $this->resCode->SERVER_ERROR("kesalahan dalam mengambil data!", $th->getMessage());
        }
    }

    public function edit(string $id) {}

    public function update(Request $req, string $id) {}

    public function destroy(string $id) {}
}
