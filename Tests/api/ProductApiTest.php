<?php
namespace api;

use \Codeception\Actor;

class ProductApiTest extends \Codeception\tests\api
{
    public function testGetProductList(ApiTester $I)
    {
        $I->sendGET('/api/v1/products');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['product_name' => 'Sample Product']);
    }

    public function testAddProduct(ApiTester $I)
    {
        $I->sendPOST('/api/v1/products', ['name' => 'New Product', 'price' => 100]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseContains('New Product');
    }
}
