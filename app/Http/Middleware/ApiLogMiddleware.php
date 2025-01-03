<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

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

        // 记录响应信息
        $responseData = $response->getData();
        Log::channel('api')->info('API Response', [
            'path' => $request->path(),
            'status_code' => $response->status(),
            'response' => $responseData
        ]);

        return $response;
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