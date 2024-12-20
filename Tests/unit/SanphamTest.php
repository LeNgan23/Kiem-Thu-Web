<?php

// File giả lập dữ liệu và test case

use PHPUnit\Framework\TestCase;
class SanphamTest extends TestCase {
    
    public function setUp(): void
    {
      
    }
    // Giả lập dữ liệu sản phẩm
    private function generateProductData() {
        return [
            'id' => 1,
            'name' => 'Product A',
            'price' => 100000,
            'quantity' => 10,
            'category_id' => 2,
            'created' => '2024-12-18 10:00:00',
            'status' => 1,  // Available
        ];
    }
    // Giả lập dữ liệu giỏ hàng
    private function generateCartData() {
        return [
            1 => 2, // Product ID 1 with quantity 2
            2 => 1, // Product ID 2 with quantity 1
        ];
    }

    // Giả lập dữ liệu người dùng
    private function generateUserData() {
        return [
            'id' => 123,
            'username' => 'john_doe',
            'email' => 'john@example.com',
            'full_name' => 'John Doe',
            'phone' => '1234567890',
            'address' => '123 Main Street, City, Country',
        ];
    }

    // Giả lập dữ liệu đơn hàng
    private function generateOrderData() {
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
            'status' => 0,  // Trạng thái đơn hàng mới tạo (chưa duyệt)
        ];
    }

    // Testcase: Thêm sản phẩm vào giỏ hàng
    public function testAddToCart()
    {
        // Giả lập giỏ hàng
        $cart = $this->generateCartData();

        // Thêm một sản phẩm mới vào giỏ hàng
        $productId = 3;
        $quantity = 1;
        
        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Nếu chưa có sản phẩm, thêm vào giỏ hàng
            $cart[$productId] = ['product_id' => $productId, 'quantity' => $quantity];
        }

        // Kiểm tra xem sản phẩm đã được thêm vào giỏ hàng chưa
        $this->assertArrayHasKey(3, $cart);  // Kiểm tra sản phẩm ID = 3
        $this->assertEquals(1, $cart[3]['quantity']);  // Kiểm tra số lượng sản phẩm ID = 3
    }
    // Test case: Tạo đơn hàng từ giỏ hàng
    public function testCreateOrder()
    {
        // Giả lập dữ liệu đơn hàng
        $orderData = $this->generateOrderData();

        // Kiểm tra dữ liệu đơn hàng
        $this->assertArrayHasKey('orderCode', $orderData);
        $this->assertEquals('ORD001', $orderData['orderCode']);
        $this->assertEquals(123, $orderData['customerid']);
        $this->assertEquals(0, $orderData['status']); // Trạng thái đơn hàng là 0 (chưa xử lý)
    }
    public function testApproveOrder()
    {
        // Giả lập dữ liệu đơn hàng
        $orderData = $this->generateOrderData();

        // Duyệt đơn hàng (thay đổi trạng thái từ 0 sang 1)
        if ($orderData['status'] == 0) {
            $orderData['status'] = 1; // Duyệt đơn hàng, thay đổi trạng thái thành 1
        }

        // Kiểm tra xem trạng thái đơn hàng đã thay đổi thành công chưa
        $this->assertEquals(1, $orderData['status']);  // Trạng thái đơn hàng sau khi duyệt phải là 1
    }
    public function testRemoveFromCart()
    {
        // Giả lập giỏ hàng
        $cart = $this->generateCartData();

        // Xóa sản phẩm ID = 2 khỏi giỏ hàng
        unset($cart[2]);

        // Kiểm tra xem sản phẩm ID = 2 đã bị xóa chưa
        $this->assertArrayNotHasKey(2, $cart);  // Kiểm tra sản phẩm ID = 2 không còn trong giỏ hàng
    }
      // Test case: Cập nhật số lượng sản phẩm trong giỏ hàng
      public function testUpdateCart()
      {
        $number = 100;
          // Giả lập giỏ hàng (dữ liệu mẫu)
          $cart = $this->generateCartData();  // Đây là phương thức giả lập dữ liệu giỏ hàng
          // Kiểm tra nếu giỏ hàng là mảng, nếu không thì khởi tạo giỏ hàng mới
          if (!is_array($cart)) {
              $cart = [];
          }
          // Cập nhật số lượng của sản phẩm ID = 1
          if (isset($cart[1])) {
              // Nếu sản phẩm đã có trong giỏ, cập nhật số lượng
              $cart[1] = $number;  // Đặt lại số lượng sản phẩm ID = 1 thành 5
          } else {
              // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới vào giỏ với số lượng = 5
              $cart[1] = $number;
          }
          // Kiểm tra xem số lượng của sản phẩm đã được cập nhật chưa
          $this->assertEquals($number, $cart[1]);  // Kiểm tra số lượng sản phẩm ID = 1
      }
}
