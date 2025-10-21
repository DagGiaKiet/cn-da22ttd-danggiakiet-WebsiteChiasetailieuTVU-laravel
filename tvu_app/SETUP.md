# HƯỚNG DẪN CÀI ĐẶT VÀ CHẠY DỰ ÁN

## Yêu cầu hệ thống

- PHP >= 8.1
- Composer
- MySQL >= 5.7 hoặc MariaDB >= 10.3
- Node.js >= 16.x và NPM
- Web server (Apache/Nginx) hoặc PHP built-in server

## Các bước cài đặt chi tiết

### Bước 1: Clone hoặc tải project

```bash
# Nếu có git
git clone <repository-url>

# Hoặc giải nén file ZIP vào thư mục
cd "WEBSITE CHIA SE TAI LIEU"
```

### Bước 2: Cài đặt dependencies PHP

```bash
composer install
```

Nếu gặp lỗi, chạy:
```bash
composer update
composer dump-autoload
```

### Bước 3: Cài đặt dependencies JavaScript

```bash
npm install
```

### Bước 4: Cấu hình môi trường

```bash
# Windows PowerShell
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

Mở file `.env` và chỉnh sửa thông tin database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tvu_bookexchange
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### Bước 5: Generate Application Key

```bash
php artisan key:generate
```

### Bước 6: Tạo Database

#### Option 1: Import file SQL (Khuyến nghị)

1. Mở phpMyAdmin hoặc MySQL Workbench
2. Tạo database mới tên `tvu_bookexchange`
3. Import file `database/tvu_bookexchange.sql`

Hoặc dùng command line:

```bash
# Tạo database
mysql -u root -p -e "CREATE DATABASE tvu_bookexchange CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Import SQL
mysql -u root -p tvu_bookexchange < database/tvu_bookexchange.sql
```

#### Option 2: Chạy Migration và Seeder

```bash
php artisan migrate --seed
```

### Bước 7: Tạo symbolic link cho storage

```bash
php artisan storage:link
```

### Bước 8: Compile assets

#### Development mode (khuyến nghị khi dev)
```bash
npm run dev
```

#### Production mode
```bash
npm run build
```

### Bước 9: Set permissions (Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

Windows: Click chuột phải vào folder `storage` và `bootstrap/cache` → Properties → Security → Full Control

### Bước 10: Chạy ứng dụng

```bash
php artisan serve
```

Truy cập: **http://localhost:8000**

## Tài khoản mặc định

### Admin
- **Email**: admin@st.tvu.edu.vn
- **Password**: admin123
- **Quyền**: Truy cập admin panel

### Sinh viên 1
- **Email**: student1@st.tvu.edu.vn
- **Password**: student123
- **Quyền**: Sinh viên thường

### Sinh viên 2
- **Email**: student2@st.tvu.edu.vn
- **Password**: student123
- **Quyền**: Sinh viên thường

**Lưu ý**: Mật khẩu mặc định trong file SQL là hash của `password`. Hãy đổi sau khi đăng nhập lần đầu.

## Cấu trúc Database

### Bảng chính

1. **users** - Quản lý tài khoản sinh viên và admin
2. **khoas** - Danh sách Khoa
3. **nganhs** - Danh sách Ngành (thuộc Khoa)
4. **mons** - Danh sách Môn học (thuộc Ngành)
5. **documents** - Tài liệu được chia sẻ
6. **blogs** - Bài viết blog
7. **blog_comments** - Bình luận trên blog
8. **orders** - Đơn hàng
9. **carts** - Giỏ hàng

## Chức năng chính

### Trang người dùng

1. **Trang chủ** - Hiển thị tài liệu nổi bật
2. **Danh mục** - Duyệt theo Khoa → Ngành → Môn
3. **Tài liệu** - Xem và tìm kiếm tài liệu
4. **Blog** - Đọc và đăng bài chia sẻ
5. **Giỏ hàng** - Quản lý tài liệu muốn mua
6. **Thông tin cá nhân** - Xem và cập nhật profile
7. **Quản lý tài liệu cá nhân** - Đăng và quản lý tài liệu của mình
8. **Đơn hàng** - Theo dõi đơn hàng

### Trang Admin (/admin)

1. **Dashboard** - Tổng quan hệ thống
2. **Quản lý Users** - CRUD tài khoản sinh viên
3. **Quản lý Documents** - Duyệt và xóa tài liệu vi phạm
4. **Quản lý Blogs** - Kiểm duyệt bài viết
5. **Quản lý Orders** - Cập nhật trạng thái đơn hàng
6. **Quản lý Categories** - CRUD Khoa, Ngành, Môn

## Khắc phục sự cố

### Lỗi "Class not found"

```bash
composer dump-autoload
php artisan cache:clear
php artisan config:clear
```

### Lỗi Permission denied (Linux/Mac)

```bash
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Lỗi "No application encryption key"

```bash
php artisan key:generate
```

### Lỗi "SQLSTATE connection refused"

- Kiểm tra MySQL service đã chạy chưa
- Kiểm tra thông tin DB trong file `.env`
- Đảm bảo database đã được tạo

### Lỗi "Vite manifest not found"

```bash
npm install
npm run build
```

### Lỗi 404 Not Found

```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

## Cấu hình email (Optional)

Để sử dụng chức năng gửi email, cấu hình SMTP trong `.env`:

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

## Cập nhật và Bảo trì

### Clear cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Backup database

```bash
mysqldump -u root -p tvu_bookexchange > backup.sql
```

### Update dependencies

```bash
composer update
npm update
```

## Môi trường Production

### 1. Thay đổi trong .env

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 2. Optimize Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

### 3. Compile assets cho production

```bash
npm run build
```

## Hỗ trợ

Nếu gặp vấn đề:

1. Kiểm tra log tại `storage/logs/laravel.log`
2. Đảm bảo tất cả requirements đã được cài đặt
3. Kiểm tra file `.env` đã cấu hình đúng
4. Clear cache và thử lại

**Email hỗ trợ**: support@tvu.edu.vn

**Website**: https://www.tvu.edu.vn

---

© 2025 TVU Book Exchange - Trường Đại học Trà Vinh
