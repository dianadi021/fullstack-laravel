<?php

namespace App\Http\Controllers;

use Exception;

use App\Traits\Tools;
use App\Traits\ResponseCode;

use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller
{
    use ResponseCode, Tools;

    public function __construct(private $service) {}

    public function GetAllDatas(): JsonResponse
    {
        try {
            $datas = $this->service->index();

            return ($this->IsValidVal($datas) ? $this->OKE($datas) : $this->OKE([], "Data tidak ditemukan!"));
        } catch (Exception $err) {
            return $this->SERVER_ERROR($err->getMessage());
        }
    }

    public function GetDataByParams(object $req): JsonResponse
    {
        try {
            $datas = $this->service->params($req);

            return ($this->IsValidVal($datas) ? $this->OKE($datas) : $this->OKE([], "Data tidak ditemukan!"));
        } catch (Exception $err) {
            return $this->SERVER_ERROR($err->getMessage());
        }
    }

    public function CreateData(object $req): JsonResponse
    {
        return $this->service->store($req);
    }

    public function GetByID(string $id): JsonResponse
    {
        try {
            $datas = $this->service->show($id);

            return ($this->IsValidVal($datas) ? $this->OKE($datas) : $this->OKE([], "Data tidak ditemukan!"));
        } catch (Exception $err) {
            return $this->SERVER_ERROR($err->getMessage());
        }
    }

    public function UpdateByID(object $req, string $id): JsonResponse
    {
        return $this->service->update($req, $id);
    }

    public function DeleteByID(string $id): JsonResponse
    {
        try {
            $datas = $this->service->destroy($id);

            return ($this->IsValidVal($datas) ? $this->OKE($datas) : $this->OKE([], "Data tidak ditemukan!"));
        } catch (Exception $err) {
            return $this->SERVER_ERROR($err->getMessage());
        }
    }
}
