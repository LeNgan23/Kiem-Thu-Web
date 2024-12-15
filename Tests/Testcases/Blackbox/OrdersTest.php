<?php
use PHPUnit\Framework\TestCase;

class OrdersTest extends TestCase {
    private $ordersMock;
    private $orderDetailsMock;
    private $sessionMock;

    protected function setUp(): void {
        // Mock các model cần thiết
        $this->ordersMock = $this->createMock(Morders::class);
        $this->orderDetailsMock = $this->createMock(Morderdetail::class);
        $this->sessionMock = $this->createMock(CI_Session::class);

        // Tải session giả lập
        $CI =& get_instance();
        $CI->session = $this->sessionMock;
    }

    /** @test */
    public function testCancelOrder() {
        $orderId = 1;

        // Giả lập đơn hàng có trạng thái 0
        $mockOrder = ['id' => $orderId, 'status' => 0];
        $this->ordersMock->method('orders_detail')->willReturn($mockOrder);

        $this->ordersMock->expects($this->once())
                         ->method('orders_update')
                         ->with(['status' => 4], $orderId);

        $updatedOrder = $this->ordersMock->orders_detail($orderId);
        $this->assertEquals(4, $updatedOrder['status']);
    }

    /** @test */
    public function testTrashOrderInvalidStatus() {
        $orderId = 1;

        // Giả lập đơn hàng với trạng thái 1 (đang giao)
        $mockOrder = ['id' => $orderId, 'status' => 1, 'orderCode' => 'ORDER001'];
        $this->ordersMock->method('orders_detail')->willReturn($mockOrder);

        $this->expectExceptionMessage('Đơn hàng ORDER001 đang được giao, không thể lưu !');
        
        $this->ordersMock->trash($orderId);
    }

    public function testApproveOrder() {
        // Chuẩn bị đầu vào và kết quả mong đợi
        $orderId = 1;
        $orderDetail = ['status' => 0]; // Trạng thái ban đầu: Chưa duyệt
        $expectedData = ['status' => 1]; // Kết quả mong đợi: Đã duyệt

        $this->ordersMock->method('orders_detail')->with($orderId)->willReturn($orderDetail);
        $this->ordersMock->expects($this->once())
                         ->method('orders_update')
                         ->with($expectedData, $orderId);

        // Kiểm tra chuyển hướng
        $this->expectOutputRegex('/redirect\(\'admin\/orders\',\'refresh\'\)/');

        // Gọi phương thức và kiểm tra kết quả
        $orders = new Orders();
        $orders->Morders = $this->ordersMock;
        $orders->status($orderId);
    }

    public function testConfirmPayment() {
        // Chuẩn bị đầu vào và kết quả mong đợi
        $orderId = 2;
        $orderDetail = ['status' => 1]; // Trạng thái ban đầu: Đã duyệt
        $orderProducts = [
            ['productid' => 101, 'count' => 2],
            ['productid' => 102, 'count' => 3]
        ]; // Chi tiết sản phẩm trong đơn hàng

        $this->ordersMock->method('orders_detail')->with($orderId)->willReturn($orderDetail);
        $this->ordersMock->expects($this->once())
                         ->method('orders_update')
                         ->with(['status' => 2], $orderId);
        $this->orderDetailsMock->method('orderdetail_orderid')->with($orderId)->willReturn($orderProducts);

        // Không cần cập nhật số lượng sản phẩm nữa, nên loại bỏ các đoạn sau

        // Kiểm tra chuyển hướng
        $this->expectOutputRegex('/redirect\(\'admin\/orders\',\'refresh\'\)/');

        // Gọi phương thức và kiểm tra kết quả
        $orders = new Orders();
        $orders->Morders = $this->ordersMock;
        $orders->Morderdetail = $this->orderDetailsMock;
        $orders->status($orderId);
    }
}
