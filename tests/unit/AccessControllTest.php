<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

require_once 'src/AccessControl.php';
class AccessControllTest extends TestCase
{
    #[DataProvider('roleProvider')]
    public function testUser()
    {
        $ac = new AccessControl();
        $userBiasa = [
            'username' => 'rifqi',
            'role' => 'customer',
        ];
        $hasil = $ac->adminDashboard($userBiasa);
        $this->assertFalse($hasil, "User tidak bisa masuk");
    }
    public function testAdmin()
    {
        $ac = new AccessControl();
        $userAdmin = [
            'username' => 'admin',
            'role' => 'admin',
        ];
        $hasil = $ac->adminDashboard($userAdmin);
        $this->assertTrue($hasil);
    }
    public static function roleProvider(): array
    {
        return [
            'admin' => ['admin', true],
            'customer' => ['customer', false],
            'guest' => ['guest', false],
            'no_role' => ['', false],
        ];
    }
}
