<?php
namespace Helper;

// Here you can define custom actions
// All public methods declared in helper class will be available in $I
class CodeIgniterHelper extends \Codeception\Module
{
    // Phương thức giúp tạo dữ liệu đơn hàng
    public function generateOrderData()
    {
        return [
            'orderCode' => 'ORD001',
            'customerid' => 13,
            'orderdate' => '2024-12-18 10:00:00',
            'fullname' => 'John Doe',
            'phone' => '1234567890',
            'money' => 100000,
            'price_ship' => 5000,
            'coupon' => 0,
            'province' => 1,
            'district' => 1,
            'address' => '123 Main Street',
            'status' => 1,
        ];
    }
}
