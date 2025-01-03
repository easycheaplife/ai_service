<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ApiLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 记录请求信息
        Log::channel('api')->info('API Request', [
            'path' => $request->path(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'params' => $this->filterSensitiveData($request->all())
        ]);

        // 获取响应
        $response = $next($request);

        // 根据响应类型获取数据
        $responseData = $this->getResponseData($response);
        
        Log::channel('api')->info('API Response', [
            'path' => $request->path(),
            'status_code' => $response->getStatusCode(),
            'response' => $responseData
        ]);

        return $response;
    }

    /**
     * 根据不同响应类型获取响应数据
     */
    private function getResponseData($response)
    {
        if ($response instanceof JsonResponse) {
            return $response->getData();
        }

        if ($response instanceof BinaryFileResponse) {
            return [
                'type' => 'file',
                'file_path' => $response->getFile()->getPathname(),
                'file_name' => $response->getFile()->getFilename(),
                'file_size' => $response->getFile()->getSize()
            ];
        }

        // 其他类型的响应
        return [
            'type' => get_class($response),
            'content_type' => $response->headers->get('Content-Type'),
            'content_length' => $response->headers->get('Content-Length')
        ];
    }

    /**
     * 过滤敏感数据
     */
    private function filterSensitiveData(array $data): array
    {
        $sensitiveFields = ['password', 'token'];
        
        return collect($data)->map(function ($value, $key) use ($sensitiveFields) {
            if (in_array($key, $sensitiveFields)) {
                return '******';
            }
            return $value;
        })->all();
    }
} 