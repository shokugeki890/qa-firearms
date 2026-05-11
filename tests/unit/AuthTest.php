<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

require_once 'src/AuthManager.php';

class AuthTest extends TestCase
{
    #[DataProvider('passwordProvider')]
    public function testValidasiPassword($password, $harapan)
    {
        $auth = new AuthManager();
        $this->assertEquals($harapan, $auth->passwordAman($password));
    }
    public static function passwordProvider(): array
    {
        return [
            'password_pendek' => ['123', false],
            'tanpa_angka' => ['passwordku', false],
            'password_aman' => ['password123', true],
            'kosong' => ['', false],
        ];
    }
}
