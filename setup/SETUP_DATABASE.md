# Hướng Dẫn Cài Đặt Database

## Import Database từ File SQL

### Phương án 1: Sử dụng MySQL Command Line

```bash
# Bước 1: Tạo database
mysql -u root -p -e "CREATE DATABASE tvu_bookexchange CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Bước 2: Import file SQL
mysql -u root -p tvu_bookexchange < database_setup.sql
```

### Phương án 2: Sử dụng phpMyAdmin

1. Mở phpMyAdmin trong trình duyệt
2. Click vào "New" để tạo database mới
3. Nhập tên: `tvu_bookexchange`
4. Chọn Collation: `utf8mb4_unicode_ci`
5. Click "Create"
6. Chọn database vừa tạo
7. Click tab "Import"
8. Click "Choose File" và chọn file `database_setup.sql`
9. Click "Go" để import

### Phương án 3: Sử dụng Laravel Migration (Nếu chưa có dữ liệu)

```bash
# Di chuyển vào thư mục ứng dụng
cd ../src/WEBSITE\ CHIA\ SE\ TAI\ LIEU/tvu_app

# Chạy migration để tạo bảng
php artisan migrate

# Chạy seeder để tạo dữ liệu mẫu
php artisan db:seed
```

## Cấu Trúc Database

### Danh sách các bảng:

1. **users** - Quản lý tài khoản sinh viên
2. **categories** - Danh mục (Khoa, Ngành, Môn)
3. **documents** - Tài liệu
4. **blogs** - Bài đăng blog
5. **orders** - Đơn hàng
6. **carts** - Giỏ hàng
7. **tin_nhan** - Tin nhắn giữa sinh viên

### Mối quan hệ:

- `documents` → `users` (N-1)
- `documents` → `categories` (N-1)
- `orders` → `users` (N-1)
- `orders` → `documents` (N-1)
- `carts` → `users` (N-1)
- `carts` → `documents` (N-1)
- `tin_nhan` → `users` (N-1, nguoi_gui)
- `tin_nhan` → `users` (N-1, nguoi_nhan)

## Dữ Liệu Mẫu

File SQL đã bao gồm:
- 2 tài khoản mẫu (admin và user)
- Các danh mục mẫu (Khoa CNTT, Ngành Công nghệ thông tin)
- Một số tài liệu mẫu
- Dữ liệu tin nhắn mẫu

## Troubleshooting

### Lỗi: Access denied for user
```bash
# Kiểm tra tài khoản MySQL
mysql -u root -p

# Tạo user mới nếu cần
CREATE USER 'tvu_user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON tvu_bookexchange.* TO 'tvu_user'@'localhost';
FLUSH PRIVILEGES;
```

### Lỗi: Unknown database
```bash
# Kiểm tra database đã tồn tại
SHOW DATABASES;

# Tạo lại nếu chưa có
CREATE DATABASE tvu_bookexchange CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Lỗi: Syntax error hoặc Table already exists
```bash
# Drop database và import lại
DROP DATABASE IF EXISTS tvu_bookexchange;
CREATE DATABASE tvu_bookexchange CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
mysql -u root -p tvu_bookexchange < database_setup.sql
```
