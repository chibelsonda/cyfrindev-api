<?php

namespace App\Services;

use Exception;
use App\Helpers\Logger;
use Illuminate\Http\Response;

class BaseService
{
    /**
     * Set api response
     *
     * @param string|array $message
     * @param int $statusCode
     * @param array $data
     * 
     * @return array
     * 
     */
    public function setResponse(
        string|array $message = null,
        int $statusCode = 200,
        array $data = [],
    ): array {
        $response["success"] = $statusCode >= 400 ? false : true;

        if ($message) {
            $response['message'] = is_array($message)
                ? $message
                : json_decode($message) ?? $message;
        }

        if ($data) {
            $response['data'] = $data;
        }

        $response['statusCode'] = $statusCode;

        return $response;
    }

    /**
     * Handles error
     *
     * @param Exception $error
     * @param string|null $message
     * 
     * @return array
     * 
     */
    public function handleError(Exception $error, ?string $message = null): array
    {
        Logger::log($error);

        return [
            "success" => false,
            "message" => $message ?? config('message.server_error'),
            "statusCode" => Response::HTTP_INTERNAL_SERVER_ERROR
        ];
    }

    /**
     * Set unauthorized response
     *
     * @param array|string $message
     * @param array $data
     * 
     * @return array
     * 
     */
    public function setUnauthorizedResponse($message, $data = []): array
    {
        return self::setResponse($message, Response::HTTP_UNAUTHORIZED, $data);
    }

    /**
     * Set created response
     *
     * @param array|string $message
     * @param array $data
     * 
     * @return array
     * 
     */
    public function setCreatedResponse($message, $data = []): array
    {
        return self::setResponse($message, Response::HTTP_CREATED, $data);
    }

    /**
     * Set not found response
     *
     * @param array|string $message
     * @param array $data
     * 
     * @return array
     * 
     */
    public function setNotFoundResponse($message, $data = []): array
    {
        return self::setResponse($message, Response::HTTP_NOT_FOUND, $data);
    }

     /**
     * Set unprocessable response
     *
     * @param array|string $message
     * @param array $data
     * 
     * @return array
     * 
     */
    public function setUnprocessableResponse($message, $data = []): array
    {
        return self::setResponse($message, Response::HTTP_UNPROCESSABLE_ENTITY, $data);
    }
}
