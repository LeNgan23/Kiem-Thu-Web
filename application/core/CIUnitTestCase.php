<?php
use PHPUnit\Framework\TestCase;

require_once APPPATH . 'core/CIUnitTestCase.php';  // Đảm bảo nạp đúng lớp

class SanphamTest extends CIUnitTestCase {
    public function setUp(): void {
        parent::setUp();
        $this->CI->load->model('frontend/Mproduct');
    }

    public function testIndexMethod() {
        $this->CI->Sanpham->index();
        $this->assertStringContainsString('Smart Store - Tất cả sản phẩm', $this->CI->data['title']);
    }
}
