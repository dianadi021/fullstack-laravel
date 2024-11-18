<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Traits\Tools;
use App\Traits\ResponseCode;

use Illuminate\Http\JsonResponse;
use App\Services\Api\PasienRegisterService;

class PasienRegisterController extends ApiController
{
    use ResponseCode, Tools;

    public function __construct(private PasienRegisterService $service) { parent::__construct($this->service); }

    public function index(): JsonResponse { return $this->GetAllDatas(); }

    public function store(Request $req): JsonResponse { return $this->CreateData($req); }

    public function show(string $id): JsonResponse { return $this->GetByID($id); }

    public function update(Request $req, string $id): JsonResponse { return $this->UpdateByID($req, $id); }

    public function destroy(string $id): JsonResponse { return $this->DeleteByID($id); }
}
