<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use App\Constants\ErrorCodes;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $result = $this->chatService->chat($request->content);

        if ($result['code'] !== ErrorCodes::ERROR_CODE_SUCCESS) {
            return response()->json($result, 500);
        }

        return response()->json($result);
    }
} 