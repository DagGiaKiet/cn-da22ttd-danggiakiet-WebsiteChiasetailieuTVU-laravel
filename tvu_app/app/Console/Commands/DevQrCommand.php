<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;

class DevQrCommand extends Command
{
    protected $signature = 'dev:qr {--url=} {--host=} {--port=8000} {--path=/}';
    protected $description = 'In mã QR URL dev để quét bằng điện thoại (tự lấy IP LAN nếu cần)';

    public function handle(): int
    {
        $url = $this->option('url');
        if (!$url) {
            $host = $this->option('host') ?: $this->discoverLanIPv4();
            $port = (int)($this->option('port') ?: 8000);
            $path = $this->option('path') ?: '/';
            $path = '/' . ltrim($path, '/');
            $url = "http://{$host}:{$port}{$path}";
        }

        $this->line('');
        $this->info('Scan QR để mở:');
        $this->line($url);
        $this->line('');

        try {
            $qr = $this->renderAsciiQr($url);
            $this->line($qr);
            $this->line('');
            $this->comment('Gợi ý: đảm bảo php artisan serve đang chạy với --host=0.0.0.0 và điện thoại cùng mạng LAN.');
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Không thể tạo QR: '.$e->getMessage());
            $this->line('URL: '.$url);
            return self::FAILURE;
        }
    }

    protected function isPrivateIPv4(string $ip): bool
    {
        return (bool)preg_match('/^(192\\.168|10\\.|172\\.(1[6-9]|2[0-9]|3[0-1]))\\./', $ip);
    }

    protected function discoverLanIPv4(): string
    {
        // 1) From APP_URL if set and private
        $appUrl = config('app.url') ?: env('APP_URL');
        if ($appUrl) {
            $host = parse_url($appUrl, PHP_URL_HOST);
            if (is_string($host) && $this->isPrivateIPv4($host)) {
                return $host;
            }
        }

        // 2) gethostbyname
        $ip = gethostbyname(gethostname());
        if (is_string($ip) && $this->isPrivateIPv4($ip)) {
            return $ip;
        }

        // 3) Windows PowerShell (ưu tiên máy đang dùng Windows)
        $ps = 'powershell -NoProfile -Command "(Get-NetIPAddress -AddressFamily IPv4 | Where-Object { $_.IPAddress -match \"^(192\\.168|10\\.|172\\.(1[6-9]|2[0-9]|3[0-1]))\" } | Select-Object -First 1 -ExpandProperty IPAddress)"';
        $out = @shell_exec($ps);
        $out = is_string($out) ? trim($out) : '';
        if ($out !== '' && $this->isPrivateIPv4($out)) {
            return $out;
        }

        // 4) Fallback
        return '127.0.0.1';
    }

    protected function renderAsciiQr(string $text): string
    {
        // Encode to QR matrix using BaconQrCode
        $qrCode = Encoder::encode($text, ErrorCorrectionLevel::L());
        $matrix = $qrCode->getMatrix();
        $size = $matrix->getWidth();

        $quiet = 2; // quiet zone size
        $lines = [];
        for ($y = -$quiet; $y < $size + $quiet; $y++) {
            $row = '';
            for ($x = -$quiet; $x < $size + $quiet; $x++) {
                $on = false;
                if ($x >= 0 && $y >= 0 && $x < $size && $y < $size) {
                    // In BaconQrCode v3, non-zero means dark module
                    $on = (bool)$matrix->get($x, $y);
                }
                $row .= $on ? '██' : '  ';
            }
            $lines[] = $row;
        }
        return implode(PHP_EOL, $lines);
    }
}
