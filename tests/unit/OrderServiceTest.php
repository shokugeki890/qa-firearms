<?php

use PHPUnit\Framework\TestCase;

require_once 'src/OrderService.php';
require_once 'src/OrderService.php';
class OrderServiceTest extends TestCase
{
    public function testCheckoutGagal()
    {
        $dbPalsu = $this->createMock(DatabaseInterface::class);
        $dbPalsu->expects($this->once())->method('cekStok')->willReturn(0);
        $service = new OrderService($dbPalsu);
        $hasil = $service->ajukanPesanan(1, 5);
        $this->assertEquals("Stok kurang", $hasil);
    }
    public function testCheckoutAman(){
        $dbPalsu = $this->createMock(DatabaseInterface::class);
        $dbPalsu->expects($this->once())->method('cekStok')->willReturn(10);
        $service = new OrderService($dbPalsu);
        $hasil = $service->ajukanPesanan(1, 2);
        $this->assertEquals("Pesanan berhasil", $hasil);
    }
}
