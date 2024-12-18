<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Send response
     *
     * @param array $response
     * 
     * @return JsonResponse
     */
    public function sendResponse(array $response = []): JsonResponse
    {
        $httpCode = $response['statusCode'] ?? Response::HTTP_OK;
        unset($response['statusCode']);

        return response()->json($response, $httpCode);
    }
}
