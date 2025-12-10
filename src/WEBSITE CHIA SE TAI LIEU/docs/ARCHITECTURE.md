# Kiến Trúc Dự Án

## Mục tiêu phân tầng
- Giữ nguyên backend Laravel (`tvu_app/`) ổn định.
- Thêm tầng frontend riêng (`frontend/`) để tách logic giao diện và chuẩn bị mở rộng thành SPA hoặc micro-frontend.

## Thành phần chính
| Tầng | Mô tả | Thư mục |
|------|------|---------|
| Backend | Laravel 10: API, logic nghiệp vụ, Blade hiện tại | `tvu_app/` |
| Frontend (scaffold) | Mã nguồn JS/Components độc lập, sẽ dần thay thế hoặc bổ trợ Blade | `frontend/` |
| Tài liệu | Ghi chú kiến trúc, quy chuẩn | `docs/` |

## Sơ đồ thư mục rút gọn
```
WEBSITE CHIA SE TAI LIEU/
  tvu_app/            # Ứng dụng Laravel đầy đủ
    app/
    resources/        # Blade + assets hiện tại
    public/
    vite.config.js    # Đã thêm alias @frontend
  frontend/
    src/
      components/
      pages/
      layouts/
      styles/
      main.js
    README.md
  docs/
    ARCHITECTURE.md
```

## Tích hợp Vite
Thêm alias trong `tvu_app/vite.config.js`:
```js
resolve: {
  alias: {
    '@frontend': path.resolve(__dirname, '../frontend/src')
  }
}
```
Sử dụng:
```js
import { initFrontend } from '@frontend/main.js';
initFrontend();
```

## Lộ trình mở rộng
1. Di chuyển script tùy chỉnh từ Blade vào modules trong `frontend/src`.
2. Tách phần tương tác nâng cao (dark mode, dropdown, charts) thành components.
3. Thêm test (Jest/Vitest) cho frontend logic.
4. Có thể tạo build riêng (nếu chuyển sang SPA) xuất bundle -> `tvu_app/public/assets`.

## Nguyên tắc an toàn
- Không đổi tên `tvu_app/` trong phương án A.
- Mọi route/server-side logic vẫn ở Laravel.
- Thay đổi frontend tiến hoá dần: mỗi lần di chuyển code đảm bảo tương đương chức năng.
