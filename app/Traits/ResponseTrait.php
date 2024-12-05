<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    public function sendSuccess($data = [], string $message = "", int $statusCode = 200): JsonResponse
    {
        if (empty($data)) {
            return response()->json([
                'code' => $statusCode,
                'message' => $message,
                'success' => true,
            ]);
        }
        return response()->json([
            'code' => $statusCode,
            'data' => $data,
            'message' => $message,
            'success' => true,
        ]);
    }

    public function sendError(array $error = [], mixed $statusCode = 404): JsonResponse
    {
        return response()->json([
            'code' => $statusCode,
            'errors' => $error,
            'success' => false,
        ]);
    }
}
