<?php

namespace App\Traits;

trait JSONResponse{

    public static function successResponse($data, $code)
    {
        $response = [
            'status' => 'success',
            'data' => $data
        ];

        return response()->json($response, $code);
    }

    public static function failResponse($data, $code)
    {
        $response = [
            'status' => 'fail',
            'data' => $data
        ];

        return response()->json($response, $code);
    }

    public static function errorResponse($data, $message, $code)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, $code);
    }
}

?>