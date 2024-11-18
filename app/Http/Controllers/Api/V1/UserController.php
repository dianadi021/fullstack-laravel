<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Traits\Tools;
use App\Traits\ResponseCode;

use Illuminate\Http\JsonResponse;
use App\Services\V1\UserService;

class UserController extends ApiController
{
    use ResponseCode, Tools;

    public function __construct(private UserService $service) { parent::__construct($this->service); }

    public function index(): JsonResponse { return $this->GetAllDatas(); }

    public function store(Request $req): JsonResponse { return $this->CreateData($req); }

    public function show(string $id): JsonResponse { return $this->GetByID($id); }

    public function update(Request $req, string $id): JsonResponse { return $this->UpdateByID($req, $id); }

    public function destroy(string $id): JsonResponse { return $this->DeleteByID($id); }
}
