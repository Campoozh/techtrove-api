<?php

namespace App\Utility;

use Illuminate\Http\JsonResponse;

class ResponseBuilder
{
    /*
     * Optei por construir o meu ResponseBuilder para mais facilidade em "formatar"
     * as respostas enviadas ao front.
     *
     * E também para deixar o controller mais "clean".
     */

    public static function success(string $message, array $data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json(["status" => true, "message" => $message, "data" => $data ], $statusCode);
    }

    public static function error(string $message, array|string $data = [], int $statusCode = 400): JsonResponse
    {
        return response()->json(["status" => false, "message" => $message, "data" => $data ], $statusCode);
    }

    public static function sendData(array $data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json($data, $statusCode);
    }
}
