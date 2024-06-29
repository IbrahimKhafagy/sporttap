<?php
namespace App\Traits;

trait ApiResponsesTrait
{
    public function successResponse($data, $message, $code = 200)
    {

        return response()->json(['data' => $data, 'message' => $message, 'status' => $code]);
    }

    public function errorResponse($message, $status = 201)
    {
        return response()->json(['status' => $status, 'data' => null, 'message' => $message]);
    }
}
