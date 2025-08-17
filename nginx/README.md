# 在 Nginx 配置 HTTPS 而不使用域名

## 前提条件
1. **服务器的公网 IP 可用**：确保服务器具有有效的公网 IP 地址。
2. **SSL 证书**：即使不使用域名，也需要自签名证书或信任的 SSL 证书。

---

## 配置步骤

### 1. 生成自签名证书
使用 `openssl` 生成自签名证书：

```bash
# 生成私钥
openssl genrsa -out server.key 2048

# 生成自签名证书
openssl req -new -x509 -key server.key -out server.crt -days 365

# 注意：在生成证书时，Common Name (CN) 可以填写服务器的 IP 地址。

#### 这会生成以下两个文件：
    server.key：私钥文件
    server.crt：自签名证书文件

### 2. 配置 Nginx
编辑 Nginx 配置文件（例如 /etc/nginx/nginx.conf 或 /etc/nginx/sites-enabled/default），添加 HTTPS 配置：

```bash
server {
    listen 443 ssl;
    server_name _; # 使用 `_` 表示通配符，不指定域名

    ssl_certificate /path/to/server.crt;
    ssl_certificate_key /path/to/server.key;

    # 配置其他安全选项（可选）
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    location / {
        root /var/www/html; # 修改为你的文档根目录
        index index.html;
    }
}

# 可选：重定向 HTTP 到 HTTPS
server {
    listen 80;
    server_name _;

    location / {
        return 301 https://$host$request_uri;
    }
}

```
将 ssl_certificate 和 ssl_certificate_key 的路径替换为实际证书和密钥文件的位置。

### 3. 重启 Nginx
```bash
sudo systemctl restart nginx
```

这样，Nginx 就会使用自签名证书和密钥文件来提供 HTTPS 服务。