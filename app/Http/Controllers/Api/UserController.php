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
use Illuminate\Validation\ValidationException;

use App\Models\User;
use App\Http\Libraries\Tools;
use App\Http\Libraries\ResponseCode;

class UserController extends Controller
{
    private function checkValidation($req)
    {
        $req->validate([
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

    private $resCode, $tools, $user, $userAgent;
    public function __construct()
    {
        $this->tools = new Tools;
        $this->resCode = new ResponseCode;
        $this->user = new User;
        $this->userAgent = request()->header('User-Agent');
    }

    public function index()
    {
        try {
            $getDatas = $this->tools->IsValidVal($this->user::all());
            if ($this->tools->IsValidVal($getDatas)) {
                return $this->resCode->OKE("berhasil mengambil data", $getDatas);
            }
            return $this->resCode->OKE("tidak ada data");
        } catch (Exception $th) {
            return $this->resCode->SERVER_ERROR("kesalahan dalam mengambil data!", $th);
        }
    }

    public function create() {}

    public function store(Request $req)
    {
        setlocale(LC_TIME, 'id_ID.utf8');

        if (strpos($this->userAgent, 'Mozilla') !== false) {
            $this->checkValidation($req);
        }

        try {
            if (strpos($this->userAgent, 'Postman') !== false) {
                $this->checkValidation($req);
            }

            DB::beginTransaction();

            $user = User::create([
                'username' => $req->username,
                'email' => $req->email,
                'password' => Hash::make($req->password)
            ]);

            $user->expired_date = now(env('APP_TIMEZONE', 'UTC'))->addDays(30)->toDateTimeString();
            $user->save();

            DB::commit();

            event(new Registered($user));
            Auth::login($user);

            return $this->resCode->CREATED("berhasil menyimpan data", $user);
        } catch (ValidationException $th) {
            DB::rollBack();
            return $this->resCode->SERVER_ERROR("kesalahan dalam menyimpan data!", $th);
        }
    }

    public function show(string $id)
    {
        try {
            $getDatas = $this->tools->isValidVal($this->user::find($id));
            if ($getDatas) {
                return $this->resCode->OKE("berhasil mengambil data", $getDatas);
            }
            return $this->resCode->OKE("tidak ada data");
        } catch (Exception $th) {
            return $this->resCode->SERVER_ERROR("kesalahan dalam mengambil data!", $th);
        }
    }

    public function edit(string $id)
    {
    }

    public function update(Request $req, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
