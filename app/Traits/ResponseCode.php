<?php

namespace App\Traits;

use App\Traits\Tools;

trait ResponseCode
{
    use Tools;

    private $status = [
        200 => "OK",
        201 => "Created",
        202 => "Accepted",
        400 => "Bad Request",
        401 => "Unauthorized",
        403 => "Forbidden",
        404 => "Not Found",
        422 => "Unprocessable Entity",
        429 => "Too Many Requests",
        500 => "Internal Server Error",
        504 => "Gateway Timeout"
    ];

    public function OKE($msg, $datas = [])
    {
        $msg = ($msg ?: $this->status[200]);
        return response()->json($this->ajaxJSONReturn(200, "success", $msg, $datas), 200);
    }

    public function CREATED($msg, $datas = [])
    {
        $msg = ($msg ?: $this->status[201]);
        return response()->json($this->ajaxJSONReturn(201, "success", $msg, $datas), 201);
    }

    public function ACCEPTED($msg, $datas = [])
    {
        $msg = ($msg ?: $this->status[202]);
        return response()->json($this->ajaxJSONReturn(202, "success", $msg, $datas), 202);
    }

    public function BAD_REQUEST($msg, $datas = [])
    {
        $msg = ($msg ?: $this->status[400]);
        return response()->json($this->ajaxJSONReturn(400, "failed", $msg, $datas), 400);
    }

    public function UNAUTHORIZED($msg, $datas = [])
    {
        $msg = ($msg ?: $this->status[401]);
        return response()->json($this->ajaxJSONReturn(401, "failed", $msg, $datas), 401);
    }

    public function FORBIDDEN($msg, $datas = [])
    {
        $msg = ($msg ?: $this->status[403]);
        return response()->json($this->ajaxJSONReturn(403, "failed", $msg, $datas), 403);
    }

    public function NOT_FOUND($msg, $datas = [])
    {
        $msg = ($msg ?: $this->status[404]);
        return response()->json($this->ajaxJSONReturn(404, "failed", $msg, $datas), 404);
    }

    public function UNPROCESS_ENTITY($msg, $datas = [])
    {
        $msg = ($msg ?: $this->status[422]);
        return response()->json($this->ajaxJSONReturn(422, "failed", $msg, $datas), 422);
    }

    public function TO_MANY_REQ($msg, $datas = [])
    {
        $msg = ($msg ?: $this->status[429]);
        return response()->json($this->ajaxJSONReturn(429, "failed", $msg, $datas), 429);
    }

    public function SERVER_ERROR($msg, $datas = [])
    {
        $msg = ($msg ?: $this->status[500]);
        return response()->json($this->ajaxJSONReturn(500, "failure", $msg, $datas), 500);
    }

    public function SERVER_TIMEOUT($msg, $datas = [])
    {
        $msg = ($msg ?: $this->status[504]);
        return response()->json($this->ajaxJSONReturn(504, "failure", $msg, $datas), 504);
    }
}
