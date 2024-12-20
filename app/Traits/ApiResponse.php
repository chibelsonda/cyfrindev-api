<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{ 
    /**
     * @var int
     */
    private $httpCode = 200;
    
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
    public function sendResponse($data = []): JsonResponse 
    {
        $response['success'] = true;

        if ($this->message) {
            $response['message'] = $this->message;
        }

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, $this->httpCode);
    }
    
    /**
     * Create created api response.
     *
     * @param string $entity
     *
     * @return ApiResponse
     */
    public function created($entity): ApiResponse
    {
        $this->message = "$entity created successfully.";
        $this->httpCode = Response::HTTP_CREATED;

        return $this;
    }
    
    /**
     * Create updated api response.
     *
     * @param string $entity
     *
     * @return ApiResponseTrait
     */
    public function updated($entity): ApiResponse
    {
        $this->message = "$entity updated successfully.";

        return $this;
    }
    
    /**
     * Create deleted api response.
     *
     * @param string $entity
     *
     * @return ApiResponseTrait
     */
    public function deleted($entity): ApiResponse
    {
        $this->message = "$entity deleted successfully.";

        return $this;
    }
    
    /**
     * Set response message
     *
     * @param string $message
     *
     * @return ApiResponseTrait
     */
    public function message($message): ApiResponse
    {
        $this->message = $message;
        
        return $this;
    }
}