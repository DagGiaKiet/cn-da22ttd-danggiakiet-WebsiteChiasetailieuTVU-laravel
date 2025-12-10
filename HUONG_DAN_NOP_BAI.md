# Hướng Dẫn Nộp Tài Liệu Đồ Án

## Các Thư Mục Cần Cập Nhật

### 1. Báo Cáo Tiến Độ (progress-report/)
**Bắt buộc** - Cập nhật định kỳ hàng tuần

Thêm file báo cáo tiến độ vào thư mục này:
```bash
cd "d:\BOOK V2 LIQUID GLASS\progress-report"
# Copy file báo cáo vào đây
# Đặt tên: BaoCaoTienDo_Tuan[XX]_[Ngay-Thang].pdf
```

**Sau khi thêm file, commit lên GitHub:**
```bash
cd "d:\BOOK V2 LIQUID GLASS"
git add progress-report/
git commit -m "Thêm báo cáo tiến độ tuần [XX]"
git push origin main
```

### 2. Tài Liệu Văn Bản (thesis/)
**Bắt buộc** - Cập nhật khi hoàn thành

#### a. Quyển báo cáo dạng DOC/DOCX (thesis/doc/)
```bash
cd "d:\BOOK V2 LIQUID GLASS\thesis\doc"
# Copy file .doc hoặc .docx vào đây
```

#### b. Quyển báo cáo dạng PDF (thesis/pdf/)
```bash
cd "d:\BOOK V2 LIQUID GLASS\thesis\pdf"
# Copy file .pdf vào đây
```

#### c. Tài liệu HTML (thesis/html/)
```bash
cd "d:\BOOK V2 LIQUID GLASS\thesis\html"
# Copy các file HTML, CSS, JS vào đây
```

#### d. Slide, Video, Poster (thesis/abs/)
```bash
cd "d:\BOOK V2 LIQUID GLASS\thesis\abs"
# Copy file PowerPoint, video demo, poster vào đây
# Ví dụ: Slide_BaoCao.pptx, Demo_Video.mp4, Poster.pdf
```

#### e. Tài liệu tham khảo (thesis/refs/)
```bash
cd "d:\BOOK V2 LIQUID GLASS\thesis\refs"
# Copy các tài liệu đã tham khảo vào đây
```

**Sau khi thêm tài liệu, commit lên GitHub:**
```bash
cd "d:\BOOK V2 LIQUID GLASS"
git add thesis/
git commit -m "Cập nhật tài liệu đồ án: [mô tả]"
git push origin main
```

### 3. Phần mềm liên quan (soft/)
Nếu có phần mềm, công cụ đặc biệt:
```bash
cd "d:\BOOK V2 LIQUID GLASS\soft"
# Copy các phần mềm vào đây
```

### 4. Docker (docker/)
Nếu có cấu hình Docker:
```bash
cd "d:\BOOK V2 LIQUID GLASS\docker"
# Tạo Dockerfile, docker-compose.yml
```

## Quy Trình Nộp Bài Hoàn Chỉnh

### Bước 1: Chuẩn bị tài liệu
- [ ] Báo cáo đồ án hoàn chỉnh (.doc, .pdf)
- [ ] Slide PowerPoint
- [ ] Video demo (nếu có)
- [ ] Poster (nếu có)
- [ ] Tài liệu tham khảo

### Bước 2: Copy vào đúng thư mục
```bash
# Ví dụ:
copy "D:\Documents\BaoCaoDoAn_Final.docx" "d:\BOOK V2 LIQUID GLASS\thesis\doc\"
copy "D:\Documents\BaoCaoDoAn_Final.pdf" "d:\BOOK V2 LIQUID GLASS\thesis\pdf\"
copy "D:\Documents\Slide_BaoCao.pptx" "d:\BOOK V2 LIQUID GLASS\thesis\abs\"
copy "D:\Documents\Video_Demo.mp4" "d:\BOOK V2 LIQUID GLASS\thesis\abs\"
```

### Bước 3: Commit và push lên GitHub
```bash
cd "d:\BOOK V2 LIQUID GLASS"

# Xem các file đã thay đổi
git status

# Thêm tất cả file mới
git add .

# Commit với message rõ ràng
git commit -m "Nộp tài liệu đồ án hoàn chỉnh
- Thêm quyển báo cáo DOC và PDF
- Thêm slide PowerPoint
- Thêm video demo
- Thêm poster"

# Push lên GitHub
git push origin main
```

### Bước 4: Kiểm tra trên GitHub
1. Mở trình duyệt
2. Truy cập: https://github.com/DagGiaKiet/cn-da22ttd-danggiakiet-WebsiteChiasetailieuTVU-laravel
3. Kiểm tra các file đã được upload đầy đủ

## Lưu Ý Quan Trọng

### ⚠️ File cần loại trừ
File `.gitignore` đã được cấu hình để **TẠM THỜI IGNORE** các file:
- thesis/doc/*.doc, *.docx
- thesis/pdf/*.pdf
- thesis/abs/*.ppt, *.pptx, *.avi, *.mp4

**Khi nộp bài cuối cùng**, bạn cần:
1. Mở file `.gitignore`
2. Xóa hoặc comment (#) các dòng ignore này
3. Commit lại để các file được track

### 📝 Checklist trước khi nộp

- [ ] Tất cả báo cáo tiến độ đã được upload
- [ ] Quyển báo cáo DOC và PDF đầy đủ
- [ ] Slide PowerPoint đã hoàn thiện
- [ ] Video demo (nếu có) đã được thêm
- [ ] Poster (nếu có) đã được thêm
- [ ] Tài liệu tham khảo đã được liệt kê
- [ ] README.md đã cập nhật thông tin liên lạc đầy đủ
- [ ] Đã kiểm tra trên GitHub

### 🔄 Cập nhật thông tin cá nhân

Nhớ cập nhật thông tin trong `README.md`:
```markdown
| **Điện thoại** | [SỐ ĐIỆN THOẠI CỦA BẠN] |

**Giảng viên hướng dẫn:**
- **Họ tên**: [TÊN GIẢNG VIÊN]
- **Email**: [EMAIL GIẢNG VIÊN]
```

## Hỗ Trợ

Nếu gặp vấn đề khi commit/push:
1. Kiểm tra kết nối internet
2. Xác nhận đã đăng nhập GitHub
3. Kiểm tra file có quá lớn không (> 100MB cần dùng Git LFS)

**Liên hệ hỗ trợ kỹ thuật Git:**
- Tìm kiếm: "git push error [tên lỗi]"
- Hoặc nhờ giảng viên/bạn bè hỗ trợ
