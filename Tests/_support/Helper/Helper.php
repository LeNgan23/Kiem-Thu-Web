<?php
// tests/_support/Helper/Helper.php
namespace Tests\Support\Helper;
use Codeception\Module;

class Helper extends Module
{
    protected $CI;

    // Hàm khởi tạo CodeIgniter
    public function _initialize()
    {
        // Yêu cầu các file chính của CodeIgniter
        require_once __DIR__ . '/../../../application/config/constants.php';  // Đường dẫn chính xác đến constants.php
        require_once __DIR__ . '/../../../system/core/CodeIgniter.php';  // Đường dẫn chính xác đến CodeIgniter.php

        // Tạo instance của CodeIgniter
        $this->CI = &get_instance();

        // Đảm bảo các thư viện cần thiết được tải
        $this->CI->load->library('session');
        $this->CI->load->model('frontend/Mproduct');
        $this->CI->load->model('frontend/Mcategory');
    }
}
