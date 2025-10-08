<?php

namespace App\Helpers;

class ResponseHelper {

    public static function success(bool $error = false, string $message, $data, int $status = 200) {

        return response()->json([

            'error' => $error,
            'message' => $message,
            'data' => $data, 
            'status' => $status

        ]);

    }

    public static function error(bool $error = true, string $message, $data, int $status = 400) {

        return response()->json([

            'error' => $error,
            'message' => $message,
            'data' => $data, 
            'status' => $status

        ]);

    }

}