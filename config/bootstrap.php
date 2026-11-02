<?php
declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

function env_value(string $key, mixed $default = null): mixed {
    static $env = null;
    if ($env === null) {
        $env = [];
        $file = BASE_PATH . '/.env';
        if (is_file($file)) {
            foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
                [$k, $v] = explode('=', $line, 2);
                $env[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
            }
        }
    }
    return $env[$key] ?? $default;
}

date_default_timezone_set('Asia/Kolkata');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name((string)env_value('SESSION_NAME', 'jobconnect_session'));
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'httponly' => true,
        'secure' => $secure,
        'samesite' => 'Lax',
        'path' => '/'
    ]);
    session_start();
}

require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/Helpers/functions.php';
require_once BASE_PATH . '/app/Helpers/csrf.php';
require_once BASE_PATH . '/app/Helpers/auth.php';
