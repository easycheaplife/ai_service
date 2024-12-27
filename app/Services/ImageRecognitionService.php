<?php

namespace App\Services;

use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use Illuminate\Support\Facades\Http;

class ImageRecognitionService
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('api.image_recognition.url');
    }

    public function recognize(string $imageUrl)
    {
        try {
            $response = Http::post($this->apiUrl, [
                'image_url' => $imageUrl
            ]);

            if (!$response->successful()) {
                return [
                    'code' => ErrorCodes::ERROR_CODE_IMAGE_RECOGNITION_FAILED,
                    'message' => ErrorDescs::ERROR_CODE_IMAGE_RECOGNITION_FAILED,
                    'data' => []
                ];
            }

            return [
                'code' => ErrorCodes::ERROR_CODE_SUCCESS,
                'message' => ErrorDescs::ERROR_CODE_SUCCESS,
                'data' => $response->json()
            ];

        } catch (\Exception $e) {
            return [
                'code' => ErrorCodes::ERROR_CODE_IMAGE_RECOGNITION_SERVICE_ERROR,
                'message' => ErrorDescs::ERROR_CODE_IMAGE_RECOGNITION_SERVICE_ERROR,
                'data' => []
            ];
        }
    }
} 