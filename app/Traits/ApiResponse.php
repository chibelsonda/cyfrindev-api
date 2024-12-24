<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{     
    /**
     * @var string
     */
    private $message;

    /**
     * Send api response
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    public function sendResponse($data = [], $httpCode = 200): JsonResponse 
    {
        $response['success'] = true;

        if ($this->message) {
            $response['message'] = $this->message;
        }

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, $httpCode);
    }
        
    /**
     * Set response message
     *
     * @param string $message
     *
     * @return ApiResponse
     */
    public function message($message): ApiResponse
    {
        $this->message = $message;
        
        return $this;
    }
}