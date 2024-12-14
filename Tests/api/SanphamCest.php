<?php

class SanphamCest
{
    protected $baseUrl = '/san-pham';

    // Test thêm sản phẩm vào giỏ hàng
    public function testAddToCart(ApiTester $I)
    {
        $I->wantTo('Thêm sản phẩm vào giỏ hàng');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->baseUrl . '/addcart', ['id' => 1]); // ID sản phẩm
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('cart');
    }

    // Test cập nhật số lượng sản phẩm trong giỏ
    public function testUpdateCart(ApiTester $I)
    {
        $I->wantTo('Cập nhật số lượng sản phẩm trong giỏ');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->baseUrl . '/update', ['id' => 1, 'sl' => 2]); // Cập nhật số lượng
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('cart');
    }

    // Test xóa sản phẩm khỏi giỏ
    public function testRemoveFromCart(ApiTester $I)
    {
        $I->wantTo('Xóa sản phẩm khỏi giỏ');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST($this->baseUrl . '/remove', ['id' => 1]); // ID sản phẩm cần xóa
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('cart');
    }
}
