<?php

use PHPUnit\Framework\TestCase;

require_once 'src/CartManager.php';

class CartTest extends TestCase
{
    public function testTotalHarga()
    {
        $manager = new CartManager();
        $items = [
            ['price' => 100, 'quantity' => 2],
            ['price' => 50, 'quantity' => 1],
        ];
        $total = $manager->hitungTotal($items);
        $this->assertEquals(250, $total);
    }
    public function testKeranjangKosong()
    {
        $manager = new CartManager();
        $items = [];

        $total = $manager->hitungTotal($items);
        $jumlah = $manager->hitungJumlahBarang($items);

        $this->assertEquals(0, $total);
        $this->assertEquals(0, $jumlah);
    }
    public function testJumlahBarangMinus()
    {
        $manager = new CartManager();
        $items = [
            ['price' => 10000, 'quantity' => 1],
            ['price' => 5000, 'quantity' => -1],
        ];
        $total = $manager->hitungTotal($items);
        $this->assertEquals(10000, $total);
    }
    public function testGagalTambahBarang()
    {
        $manager = new CartManager();
        $hasil = $manager->tambahBarang([], 5, 10);
        $this->assertFalse($hasil, "Stok ada 5, permintaan 10");
    }
    public function testAmanTambahBarang()
    {
        $manager = new CartManager();
        $hasil = $manager->tambahBarang([], 10, 2);
        $this->assertTrue($hasil);
    }
}
