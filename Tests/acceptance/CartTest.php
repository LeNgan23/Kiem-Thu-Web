<?php
namespace Acceptance;

use AcceptanceTester;

class CartTest extends AcceptanceTester
{
    public function _before(AcceptanceTester $I)
    {
        // Cleanup, xóa giỏ hàng trước khi bắt đầu mỗi test
        $I->clearSession();
    }

    public function testAddProductToEmptyCart(AcceptanceTester $I)
    {
        $I->sendPOST('/sanpham/addcart', ['id' => 123, 'quantity' => 1]);
        $I->seeInSession('cart');
        $cart = $I->grabSession('cart');
        $I->assertArrayHasKey(123, $cart);
        $I->assertEquals(1, $cart[123]);
    }
}
