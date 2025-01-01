<?php

namespace App\Services;

use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use Illuminate\Support\Facades\Http;

class ChatService
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('api.chat.url');
    }

    public function chat(string $content)
    {
        try {
            $response = Http::post($this->apiUrl, [
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $content
                    ],
                    [
                        'role' => 'system',
                        'content' => '你是一位语文老师。'
                    ]
                ]
            ]);

            if (!$response->successful()) {
                return [
                    'code' => ErrorCodes::ERROR_CODE_CHAT_FAILED,
                    'message' => ErrorDescs::ERROR_CODE_CHAT_FAILED,
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
                'code' => ErrorCodes::ERROR_CODE_CHAT_SERVICE_ERROR,
                'message' => ErrorDescs::ERROR_CODE_CHAT_SERVICE_ERROR,
                'data' => []
            ];
        }
    }
} 