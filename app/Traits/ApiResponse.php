<?php

namespace App\Traits;

trait ApiResponse
{
    protected function success($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function fail($message = 'Failed', $code = 400, $errors = null)
    {
        return response()->json([
            'status' => 'fail',
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }

    protected function error($message = 'Error', $code = 500)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    protected function notFound($message = 'Resource not found')
    {
        return response()->json([
            'status' => 'fail',
            'message' => $message,
        ], 404);
    }

    protected function unauthorized($message = 'Unauthorized')
    {
        return response()->json([
            'status' => 'fail',
            'message' => $message,
        ], 401);
    }

    protected function forbidden($message = 'Forbidden')
    {
        return response()->json([
            'status' => 'fail',
            'message' => $message,
        ], 403);
    }

    protected function validationError($errors, $message = 'Validation failed')
    {
        return response()->json([
            'status' => 'fail',
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }
}