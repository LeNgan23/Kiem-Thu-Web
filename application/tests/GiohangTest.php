<?php
use PHPUnit\Framework\TestCase;

class GiohangTest extends TestCase {
    private $CI;

    protected function setUp(): void {
        $this->CI = &get_instance();
        $this->CI->load->library('session');
        $this->CI->load->model('frontend/Mcustomer');
        $this->CI->load->library('form_validation');
    }

    public function testCheckMail_ExistingEmail() {
        // Giả lập email tồn tại
        $this->CI->Mcustomer->method('customer_detail_email')
            ->willReturn(true);

        $_POST['email'] = 'existing@example.com';
        $result = $this->CI->check_mail();
        $this->assertFalse($result, 'Email tồn tại nhưng không bị từ chối.');
    }

    public function testCheckMail_NewEmail() {
        // Giả lập email không tồn tại
        $this->CI->Mcustomer->method('customer_detail_email')
            ->willReturn(false);

        $_POST['email'] = 'new@example.com';
        $result = $this->CI->check_mail();
        $this->assertTrue($result, 'Email mới nhưng bị từ chối.');
    }
}
