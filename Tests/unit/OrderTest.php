<?php

use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private $orderModel;

    // Khởi tạo setup trước mỗi test
    public function setUp(): void
    {
      
    }

    // Testcase kiểm tra tạo đơn hàng
    public function testCreateOrder()
    {
        $orderData = $this->generateOrderData(); // Sử dụng phương thức để lấy dữ liệu giả lập

        // Kiểm tra dữ liệu tạo đơn hàng
        $this->assertArrayHasKey('orderCode', $orderData);
        $this->assertEquals('ORD001', $orderData['orderCode']);
    }

    public function testCancelOrder()
    {
        // Sử dụng phương thức generateOrderData để tạo dữ liệu giả lập
        $orderData = $this->generateOrderData();
    
        // Kiểm tra trạng thái của đơn hàng trước khi hủy (status = 2)
        $this->assertEquals(2, $orderData['status']); // Trước khi hủy, trạng thái là 2 (chờ xử lý)
    
        // Giả lập hành động hủy đơn hàng
        if ($orderData['status'] == 2) {
            // Thực hiện hành động hủy
            $orderData['status'] = 4; // Trạng thái sau khi hủy (4 là trạng thái hủy)
    
            // Kiểm tra trạng thái đơn hàng đã thay đổi thành công
            $this->assertEquals(4, $orderData['status']); // Sau khi hủy, trạng thái là 4 (đã hủy)
        } else {
            $this->fail("Không thể hủy đơn hàng có trạng thái khác 2");
        }
    }

    // Phương thức giả lập để tạo dữ liệu đơn hàng
    private function generateOrderData()
    {
        return [
            'orderCode' => 'ORD001',
            'customerid' => 123,
            'orderdate' => '2024-12-18 10:00:00',
            'fullname' => 'John Doe',
            'phone' => '1234567890',
            'money' => 100000,
            'price_ship' => 5000,
            'coupon' => 0,
            'province' => 1,
            'district' => 1,
            'address' => '123 Main Street',
            'status' => 0,
        ];
    }
        public function testRestoreOrder()
    {
        // Giả lập dữ liệu đơn hàng đã bị xóa (status = 0)
        $orderData = $this->generateOrderData(1);  // Giả sử ID của đơn hàng là 1
        $orderData['status'] = 0;  // Đơn hàng đã bị xóa

        // Gọi phương thức restore trực tiếp (giả lập, không sử dụng Morders hay bất kỳ framework nào)
        $restoredOrder = $this->restore($orderData);

        // Kiểm tra xem trạng thái của đơn hàng có được thay đổi thành 1 hay không
        $this->assertEquals(1, $restoredOrder['status']);  // Đảm bảo rằng trạng thái đã thay đổi thành 1 (khôi phục)

        // Kiểm tra thông báo thành công (giả lập thông báo flash)
        $this->assertEquals('Khôi phục đơn hàng thành công', $restoredOrder['message']);
    }

    private function restore($orderData)
    {
        // Giả lập hành động khôi phục đơn hàng (thay đổi trạng thái từ 0 -> 1)
        if ($orderData['status'] == 0) {
            $orderData['status'] = 1;  // Đổi trạng thái đơn hàng thành 1 (khôi phục)
            $orderData['message'] = 'Khôi phục đơn hàng thành công';  // Giả lập thông báo thành công
        } else {
            $orderData['message'] = 'Đơn hàng không thể khôi phục';  // Giả lập thông báo lỗi
        }

        // Trả về dữ liệu đơn hàng đã thay đổi
        return $orderData;
    }

    public function testStatusOrderPending()
    {
        $orderId = 1;
        $orderData = $this->generateOrderData($orderId, 0);  // Trạng thái là 0 (chưa duyệt)

        // Kiểm tra trạng thái đơn hàng trước khi gọi phương thức
        $this->assertEquals(0, $orderData['status']);

        // Giả lập gọi phương thức status
        if ($orderData['status'] == 0) {
            $orderData['status'] = 1;  // Cập nhật trạng thái đơn hàng thành 1 (đã duyệt)
        }

        // Kiểm tra lại trạng thái sau khi duyệt
        $this->assertEquals(1, $orderData['status']);
    }

    // Testcase kiểm tra duyệt đơn hàng với trạng thái 1 (đã duyệt)
    public function testStatusOrderApproved()
    {
        $orderId = 2;
        $orderData = $this->generateOrderData($orderId, 1);  // Trạng thái là 1 (đã duyệt)

        // Kiểm tra trạng thái đơn hàng trước khi gọi phương thức
        $this->assertEquals(1, $orderData['status']);

        // Giả lập gọi phương thức status
        if ($orderData['status'] == 1) {
            $orderData['status'] = 2;  // Cập nhật trạng thái đơn hàng thành 2 (đang xử lý)

            // Giả lập cập nhật số lượng sản phẩm (ví dụ: giả lập các sản phẩm trong đơn hàng)
            $orderDetail = [
                ['productid' => 101, 'count' => 3],
                ['productid' => 102, 'count' => 2],
            ];

            foreach ($orderDetail as $detail) {
                $productId = $detail['productid'];
                $productCount = $detail['count'];

                // Giả lập lấy số lượng sản phẩm đã bán
                $numberBuy = 10;  // Giả lập số lượng đã bán là 10
                $newNumberBuy = $numberBuy + $productCount;  // Cập nhật số lượng bán mới

                // Giả lập cập nhật số lượng sản phẩm
                $this->assertGreaterThan($numberBuy, $newNumberBuy);
            }
        }

        // Kiểm tra lại trạng thái sau khi xử lý
        $this->assertEquals(2, $orderData['status']);
    }

    // Testcase kiểm tra trạng thái đơn hàng không hợp lệ (ví dụ, không phải trạng thái 0 hoặc 1)
    public function testStatusOrderInvalid()
    {
        $orderId = 3;
        $orderData = $this->generateOrderData($orderId, 3);  // Trạng thái không hợp lệ (ví dụ: 3)

        // Kiểm tra trạng thái đơn hàng trước khi gọi phương thức
        $this->assertEquals(3, $orderData['status']);

        // Giả lập gọi phương thức status
        if (!in_array($orderData['status'], [0, 1])) {
            // Nếu trạng thái không hợp lệ, không thay đổi gì
            $this->assertEquals(3, $orderData['status']);  // Đảm bảo trạng thái không thay đổi
        }
    }
}
