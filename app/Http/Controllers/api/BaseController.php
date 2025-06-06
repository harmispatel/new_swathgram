<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Send a standardized response for all API responses.
     *
     * @param mixed $data
     * @param string $message
     * @param bool $success
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function sendResponse($data, $message, $success = true, $statusCode = Response::HTTP_OK)
    {
        return response()->json([ 
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
    /**
     * Send a standardized error response.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($message, $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }
}
