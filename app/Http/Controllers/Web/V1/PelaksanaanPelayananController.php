<?php

namespace App\Http\Controllers\Web\V1;

use Illuminate\Http\Request;

use App\Traits\Tools;
use App\Traits\ResponseCode;
use App\Http\Controllers\Controller;

use App\Services\Api\V1\SearchService;

class PelaksanaanPelayananController extends Controller
{
    use Tools, ResponseCode;
    public function __construct(
        private SearchService $searchSrvice
    ) {}

    public function index()
    {
        return view('transaksi.pelaksanaan-pelayanan.index');
    }

    public function show($id_kunjungan)
    {
        $dataPasienKunjungan = $this->searchSrvice->GetDataPasienByIdKunjungan($id_kunjungan);
        return view('transaksi.pelaksanaan-pelayanan.show', compact('dataPasienKunjungan'));
    }
}
