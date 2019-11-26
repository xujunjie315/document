# nginx应用

## 1.常规服务器nginx配置

```bash
    location / {
        proxy_pass http://127.0.0.1:8080;
        proxy_redirect default;

        proxy_set_header Host $http_host;
        proxy_set_header X-Real-IP $remote_addr;

        proxy_connect_timeout 30;
        proxy_send_timeout 60;
        proxy_read_timeout 60;

        proxy_buffer_size 32k;
        proxy_buffering on;
        proxy_buffers 4 128k;
        proxy_busy_buffers_size 256k;
        proxy_max_temp_file_size 256k;
    }
```

## 2.静态文件服务器

```bash
    location ~ .*\.(jpg|gif|png)$ {
        gzip on;
        gzip_http_version 1.1;
        gzip_comp_level 2;
        gzip_types text/plain application/javascript application/x-javascript text/css application/xml text/javascript application/x-httpd-php image/jpeg image/gif image/png
        //防盗链
        valid_referers none blocked 116.62.103.228 ~/google\./;
        if($invalid_referer) {
            return 403;
        }
        root /opt/app/code/images
    }
    location ~ .*\.(txt|xml)$ {
        gzip on;
        gzip_http_level 1;
        gzip_comp_level1;
        gzip_types text/plain application/javascript application/x-javascript text/css application/xml text/javascript application/x-httpd-php image/jpeg image/gif image/png
        root /opt/app/code/doc
    }
    //允许跨域访问
    location ~ .*\.(htm|html)$ {
        add_header Access-Controller-Allow-Origin http://www.jesonc.com;
        add_header Access-Controller-Allow-Methods GET,POST,PUT,DELETE,OPTIONS;
        root /opt/app/code;
    }
    location ~ ^/download {
        gzip_static on;
        tcp_nopush on;
        root /opt/app/code;
    }
```

## 3.代理服务

```bash
    //反向代理
    location ~ /test_proxy.htmls {
        proxy_pass http://127.0.0.1:8080;
    }
    //正向代理
    resolver 8.8.8.8;
    location / {
        proxy_pass http://$http_host$request_url;
    }
```



## 4.负载均衡

```bash
    upstream imooc {
        server 116.62.103.228:8001;
        server 116.62.103.228:8002;
        server 116.62.103.228:8003;
    }
    upstream imooc {
        server 116.62.103.228:8001 weight=5;
        server 116.62.103.228:8002;
        server 116.62.103.228:8003;
    }
    upstream imooc {
        ip_hash;
        server 116.62.103.228:8001;
        server 116.62.103.228:8002;
        server 116.62.103.228:8003;
    }
    upstream imooc {
        hash $request_url
        server 116.62.103.228:8001;
        server 116.62.103.228:8002;
        server 116.62.103.228:8003;
    }
    location / {
        proxy_pass http://imooc;
        include proxy_params;
    }
```

* 轮询：按时间的顺序逐一分配到不同的后端服务器
* 加权轮询：weight值越大，分配到的访问几率越高
* ip_hash:每个请求按访问IP的hash结果分配，这样来自同一个ip会固定访问一个后端服务器
* least_conn:最少链接数，哪个机器连接数少就分发
* url_hash:按照访问的URL的hash结果来分配请求，是每个URL定向到同一个后端服务器
* hash关键数值：hash自定义的key

## 5.nginx代理缓存

```bash
    upstream imooc {
        server 116.62.103.228:8001;
        server 116.62.103.228:8002;
        server 116.62.103.228:8003;
    }
    proxy_cache_path /opt/app/cache levels=1:2 keys_zone=imooc_cache:10m max_size=10g inactive=60m use_temp_path=off;
    server {
        listen 80;
        server_name localhost;
        access_log /var/log/nginx/test_proxy.access.log main;

        if ($request_uri ~ ^/(url3|login|register|password\/reset)) {
            set $cookie_nocache 1;
        }

        location / {
            proxy_cache immooc_cache;
            proxy_pass http://imooc;
            proxy_cache_valid 200 304 12h;
            proxy_cache_valid any 10m;
            proxy_cache_key $host$uri$is_args$args;
            proxy_no_cache $cookie_nocache $arg_nocache $arg_comment;
            proxy_no_cache $http_pragma $http_authorization;
            add_header Nginx-Cache "$upstream_cache_status";
            proxy_next_upsteam error timeout invalid_header http_500 http_502 http_503 http_504;
            include proxy_params;
        }
    }
```

## 6.动静分离

```bash
upstream php{
    server 127.0.0.1:8080;
}
server {
    listen 80;
    server_name localhost;
    access_log /var/log/nginx/log/host.access.log main;
    root /opt/app/code;
    location ~ \.php$ {
        proxy_pass http://php;
        index index.html index.htm;
    }
    location ~ \.(jpg|png|gif)$ {
        expires 1h;
        gzip on;
    }
    location / {
        index index.html index.htm;
    }
    error_page 500 502 503 504 404 /50x.html;
}
```

## 7.rewrite

```bash
rewrite ^(.*)$ /pages/maintain.html break;

server {
    listen 80 default_server;
    server_name jeson.t.imooc.io;
    access_log /var/log/nginx/log/host.access.log main;
    root /opt/app/code;
    location ~ ^/break {
        rewrite ^/break /test/ break;
    }
    location ~ ^/last {
        rewrite ^/last /test/ last;
    }
    location /test/ {
        default_type application/json;
        return 200 '{"status":"success"}';
    }
    location ~ ^/imooc {
        rewrite ^/imooc http://www.imooc.com/ permanent;
        rewrite ^/imooc http://www.imooc.com/ redirect;
    }
    location / {
        rewrite ^/course-(\d+)-(\d+)-(\d+)\.html$ /course/$1/$2/course_$3.html break;
    }
}
```