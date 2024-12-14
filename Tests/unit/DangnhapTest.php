<?php
use PHPUnit\Framework\TestCase;

class DangnhapTest extends TestCase {
    private $CI;

    public function setUp(): void {
        // Lấy instance CodeIgniter
        $this->CI =& get_instance();
        $this->CI->load->model('frontend/Mcustomer');
        $this->CI->load->library('session');
    }

    /**
     * Test: Đăng nhập thành công
     */
    public function testDangNhapSuccess() {
        $username = 'testuser';
        $password = md5('123456');

        // Mock phương thức customer_login để trả về user giả
        $this->CI->Mcustomer = $this->createMock(Mcustomer::class);
        $this->CI->Mcustomer->method('customer_login')
            ->willReturn([
                'id' => 1,
                'email' => 'test@example.com',
                'fullname' => 'Test User'
            ]);

        $_POST['username'] = $username;
        $_POST['password'] = $password;

        // Gọi phương thức dangnhap
        $this->CI->Dangnhap->dangnhap();

        // Kiểm tra session
        $this->assertEquals(1, $this->CI->session->userdata('id'));
        $this->assertEquals('test@example.com', $this->CI->session->userdata('email'));
        $this->assertEquals('Test User', $this->CI->session->userdata('sessionKhachHang_name'));
    }

    /**
     * Test: Đăng nhập thất bại
     */
    public function testDangNhapFail() {
        $username = 'wronguser';
        $password = md5('wrongpassword');

        // Mock phương thức customer_login để trả về false
        $this->CI->Mcustomer = $this->createMock(Mcustomer::class);
        $this->CI->Mcustomer->method('customer_login')->willReturn(false);

        $_POST['username'] = $username;
        $_POST['password'] = $password;

        // Gọi phương thức dangnhap
        $this->CI->Dangnhap->dangnhap();

        // Kiểm tra lỗi trả về
        $this->assertArrayHasKey('error', $this->CI->data);
        $this->assertEquals('Tài khoản hoặc mật khẩu không chính xác', $this->CI->data['error']);
    }

    /**
     * Test: Đăng ký tài khoản mới
     */
    public function testDangKySuccess() {
        $new_user = [
            'username' => 'newuser',
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'phone' => '123456789',
            'password' => '123456',
            're_password' => '123456'
        ];

        // Mock phương thức customer_insert
        $this->CI->Mcustomer = $this->createMock(Mcustomer::class);
        $this->CI->Mcustomer->method('customer_insert')->willReturn(true);

        $_POST = $new_user;

        // Gọi phương thức dangky
        $this->CI->Dangnhap->dangky();

        // Kiểm tra thông báo thành công
        $this->assertArrayHasKey('success', $this->CI->data);
        $this->assertEquals('Đăng ký thành công! Bạn đã nhận được 1 mã giảm giá cho thành viên mới, vui lòng kiểm tra email !!', $this->CI->data['success']);
    }

    /**
     * Test: Đăng ký thất bại (username đã tồn tại)
     */
    public function testDangKyFailUsernameExists() {
        $existing_user = [
            'username' => 'existinguser',
            'name' => 'Existing User',
            'email' => 'existinguser@example.com',
            'phone' => '123456789',
            'password' => '123456',
            're_password' => '123456'
        ];

        // Mock phương thức customer_insert trả về false
        $this->CI->Mcustomer = $this->createMock(Mcustomer::class);
        $this->CI->Mcustomer->method('customer_insert')->willReturn(false);

        $_POST = $existing_user;

        // Gọi phương thức dangky
        $this->CI->Dangnhap->dangky();

        // Kiểm tra lỗi trả về
        $this->assertArrayHasKey('error', $this->CI->data);
    }

    /**
     * Test: Đăng xuất
     */
    public function testDangXuat() {
        // Thiết lập dữ liệu session giả
        $this->CI->session->set_userdata([
            'id' => 1,
            'email' => 'test@example.com',
            'sessionKhachHang' => ['id' => 1, 'email' => 'test@example.com']
        ]);

        // Gọi phương thức dangxuat
        $this->CI->Dangnhap->dangxuat();

        // Kiểm tra session đã bị hủy
        $this->assertNull($this->CI->session->userdata('id'));
        $this->assertNull($this->CI->session->userdata('email'));
        $this->assertNull($this->CI->session->userdata('sessionKhachHang'));
    }
}
