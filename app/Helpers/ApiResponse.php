<?php

namespace App\Helpers;

use \Illuminate\Http\JsonResponse;

class ApiResponse
{

    static public function create($success ,$status=200, $error=null, $data=null, $messages=null) : JsonResponse
    {
        return response()->json(
            [
                'success' => $success,
                'status' => $status,
                'errors' => $error,
                'data' => $data,
                'messages' => $messages
            ]
            ,$status);
    }


    static public function success($data=null, $messages=null, $status=200) : JsonResponse
    {
        return self::create(true, $status, null, $data, $messages);
    }


    static public function error($status=400, $error=null, $messages=null) : JsonResponse
    {
        return self::create(false, $status, $error, null, $messages);
    }
}
