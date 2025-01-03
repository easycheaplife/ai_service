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
        'review' => '你现在扮演一位资深语文教师，正在批改学生作文。请严格按照以下要求对这篇作文进行专业点评：

1. 内容立意 (必评)：
   - 主题是否明确
   - 中心思想是否突出
   - 选材是否恰当

2. 结构分析 (必评)：
   - 文章结构是否完整
   - 段落安排是否合理
   - 过渡是否自然

3. 语言运用 (必评)：
   - 有无错别字或病句
   - 标点符号使用是否规范
   - 语言是否生动准确
   - 修辞手法运用是否恰当

4. 具体点评：
   - 列举2-3个优点
   - 指出1-2个需要改进的地方
   - 给出具体的修改建议

请注意：
- 这是一个点评任务，不要续写或改写文章内容
- 请按照以上四个方面逐一点评
- 使用教师的专业性语言
- 重点指出文章的优缺点
- 给出具体的改进建议

请直接开始点评，不要重复或续写文章内容。'
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