<?php
use PHPUnit\Framework\TestCase;

class OrderManagementTest extends TestCase
{
    protected $orderManagement;

    protected function setUp(): void
    {
        // Giả sử lớp OrderManagement có các phương thức cho các hành động
        $this->orderManagement = new OrderManagement();
    }

    public function testCancelOrder()
    {
        // Tạo đơn hàng với trạng thái "Chờ duyệt"
        $order = new Order();
        $order->setStatus('Chờ duyệt');
        $order->setId(1);

        // Kiểm tra hủy đơn
        $result = $this->orderManagement->cancelOrder($order);

        // Kiểm tra kết quả sau khi hủy
        $this->assertEquals('Đã hủy', $order->getStatus(), "Trạng thái đơn hàng không được cập nhật đúng.");

        // Tạo đơn hàng với trạng thái "Đang giao"
        $order->setStatus('Đang giao');
        $order->setId(2);

        // Cố gắng hủy đơn hàng khi đang giao
        $result = $this->orderManagement->cancelOrder($order);

        // Kiểm tra trạng thái đơn hàng (không thể hủy khi đang giao)
        $this->assertEquals('Đang giao', $order->getStatus(), "Không thể hủy đơn hàng đang giao.");
    }

    public function testDeleteOrder()
    {
        // Tạo đơn hàng với trạng thái "Đang giao"
        $order = new Order();
        $order->setStatus('Đang giao');
        $order->setId(2);

        // Cố gắng xóa đơn hàng khi đang giao
        $result = $this->orderManagement->deleteOrder($order);

        // Kiểm tra kết quả xóa
        $this->assertFalse($result, "Không thể xóa đơn hàng đang giao.");
        
        // Tạo đơn hàng đã hoàn thành
        $order->setStatus('Đã giao');

        // Thử xóa đơn hàng đã giao
        $result = $this->orderManagement->deleteOrder($order);

        // Kiểm tra kết quả xóa
        $this->assertTrue($result, "Đơn hàng đã giao nhưng vẫn không thể xóa.");
    }

    public function testApproveOrder()
    {
        // Tạo đơn hàng với trạng thái "Chờ duyệt"
        $order = new Order();
        $order->setStatus('Chờ duyệt');
        $order->setId(3);

        // Duyệt đơn hàng
        $result = $this->orderManagement->approveOrder($order);

        // Kiểm tra trạng thái sau khi duyệt
        $this->assertEquals('Đang giao', $order->getStatus(), "Trạng thái đơn hàng không được cập nhật sau khi duyệt.");
    }

    public function testCompleteOrder()
    {
        // Tạo đơn hàng với trạng thái "Đang giao"
        $order = new Order();
        $order->setStatus('Đang giao');
        $order->setId(4);

        // Xác nhận hoàn tất đơn hàng
        $result = $this->orderManagement->completeOrder($order);

        // Kiểm tra trạng thái sau khi hoàn tất
        $this->assertEquals('Đã giao', $order->getStatus(), "Trạng thái đơn hàng không được cập nhật sau khi xác nhận hoàn tất.");
    }
}
?>
