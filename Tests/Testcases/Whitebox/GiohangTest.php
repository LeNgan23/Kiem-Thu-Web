<?php
use PHPUnit\Framework\TestCase;

class GiohangTest extends TestCase
{
    private $giohang;

    protected function setUp(): void
    {
        // Tạo mock nhưng giữ nguyên phương thức `thankyou`
        $this->giohang = $this->getMockBuilder(Giohang::class)
                            ->onlyMethods(['load', 'session', 'email', 'parser', 'Morder', 'Mcustomer', 'Mprovince', 'Mdistrict'])
                            ->getMock();
    }


    public function testSendThankYouEmail()
    {
        // Giả lập session
        $mockSession = [
            'info-customer' => [
                'id' => 1,
                'email' => 'test@example.com',
                'fullname' => 'Test User'
            ]
        ];
        $this->giohang->session = $mockSession;
    
        // Giả lập dữ liệu mô hình
        $this->giohang->Morder = $this->createMock(Morder::class);
        $this->giohang->Mcustomer = $this->createMock(Mcustomer::class);
        $this->giohang->Mprovince = $this->createMock(Mprovince::class);
        $this->giohang->Mdistrict = $this->createMock(Mdistrict::class);
    
        // Kiểm tra gửi email
        $result = $this->giohang->thankyou(); // Gọi trực tiếp phương thức
        $this->assertTrue($result); // Kiểm tra kết quả trả về
    }
    
}
