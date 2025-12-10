<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;

class DevServeCommand extends Command
{
    protected $signature = 'dev:serve {--host=0.0.0.0} {--port=8000} {--path=/} {--php=php} {--timeout=15}';
    protected $description = 'Khởi chạy server dev và in QR để quét bằng điện thoại';

    public function handle(): int
    {
        $bindHost = (string)$this->option('host'); // host để bind server, mặc định 0.0.0.0
        $port = (int)$this->option('port');
        $path = '/' . ltrim((string)$this->option('path'), '/');
        $php = (string)$this->option('php');
        $timeout = (int)$this->option('timeout');

        // Host dùng cho QR: nếu bind 0.0.0.0 hoặc 127.0.0.1 thì tìm IP LAN
        $qrHost = ($bindHost === '0.0.0.0' || $bindHost === '127.0.0.1') ? $this->discoverLanIPv4() : $bindHost;
        $url = "http://{$qrHost}:{$port}{$path}";

        $this->info("Starting Laravel dev server on {$bindHost}:{$port} ...");
        $process = new Process([$php, 'artisan', 'serve', "--host={$bindHost}", "--port={$port}"]);
        $process->setWorkingDirectory(base_path());
        $process->setTimeout(null); // keep running

        // Ensure child process is killed when this command exits
        register_shutdown_function(function() use ($process){
            if ($process->isRunning()) {
                $process->stop(0.5);
            }
        });

        $process->start();

        // Wait until port is open or timeout
        $this->line('Đợi server khởi động...');
        $ready = $this->waitUntilListening($qrHost, $port, $timeout);
        if (!$ready) {
            $this->warn('Không xác nhận được trạng thái server trong thời gian quy định, vẫn tiếp tục hiển thị output.');
        } else {
            $this->line('');
            $this->info('Scan QR để mở trên điện thoại:');
            $this->line($url);
            $this->line('');
            try {
                $this->line($this->renderAsciiQr($url));
            } catch (\Throwable $e) {
                $this->warn('Không thể render QR: '.$e->getMessage());
            }
            $this->line('');
        }

        $this->comment('Nhấn Ctrl+C để dừng server. Khi server dừng, QR sẽ không còn hiệu lực.');

        // Pipe output while server is running
        while ($process->isRunning()) {
            $out = $process->getIncrementalOutput();
            $err = $process->getIncrementalErrorOutput();
            if ($out) { $this->output->write($out); }
            if ($err) { $this->output->write($err); }
            usleep(100000); // 100ms
        }

        $code = $process->getExitCode() ?? 0;
        $this->line("");
        $this->info("Server stopped. Exit code: {$code}");
        return $code === 0 ? self::SUCCESS : self::FAILURE;
    }

    protected function waitUntilListening(string $host, int $port, int $timeoutSeconds = 10): bool
    {
        $start = time();
        while ((time() - $start) < $timeoutSeconds) {
            $conn = @fsockopen($host, $port, $errno, $errstr, 0.3);
            if (is_resource($conn)) { fclose($conn); return true; }
            usleep(200000);
        }
        return false;
    }

    protected function isPrivateIPv4(string $ip): bool
    {
        return (bool)preg_match('/^(192\\.168|10\\.|172\\.(1[6-9]|2[0-9]|3[0-1]))\\./', $ip);
    }

    protected function discoverLanIPv4(): string
    {
        $appUrl = config('app.url') ?: env('APP_URL');
        if ($appUrl) {
            $host = parse_url($appUrl, PHP_URL_HOST);
            if (is_string($host) && $this->isPrivateIPv4($host)) return $host;
        }
        $ip = gethostbyname(gethostname());
        if (is_string($ip) && $this->isPrivateIPv4($ip)) return $ip;
        $ps = 'powershell -NoProfile -Command "(Get-NetIPAddress -AddressFamily IPv4 | Where-Object { $_.IPAddress -match \"^(192\\.168|10\\.|172\\.(1[6-9]|2[0-9]|3[0-1]))\" } | Select-Object -First 1 -ExpandProperty IPAddress)"';
        $out = @shell_exec($ps);
        $out = is_string($out) ? trim($out) : '';
        if ($out !== '' && $this->isPrivateIPv4($out)) return $out;
        return '127.0.0.1';
    }

    protected function renderAsciiQr(string $text): string
    {
        $qrCode = Encoder::encode($text, ErrorCorrectionLevel::L());
        $matrix = $qrCode->getMatrix();
        $size = $matrix->getWidth();
        $quiet = 2;
        $lines = [];
        for ($y = -$quiet; $y < $size + $quiet; $y++) {
            $row = '';
            for ($x = -$quiet; $x < $size + $quiet; $x++) {
                $on = false;
                if ($x >= 0 && $y >= 0 && $x < $size && $y < $size) {
                    $on = (bool)$matrix->get($x, $y);
                }
                $row .= $on ? '██' : '  ';
            }
            $lines[] = $row;
        }
        return implode(PHP_EOL, $lines);
    }
}
