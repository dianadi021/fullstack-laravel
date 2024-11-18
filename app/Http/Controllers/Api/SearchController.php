<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Libraries\Tools;
use App\Http\Libraries\ResponseCode;

class SearchController extends Controller
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

    public function index(Request $req)
    {
        try {
            switch ($req->get_data) {
                case 'provinsi':
                    $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi " : "");
                    $wheres = ($this->IsValidVal($req->q) ? " WHERE LOWER(prov.name) LIKE LOWER('%$req->q%') " : $wheres);

                    $qry = "SELECT prov.id, prov.name FROM provinsi prov $wheres ORDER BY prov.name ASC";
                    $datas = DB::select("$qry");
                    return $this->resCode->OKE("berhasil mengambil data", $datas);
                    break;

                case 'kabupaten':
                    $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->id_kabupaten) ? " kab.id = $req->id_kabupaten AND " : "");
                    $wheres .= ($this->IsValidVal($req->q) ? " $wheres LOWER(kab.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                    $qry = "SELECT kab.id, kab.name, kab.type, prov.name as provinsi FROM kabupaten kab JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kab.name ASC";
                    $datas = DB::select("$qry");
                    return $this->resCode->OKE("berhasil mengambil data", $datas);
                    break;

                case 'kecamatan':
                    $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->id_kabupaten) ? " kab.id = $req->id_kabupaten AND " : "");
                    $wheres .= ($this->IsValidVal($req->id_kecamatan) ? " kec.id = $req->id_kecamatan AND " : "");
                    $wheres .= ($this->IsValidVal($req->q) ? " $wheres LOWER(kec.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                    $qry = "SELECT kec.id, kec.name, kab.name as kabupaten, prov.name as provinsi FROM kecamatan kec JOIN kabupaten kab ON kab.id = kec.id_kabupaten JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kec.name ASC";
                    $datas = DB::select("$qry");
                    return $this->resCode->OKE("berhasil mengambil data", $datas);
                    break;

                case 'kelurahan':
                    $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
                    $wheres .= ($this->IsValidVal($req->id_kabupaten) ? " kab.id = $req->id_kabupaten AND " : "");
                    $wheres .= ($this->IsValidVal($req->id_kecamatan) ? " kec.id = $req->id_kecamatan AND " : "");
                    $wheres .= ($this->IsValidVal($req->id_kelurahan) ? " kel.id = $req->id_kelurahan AND " : "");
                    $wheres .= ($this->IsValidVal($req->q) ? " $wheres LOWER(kel.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                    $qry = "SELECT kel.id, kel.name, kel.postal_code, kec.name as kecamatan, kab.name as kabupaten, prov.name as provinsi FROM kelurahan kel JOIN kecamatan kec ON kec.id = kel.id_kecamatan JOIN kabupaten kab ON kab.id = kec.id_kabupaten JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kel.name ASC";
                    $datas = DB::select("$qry");
                    return $this->resCode->OKE("berhasil mengambil data", $datas);
                    break;

                case 'golongan_darah':
                    $qry = "SELECT goldar.id, goldar.name FROM golongan_darah goldar WHERE LOWER(goldar.name) LIKE LOWER('$req->q%')";
                    $datas = DB::select("$qry");
                    return $this->resCode->OKE("berhasil mengambil data", $datas);
                    break;

                default:
                    return $this->resCode->OKE("berhasil mengambil data", []);
                    break;
            }

            return $this->resCode->OKE("tidak ada data");
        } catch (Exception $th) {
            return $this->resCode->SERVER_ERROR("kesalahan dalam mengambil data!", $th->getMessage());
        }
    }
}
