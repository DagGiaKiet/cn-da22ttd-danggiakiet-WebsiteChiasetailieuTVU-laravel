# Hướng Dẫn Cấu Hình Môi Trường (.env)

## Tạo File .env

File `.env.example` đã được cung cấp trong thư mục setup này. Bạn cần copy và đổi tên thành `.env`:

```bash
# Linux/Mac
cp .env.example .env

# Windows (PowerShell)
Copy-Item .env.example .env
```

## Các Cấu Hình Quan Trọng

### 1. Application Settings

```env
APP_NAME="TVU Book Exchange"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000
```

- `APP_NAME`: Tên ứng dụng
- `APP_ENV`: Môi trường (local, production)
- `APP_KEY`: Được generate tự động bằng lệnh `php artisan key:generate`
- `APP_DEBUG`: Bật/tắt debug mode (production nên set = false)
- `APP_URL`: URL của ứng dụng

### 2. Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tvu_bookexchange
DB_USERNAME=root
DB_PASSWORD=
```

**Cần thay đổi:**
- `DB_DATABASE`: Tên database đã tạo
- `DB_USERNAME`: Username MySQL của bạn
- `DB_PASSWORD`: Password MySQL của bạn

### 3. Mail Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Hướng dẫn cấu hình Gmail:**
1. Bật xác thực 2 bước trong Google Account
2. Tạo App Password: https://myaccount.google.com/apppasswords
3. Sử dụng App Password trong `MAIL_PASSWORD`

### 4. Session & Cache

```env
SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

- `SESSION_DRIVER`: Cách lưu session (file, database, redis)
- `SESSION_LIFETIME`: Thời gian session tồn tại (phút)
- `CACHE_DRIVER`: Driver cho cache
- `QUEUE_CONNECTION`: Driver cho queue

## Generate Application Key

Sau khi tạo file `.env`, chạy lệnh:

```bash
php artisan key:generate
```

Lệnh này sẽ tự động tạo `APP_KEY` trong file `.env`.

## Kiểm Tra Cấu Hình

```bash
# Xem tất cả cấu hình hiện tại
php artisan config:show

# Clear cache cấu hình
php artisan config:clear

# Cache cấu hình (production)
php artisan config:cache
```

## Cấu Hình Production

Khi deploy lên production, cần thay đổi:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

## Bảo Mật

⚠️ **QUAN TRỌNG:**
- **KHÔNG BAO GIỜ** commit file `.env` lên Git
- File `.env` chứa thông tin nhạy cảm (password, API keys)
- Chỉ commit file `.env.example` (không chứa thông tin thật)

## Troubleshooting

### Lỗi: No application encryption key has been specified
```bash
php artisan key:generate
```

### Lỗi: Configuration cache not found
```bash
php artisan config:cache
```

### Lỗi: Cannot write to .env file
- Kiểm tra quyền file: File .env cần có quyền write (644)
- Windows: Kiểm tra file không bị read-only
