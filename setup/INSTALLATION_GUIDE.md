# Hướng Dẫn Cài Đặt Đầy Đủ

## Website Chia Sẻ Tài Liệu - Trường Đại học Trà Vinh

### Yêu cầu hệ thống

- **PHP**: >= 8.1
- **Composer**: Phiên bản mới nhất
- **MySQL**: >= 5.7 hoặc MariaDB >= 10.3
- **Node.js**: >= 16.x
- **NPM**: >= 8.x
- **Web Server**: Apache hoặc Nginx

### Bước 1: Clone Repository

```bash
git clone https://github.com/DagGiaKiet/cn-da22ttd-danggiakiet-WebsiteChiasetailieuTVU-laravel.git
cd cn-da22ttd-danggiakiet-WebsiteChiasetailieuTVU-laravel
```

### Bước 2: Cài Đặt Dependencies

```bash
# Di chuyển vào thư mục source code
cd src/WEBSITE\ CHIA\ SE\ TAI\ LIEU/tvu_app

# Cài đặt PHP dependencies
composer install

# Cài đặt Node.js dependencies
npm install
```

### Bước 3: Cấu Hình Môi Trường

```bash
# Copy file .env.example từ thư mục setup
cp ../../../setup/.env.example .env

# Hoặc tạo từ template trong thư mục hiện tại
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Bước 4: Cấu Hình Database

1. Tạo database trong MySQL/MariaDB:

```sql
CREATE DATABASE tvu_bookexchange CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Import dữ liệu từ file SQL:

```bash
# Sử dụng MySQL command line
mysql -u root -p tvu_bookexchange < ../../../setup/database_setup.sql

# Hoặc sử dụng phpMyAdmin
# - Mở phpMyAdmin
# - Chọn database tvu_bookexchange
# - Click Import
# - Chọn file setup/database_setup.sql
# - Click Go
```

3. Cập nhật thông tin database trong file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tvu_bookexchange
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Bước 5: Cấu Hình Storage

```bash
# Tạo symbolic link cho storage
php artisan storage:link

# Set quyền cho thư mục storage và bootstrap/cache (Linux/Mac)
chmod -R 775 storage bootstrap/cache

# Windows: Không cần thiết
```

### Bước 6: Compile Assets

```bash
# Development mode
npm run dev

# Production mode
npm run build
```

### Bước 7: Chạy Ứng Dụng

#### Development Server (Laravel built-in)

```bash
php artisan serve
```

Truy cập: http://localhost:8000

#### Production (Apache)

1. Cấu hình Virtual Host:

```apache
<VirtualHost *:80>
    ServerName tvu-bookexchange.local
    DocumentRoot "D:/BOOK V2 LIQUID GLASS/src/WEBSITE CHIA SE TAI LIEU/tvu_app/public"
    
    <Directory "D:/BOOK V2 LIQUID GLASS/src/WEBSITE CHIA SE TAI LIEU/tvu_app/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

2. Thêm vào file hosts:

```
127.0.0.1 tvu-bookexchange.local
```

3. Restart Apache

### Bước 8: Tài Khoản Mẫu

#### Admin
- Email: `admin@tvu.edu.vn`
- Password: `admin123`

#### User
- Email: `user@st.tvu.edu.vn`
- Password: `user123`

### Xử Lý Lỗi Thường Gặp

#### Lỗi: 500 Internal Server Error
- Kiểm tra quyền thư mục storage và bootstrap/cache
- Kiểm tra file .env đã được cấu hình đúng
- Kiểm tra log tại storage/logs/laravel.log

#### Lỗi: Database connection refused
- Kiểm tra MySQL service đang chạy
- Kiểm tra thông tin DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD trong .env

#### Lỗi: Class not found
- Chạy: `composer dump-autoload`
- Clear cache: `php artisan cache:clear && php artisan config:clear`

### Thông Tin Liên Hệ

**Sinh viên thực hiện:**
- Họ tên: Đặng Gia Kiệt
- MSSV: 110122001
- Email: 110122001@st.tvu.edu.vn
- Điện thoại: [Số điện thoại]

**Giảng viên hướng dẫn:**
- [Tên giảng viên]
- Email: [Email giảng viên]
