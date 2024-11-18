<?php

namespace App\Http\Controllers\Web\V1;

use Illuminate\Http\Request;

use App\Traits\Tools;
use App\Traits\ResponseCode;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\GolonganDarah;

class WebController extends Controller
{
    use Tools, ResponseCode;

    public function GolonganDarah(Request $req)
    {
        $goldar = GolonganDarah::select('id', 'name')->get();
        return view('master-data.golongan-darah', compact('goldar'));
    }

    public function Wilayah(Request $req)
    {
        return view('master-data.wilayah');
    }


    public function UserSystem(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(
                        'users.username',
                        'users.email',
                        'users.status',
                        'roles.name as role_name',
                        'roles.description'
                    )
                    ->join('roles', 'users.id_role', '=', 'roles.id')
                    ->get();

            return $this->OKE("berhasil mengambil data", $users);
        }

        return view('master-data.user-system');
    }

    public function PendaftaranPasien(Request $req)
    {
        return view('transaksi.pendaftaran-pasien');
    }

    public function PelaksanaanPelayanan(Request $req)
    {
        return view('transaksi.pelaksanaan-pelayanan');
    }
}
