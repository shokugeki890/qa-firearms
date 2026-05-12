<?php

use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    protected PDO $pdo;
    public function testTransaksi()
    {
        $this->pdo->exec("INSERT INTO products(id,name,stock) VALUES (1, 'pistol', 10)");
        $repository = new OrderRepositroy($this->pdo);
        $repository->createOrder(userId: 1, productId: 1, qty: 3);
        $stmt = $this->pdo->query("SELECT stock FROM products WHERE id = 1");
        $stok = $stmt->fetchColumn();
        $this->assertEquals(7, $stok, "Stok harus berkurang setelah checkout");
    }
}
