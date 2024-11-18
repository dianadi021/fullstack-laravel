<?php

namespace App\Traits;

use App\Traits\Tools;

Trait ResponseCode
{
    use Tools;

    private $success = "Berhasil memproses data!";
    private $failed = "Gagal memproses data!";

    public function OKE($datas = null, $msg = null)
    {
        $msg = ($msg ?: $this->success);
        return response()->json(["status" => 200, "message" => $msg, "datas" => $datas], 200);
    }

    public function CREATED($datas = null, $msg = null)
    {
        $msg = ($msg ?: $this->success);
        return response()->json(["status" => 201, "message" => $msg, "datas" => $datas], 201);
    }

    public function ACCEPTED($datas = null, $msg = null)
    {
        $msg = ($msg ?: $this->success);
        return response()->json(["status" => 202, "message" => $msg, "datas" => $datas], 202);
    }

    public function BAD_REQUEST($datas = null, $msg = null)
    {
        $msg = ($msg ?: $this->failed);
        return response()->json(["status" => 400, "message" => $msg, "datas" => $datas], 400);
    }

    public function UNAUTHORIZED($datas = null, $msg = null)
    {
        $msg = ($msg ?: $this->failed);
        return response()->json(["status" => 401, "message" => $msg, "datas" => $datas], 401);
    }

    public function FORBIDDEN($datas = null, $msg = null)
    {
        $msg = ($msg ?: $this->failed);
        return response()->json(["status" => 403, "message" => $msg, "datas" => $datas], 403);
    }

    public function NOT_FOUND($datas = null, $msg = null)
    {
        $msg = ($msg ?: $this->failed);
        return response()->json(["status" => 404, "message" => $msg, "datas" => $datas], 404);
    }

    public function UNPROCESS_ENTITY($datas = null, $msg = null)
    {
        $msg = ($msg ?: $this->failed);
        return response()->json(["status" => 422, "message" => $msg, "datas" => $datas], 422);
    }

    public function TO_MANY_REQ($datas = null, $msg = null)
    {
        $msg = ($msg ?: $this->failed);
        return response()->json(["status" => 429, "message" => $msg, "datas" => $datas], 429);
    }

    public function SERVER_ERROR($datas = null, $msg = null)
    {
        $msg = ($msg ?: $this->failed);
        return response()->json(["status" => 500, "message" => $msg, "datas" => $datas], 500);
    }

    public function SERVER_TIMEOUT($datas = null, $msg = null)
    {
        $msg = ($msg ?: $this->failed);
        return response()->json(["status" => 504, "message" => $msg, "datas" => $datas], 504);
    }
}
