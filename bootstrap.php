<?php

// Tự động tải các thư viện được cài đặt qua Composer
require_once __DIR__ . '/vendor/autoload.php';

// Định nghĩa đường dẫn đến hệ thống CodeIgniter
define('BASEPATH', __DIR__ . '/system/');
define('APPPATH', __DIR__ . '/application/');
define('ENVIRONMENT', 'testing');
define('SYSDIR', 'system'); // Đảm bảo SYSDIR được định nghĩa

// Kiểm tra nếu VIEWPATH chưa được định nghĩa thì định nghĩa nó
if (!defined('VIEWPATH')) {
    define('VIEWPATH', APPPATH . 'views/');
}



// Khởi chạy CodeIgniter
require_once __DIR__ . '/system/core/CodeIgniter.php';

// Khởi tạo một instance của CodeIgniter
$CI = &get_instance();

