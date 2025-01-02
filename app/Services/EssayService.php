<?php

namespace App\Services;

use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use Illuminate\Support\Facades\Http;

class EssayService
{
    private $apiUrl;
    private $systemPrompts = [
        'write' => '你是一位专业的写作导师，擅长根据主题创作优质作文。请根据用户提供的主题，写出结构完整、内容丰富、语言优美的作文。',
        'template' => '你是一位资深的写作指导专家，擅长提供作文模板。请根据用户的需求，提供清晰的作文结构模板，包括开头、主体和结尾的写作建议。',
        'continue' => '你是一位富有创造力的写作助手，擅长作文续写。请基于已有内容，保持风格连贯，进行合理的情节发展和内容扩展。',
        'correct' => '你是一位严谨的写作教师，擅长发现和纠正作文中的错误。请仔细分析文章，指出语法、用词、标点等方面的错误，并给出修改建议。',
        'review' => '你是一位专业的作文点评老师，擅长全面评价作文。请从内容、结构、语言、创意等多个维度进行分析，指出优点和不足，并提供改进建议。'
    ];

    public function __construct()
    {
        $this->apiUrl = config('api.chat.url');
    }

    public function processEssay(string $content, string $type)
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
                        'content' => $this->systemPrompts[$type]
                    ]
                ]
            ]);

            if (!$response->successful()) {
                return [
                    'code' => ErrorCodes::ERROR_CODE_ESSAY_FAILED,
                    'message' => ErrorDescs::ERROR_CODE_ESSAY_FAILED,
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
                'code' => ErrorCodes::ERROR_CODE_ESSAY_SERVICE_ERROR,
                'message' => ErrorDescs::ERROR_CODE_ESSAY_SERVICE_ERROR,
                'data' => []
            ];
        }
    }
} 