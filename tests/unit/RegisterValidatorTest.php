<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

require_once 'src/RegisterValidator.php';
class RegisterValidatorTest extends TestCase
{
    #[DataProvider('registerProvider')]
    public function testValidasi($username, $email, $password, $confirm, $jumlahError)
    {
        $validator = new RegisterValidator();
        $errors = $validator->validate($username, $email, $password, $confirm);
        $this->assertCount($jumlahError, $errors);
    }
    public static function registerProvider(): array
    {
        return [
            'berhasil' => ['rifqi', 'rifqi@gmail.com', 'rifqi123', 'rifqi123', 0],
            'username_pendek' => ['rif', 'rifqi@gmail.com', 'rifqi123', 'rifqi123', 1],
            'username_panjang' => ['rifqi_hafidh_suryana_latihan_leg_day_biar_bool_aku_pulen', 'rifqi@gmail.com', 'rifqi123', 'rifqi123', 2],
            'username_simbol' => ['12!#@!', 'rifqi@gmail.com', 'rifqi123', 'rifqi123', 1],
            'username_spasi' => ['rifqi hafidh suryana', 'rifqi@gmail.com', 'rifqi123', 'rifqi123', 1],
            'email_kosong' => ['rifqi', '', 'rifqi123', 'rifqi123', 2],
            'email_tanpa_at' => ['rifqi', 'rifqigmail.com', 'rifqi123', 'rifqi123', 1],
            'email_tanpa_dot' => ['rifqi', 'rifqi@gmail', 'rifqi123', 'rifqi123', 1],
            'email_spasi' => ['rifqi', 'rifqi @gmail.com', 'rifqi123', 'rifqi123', 2],
            'email_tanpa_com' => ['rifqi', 'rifqi@gmail.', 'rifqi123', 'rifqi123', 1],
            'email_simbol' => ['rifqi', '12!#@!@gmail.com', 'rifqi123', 'rifqi123', 1],
            'password_gagal' => ['rifqi', 'rifqi@gmail.com', 'rifqi123', 'wali123', 1],
            'password_pendek' => ['rifqi', 'rifqi@gmail.com', 'rif', 'rif', 1],
            'password_kosong' => ['rifqi', 'rifqi@gmail.com', '', '', 1],
            'password_konfirmasi' => ['rifqi', 'rifqi@gmail.com', 'rifqi123', '', 1],
            'semua_salah' => ['rif', 'rifqi gmail', 'rif', 'qi', 5],
        ];
    }
}
