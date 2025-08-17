# AI Service (Laravel)

一个基于 Laravel 10 的轻量级 AI 中台服务，提供：
- 文件上传/下载
- 图像识别（转发到后端模型服务）
- 对话聊天（转发到后端大模型服务）

所有 API 以统一的响应格式返回，便于前后端协作与错误处理。

## 运行环境
- PHP >= 8.1
- Composer
- （可选）Node.js 18+（仅在需要前端/Vite 相关功能时）

## 快速开始
1. 克隆项目并安装依赖
   - git clone <repo>
   - cd ai_service
   - composer install
2. 准备环境变量
   - cp .env.example .env
   - php artisan key:generate
3. 配置外部服务地址（见“配置”一节），确保指向可用的后端服务
4. 启动服务
   - php artisan serve
   - 默认监听 http://127.0.0.1:8000

## 配置
相关配置集中在 config/api.php，并支持通过环境变量覆盖：
- IMAGE_RECOGNITION_API_URL（默认：http://127.0.0.1:5000/api/image-recognition）
- CHAT_API_URL（默认：http://127.0.0.1:5000/api/chat）

在 .env 中示例如下：
```
IMAGE_RECOGNITION_API_URL=http://127.0.0.1:5000/api/image-recognition
CHAT_API_URL=http://127.0.0.1:5000/api/chat
```

## API 约定
- 基础路径：/api
- 认证：当前公开接口无需认证；/api/user 使用 Sanctum 鉴权仅作示例
- 统一返回结构（无论 GET/POST）：
```
{
  "code": 0,
  "message": "",
  "data": { ... }
}
```
- 错误码约定（app/Constants/ErrorCodes.php）：
  - 0: 成功
  - 1: 入参错误
  - 2: 数据库错误
  - 3: 文件不存在
  - 4: 图像识别失败
  - 5: 图像识别服务异常
  - 6: 聊天请求失败
  - 7: 聊天服务异常
- 提示：请以 code 字段作为业务成功与否的唯一判断依据。部分接口在失败时可能仍返回 HTTP 200（例如文件上传/下载），而图像识别与聊天在服务内部失败时会返回 HTTP 500。

## 接口文档与示例
以下示例默认服务地址为 http://127.0.0.1:8000。

### 1) 文件上传
- 路径：POST /api/file/upload
- 入参：multipart/form-data，字段名 file
- 响应：
```
{
  "code": 0,
  "message": "",
  "data": {"file_name": "xxxxx"}
}
```
- 示例：
```
curl -X POST http://127.0.0.1:8000/api/file/upload \
  -F "file=@/path/to/your/file.png"
```

### 2) 文件下载
- 路径：GET /api/file/download/{file_name}
- 行为：触发文件下载；若文件不存在，返回统一错误结构
- 示例：
```
curl -X GET -OJ http://127.0.0.1:8000/api/file/download/xxxxx
```

### 3) 图像识别
- 路径：GET/POST /api/image-recognition
- 入参：image_url（必填，需为有效 URL）
- 响应：统一结构，data 为下游识别服务的 JSON 结果
- 示例（GET）：
```
curl "http://127.0.0.1:8000/api/image-recognition?image_url=https://example.com/cat.jpg"
```
- 示例（POST）：
```
curl -X POST http://127.0.0.1:8000/api/image-recognition \
  -H "Content-Type: application/json" \
  -d '{"image_url":"https://example.com/cat.jpg"}'
```

### 4) 聊天
- 路径：GET/POST /api/chat
- 入参：content（必填，字符串）
- 响应：统一结构，data 为下游大模型服务的 JSON 结果
- 示例（GET）：
```
curl "http://127.0.0.1:8000/api/chat?content=你好"
```
- 示例（POST）：
```
curl -X POST http://127.0.0.1:8000/api/chat \
  -H "Content-Type: application/json" \
  -d '{"content":"写一首关于春天的短诗"}'
```

## 本地开发
- 日志：storage/logs/laravel.log
- 代码风格：
  - ./vendor/bin/pint 进行自动格式化
- 可选 Docker 开发（Laravel Sail）：
  - 参考 https://laravel.com/docs/sail 安装与使用

## 测试
- 运行测试：
```
./vendor/bin/phpunit
```

## 许可证
本项目采用 MIT 许可证，详见 LICENSE。
