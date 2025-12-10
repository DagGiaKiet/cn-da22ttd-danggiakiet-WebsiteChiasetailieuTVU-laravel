<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReplaceStringCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Example: php artisan data:replace-string "old" "new" --dry-run
     */
    protected $signature = 'data:replace-string {from} {to} {--dry-run : Chỉ xem trước số lượng thay đổi, không ghi DB}';

    /**
     * The console command description.
     */
    protected $description = 'Thay thế chuỗi văn bản trong các cột nội dung (documents, blogs) trên toàn hệ thống';

    public function handle(): int
    {
        $from = (string) $this->argument('from');
        $to   = (string) $this->argument('to');
        $dry  = (bool) $this->option('dry-run');

        if ($from === '') {
            $this->error('Giá trị from không được rỗng.');
            return self::FAILURE;
        }

        $targets = [
            ['table' => 'documents', 'columns' => ['ten_tai_lieu','mo_ta']],
            ['table' => 'blogs',     'columns' => ['tieu_de','noi_dung']],
        ];

        $totalAffected = 0;
        foreach ($targets as $t) {
            $table = $t['table'];
            foreach ($t['columns'] as $col) {
                try {
                    $count = DB::table($table)->where($col, 'like', "%{$from}%")->count();
                } catch (\Throwable $e) {
                    // Bảng/cột có thể không tồn tại tùy DB hiện tại
                    $this->line("- Bỏ qua {$table}.{$col} (".$e->getMessage().")");
                    continue;
                }

                if ($count === 0) {
                    $this->line("- {$table}.{$col}: 0 bản ghi cần thay");
                    continue;
                }

                if ($dry) {
                    $this->info("- {$table}.{$col}: sẽ thay trong {$count} bản ghi (dry-run)");
                    continue;
                }

                // MySQL/MariaDB REPLACE in place
                $sql = "UPDATE `{$table}` SET `{$col}` = REPLACE(`{$col}`, ?, ? ) WHERE `{$col}` LIKE ?";
                $affected = DB::update($sql, [$from, $to, "%{$from}%"]);
                $totalAffected += $affected;
                $this->info("- {$table}.{$col}: đã thay trong {$affected} bản ghi");
            }
        }

        if (!$dry) {
            $this->info("Hoàn tất. Tổng số bản ghi cập nhật: {$totalAffected}");
        } else {
            $this->info('Dry-run xong. Không có thay đổi nào được ghi.');
        }

        return self::SUCCESS;
    }
}
