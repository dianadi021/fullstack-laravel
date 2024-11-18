<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use Illuminate\Http\JsonResponse;
use App\Services\Api\V1\SearchService;

class SearchController extends ApiController
{
    public function __construct(private SearchService $service) { parent::__construct($this->service); }

    public function index(Request $req): JsonResponse { return $this->GetDataByParams($req); }
}
