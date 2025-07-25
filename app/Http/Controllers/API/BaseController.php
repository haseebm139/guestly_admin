<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Send a successful response.
     *
     * @param mixed $result The data to send back in the response.
     * @param string|null $message The success message (optional).
     * @param int $code HTTP status code (default 200).
     * @param array $headers Additional headers (optional).
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result = [], $message = 'Operation successful', $code = 200, $headers = [])
    {
        $response = [
            'success' => true,
            'data'    => $result,  // Assuming $result includes any relevant data
        ];

        if ($message) {
            $response['message'] = $message;
        }

        // Return the JSON response with the optional headers
        return response()->json($response, $code, $headers);
    }

    /**
     * Send an error response.
     *
     * @param string $error The error message.
     * @param array $errorMessages Additional error details (optional).
     * @param int $code HTTP status code (default 400).
     * @param array $headers Additional headers (optional).
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 400, $headers = [])
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        // Return the JSON error response with the optional headers
        return response()->json($response, $code, $headers);
    }

    public function sendResponseAnother($result, $message = '', $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ], $code);
    }

    public function sendErrorAnother($error, $errorMessages = [], $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $error,
            'data'    => $errorMessages,
        ], $code);
    }


}
