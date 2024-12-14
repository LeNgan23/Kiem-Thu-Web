<?php

class DangnhapCest
{
    public function testDangNhap(AcceptanceTester $I)
    {
        $I->amOnPage('/dangnhap');
        $I->fillField('username', 'testuser');
        $I->fillField('password', '123456');
        $I->click('Đăng nhập');
        $I->see('Chào mừng, Test User', '.welcome-message');
    }

    public function testDangKy(AcceptanceTester $I)
    {
        $I->amOnPage('/dangky');
        $I->fillField('username', 'newuser');
        $I->fillField('name', 'New User');
        $I->fillField('password', '123456');
        $I->fillField('re_password', '123456');
        $I->fillField('email', 'newuser@example.com');
        $I->fillField('phone', '123456789');
        $I->click('Đăng ký');
        $I->see('Đăng ký thành công!', '.success-message');
    }
}
