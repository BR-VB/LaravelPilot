<?php

if (!function_exists('apiResponse')) {
    function apiResponse($data, $message, $success = true, $statusCode = 200, $headers = [], $errors = null)
    {
        $response = response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
        ], $statusCode);

        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
