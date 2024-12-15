<?php

use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private $orderManager;
    
    protected function setUp(): void
    {
        // Giả sử OrderManager là lớp quản lý đơn hàng và nó cần được khởi tạo
        $this->orderManager = new OrderManager();
    }

    public function testInvalidProductInOrder()
    {
        // Tạo đơn hàng với sản phẩm không hợp lệ
        $order = new Order();
        $order->addProduct('invalid_product_id', 2); // ID sản phẩm không hợp lệ
        $order->submit();

        // Kiểm tra thông báo lỗi trả về
        $this->assertEquals('Sản phẩm không hợp lệ hoặc hết hàng', $order->getErrorMessage());
        $this->assertFalse($order->isSubmitted());
    }

    public function testAccessControlForCancelOrder()
    {
        // Đăng nhập với tài khoản user
        $user = new User('user@example.com', 'password');
        $order = new Order();
        $order->setUser($user);
        $order->createOrder();
        
        // Người dùng không có quyền hủy đơn
        $this->expectException('UnauthorizedException');
        $order->cancel();
        
        // Đăng nhập với tài khoản admin
        $admin = new User('admin@example.com', 'adminpassword');
        $order->setUser($admin);
        
        // Admin có quyền hủy đơn
        $order->cancel();
        $this->assertTrue($order->isCancelled());
    }

    public function testOrderNotification()
    {
        // Giả lập gửi email hoặc thông báo
        $user = new User('user@example.com', 'password');
        $order = new Order();
        $order->setUser($user);
        $order->createOrder();

        // Duyệt đơn hàng và kiểm tra thông báo
        $order->approve();
        $this->assertTrue($order->getNotificationSent());
        $this->assertEquals('Đơn hàng đã được duyệt!', $order->getNotificationMessage());

        // Hủy đơn hàng và kiểm tra thông báo
        $order->cancel();
        $this->assertTrue($order->getNotificationSent());
        $this->assertEquals('Đơn hàng đã bị hủy!', $order->getNotificationMessage());

        // Xác nhận thanh toán và kiểm tra thông báo
        $order->confirmPayment();
        $this->assertTrue($order->getNotificationSent());
        $this->assertEquals('Đơn hàng đã hoàn tất thanh toán!', $order->getNotificationMessage());
    }

    // Kiểm tra hủy đơn hàng
    public function testCancelOrder()
    {
        $orderId = 1;  // Giả sử ID đơn hàng là 1
        
        // Giả sử đơn hàng có thể hủy
        $this->orderManager->cancelOrder($orderId);
        
        // Kiểm tra trạng thái đơn hàng đã hủy
        $order = $this->orderManager->getOrderById($orderId);
        $this->assertEquals('canceled', $order->status); // Kiểm tra trạng thái đơn hàng
    }

    // Kiểm tra xóa đơn hàng (không thể xóa khi đơn đang giao)
    public function testDeleteOrder()
    {
        $orderId = 2;  // Giả sử ID đơn hàng là 2
        $order = $this->orderManager->getOrderById($orderId);

        // Nếu đơn hàng không đang giao, nó có thể bị xóa
        if ($order->status !== 'shipping') {
            $this->orderManager->deleteOrder($orderId);
            $deletedOrder = $this->orderManager->getOrderById($orderId);
            $this->assertNull($deletedOrder); // Kiểm tra đơn hàng đã bị xóa
        } else {
            // Kiểm tra xóa đơn hàng đang giao sẽ ném lỗi
            $this->expectException(Exception::class);
            $this->orderManager->deleteOrder($orderId);  
        }
    }

    // Kiểm tra duyệt đơn hàng
    public function testApproveOrder()
    {
        $orderId = 3;  // Giả sử ID đơn hàng là 3
        
        // Duyệt đơn hàng
        $this->orderManager->approveOrder($orderId);
        
        // Kiểm tra trạng thái đơn hàng đã duyệt
        $order = $this->orderManager->getOrderById($orderId);
        $this->assertEquals('approved', $order->status); // Kiểm tra trạng thái đơn hàng
    }

    // Kiểm tra xác nhận thanh toán
    public function testConfirmPayment()
    {
        $orderId = 4;  // Giả sử ID đơn hàng là 4
        
        // Xác nhận thanh toán
        $this->orderManager->confirmPayment($orderId);
        
        // Kiểm tra trạng thái đơn hàng đã thanh toán
        $order = $this->orderManager->getOrderById($orderId);
        $this->assertEquals('paid', $order->status); // Kiểm tra trạng thái thanh toán
    }

    // Cleanup sau mỗi lần kiểm thử
    protected function tearDown(): void
    {
        // Cleanup nếu cần (ví dụ: xóa dữ liệu kiểm thử)
    }
}
