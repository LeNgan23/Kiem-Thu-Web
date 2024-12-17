<?php
use Codeception\Util\HttpCode;

class ExampleApiTestCest
{
    public function _before(ApiTester $I)
    {
        // Code will run before each test
    }

    public function testGetUsers(ApiTester $I)
    {
        $I->sendGET('/users');
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseContainsJson(['name' => 'John Doe']);
    }
}
