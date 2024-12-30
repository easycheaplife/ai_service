<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Endpoints Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for various API endpoints used in the application
    |
    */

    'image_recognition' => [
        'url' => env('IMAGE_RECOGNITION_API_URL', 'http://127.0.0.1:5000/api/image-recognition'),
    ],
    
    'chat' => [
        'url' => env('CHAT_API_URL', 'http://127.0.0.1:5000/api/chat'),
    ],
]; 