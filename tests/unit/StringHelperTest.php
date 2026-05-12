<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

require_once 'src/StringHelper.php';
class StringHelperTest extends TestCase
{
    #[DataProvider('slugProvider')]
    public function testSlugify($input, $output)
    {
        $helper = new StringHelper();
        $this->assertEquals($output, $helper->slugify($input));
    }
    #[DataProvider('truncateProvider')]
    public function testTruncate($input, $limit, $output)
    {
        $helper = new StringHelper();
        $this->assertEquals($output, $helper->truncate($input, $limit));
    }
    public static function slugProvider(): array
    {
        return [
            'simple' => ['Laras Panjang', 'laras-panjang'],
            'huruf_besar' => ['LARAS PANJANG', 'laras-panjang'],
            'simbol' => ['Laras & Panjang!', 'laras---panjang'],
            'banyak_spasi' => [' Laras Panjang ', 'laras-panjang'],
            'angka' => ['12 Laras Panjang', '12-laras-panjang'],
            'titik_koma' => ['Laras; Panjang.', 'laras--panjang'],
            'kosong' => ['', ''],
            'strip_ganda' => ['Laras---Panjang', 'laras---panjang'],
            'aneh' => ['!@#$%', ''],
            'campur' => ['100% Laras & Panjang!', '100--laras---panjang'],
        ];
    }
    public static function truncateProvider(): array
    {
        return [
            'pendek' => ['Laras', 10, 'Laras'],
            'pas' => ['Laras Panj', 10, 'Laras Panj'],
            'potong_sedikit' => ['Laras panjang', 10, 'Laras panj...'],
            'limit_kecil' => ['Laras panjang', 4, 'Lara...'],
            'limit_nol' => ['Laras panjang', 0, '...'],
            'teks_kosong' => ['', 10, ''],
            'limit_besar' => ['Laras panjang', 100, 'Laras panjang'],
            'spasi_akhir' => ['Laras panj ', 10, 'Laras panj...'],
            'angka_string' => ['1234567890', 5, '12345...'],
            'emoji' => ['Laras panjang 🥰', 10, 'Laras panj...'],
        ];
    }
}
