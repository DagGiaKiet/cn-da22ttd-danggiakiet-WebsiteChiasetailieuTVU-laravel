# Website Chia Sẻ Tài Liệu - Trường Đại học Trà Vinh

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📚 Giới Thiệu Đồ Án

Website cho phép sinh viên Trường Đại học Trà Vinh đăng tải, chia sẻ và trao đổi giáo trình hoặc tặng tài liệu học tập bản giấy (đã sử dụng). Tài liệu được phân loại theo Khoa, Ngành, Môn học. Hệ thống hỗ trợ hai hình thức chia sẻ: miễn phí hoặc bán lại với giá rẻ.

## 👨‍🎓 Thông Tin Sinh Viên

| Thông tin | Chi tiết |
|-----------|----------|
| **Họ và tên** | Đặng Gia Kiệt |
| **MSSV** | 110122098 |
| **Lớp** | DA22TTD |
| **Khoa** | Công nghệ Thông tin |
| **Email** | 110122098@st.tvu.edu.vn |
| **Điện thoại** | [Số điện thoại của bạn] |

## 👨‍🏫 Giảng Viên Hướng Dẫn

| Thông tin | Chi tiết |
|-----------|----------|
| **Họ và tên** | [Tên giảng viên] |
| **Bộ môn** | [Bộ môn] |
| **Email** | [Email giảng viên] |

## 🚀 Tính Năng Chính

### Trang Người Dùng (Frontend)
- ✅ Trang chủ hiển thị tài liệu nổi bật, bài blog mới nhất
- ✅ Danh mục phân loại theo Khoa → Ngành → Môn học
- ✅ Chức năng tìm kiếm, lọc tài liệu
- ✅ Blog chia sẻ kinh nghiệm, trao đổi trực tiếp
- ✅ Giỏ hàng quản lý tài liệu muốn mua
- ✅ Đăng ký/Đăng nhập (chỉ email @st.tvu.edu.vn)
- ✅ Quản lý thông tin cá nhân, lịch sử giao dịch
- ✅ Đăng tải và quản lý tài liệu
- ✅ Hệ thống tin nhắn giữa sinh viên

### Trang Quản Trị (Admin Panel)
- ✅ Quản lý tài khoản sinh viên
- ✅ Quản lý đơn hàng, cập nhật trạng thái
- ✅ Quản lý danh mục (Khoa, Ngành, Môn học)
- ✅ Quản lý bài đăng Blog
- ✅ Quản lý tài liệu
- ✅ Thống kê, báo cáo

## 💻 Công Nghệ Sử Dụng

### Backend
- **Framework**: Laravel 10.x
- **PHP**: >= 8.1
- **Database**: MySQL 5.7+
- **Authentication**: Laravel UI

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Bootstrap 5.3
- **JavaScript**: Vanilla JS + jQuery
- **Icons**: Font Awesome 6

## 📁 Cấu Trúc Thư Mục

```
cn-da22ttd-danggiakiet-WebsiteChiasetailieuTVU-laravel/
│
├── setup/                          # Tập tin cài đặt, dữ liệu mẫu
│   ├── README.md                   # Hướng dẫn thư mục setup
│   ├── INSTALLATION_GUIDE.md       # Hướng dẫn cài đặt đầy đủ
│   ├── SETUP_DATABASE.md           # Hướng dẫn cài đặt database
│   ├── SETUP_ENVIRONMENT.md        # Hướng dẫn cấu hình môi trường
│   ├── database_setup.sql          # File SQL database
│   └── .env.example                # Template cấu hình môi trường
│
├── src/                            # Mã nguồn chương trình
│   └── WEBSITE CHIA SE TAI LIEU/   # Source code Laravel
│       ├── tvu_app/                # Ứng dụng Laravel chính
│       ├── database/               # Database, migrations, seeders
│       ├── frontend/               # Frontend assets
│       └── docs/                   # Tài liệu kỹ thuật
│
├── progress-report/                # Báo cáo tiến độ [BẮT BUỘC]
│   └── README.md                   # Hướng dẫn báo cáo tiến độ
│
├── thesis/                         # Tài liệu văn bản đồ án [BẮT BUỘC]
│   ├── doc/                        # Tài liệu dạng .DOC, .DOCX
│   ├── pdf/                        # Tài liệu dạng .PDF
│   ├── html/                       # Tài liệu dạng web
│   ├── abs/                        # Báo cáo (.PPT, .AVI, Poster)
│   └── refs/                       # Tài liệu tham khảo
│
├── soft/                           # Phần mềm liên quan (nếu có)
│   └── README.md
│
├── docker/                         # Cấu hình Docker (nếu có)
│   └── README.md
│
├── .gitignore                      # Git ignore file
└── README.md                       # File này
```

## ⚙️ Hướng Dẫn Cài Đặt

### Yêu Cầu Hệ Thống
- PHP >= 8.1
- Composer
- MySQL >= 5.7 hoặc MariaDB >= 10.3
- Node.js >= 16.x
- NPM >= 8.x
- Web Server (Apache/Nginx)

### Cài Đặt Nhanh

```bash
# 1. Clone repository
git clone https://github.com/DagGiaKiet/cn-da22ttd-danggiakiet-WebsiteChiasetailieuTVU-laravel.git
cd cn-da22ttd-danggiakiet-WebsiteChiasetailieuTVU-laravel

# 2. Di chuyển vào thư mục ứng dụng
cd src/WEBSITE\ CHIA\ SE\ TAI\ LIEU/tvu_app

# 3. Cài đặt dependencies
composer install
npm install

# 4. Cấu hình môi trường
cp ../../../setup/.env.example .env
php artisan key:generate

# 5. Tạo database và import dữ liệu
mysql -u root -p -e "CREATE DATABASE tvu_bookexchange CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p tvu_bookexchange < ../../../setup/database_setup.sql

# 6. Cập nhật thông tin database trong file .env
# DB_DATABASE=tvu_bookexchange
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 7. Tạo symbolic link storage
php artisan storage:link

# 8. Compile assets
npm run build

# 9. Chạy ứng dụng
php artisan serve
```

Truy cập: http://localhost:8000

### Hướng Dẫn Chi Tiết

Xem file [setup/INSTALLATION_GUIDE.md](setup/INSTALLATION_GUIDE.md) để biết hướng dẫn cài đặt chi tiết.

## 🔑 Tài Khoản Mẫu

### Admin
- **Email**: admin@tvu.edu.vn
- **Password**: admin123

### User
- **Email**: user@st.tvu.edu.vn
- **Password**: user123

## 📖 Tài Liệu

- **Hướng dẫn cài đặt**: [setup/INSTALLATION_GUIDE.md](setup/INSTALLATION_GUIDE.md)
- **Cấu hình database**: [setup/SETUP_DATABASE.md](setup/SETUP_DATABASE.md)
- **Cấu hình môi trường**: [setup/SETUP_ENVIRONMENT.md](setup/SETUP_ENVIRONMENT.md)
- **Kiến trúc hệ thống**: [src/WEBSITE CHIA SE TAI LIEU/docs/ARCHITECTURE.md](src/WEBSITE%20CHIA%20SE%20TAI%20LIEU/docs/ARCHITECTURE.md)

## 🗂️ Cấu Trúc Database

### Các Bảng Chính

1. **users** - Quản lý tài khoản sinh viên
2. **categories** - Danh mục (Khoa, Ngành, Môn)
3. **documents** - Tài liệu học tập
4. **blogs** - Bài đăng blog
5. **orders** - Đơn hàng
6. **carts** - Giỏ hàng
7. **tin_nhan** - Tin nhắn giữa sinh viên

Xem chi tiết trong file [setup/database_setup.sql](setup/database_setup.sql)

## 📸 Screenshots

*(Thêm screenshots của ứng dụng vào đây)*

## 🔧 Troubleshooting

### Lỗi: 500 Internal Server Error
```bash
# Kiểm tra quyền thư mục
chmod -R 775 storage bootstrap/cache  # Linux/Mac

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Lỗi: Database connection refused
- Kiểm tra MySQL service đang chạy
- Kiểm tra thông tin trong file `.env`
- Kiểm tra database đã được tạo chưa

### Lỗi: Class not found
```bash
composer dump-autoload
php artisan clear-compiled
```

## 📝 License

Dự án này được phát triển cho mục đích học tập tại Trường Đại học Trà Vinh.

## 🤝 Đóng Góp

Mọi đóng góp, ý kiến đều được hoan nghênh. Vui lòng tạo issue hoặc pull request.

## 📞 Liên Hệ

**Sinh viên thực hiện:**
- **Họ tên**: Đặng Gia Kiệt
- **MSSV**: 110122098
- **Email**: 110122098@st.tvu.edu.vn
- **GitHub**: [DagGiaKiet](https://github.com/DagGiaKiet)
---

**Trường Đại học Trà Vinh**  
**Khoa Công nghệ Thông tin**  
**Năm học 2024-2025**
