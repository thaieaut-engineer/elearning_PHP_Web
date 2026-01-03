<?php
const _THAI = true; // kiểm tra truy cập có hơp lệ cho các file

const _MODULES = 'dashboard'; // module mặc định
const _ACTION = 'index'; // action mặc định

// Cấu hình kết nối cơ sở dữ liệu
// Hàm bổ trợ đọc file .env đơn giản
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

// Gán biến để sử dụng trong dự án
$host = $_ENV['DB_HOST'] ?? 'localhost';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$db   = $_ENV['DB_NAME'] ?? 'elearning';
$driver = 'mysql'; // Loại cơ sở dữ liệu

// debug error
const DEBUG = true; // Bật/tắt chế độ gỡ lỗi

// Cấu hình đường dẫn
define('HOST_URL', 'http://localhost/elearning'); // URL máy chủ
define('HOST_URL_TEMPLATES', HOST_URL . '/templates'); // URL thư mục templates

// Cấu hình thư mục
define('PATH_URL', __DIR__ ); // Đường dẫn gốc của dự án
define('PATH_URL_TEMPLATES', PATH_URL . '/templates'); // Đường dẫn thư mục templates