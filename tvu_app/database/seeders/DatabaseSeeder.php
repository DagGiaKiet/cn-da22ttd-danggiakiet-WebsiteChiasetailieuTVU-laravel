<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Khoa;
use App\Models\Nganh;
use App\Models\Mon;
use App\Models\Document;
use App\Models\Blog;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users (idempotent)
        $admin = User::firstOrCreate(
            ['email' => 'admin@st.tvu.edu.vn'],
            [
                'name' => 'Admin TVU',
                'password' => Hash::make('admin123'),
                'ma_sv' => 'ADMIN001',
                'ma_lop' => 'ADMIN',
                'khoa' => 'Quản trị hệ thống',
                'nganh' => 'Administrator',
                'role' => 'admin'
            ]
        );

        // Ensure only this account is admin; others become students
        User::where('email', '!=', 'admin@st.tvu.edu.vn')->update(['role' => 'student']);

        $student1 = User::firstOrCreate(
            ['email' => 'student1@st.tvu.edu.vn'],
            [
                'name' => 'Nguyễn Văn A',
                'password' => Hash::make('student123'),
                'ma_sv' => '2151120001',
                'ma_lop' => 'DH21CS01',
                'khoa' => 'Công nghệ Thông tin',
                'nganh' => 'Khoa học Máy tính',
                'role' => 'student'
            ]
        );

        $student2 = User::firstOrCreate(
            ['email' => 'student2@st.tvu.edu.vn'],
            [
                'name' => 'Trần Thị B',
                'password' => Hash::make('student123'),
                'ma_sv' => '2151120002',
                'ma_lop' => 'DH21CS01',
                'khoa' => 'Công nghệ Thông tin',
                'nganh' => 'Khoa học Máy tính',
                'role' => 'student'
            ]
        );

        // Create Khoas
        $khoaCNTT = Khoa::firstOrCreate([
            'ten_khoa' => 'Công nghệ Thông tin',
        ], [
            'mo_ta' => 'Khoa Công nghệ Thông tin'
        ]);

        $khoaKT = Khoa::firstOrCreate([
            'ten_khoa' => 'Kinh tế',
        ], [
            'mo_ta' => 'Khoa Kinh tế'
        ]);

        $khoaSP = Khoa::firstOrCreate([
            'ten_khoa' => 'Sư phạm',
        ], [
            'mo_ta' => 'Khoa Sư phạm'
        ]);

        // Additional Khoa for political theory
        $khoaLLCT = Khoa::firstOrCreate([
            'ten_khoa' => 'Lý luận chính trị',
        ], [
            'mo_ta' => 'Khoa Lý luận chính trị'
        ]);

        // Nganh for political theory
        $nganhLLCT = Nganh::firstOrCreate(
            [
                'ten_nganh' => 'Lý luận Chính trị',
                'khoa_id' => $khoaLLCT->id,
            ],
            [
                'mo_ta' => 'Các môn thuộc khối Lý luận Chính trị'
            ]
        );

        // Mons for political theory
        $monKinhTeChinhTri = Mon::firstOrCreate(
            [
                'ten_mon' => 'Kinh tế chính trị Mác - Lênin',
                'nganh_id' => $nganhLLCT->id,
            ],
            [
                'mo_ta' => 'Học phần Kinh tế chính trị trong khối LLCT'
            ]
        );

        $monLichSuDang = Mon::firstOrCreate(
            [
                'ten_mon' => 'Lịch sử Đảng Cộng sản Việt Nam',
                'nganh_id' => $nganhLLCT->id,
            ],
            [
                'mo_ta' => 'Học phần Lịch sử ĐCSVN trong khối LLCT'
            ]
        );

        // Create Nganhs for CNTT
        $nganhKHMT = Nganh::firstOrCreate(
            [
                'ten_nganh' => 'Khoa học Máy tính',
                'khoa_id' => $khoaCNTT->id,
            ],
            [
                'mo_ta' => 'Ngành Khoa học Máy tính'
            ]
        );

        $nganhHTTT = Nganh::firstOrCreate(
            [
                'ten_nganh' => 'Hệ thống Thông tin',
                'khoa_id' => $khoaCNTT->id,
            ],
            [
                'mo_ta' => 'Ngành Hệ thống Thông tin'
            ]
        );

        // Create Nganhs for Kinh tế
        $nganhQTKD = Nganh::firstOrCreate(
            [
                'ten_nganh' => 'Quản trị Kinh doanh',
                'khoa_id' => $khoaKT->id,
            ],
            [
                'mo_ta' => 'Ngành Quản trị Kinh doanh'
            ]
        );

        $nganhKeToan = Nganh::firstOrCreate(
            [
                'ten_nganh' => 'Kế toán',
                'khoa_id' => $khoaKT->id,
            ],
            [
                'mo_ta' => 'Ngành Kế toán'
            ]
        );

        // Create Mons for Khoa học Máy tính
        $monOOP = Mon::firstOrCreate(
            [
                'ten_mon' => 'Lập trình Hướng đối tượng',
                'nganh_id' => $nganhKHMT->id,
            ],
            [
                'mo_ta' => 'Môn Lập trình Hướng đối tượng với Java/C++'
            ]
        );

        $monDSA = Mon::firstOrCreate(
            [
                'ten_mon' => 'Cấu trúc Dữ liệu và Giải thuật',
                'nganh_id' => $nganhKHMT->id,
            ],
            [
                'mo_ta' => 'Môn Cấu trúc Dữ liệu và Giải thuật'
            ]
        );

        $monDB = Mon::firstOrCreate(
            [
                'ten_mon' => 'Cơ sở Dữ liệu',
                'nganh_id' => $nganhKHMT->id,
            ],
            [
                'mo_ta' => 'Môn Cơ sở Dữ liệu'
            ]
        );

        $monWeb = Mon::firstOrCreate(
            [
                'ten_mon' => 'Lập trình Web',
                'nganh_id' => $nganhKHMT->id,
            ],
            [
                'mo_ta' => 'Môn Lập trình Web với HTML, CSS, JavaScript, PHP'
            ]
        );

        // Create Mons for Hệ thống Thông tin
        $monPTTKHT = Mon::firstOrCreate(
            [
                'ten_mon' => 'Phân tích Thiết kế Hệ thống',
                'nganh_id' => $nganhHTTT->id,
            ],
            [
                'mo_ta' => 'Môn Phân tích và Thiết kế Hệ thống Thông tin'
            ]
        );

        $monQTHT = Mon::firstOrCreate(
            [
                'ten_mon' => 'Quản trị Hệ thống',
                'nganh_id' => $nganhHTTT->id,
            ],
            [
                'mo_ta' => 'Môn Quản trị Hệ thống'
            ]
        );

        // Create Mons for Quản trị Kinh doanh
        $monMKT = Mon::firstOrCreate(
            [
                'ten_mon' => 'Quản trị Marketing',
                'nganh_id' => $nganhQTKD->id,
            ],
            [
                'mo_ta' => 'Môn Quản trị Marketing'
            ]
        );

        $monTC = Mon::firstOrCreate(
            [
                'ten_mon' => 'Quản trị Tài chính',
                'nganh_id' => $nganhQTKD->id,
            ],
            [
                'mo_ta' => 'Môn Quản trị Tài chính Doanh nghiệp'
            ]
        );

        // Create Mons for Kế toán
        $monKTTC = Mon::firstOrCreate(
            [
                'ten_mon' => 'Kế toán Tài chính',
                'nganh_id' => $nganhKeToan->id,
            ],
            [
                'mo_ta' => 'Môn Kế toán Tài chính'
            ]
        );

        $monKTQT = Mon::firstOrCreate(
            [
                'ten_mon' => 'Kế toán Quản trị',
                'nganh_id' => $nganhKeToan->id,
            ],
            [
                'mo_ta' => 'Môn Kế toán Quản trị'
            ]
        );

        // Create Documents (existing)
        Document::firstOrCreate(
            ['ten_tai_lieu' => 'Giáo trình Lập trình Hướng đối tượng Java'],
            [
                'mo_ta' => 'Giáo trình đầy đủ về OOP với Java, còn mới 90%',
                'hinh_anh' => 'java-oop.jpg',
                'gia' => 50000,
                'loai' => 'ban',
                'khoa_id' => $khoaCNTT->id,
                'nganh_id' => $nganhKHMT->id,
                'mon_id' => $monOOP->id,
                'user_id' => $student1->id,
                'trang_thai' => 'available'
            ]
        );

        Document::firstOrCreate(
            ['ten_tai_lieu' => 'Slide bài giảng Cấu trúc Dữ liệu'],
            [
                'mo_ta' => 'Tài liệu slide đầy đủ từ giảng viên, chia sẻ miễn phí',
                'hinh_anh' => 'data-structure.jpg',
                'gia' => 0,
                'loai' => 'cho',
                'khoa_id' => $khoaCNTT->id,
                'nganh_id' => $nganhKHMT->id,
                'mon_id' => $monDSA->id,
                'user_id' => $student1->id,
                'trang_thai' => 'available'
            ]
        );

        Document::firstOrCreate(
            ['ten_tai_lieu' => 'Giáo trình Cơ sở Dữ liệu'],
            [
                'mo_ta' => 'Giáo trình về Database, SQL, còn đẹp',
                'hinh_anh' => 'database.jpg',
                'gia' => 40000,
                'loai' => 'ban',
                'khoa_id' => $khoaCNTT->id,
                'nganh_id' => $nganhKHMT->id,
                'mon_id' => $monDB->id,
                'user_id' => $student2->id,
                'trang_thai' => 'available'
            ]
        );

        // Create Documents matching landing featured items
        Document::updateOrCreate(
            ['ten_tai_lieu' => 'Kinh Tế Chính Trị MÁC - LÊNIN'],
            [
                'mo_ta' => 'Ghi chú đầy đủ các mục quan trọng.',
                'hinh_anh' => 'img/lichsudang.jpg', // dùng ảnh sách Lịch sử Đảng ở public/img
                'gia' => 0,
                'loai' => 'cho',
                'khoa_id' => $khoaLLCT->id,
                'nganh_id' => $nganhLLCT->id,
                'mon_id' => $monKinhTeChinhTri->id,
                'user_id' => $student1->id,
                'trang_thai' => 'available'
            ]
        );

        Document::updateOrCreate(
            ['ten_tai_lieu' => 'GIÁO TRÌNH LỊCH SỬ ĐẢNG CỘNG SẢN VIỆT NAM'],
            [
                'mo_ta' => 'Sách giáo khoa có đánh note đầy đủ với các khái niệm quan trọng',
                'hinh_anh' => null,
                'gia' => 50000,
                'loai' => 'ban',
                'khoa_id' => $khoaLLCT->id,
                'nganh_id' => $nganhLLCT->id,
                'mon_id' => $monLichSuDang->id,
                'user_id' => $student2->id,
                'trang_thai' => 'available'
            ]
        );

        // Add a Mon for Tin học cơ bản under KHMT
        $monTinHocCoBan = Mon::firstOrCreate(
            [
                'ten_mon' => 'Tin học cơ bản',
                'nganh_id' => $nganhKHMT->id,
            ],
            [
                'mo_ta' => 'Tin học ứng dụng cơ bản'
            ]
        );

        Document::updateOrCreate(
            ['ten_tai_lieu' => 'Tài liệu giảng dạy môn tin học ứng dụng tin học cơ bản'],
            [
                'mo_ta' => 'Có chú thích những phần quan trọng',
                'hinh_anh' => 'img/tinhoccoban.jpg',
                'gia' => 30000,
                'loai' => 'ban',
                'khoa_id' => $khoaCNTT->id,
                'nganh_id' => $nganhKHMT->id,
                'mon_id' => $monTinHocCoBan->id,
                'user_id' => $student1->id,
                'trang_thai' => 'available'
            ]
        );

        // Create Blogs
        Blog::firstOrCreate(
            ['tieu_de' => 'Chia sẻ tài liệu Lập trình Web'],
            [
                'noi_dung' => 'Mình có bộ tài liệu Lập trình Web đầy đủ, bao gồm HTML, CSS, JavaScript, PHP. Ai cần liên hệ mình nhé! Gặp tại TVU.',
                'hinh_anh' => 'web-programming.jpg',
                'user_id' => $student1->id
            ]
        );

        Blog::firstOrCreate(
            ['tieu_de' => 'Cho tặng slide môn Marketing'],
            [
                'noi_dung' => 'Mình có slide môn Quản trị Marketing đầy đủ, in màu, chia sẻ miễn phí cho các bạn. Inbox mình để hẹn gặp.',
                'hinh_anh' => 'marketing.jpg',
                'user_id' => $student2->id
            ]
        );
    }
}
