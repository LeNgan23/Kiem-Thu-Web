<?php
// Thêm sản phẩm vào giỏ hàng (addcart): Đảm bảo sản phẩm được thêm đúng cách vào session.
// Cập nhật số lượng sản phẩm trong giỏ (update): Kiểm tra việc thay đổi số lượng sản phẩm có đúng không.
// Xóa sản phẩm khỏi giỏ hàng (remove): Đảm bảo sản phẩm bị xóa chính xác.

class SanphamTest extends \Codeception\Test\Unit
{
    protected $tester;

    protected function _before()
    {
        $this->tester = new \Frontend\Sanpham(); // Khởi tạo đối tượng Sanpham controller
    }

    // Kiểm tra chức năng thêm sản phẩm vào giỏ
    public function testAddToCart()
    {
        $cart = ['1' => 1];
        $this->tester->addcart(); // Giả sử nó lấy dữ liệu từ $_POST['id']

        // Kiểm tra rằng sản phẩm đã được thêm vào giỏ
        $this->assertEquals($cart, $this->tester->session->userdata('cart'));
    }

    // Kiểm tra chức năng cập nhật sản phẩm trong giỏ
    public function testUpdateCart()
    {
        $cart = ['1' => 2];
        $this->tester->update(); // Giả sử nó lấy dữ liệu từ $_POST['id'] và $_POST['sl']

        // Kiểm tra rằng số lượng đã được cập nhật trong giỏ
        $this->assertEquals($cart, $this->tester->session->userdata('cart'));
    }

    // Kiểm tra chức năng xóa sản phẩm khỏi giỏ
    public function testRemoveFromCart()
    {
        $cart = [];
        $this->tester->remove(); // Giả sử nó lấy dữ liệu từ $_POST['id']

        // Kiểm tra rằng sản phẩm đã bị xóa khỏi giỏ
        $this->assertEquals($cart, $this->tester->session->userdata('cart'));
    }
}
