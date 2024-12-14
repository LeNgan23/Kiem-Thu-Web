<?php
use \Codeception\Util\Locator;
require_once __DIR__ . './Calculator.php';
class CartTest extends \Codeception\Test\Unit
{
    protected $tester;

    // Mock session
    protected $session;

    public function _before()
    {
        // Mock the session object
        $this->session = Stub::makeEmpty('CodeIgniter\Session\Session');
    }

    public function testAddProductToCartWhenEmpty()
    {
        // Giả sử chúng ta gửi POST request với ID sản phẩm
        $_POST['id'] = 123;

        // Gọi phương thức addcart
        $cart = new CartController();  // Thay 'CartController' bằng tên controller thực tế
        $cart->addcart();

        // Kiểm tra xem giỏ hàng đã được cập nhật chưa
        $cartData = $this->session->userdata('cart');
        $this->assertArrayHasKey(123, $cartData);
        $this->assertEquals(1, $cartData[123]);
    }

    public function testAddProductToCartWhenProductExists()
    {
        // Giả sử chúng ta gửi POST request với ID sản phẩm
        $_POST['id'] = 123;

        // Thiết lập giỏ hàng đã có sản phẩm
        $existingCart = [123 => 1];
        $this->session->set_userdata('cart', $existingCart);

        // Gọi phương thức addcart
        $cart = new CartController();  // Thay 'CartController' bằng tên controller thực tế
        $cart->addcart();

        // Kiểm tra xem số lượng của sản phẩm trong giỏ đã được tăng lên
        $cartData = $this->session->userdata('cart');
        $this->assertArrayHasKey(123, $cartData);
        $this->assertEquals(2, $cartData[123]); // Sản phẩm 123 phải có số lượng = 2
    }
}
