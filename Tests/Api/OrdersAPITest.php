<?php
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require 'C:/xampp/htdocs/Kiem-Thu-Web/vendor/autoload.php';

class OrdersAPITest extends TestCase
{
    private $session;

    public function setUp(): void
    {
        // Khởi tạo session và request
        $this->session = new Session();
        $this->session->start();
    }

    public function tearDown(): void
    {
        // Dọn dẹp session sau mỗi lần test
        $this->session->clear();
    }

    public function testOrderEmailSending()
    {
        // Giả sử bạn có các dữ liệu cần thiết
        $customerData = [
            'name' => 'John Doe',
            'email' => 'customer@example.com',
            'phone' => '123456789',
            'address' => '123 Main St',
            'city' => 'Hanoi',
            'district' => 'District A'
        ];

        // Mô phỏng việc điền thông tin và đặt hàng
        $this->session->set('customer_data', $customerData);
        $this->session->set('cart', [
            1 => 2, // Giả sử sản phẩm có ID 1 và số lượng là 2
        ]);

        // Giả sử bạn có một hàm gửi email trong lớp OrderController
        $orderController = new OrderController(); // Thay OrderController bằng tên controller của bạn
        $response = $orderController->placeOrder($this->session); // Giả sử hàm này xử lý việc tạo đơn hàng

        // Kiểm tra rằng phản hồi trả về là thành công (status 200)
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        // Kiểm tra email đã được gửi
        $this->assertTrue($this->isEmailSent()); // Giả sử bạn có một phương thức kiểm tra email đã gửi

        // Kiểm tra nội dung email
        $emailContent = $this->getLastEmailContent();
        $this->assertStringContainsString('Thank you for your order', $emailContent);
        $this->assertStringContainsString('customer@example.com', $emailContent);
        $this->assertStringContainsString('Order Code:', $emailContent);
        $this->assertStringContainsString('Total amount:', $emailContent);
    }

    // Phương thức giả định kiểm tra xem email đã được gửi chưa
    private function isEmailSent()
    {
        // Kiểm tra trong môi trường của bạn, ví dụ bằng cách sử dụng Mailtrap, hoặc thông qua Symfony Mailer
        // Bạn cần thay thế mã này bằng phương thức thực tế kiểm tra email đã gửi
        return true;
    }

    // Phương thức giả định lấy nội dung email vừa gửi
    private function getLastEmailContent()
    {
        // Lấy nội dung email từ hệ thống hoặc dịch vụ gửi email
        return 'Thank you for your order. Your order code is: ABC123. Total amount: 500,000 VND';
    }
}
