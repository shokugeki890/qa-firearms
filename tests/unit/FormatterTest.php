<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

require_once 'src/Formatter.php';
class FormatterTest extends TestCase
{
    #[DataProvider('rupiahData')]
    public function testFormatRupiah($inputAngka, $ouputAngka)
    {
        $formatter = new Formatter();
        $hasil = $formatter->rupiah($inputAngka);
        $this->assertEquals($ouputAngka, trim($hasil));
    }
    public static function rupiahData(): array
    {
        return [
            'puluhan_ribu' => [10000, 'Rp 10.000'],
            'ratusan'=>[100, 'Rp 100'],
            'jutaan'=>[1500500, 'Rp 1.500.500'],
            'nol'=>[0, 'Rp 0'],
        ];
    }
}
