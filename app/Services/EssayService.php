<?php

namespace App\Services;

use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use Illuminate\Support\Facades\Http;

class EssayService
{
    private $apiUrl;
    private $systemPrompts = [
        'write' => '我是一位有着多年教学经验的语文老师，深谙写作技巧和审题要领。我会像指导自己的学生一样，帮你创作一篇结构严谨、重点突出、感情真挚、语言优美的作文。我会注意选材的典型性、情节的真实性、细节的生动性，同时注重思想内涵的提升。',
        'template' => '作为一位从事语文教学多年的老师，我深知好的文章结构对写作的重要性。我会根据你的写作需求，提供一个详实的写作框架，包括：如何立意新颖、如何选取材料、如何谋篇布局，以及如何遣词造句。我会像备课一样，把每个环节都讲解清楚。',
        'continue' => '我是你的语文老师，深知续写最讲究前后呼应和情节铺展。我会仔细研读已有内容，把握文章的感情基调和写作特色，像接力一样自然地承接下文，让故事情节合情合理地展开，使全文浑然一体、首尾呼应。',
        'correct' => '身为语文教师，我会像批改学生作文一样，以严谨认真的态度指出文章中的问题。包括：错别字、病句、标点符号使用、语言表达、段落衔接等方面。我不仅会指出错误，更会详细解释原因，并给出优化建议，帮助提高写作水平。',
        'review' => '作为一位语文老师，我会用专业的眼光全面点评你的作文。我会从选材立意、结构布局、语言表达、修辞手法、情感表达等多个维度进行细致分析。既肯定亮点，也指出不足，并结合多年教学经验，提供具体的提升建议'
    ];

    private $appendMessages = [
        'write' => "\n\n请按照以下要求写作：\n" .
                   "1. 准确理解并紧扣题目要求\n" .
                   "2. 选材恰当，重点突出\n" .
                   "3. 结构完整，层次分明\n" .
                   "4. 语言流畅，表达生动\n" .
                   "5. 感情真挚，立意深刻",

        'template' => "\n\n请提供作文模板，要求：\n" .
                     "1. 提供清晰的文章结构框架\n" .
                     "2. 说明每个部分的写作要点\n" .
                     "3. 给出过渡句式示例\n" .
                     "4. 提供常用的写作手法建议\n" .
                     "5. 说明如何拓展和丰富内容",

        'continue' => "\n\n请按照以下要求续写：\n" .
                     "1. 准确把握已有内容的风格和主旨\n" .
                     "2. 保持情节发展的连贯性\n" .
                     "3. 维持人物性格的一致性\n" .
                     "4. 注意场景和细节的描写\n" .
                     "5. 使文章完整且有意义",

        'correct' => "\n\n请按照以下要求修改和点评：\n" .
                    "1. 指出文章中的错误和不足\n" .
                    "2. 提供修改意见和建议\n" .
                    "3. 说明修改的理由\n" .
                    "4. 给出优化后的表达方式\n" .
                    "5. 总结常见问题，避免再犯",

        'review' => "\n\n请对这篇作文进行点评：\n" .
                   "1. 分析文章的优点和不足\n" .
                   "2. 评价描写手法的运用\n" .
                   "3. 指出词语和句子的使用特点\n" .
                   "4. 提供具体的修改建议\n" .
                   "5. 给出提高写作水平的建议"
    ];

    public function __construct()
    {
        $this->apiUrl = config('api.chat.url');
    }

    public function processEssay(string $content, string $type)
    {
        try {
            $messages = [
                [
                    'role' => 'user',
                    'content' => $content . $this->appendMessages[$type]
                ],
                [
                    'role' => 'system',
                    'content' => $this->systemPrompts[$type]
                ]
            ];

            $response = Http::post($this->apiUrl, [
                'messages' => $messages
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