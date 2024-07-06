<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * Success Response.
     *
     * @param  mixed  $data
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public function successResponse(
        mixed $data,
        string $message = '',
        bool $isVisibleMessage = false,
        int $statusCode =
        Response::HTTP_OK
    ): JsonResponse
    {
        $payload = [
            'isVisibleMessage' => $isVisibleMessage,
            'message' => $message,
            'data' => $data,
        ];

        return new JsonResponse($payload, $statusCode);
    }

    /**
     * Error Response.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public function errorResponse(
        mixed $data,
        string $message = '',
        bool $isVisibleMessage = false,
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse
    {
        if (!$message) {
            $message = Response::$statusTexts[$statusCode];
        }

        $payload = [
            'isVisibleMessage' => $isVisibleMessage,
            'message' => $message,
            'data' => $data,
        ];

        return new JsonResponse($payload, $statusCode);
    }

    /**
     * Response with status code 200.
     *
     * @param  mixed  $data
     * @return JsonResponse
     */
    public function okResponse(mixed $data): JsonResponse
    {
        return $this->successResponse($data);
    }

    /**
     * Response with status code 201.
     *
     * @param  mixed  $data
     * @return JsonResponse
     */
    public function createdResponse(
        mixed $data,
        string $message = '',
        bool $isVisibleMessage = false,
    ): JsonResponse
    {
        return $this->successResponse($data, $message, $isVisibleMessage, Response::HTTP_CREATED);
    }

    /**
     * Response with status code 204.
     *
     * @return JsonResponse
     */
    public function noContentResponse(
        string $message = '',
        bool $isVisibleMessage = false,
    ): JsonResponse
    {
        return $this->successResponse([], $message, $isVisibleMessage, Response::HTTP_NO_CONTENT);
    }

    /**
     * Response with status code 400.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function badRequestResponse(
        mixed $data,
        string $message = '',
        bool $isVisibleMessage = false,
    ): JsonResponse
    {
        return $this->errorResponse($data, $message, $isVisibleMessage, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Response with status code 401.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function unauthorizedResponse(
        mixed $data,
        string $message = '',
        bool $isVisibleMessage = false,
    ): JsonResponse
    {
        return $this->errorResponse($data, $message, $isVisibleMessage, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Response with status code 403.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function forbiddenResponse(
        mixed $data,
        string $message = '',
        bool $isVisibleMessage = false,
    ): JsonResponse
    {
        return $this->errorResponse($data, $message, $isVisibleMessage, Response::HTTP_FORBIDDEN);
    }

    /**
     * Response with status code 404.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function notFoundResponse(
        mixed $data,
        string $message = '',
        bool $isVisibleMessage = false,
    ): JsonResponse
    {
        return $this->errorResponse($data, $message, $isVisibleMessage, Response::HTTP_NOT_FOUND);
    }

    /**
     * Response with status code 409.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function conflictResponse(
        mixed $data,
        string $message = '',
        bool $isVisibleMessage = false,
    ): JsonResponse
    {
        return $this->errorResponse($data, $message, $isVisibleMessage, Response::HTTP_CONFLICT);
    }

    /**
     * Response with status code 422.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function unprocessableResponse(
        mixed $data,
        string $message = '',
        bool $isVisibleMessage = false,
    ): JsonResponse
    {
        return $this->errorResponse($data, $message, $isVisibleMessage, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
