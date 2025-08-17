<?php

namespace App\Http\Controllers;

use App\Services\EssayService;
use App\Constants\ErrorCodes;
use Illuminate\Http\Request;

class EssayController extends Controller
{
    protected $essayService;

    public function __construct(EssayService $essayService)
    {
        $this->essayService = $essayService;
    }

    public function write(Request $request)
    {
        $request->validate(['content' => 'required|string']);
        $result = $this->essayService->processEssay($request->content, 'write');
        return $this->handleResponse($result);
    }

    public function template(Request $request)
    {
        $request->validate(['content' => 'required|string']);
        $result = $this->essayService->processEssay($request->content, 'template');
        return $this->handleResponse($result);
    }

    public function continue(Request $request)
    {
        $request->validate(['content' => 'required|string']);
        $result = $this->essayService->processEssay($request->content, 'continue');
        return $this->handleResponse($result);
    }

    public function correct(Request $request)
    {
        $request->validate(['content' => 'required|string']);
        $result = $this->essayService->processEssay($request->content, 'correct');
        return $this->handleResponse($result);
    }

    public function review(Request $request)
    {
        $request->validate(['content' => 'required|string']);
        $result = $this->essayService->processEssay($request->content, 'review');
        return $this->handleResponse($result);
    }

    private function handleResponse($result)
    {
        if ($result['code'] !== ErrorCodes::ERROR_CODE_SUCCESS) {
            return response()->json($result, 500);
        }
        return response()->json($result);
    }
} 