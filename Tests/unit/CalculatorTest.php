<?php
use \Codeception\Util\Locator;
require_once __DIR__ . './Calculator.php';
class CalculatorTest extends \Codeception\Test\Unit
{
    public function testAdd()
    {
        $calculator = new Calculator();
        $result = $calculator->add(2, 3);
        $this->assertEquals(5, $result); // Kiểm tra kết quả trả về có bằng 5 không
    }
}
