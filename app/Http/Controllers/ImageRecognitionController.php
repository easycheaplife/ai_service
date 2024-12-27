<?php

namespace App\Http\Controllers;

use App\Services\ImageRecognitionService;
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

        if (!$result['success']) {
            return response()->json($result, 500);
        }

        return response()->json($result);
    }
} 