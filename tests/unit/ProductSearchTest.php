<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

require_once 'src/ProductSearch.php';
class ProductSearchTest extends TestCase
{
    private static array $gudang = [
        ['id' => 1, 'name' => 'R-15 Tactical Rifle', 'price' => 12000],
        ['id' => 2, 'name' => 'RP9 9mm Pistol', 'price' => 4000],
        ['id' => 3, 'name' => 'R-700 Bolt Action', 'price' => 9000],
        ['id' => 4, 'name' => 'RS12 Tactical Shotgun', 'price' => 7000],
    ];
    #[DataProvider('searchProvider')]
    public function testPencarian($keywoard, $min, $max, $jumlah)
    {
        $search = new ProductSearch();
        $hasil = $search->search(self::$gudang, $keywoard, $min, $max);
        $this->assertCount($jumlah, $hasil);
    }
    public static function searchProvider(): array
    {
        return [
            'cari_pistol' => ['Pistol', 0, 999999, 1],
            'cari_rifle' => ['rifle', 0, 999999, 1],
            'cari_smg' => ['Smg', 0, 999999, 0],
            'kosong' => ['', 0, 999999, 4],
            'harga_murah' => ['', 0, 5000, 1],
            'harga_menengah' => ['', 5000, 10000, 2],
            'harga_mahal' => ['', 10000, 50000, 1],
            'harga_kemahalan' => ['', 50000, 100000, 0],
            'pistol_murah' => ['Pistol', 0, 5000, 1],
            'rifle_mahal' => ['Rifle', 10000, 50000, 1],
            'shotgun_pas' => ['Shotgun', 5000, 10000, 1],
            'cari_r' => ['R', 0, 99999, 4],
        ];
    }
}
