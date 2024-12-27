<?php

namespace App\Http\Controllers;

use App\Services\ImageRecognitionService;
use App\Constants\ErrorCodes;
use Illuminate\Http\Request;

class ImageRecognitionController extends Controller
{
    protected $imageRecognitionService;

    public function __construct(ImageRecognitionService $imageRecognitionService)
    {
        $this->imageRecognitionService = $imageRecognitionService;
    }

    public function recognize(Request $request)
    {
        $request->validate([
            'image_url' => 'required|url'
        ]);

        $result = $this->imageRecognitionService->recognize($request->image_url);

        if ($result['code'] !== ErrorCodes::ERROR_CODE_SUCCESS) {
            return response()->json($result, 500);
        }

        return response()->json($result);
    }
} 