<?php

class SanphamCest
{
    // Test người dùng thêm sản phẩm vào giỏ hàng
    public function testAddToCart(AcceptanceTester $I)
    {
        $I->wantTo('Thêm sản phẩm vào giỏ hàng');
        $I->amOnPage('/san-pham');
        $I->click('Add to Cart', '#product-1'); // Giả sử có nút "Add to Cart"
        $I->see('1 sản phẩm trong giỏ hàng'); // Kiểm tra giỏ hàng đã có sản phẩm
    }

    // Test người dùng cập nhật số lượng sản phẩm trong giỏ
    public function testUpdateCart(AcceptanceTester $I)
    {
        $I->wantTo('Cập nhật số lượng sản phẩm trong giỏ hàng');
        $I->amOnPage('/cart');
        $I->fillField('#product-1-quantity', '3'); // Giả sử có ô input cho số lượng
        $I->click('Cập nhật');
        $I->see('3 sản phẩm trong giỏ hàng'); // Kiểm tra số lượng đã được cập nhật
    }

    // Test người dùng xóa sản phẩm khỏi giỏ
    public function testRemoveFromCart(AcceptanceTester $I)
    {
        $I->wantTo('Xóa sản phẩm khỏi giỏ hàng');
        $I->amOnPage('/cart');
        $I->click('Remove', '#product-1'); // Giả sử có nút "Remove"
        $I->dontSee('Sản phẩm 1'); // Kiểm tra sản phẩm đã bị xóa
    }
}
