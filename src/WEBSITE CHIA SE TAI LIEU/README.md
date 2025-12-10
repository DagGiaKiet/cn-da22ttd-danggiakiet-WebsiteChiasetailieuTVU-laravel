# Website Chia Sẻ Tài Liệu - Trường Đại học Trà Vinh

## 📚 Tổng quan dự án

### Giới thiệu
Website cho phép sinh viên Trường Đại học Trà Vinh đăng tải, chia sẻ và trao đổi giáo trình hoặc tài liệu học tập bản giấy (đã sử dụng). Tài liệu được phân loại theo Khoa, Ngành, Môn học. Hệ thống hỗ trợ hai hình thức chia sẻ: miễn phí hoặc bán lại với giá rẻ.

### Công nghệ sử dụng
- **Backend Framework**: Laravel 10.x (PHP 8.1+)
- **Database**: MySQL 5.7+
- **Frontend**: Blade Template Engine
- **CSS Framework**: Bootstrap 5.3
- **Authentication**: Laravel UI
- **Icons**: Font Awesome 6

### Yêu cầu hệ thống
- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM (để compile assets)
- Web server (Apache/Nginx)

### Tính năng chính

#### Trang người dùng (Frontend)
- **Trang chủ**: Hiển thị tài liệu nổi bật, bài blog mới nhất
- **Danh mục**: Phân loại theo Khoa → Ngành → Môn học
- **Blog**: Đăng bài chia sẻ, trao đổi trực tiếp tại TVU
- **Giỏ hàng**: Quản lý tài liệu muốn mua
- **Đăng ký/Đăng nhập**: Chỉ chấp nhận email @st.tvu.edu.vn
- **Thông tin cá nhân**: Cập nhật thông tin, xem lịch sử giao dịch
- **Quản lý tài liệu**: Đăng tải và quản lý tài liệu của bản thân

#### Trang quản trị (Admin Panel)
- Quản lý tài khoản sinh viên
- Quản lý đơn hàng (cập nhật trạng thái)
- Quản lý danh mục (Khoa, Ngành, Môn học)
- Quản lý bài đăng Blog
- Quản lý tài liệu

### Cấu trúc Database

#### Bảng `users`
- id, name, email, password, ma_sv, ma_lop, khoa, nganh, anh_the, role, created_at

#### Bảng `documents`
- id, ten_tai_lieu, mo_ta, hinh_anh, gia, loai, khoa_id, nganh_id, mon_id, user_id, created_at

#### Bảng `orders`
- id, user_id, document_id, trang_thai, created_at

#### Bảng `blogs`
- id, tieu_de, noi_dung, hinh_anh, user_id, created_at

#### Bảng `categories`
- Bảng `khoas`: id, ten_khoa
- Bảng `nganhs`: id, ten_nganh, khoa_id
- Bảng `mons`: id, ten_mon, nganh_id

### Cấu trúc thư mục

```
WEBSITE CHIA SE TAI LIEU/
├── tvu_app/                    # Backend Laravel (app chính)
│   ├── app/
│   ├── resources/              # Blade + assets hiện tại
│   ├── public/                 # Document root Laravel
│   ├── vite.config.js          # Đã thêm alias @frontend
│   └── ...
├── frontend/                   # Frontend tách riêng (scaffold)
│   └── src/
│       ├── components/
│       ├── pages/
│       ├── layouts/
│       ├── styles/
│       └── main.js
├── docs/                       # Tài liệu kiến trúc, quy chuẩn
│   └── ARCHITECTURE.md
├── database/                   # SQL, migrations, seeders (nếu dùng ngoài tvu_app)
├── vendor/                     # Dependencies (root hoặc do cài đặt trước)
├── README.md
└── ...
```

### Phân tầng kiến trúc (Frontend / Backend)

Phương án A triển khai nhằm tách mã nguồn giao diện ra thư mục `frontend/` mà **không ảnh hưởng** đến hoạt động hiện tại của Laravel trong `tvu_app/`.

| Thành phần | Vai trò | Thư mục |
|------------|---------|---------|
| Backend | Logic nghiệp vụ, route, Blade, API | `tvu_app/` |
| Frontend | Mã nguồn JS/Components mở rộng, chuẩn bị cho SPA | `frontend/` |
| Tài liệu | Ghi chú kiến trúc, mở rộng | `docs/` |

Alias Vite (`@frontend`) giúp import trực tiếp mã nguồn frontend từ bên trong build Laravel:

```js
// tvu_app/resources/js/app.js (ví dụ)
import { initFrontend } from '@frontend/main.js';
initFrontend();
```

Lộ trình mở rộng đề xuất:
1. Di chuyển dần các script tùy chỉnh (dark mode, dropdown, charts) vào `frontend/src`.
2. Chuẩn hóa component (tách phần giao diện lặp lại).
3. Thêm test (Vitest/Jest) cho logic phức tạp.
4. Tùy chọn tách build riêng nếu chuyển sang SPA hoàn chỉnh.

Xem thêm chi tiết trong `docs/ARCHITECTURE.md`.

### Hướng dẫn cài đặt

#### 1. Clone project

```bash
git clone <repository-url>
cd WEBSITE\ CHIA\ SE\ TAI\ LIEU
```

#### 2. Cài đặt dependencies

```bash
composer install
npm install
```

#### 3. Cấu hình môi trường

```bash
cp .env.example .env
```

Mở file `.env` và cấu hình database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tvu_bookexchange
DB_USERNAME=root
DB_PASSWORD=
```

#### 4. Generate Application Key

```bash
php artisan key:generate
```

#### 5. Tạo Database

Tạo database trong MySQL:

```sql
CREATE DATABASE tvu_bookexchange CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Hoặc import file SQL có sẵn:

```bash
mysql -u root -p tvu_bookexchange < database/tvu_bookexchange.sql
```

#### 6. Chạy Migration và Seeder

```bash
php artisan migrate --seed
```

Lệnh này sẽ tạo các bảng và dữ liệu mẫu.

#### 7. Tạo symbolic link cho storage

```bash
php artisan storage:link
```

#### 8. Compile assets

```bash
npm run dev
```

Hoặc để production:

```bash
npm run build
```

#### 9. Chạy ứng dụng

```bash
php artisan serve
```

Truy cập: `http://localhost:8000`

### Tài khoản mặc định

#### Admin
- Email: admin@st.tvu.edu.vn
- Password: admin123

#### Sinh viên 1
- Email: student1@st.tvu.edu.vn
- Password: student123

#### Sinh viên 2
- Email: student2@st.tvu.edu.vn
- Password: student123

### Lưu ý quan trọng

1. **Email xác thực**: Hệ thống chỉ chấp nhận email có đuôi `@st.tvu.edu.vn`
2. **Upload ảnh**: Cần upload ảnh thẻ sinh viên khi đăng ký
3. **Quyền truy cập**: Admin panel chỉ dành cho tài khoản có role = 'admin'
4. **Storage**: Đảm bảo thư mục `storage/app/public` có quyền ghi

### Khắc phục sự cố

#### Lỗi permission

```bash
chmod -R 775 storage bootstrap/cache
```

#### Lỗi composer

```bash
composer update
composer dump-autoload
```

#### Lỗi cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Hỗ trợ

Nếu gặp vấn đề khi cài đặt hoặc sử dụng, vui lòng liên hệ:
- Email: support@tvu.edu.vn
- Website: https://www.tvu.edu.vn

### License

MIT License - Trường Đại học Trà Vinh
