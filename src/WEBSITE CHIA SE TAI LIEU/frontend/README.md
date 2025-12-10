# Frontend Scaffold

Thư mục `frontend/` chứa mã nguồn giao diện tách riêng khỏi backend Laravel trong `tvu_app/`.

## Mục tiêu
- Phân tách rõ ràng phần hiển thị (JS/SPA) với backend.
- Chuẩn bị cho việc chuyển dần sang component-based hoặc SPA.
- Cho phép alias `@frontend` để import source từ Vite.

## Cấu trúc
```
frontend/
  src/
    components/   # Component JS/TS sau này
    pages/        # Logic trang nếu build SPA
    layouts/      # Layout cấp cao
    styles/       # CSS/SCSS riêng
    main.js       # Entry point
```

## Sử dụng với Vite (trong backend)
Trong file `tvu_app/vite.config.js` đã thêm alias:
```
resolve: { alias: { '@frontend': path.resolve(__dirname, '../frontend/src') } }
```
Bạn có thể import:
```js
import { initFrontend } from '@frontend/main.js';
initFrontend();
```

## Bước tiếp theo đề xuất
1. Di chuyển JS tùy chỉnh dần từ `resources/js` sang `frontend/src`.
2. Thêm tool build riêng (tùy chọn) nếu cần phân tách hoàn toàn.
3. Chuẩn hóa coding style, lint, và test cho frontend.
