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
                'khoa' => 'Kỹ thuật và Công nghệ ( CET )',
                'nganh' => 'Công nghệ thông tin (ABET)',
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
                'khoa' => 'Kỹ thuật và Công nghệ ( CET )',
                'nganh' => 'Công nghệ thông tin (ABET)',
                'role' => 'student'
            ]
        );

        // Create Khoas
        $khoaCET = Khoa::firstOrCreate([
            'ten_khoa' => 'Kỹ thuật và Công nghệ ( CET )',
        ], [
            'mo_ta' => 'Khoa Kỹ thuật và Công nghệ'
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

        // Nganhs for CET
        $nganhCNTT_ABET = Nganh::firstOrCreate(
            [
                'ten_nganh' => 'Công nghệ thông tin (ABET)',
                'khoa_id' => $khoaCET->id,
            ],
            [
                'mo_ta' => 'Ngành Công nghệ thông tin theo chuẩn ABET'
            ]
        );

        $nganhDDT = Nganh::firstOrCreate(
            [
                'ten_nganh' => 'Điện - Điện tử & Tự động hóa',
                'khoa_id' => $khoaCET->id,
            ],
            [
                'mo_ta' => 'Ngành Điện - Điện tử & Tự động hóa'
            ]
        );

        $nganhCK = Nganh::firstOrCreate(
            [
                'ten_nganh' => 'Cơ khí',
                'khoa_id' => $khoaCET->id,
            ],
            [
                'mo_ta' => 'Ngành Cơ khí'
            ]
        );

        $nganhXD = Nganh::firstOrCreate(
            [
                'ten_nganh' => 'Xây dựng',
                'khoa_id' => $khoaCET->id,
            ],
            [
                'mo_ta' => 'Ngành Xây dựng'
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

        // Nganh for LLCT - Corrected to "Chính trị học"
        $nganhCTH = Nganh::firstOrCreate(
            [
                'ten_nganh' => 'Chính trị học',
                'khoa_id' => $khoaLLCT->id,
            ],
            [
                'mo_ta' => 'Ngành Chính trị học'
            ]
        );

        // Nganh for Su Pham
        $nganhGDMN = Nganh::firstOrCreate(
             [
                'ten_nganh' => 'Giáo dục Mầm non',
                'khoa_id' => $khoaSP->id,
             ],
             [
                'mo_ta' => 'Ngành Giáo dục Mầm non'
             ]
        );
        
        $nganhGDTH = Nganh::firstOrCreate(
             [
                'ten_nganh' => 'Giáo dục Tiểu học',
                'khoa_id' => $khoaSP->id,
             ],
             [
                'mo_ta' => 'Ngành Giáo dục Tiểu học'
             ]
        );

        $nganhSPNV = Nganh::firstOrCreate(
             [
                'ten_nganh' => 'Sư phạm Ngữ văn',
                'khoa_id' => $khoaSP->id,
             ],
             [
                'mo_ta' => 'Ngành Sư phạm Ngữ văn'
             ]
        );

        $nganhSPTK = Nganh::firstOrCreate(
             [
                'ten_nganh' => 'Sư phạm Tiếng Khmer',
                'khoa_id' => $khoaSP->id,
             ],
             [
                'mo_ta' => 'Ngành Sư phạm Tiếng Khmer'
             ]
        );

        // Mons for political theory (LLCT) - Linked to CTH
        $monKinhTeChinhTri = Mon::firstOrCreate(
            [
                'ten_mon' => 'Kinh tế chính trị Mác - Lênin',
                'nganh_id' => $nganhCTH->id,
            ],
            [
                'mo_ta' => 'Học phần Kinh tế chính trị trong khối LLCT'
            ]
        );

        $monLichSuDang = Mon::firstOrCreate(
            [
                'ten_mon' => 'Lịch sử Đảng Cộng sản Việt Nam',
                'nganh_id' => $nganhCTH->id,
            ],
            [
                'mo_ta' => 'Học phần Lịch sử ĐCSVN trong khối LLCT'
            ]
        );

        // Create Mons for CNTT ABET
        $monOOP = Mon::firstOrCreate(
            [
                'ten_mon' => 'Lập trình Hướng đối tượng',
                'nganh_id' => $nganhCNTT_ABET->id,
            ],
            [
                'mo_ta' => 'Môn Lập trình Hướng đối tượng với Java/C++'
            ]
        );

        $monDSA = Mon::firstOrCreate(
            [
                'ten_mon' => 'Cấu trúc Dữ liệu và Giải thuật',
                'nganh_id' => $nganhCNTT_ABET->id,
            ],
            [
                'mo_ta' => 'Môn Cấu trúc Dữ liệu và Giải thuật'
            ]
        );

        $monDB = Mon::firstOrCreate(
            [
                'ten_mon' => 'Cơ sở Dữ liệu',
                'nganh_id' => $nganhCNTT_ABET->id,
            ],
            [
                'mo_ta' => 'Môn Cơ sở Dữ liệu'
            ]
        );

        $monWeb = Mon::firstOrCreate(
            [
                'ten_mon' => 'Lập trình Web',
                'nganh_id' => $nganhCNTT_ABET->id,
            ],
            [
                'mo_ta' => 'Môn Lập trình Web với HTML, CSS, JavaScript, PHP'
            ]
        );

        $monPTTKHT = Mon::firstOrCreate(
            [
                'ten_mon' => 'Phân tích Thiết kế Hệ thống',
                'nganh_id' => $nganhCNTT_ABET->id,
            ],
            [
                'mo_ta' => 'Môn Phân tích và Thiết kế Hệ thống Thông tin'
            ]
        );

        $monQTHT = Mon::firstOrCreate(
            [
                'ten_mon' => 'Quản trị Hệ thống',
                'nganh_id' => $nganhCNTT_ABET->id,
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

        // Create new Subject (Mon) entries for the new documents
        $monDaiSo = Mon::firstOrCreate(['ten_mon' => 'Đại số đại cương', 'nganh_id' => $nganhCNTT_ABET->id], ['mo_ta' => 'Môn Đại số đại cương']);
        $monKTLT = Mon::firstOrCreate(['ten_mon' => 'Kỹ thuật lập trình', 'nganh_id' => $nganhCNTT_ABET->id], ['mo_ta' => 'Môn Kỹ thuật lập trình']);
        $monTACN = Mon::firstOrCreate(['ten_mon' => 'Tiếng Anh chuyên ngành', 'nganh_id' => $nganhCNTT_ABET->id], ['mo_ta' => 'Môn Tiếng Anh chuyên ngành']);
        $monTVTH = Mon::firstOrCreate(['ten_mon' => 'Tiếng Việt thực hành', 'nganh_id' => $nganhCNTT_ABET->id], ['mo_ta' => 'Môn Tiếng Việt thực hành']);
        $monToanKT = Mon::firstOrCreate(['ten_mon' => 'Toán Kinh tế', 'nganh_id' => $nganhCNTT_ABET->id], ['mo_ta' => 'Môn Toán Kinh tế']);
        $monToanRR = Mon::firstOrCreate(['ten_mon' => 'Toán Rời rạc', 'nganh_id' => $nganhCNTT_ABET->id], ['mo_ta' => 'Môn Toán Rời rạc']);
        $monVTP = Mon::firstOrCreate(['ten_mon' => 'Vi tích phân A1', 'nganh_id' => $nganhCNTT_ABET->id], ['mo_ta' => 'Môn Vi tích phân A1']);

        // Create New Documents with Images
        $students = [$student1->id, $student2->id];
        $descriptions = [
            'Sách còn mới 99%, chưa viết vẽ gì.',
            'Tài liệu học tập chính hãng, pass lại giá rẻ.',
            'Giáo trình Photo, chữ rõ nét.',
            'Sách cũ nhưng nội dung vẫn đầy đủ.',
            'Mua về nhưng không dùng đến, pass lại cho bạn nào cần.',
            'Tài liệu tham khảo rất hay cho môn này.',
            'Sách của thầy cô trong trường biên soạn.'
        ];

        Document::create([
            'ten_tai_lieu' => 'Đại Số Đại Cương',
            'mo_ta' => $descriptions[array_rand($descriptions)],
            'hinh_anh' => 'img/Dai So Dai Cuong.jpg',
            'gia' => rand(10, 60) * 1000,
            'loai' => 'ban',
            'khoa_id' => $khoaCET->id,
            'nganh_id' => $nganhCNTT_ABET->id,
            'mon_id' => $monDaiSo->id,
            'user_id' => $students[array_rand($students)],
            'trang_thai' => 'available'
        ]);

        Document::create([
            'ten_tai_lieu' => 'Kỹ Thuật Lập Trinh C/C++',
            'mo_ta' => $descriptions[array_rand($descriptions)],
            'hinh_anh' => 'img/Ky Thuat Lap Trinh.jpg',
            'gia' => rand(10, 60) * 1000,
            'loai' => 'ban',
            'khoa_id' => $khoaCET->id,
            'nganh_id' => $nganhCNTT_ABET->id,
            'mon_id' => $monKTLT->id,
            'user_id' => $students[array_rand($students)],
            'trang_thai' => 'available'
        ]);

        Document::create([
            'ten_tai_lieu' => 'Tiếng Anh Chuyên Ngành CNTT',
            'mo_ta' => $descriptions[array_rand($descriptions)],
            'hinh_anh' => 'img/Tieng Anh Chuyen Nganh.jpg',
            'gia' => rand(10, 60) * 1000,
            'loai' => 'ban',
            'khoa_id' => $khoaCET->id,
            'nganh_id' => $nganhCNTT_ABET->id,
            'mon_id' => $monTACN->id,
            'user_id' => $students[array_rand($students)],
            'trang_thai' => 'available'
        ]);

        Document::create([
            'ten_tai_lieu' => 'Tiếng Việt Thực Hành',
            'mo_ta' => $descriptions[array_rand($descriptions)],
            'hinh_anh' => 'img/Tieng Viet Thuc Hanh.jpg',
            'gia' => rand(10, 60) * 1000,
            'loai' => 'ban',
            'khoa_id' => $khoaCET->id,
            'nganh_id' => $nganhCNTT_ABET->id,
            'mon_id' => $monTVTH->id,
            'user_id' => $students[array_rand($students)],
            'trang_thai' => 'available'
        ]);

        Document::create([
            'ten_tai_lieu' => 'Toán Kinh Tế',
            'mo_ta' => $descriptions[array_rand($descriptions)],
            'hinh_anh' => 'img/Toan Kinh Te.jpg',
            'gia' => rand(10, 60) * 1000,
            'loai' => 'ban',
            'khoa_id' => $khoaCET->id,
            'nganh_id' => $nganhCNTT_ABET->id,
            'mon_id' => $monToanKT->id,
            'user_id' => $students[array_rand($students)],
            'trang_thai' => 'available'
        ]);

        Document::create([
            'ten_tai_lieu' => 'Toán Rời Rạc & Ứng Dụng',
            'mo_ta' => $descriptions[array_rand($descriptions)],
            'hinh_anh' => 'img/Toan Roi Rac.jpg',
            'gia' => rand(10, 60) * 1000,
            'loai' => 'ban',
            'khoa_id' => $khoaCET->id,
            'nganh_id' => $nganhCNTT_ABET->id,
            'mon_id' => $monToanRR->id,
            'user_id' => $students[array_rand($students)],
            'trang_thai' => 'available'
        ]);

        Document::create([
            'ten_tai_lieu' => 'Vi Tích Phân A1',
            'mo_ta' => $descriptions[array_rand($descriptions)],
            'hinh_anh' => 'img/Vi Tich Phan A1.jpg',
            'gia' => rand(10, 60) * 1000,
            'loai' => 'ban',
            'khoa_id' => $khoaCET->id,
            'nganh_id' => $nganhCNTT_ABET->id,
            'mon_id' => $monVTP->id,
            'user_id' => $students[array_rand($students)],
            'trang_thai' => 'available'
        ]);

        // Create Documents matching landing featured items
        Document::updateOrCreate(
            ['ten_tai_lieu' => 'Kinh Tế Chính Trị MÁC - LÊNIN'],
            [
                'mo_ta' => 'Ghi chú đầy đủ các mục quan trọng.',
                'hinh_anh' => 'img/lichsudang.jpg', // dùng ảnh sách Lịch sử Đảng ở public/img
                'gia' => 0,
                'loai' => 'cho',
                'khoa_id' => $khoaLLCT->id,
                'nganh_id' => $nganhCTH->id,
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
                'nganh_id' => $nganhCTH->id,
                'mon_id' => $monLichSuDang->id,
                'user_id' => $student2->id,
                'trang_thai' => 'available'
            ]
        );

        // Add a Mon for Tin học cơ bản under KHMT
        $monTinHocCoBan = Mon::firstOrCreate(
            [
                'ten_mon' => 'Tin học cơ bản',
                'nganh_id' => $nganhCNTT_ABET->id,
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
                'khoa_id' => $khoaCET->id,
                'nganh_id' => $nganhCNTT_ABET->id,
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
