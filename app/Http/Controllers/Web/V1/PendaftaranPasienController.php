<?php

namespace App\Http\Controllers\Web\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use Illuminate\Http\JsonResponse;
use App\Services\V1\PendaftaranPasienService;

class PendaftaranPasienController extends ApiController
{
    public function __construct(private PendaftaranPasienService $service) { parent::__construct($this->service); }

    public function index(Request $req): JsonResponse { return $this->GetAllDatas($req); }

    public function store(Request $req): JsonResponse { return $this->CreateData($req); }

    public function show(string $id): JsonResponse { return $this->GetByID($id); }

    public function update(Request $req, string $id): JsonResponse { return $this->UpdateByID($req, $id); }

    public function destroy(string $id): JsonResponse { return $this->DeleteByID($id); }
}
