<?php

use PHPUnit\Framework\TestCase;

require_once 'src/AuthService.php';
require_once 'src/UserInterface.php';
class AuthServiceTest extends TestCase
{
    public function testLoginGagal()
    {
        $mockDB = $this->createMock(UserInterface::class);
        $mockDB->method('cariUsername')->willReturn(null);
        $auth = new AuthService($mockDB);
        $this->assertFalse($auth->login('admin', 'admin123'));
    }
    public function testLoginAman()
    {
        $mockDB = $this->createMock(UserInterface::class);
        $hashPalsu = password_hash('rifqi123', PASSWORD_BCRYPT);
        $mockDB->method('cariUsername')->willReturn([
            'username' => 'rifqi', 
            'password' => $hashPalsu
        ]);
        $auth = new AuthService($mockDB);
        $this->assertTrue($auth->login('rifqi', 'rifqi123'));
    }
}
