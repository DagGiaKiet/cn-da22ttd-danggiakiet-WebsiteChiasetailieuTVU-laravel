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
        // Create Admin User
        User::create([
            'name' => 'Admin TVU',
            'email' => 'admin@st.tvu.edu.vn',
            'password' => Hash::make('admin123'),
            'ma_sv' => 'ADMIN001',
            'ma_lop' => 'ADMIN',
            'khoa' => 'Quản trị hệ thống',
            'nganh' => 'Administrator',
            'role' => 'admin'
        ]);

        // Create Student Users
        User::create([
            'name' => 'Nguyễn Văn A',
            'email' => 'student1@st.tvu.edu.vn',
            'password' => Hash::make('student123'),
            'ma_sv' => '2151120001',
            'ma_lop' => 'DH21CS01',
            'khoa' => 'Kỹ thuật và Công nghệ ( CET )',
            'nganh' => 'Công nghệ thông tin (ABET)',
            'role' => 'student'
        ]);

        User::create([
            'name' => 'Trần Thị B',
            'email' => 'student2@st.tvu.edu.vn',
            'password' => Hash::make('student123'),
            'ma_sv' => '2151120002',
            'ma_lop' => 'DH21CS01',
            'khoa' => 'Kỹ thuật và Công nghệ ( CET )',
            'nganh' => 'Công nghệ thông tin (ABET)',
            'role' => 'student'
        ]);

        // Create Khoas
        $khoaCET = Khoa::create([
            'ten_khoa' => 'Kỹ thuật và Công nghệ ( CET )',
            'mo_ta' => 'Khoa Kỹ thuật và Công nghệ'
        ]);

        $khoaKT = Khoa::create([
            'ten_khoa' => 'Kinh tế',
            'mo_ta' => 'Khoa Kinh tế'
        ]);

        $khoaSP = Khoa::create([
            'ten_khoa' => 'Sư phạm',
            'mo_ta' => 'Khoa Sư phạm'
        ]);

        $khoaLLCT = Khoa::create([
            'ten_khoa' => 'Lý luận chính trị',
            'mo_ta' => 'Khoa Lý luận chính trị'
        ]);

        // Create Nganhs for CET
        $nganhCNTT_ABET = Nganh::create([
            'ten_nganh' => 'Công nghệ thông tin (ABET)',
            'khoa_id' => $khoaCET->id,
            'mo_ta' => 'Ngành Công nghệ thông tin theo chuẩn ABET'
        ]);

        $nganhDDT = Nganh::create([
            'ten_nganh' => 'Điện - Điện tử & Tự động hóa',
            'khoa_id' => $khoaCET->id,
            'mo_ta' => 'Ngành Điện - Điện tử & Tự động hóa'
        ]);

        $nganhCK = Nganh::create([
            'ten_nganh' => 'Cơ khí',
            'khoa_id' => $khoaCET->id,
            'mo_ta' => 'Ngành Cơ khí'
        ]);

        $nganhXD = Nganh::create([
            'ten_nganh' => 'Xây dựng',
            'khoa_id' => $khoaCET->id,
            'mo_ta' => 'Ngành Xây dựng'
        ]);

        // Create Nganhs for Kinh tế
        $nganhQTKD = Nganh::create([
            'ten_nganh' => 'Quản trị Kinh doanh',
            'khoa_id' => $khoaKT->id,
            'mo_ta' => 'Ngành Quản trị Kinh doanh'
        ]);

        $nganhKeToan = Nganh::create([
            'ten_nganh' => 'Kế toán',
            'khoa_id' => $khoaKT->id,
            'mo_ta' => 'Ngành Kế toán'
        ]);

        // Create Nganh for LLCT
        $nganhCTH = Nganh::create([
            'ten_nganh' => 'Chính trị học',
            'khoa_id' => $khoaLLCT->id,
            'mo_ta' => 'Ngành Chính trị học'
        ]);

        // Create Nganh for Su Pham
        $nganhGDMN = Nganh::create([
             'ten_nganh' => 'Giáo dục Mầm non',
             'khoa_id' => $khoaSP->id,
             'mo_ta' => 'Ngành Giáo dục Mầm non'
        ]);
        
        $nganhGDTH = Nganh::create([
             'ten_nganh' => 'Giáo dục Tiểu học',
             'khoa_id' => $khoaSP->id,
             'mo_ta' => 'Ngành Giáo dục Tiểu học'
        ]);

        $nganhSPNV = Nganh::create([
             'ten_nganh' => 'Sư phạm Ngữ văn',
             'khoa_id' => $khoaSP->id,
             'mo_ta' => 'Ngành Sư phạm Ngữ văn'
        ]);

        $nganhSPTK = Nganh::create([
             'ten_nganh' => 'Sư phạm Tiếng Khmer',
             'khoa_id' => $khoaSP->id,
             'mo_ta' => 'Ngành Sư phạm Tiếng Khmer'
        ]);

        // Create Mons for CNTT ABET
        Mon::create([
            'ten_mon' => 'Lập trình Hướng đối tượng',
            'nganh_id' => $nganhCNTT_ABET->id,
            'mo_ta' => 'Môn Lập trình Hướng đối tượng với Java/C++'
        ]);

        Mon::create([
            'ten_mon' => 'Cấu trúc Dữ liệu và Giải thuật',
            'nganh_id' => $nganhCNTT_ABET->id,
            'mo_ta' => 'Môn Cấu trúc Dữ liệu và Giải thuật'
        ]);

        Mon::create([
            'ten_mon' => 'Cơ sở Dữ liệu',
            'nganh_id' => $nganhCNTT_ABET->id,
            'mo_ta' => 'Môn Cơ sở Dữ liệu'
        ]);

        Mon::create([
            'ten_mon' => 'Lập trình Web',
            'nganh_id' => $nganhCNTT_ABET->id,
            'mo_ta' => 'Môn Lập trình Web với HTML, CSS, JavaScript, PHP'
        ]);

        // Create Mons for Hệ thống Thông tin replaced by other subjects or linked to CNTT
        Mon::create([
            'ten_mon' => 'Phân tích Thiết kế Hệ thống',
            'nganh_id' => $nganhCNTT_ABET->id,
            'mo_ta' => 'Môn Phân tích và Thiết kế Hệ thống Thông tin'
        ]);

        Mon::create([
            'ten_mon' => 'Quản trị Hệ thống',
            'nganh_id' => $nganhCNTT_ABET->id,
            'mo_ta' => 'Môn Quản trị Hệ thống'
        ]);

        // Create Mons for Quản trị Kinh doanh
        Mon::create([
            'ten_mon' => 'Quản trị Marketing',
            'nganh_id' => $nganhQTKD->id,
            'mo_ta' => 'Môn Quản trị Marketing'
        ]);

        Mon::create([
            'ten_mon' => 'Quản trị Tài chính',
            'nganh_id' => $nganhQTKD->id,
            'mo_ta' => 'Môn Quản trị Tài chính Doanh nghiệp'
        ]);

        // Create Mons for Kế toán
        Mon::create([
            'ten_mon' => 'Kế toán Tài chính',
            'nganh_id' => $nganhKeToan->id,
            'mo_ta' => 'Môn Kế toán Tài chính'
        ]);

        Mon::create([
            'ten_mon' => 'Kế toán Quản trị',
            'nganh_id' => $nganhKeToan->id,
            'mo_ta' => 'Môn Kế toán Quản trị'
        ]);

        // Create Documents
        Document::create([
            'ten_tai_lieu' => 'Giáo trình Lập trình Hướng đối tượng Java',
            'mo_ta' => 'Giáo trình đầy đủ về OOP với Java, còn mới 90%',
            'hinh_anh' => 'java-oop.jpg',
            'gia' => 50000,
            'loai' => 'ban',
            'khoa_id' => $khoaCET->id,
            'nganh_id' => $nganhCNTT_ABET->id,
            'mon_id' => 1,
            'user_id' => 2,
            'trang_thai' => 'available'
        ]);

        Document::create([
            'ten_tai_lieu' => 'Slide bài giảng Cấu trúc Dữ liệu',
            'mo_ta' => 'Tài liệu slide đầy đủ từ giảng viên, chia sẻ miễn phí',
            'hinh_anh' => 'data-structure.jpg',
            'gia' => 0,
            'loai' => 'cho',
            'khoa_id' => $khoaCET->id,
            'nganh_id' => $nganhCNTT_ABET->id,
            'mon_id' => 2,
            'user_id' => 2,
            'trang_thai' => 'available'
        ]);

        Document::create([
            'ten_tai_lieu' => 'Giáo trình Cơ sở Dữ liệu',
            'mo_ta' => 'Giáo trình về Database, SQL, còn đẹp',
            'hinh_anh' => 'database.jpg',
            'gia' => 40000,
            'loai' => 'ban',
            'khoa_id' => $khoaCET->id,
            'nganh_id' => $nganhCNTT_ABET->id,
            'mon_id' => 3,
            'user_id' => 3,
            'trang_thai' => 'available'
        ]);

        // Create Blogs
        Blog::create([
            'tieu_de' => 'Chia sẻ tài liệu Lập trình Web',
            'noi_dung' => 'Mình có bộ tài liệu Lập trình Web đầy đủ, bao gồm HTML, CSS, JavaScript, PHP. Ai cần liên hệ mình nhé! Gặp tại TVU.',
            'hinh_anh' => 'web-programming.jpg',
            'user_id' => 2
        ]);

        Blog::create([
            'tieu_de' => 'Cho tặng slide môn Marketing',
            'noi_dung' => 'Mình có slide môn Quản trị Marketing đầy đủ, in màu, chia sẻ miễn phí cho các bạn. Inbox mình để hẹn gặp.',
            'hinh_anh' => 'marketing.jpg',
            'user_id' => 3
        ]);
    }
}
