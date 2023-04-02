<?php

namespace App\Traits\Helpers;

use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;

trait ApiResponseTrait
{
    protected function respondWithResource(JsonResource $resource, $message = null, $statusCode = 200, $headers = [])
    {
        return $this->apiResponse(
            [
                'success' => true,
                'data' => $resource,
                'message' => $message
            ], $statusCode, $headers
        );
    }

    protected function apiResponse($data = [], $statusCode = 200, $headers = [])
    {

        $result = $this->parseGivenData($data, $statusCode, $headers);

        return response()->json(
            $result['content'], $result['statusCode'], $result['headers']
        );
    }

    public function parseGivenData($data = [], $statusCode = 200, $headers = [])
    {
        $responseStructure = [
            'success' => $data['success'],
            'message' => $data['message'] ?? null,
            'data' => $data['data'] ?? null,
        ];
        if (isset($data['errors'])) {
            $responseStructure['errors'] = $data['errors'];
        }
        if (isset($data['status'])) {
            $statusCode = $data['status'];
        }


        if (isset($data['exception']) && ($data['exception'] instanceof Error || $data['exception'] instanceof Exception)) {
            if (config('app.env') !== 'production') {
                $responseStructure['exception'] = [
                    'message' => $data['exception']->getMessage(),
                    'file' => $data['exception']->getFile(),
                    'line' => $data['exception']->getLine(),
                    'code' => $data['exception']->getCode(),
                    'trace' => $data['exception']->getTrace(),
                ];
            }

            if ($statusCode === 200) {
                $statusCode = 500;
            }
        }
        if ($data['success'] === false) {
            if (isset($data['error_code'])) {
                $responseStructure['error_code'] = $data['error_code'];
            } else {
                $responseStructure['error_code'] = 1;
            }
        }
        return ["content" => $responseStructure, "statusCode" => $statusCode, "headers" => $headers];
    }

    protected function respondWithResourceCollection(ResourceCollection $resourceCollection, $message = null, $statusCode = 200, $headers = [])
    {
        return $this->apiResponse(
            [
                'success' => true,
                'data' => $resourceCollection,
                'message' => $message
            ], $statusCode, $headers
        );
    }

    protected function respondSuccess($message = '')
    {
        return $this->apiResponse(['success' => true, 'message' => $message]);
    }


    protected function respondValue($data , $message = '' , $statusCode = 200 , $headers = [])
    {
        return $this->apiResponse(
            [
                'success' => true,
                'data' => $data,
                'message' => $message
            ], $statusCode, $headers
        );
    }
    protected function respondCreated($data, $message)
    {
        return $this->apiResponse([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], 201);
    }

    protected function respondNoContent($message = 'No Content Found')
    {
        return $this->apiResponse(['success' => false, 'message' => $message], 200);
    }



    protected function respondUnAuthorized($message = 'Unauthorized')
    {
        return $this->respondError($message, null, 401);
    }

    protected function respondError($message, Exception $exception = null, int $statusCode = 400, int $error_code = 1): JsonResponse
    {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $message ?? 'There was an internal error, Pls try again later',
                'exception' => $exception,
                'error_code' => $error_code
            ], $statusCode
        );
    }

    protected function respondForbidden($message = 'Forbidden')
    {
        return $this->respondError($message, null, 403);
    }

    protected function respondNotFound($message = 'Not Found')
    {
        return $this->respondError($message, null, 404);
    }


    protected function respondInternalError($message = 'Internal Error')
    {
        return $this->respondError($message, null, 500);
    }

    protected function respondValidationErrors(ValidationException $exception)
    {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors()
            ],
            422
        );
    }
}
