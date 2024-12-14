<?php

class DangnhapCest
{
    public function testDangNhapSuccess(ApiTester $I)
    {
        $I->sendPOST('/dangnhap', [
            'username' => 'testuser',
            'password' => '123456',
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['status' => 'success']);
    }

    public function testDangNhapFail(ApiTester $I)
    {
        $I->sendPOST('/dangnhap', [
            'username' => 'wronguser',
            'password' => 'wrongpassword',
        ]);
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['status' => 'fail']);
    }

    public function testDangKy(ApiTester $I)
    {
        $I->sendPOST('/dangky', [
            'username' => 'newuser',
            'name' => 'New User',
            'password' => '123456',
            're_password' => '123456',
            'email' => 'newuser@example.com',
            'phone' => '123456789',
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['status' => 'success']);
    }
}
