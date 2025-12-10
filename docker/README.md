# Docker Configuration

Thư mục này chứa các file cấu hình để triển khai ứng dụng trên Docker.

## Nội dung

- `Dockerfile` - File cấu hình build Docker image
- `docker-compose.yml` - Cấu hình Docker Compose
- Các file cấu hình services (nginx, php, mysql)

## Hướng dẫn sử dụng

### Khởi động ứng dụng với Docker

```bash
# Build và khởi động containers
docker-compose up -d

# Dừng containers
docker-compose down

# Xem logs
docker-compose logs -f
```

## Yêu cầu

- Docker >= 20.10
- Docker Compose >= 2.0
