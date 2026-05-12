<?php

use PHPUnit\Framework\Attributes\DataProvider;

require_once 'tests/integration/DatabaseTest.php';
require_once 'src/OrderRepository.php';

class OrderRepositoryTest extends DatabaseTest
{
    protected PDO $pdo;
    private OrderRepository $repo;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new OrderRepository($this->pdo);
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->pdo->exec("DELETE FROM transaction");
        $this->pdo->exec("DELETE FROM products");
        $this->pdo->exec("DELETE FROM users");
        $this->pdo->exec("INSERT INTO users (id, username, email, password) VALUES (1, 'admin', 'admin@gmail.com', 'admin123')");
        $this->pdo->exec("INSERT INTO products (id, name, type, price, stock, category_id, team_id) VALUES (1, 'Rifle', 'firearms', 5000, 10, 1, 1)");
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }
    public function testBeliAman()
    {
        $this->assertTrue($this->repo->createOrder(1, 1, 3));
        $stok = $this->pdo->query("SELECT stock FROM products WHERE id = 1")->fetchColumn();
        $this->assertEquals(7, $stok);
    }
    public function testBeliPenghabisan()
    {
        $this->assertTrue($this->repo->createOrder(1, 1, 10));
        $stok = $this->pdo->query("SELECT stock FROM products WHERE id = 1")->fetchColumn();
        $this->assertEquals(0, $stok);
    }
    public function testBeliGagal()
    {
        $this->assertFalse($this->repo->createOrder(1, 1, 11));
    }
    public function testBeliProdukKosong()
    {
        $this->assertFalse($this->repo->createOrder(1, 99, 1));
    }
    public function testBeliNol()
    {
        $this->assertTrue($this->repo->createOrder(1, 1, 0));
        $stok = $this->pdo->query("SELECT stock FROM products WHERE id = 1")->fetchColumn();
        $this->assertEquals(10, $stok);
    }
    public function testDataTersimpan()
    {
        $this->repo->createOrder(1, 1, 2);
        $count = $this->pdo->query("SELECT COUNT(*) FROM transaction")->fetchColumn();
        $this->assertEquals(1, $count);
    }
    public function testDetailTransaksi()
    {
        $this->repo->createOrder(1, 1, 5);
        $trx = $this->pdo->query("SELECT * FROM transaction LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals(1, $trx['user_id']);
        $this->assertEquals(5, $trx['quantity']);
    }
    public function testRollBack()
    {
        $this->assertFalse($this->repo->createOrder(99, 1, 2));
        $stmt = $this->pdo->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt->execute([1]);
        $stok = $stmt->fetchColumn();
        $this->assertNotFalse($stok, "Produk id 1 tidak ada");
        $this->assertEquals(8, (int)$stok);
    }
    public function testBeliDuaKali()
    {
        $this->repo->createOrder(1, 1, 2);
        $this->repo->createOrder(1, 1, 3);
        $stok = $this->pdo->query("SELECT stock FROM products WHERE id = 1")->fetchColumn();
        $this->assertEquals(5, $stok);
    }
    public function testBanyakUserBeli()
    {
        $this->pdo->exec("INSERT INTO users (id, username, email, password) VALUES (2, 'rifqi', 'rifqi@gmail.com', 'rifqi123')");
        $this->repo->createOrder(1, 1, 1);
        $this->repo->createOrder(2, 1, 1);
        $count = $this->pdo->query("SELECT COUNT(*) FROM transaction")->fetchColumn();
        $this->assertEquals(2, $count);
    }
    #[DataProvider('caseProvider')]
    public function testCasesProvider($uId, $pId, $qty, $expected)
    {
        $this->assertEquals($expected, $this->repo->createOrder($uId, $pId, $qty));
    }
    public static function caseProvider(): array
    {
        return [
            'product_minus' => [1, -1, 1, false],
            'qty_minus' => [1, 1, -5, false],
            'user_kosong' => [0, 1, 1, false],
            'stok_pas_pasan' => [1, 1, 10, true],
            'stok_kurang_satu' => [1, 1, 11, false],
            'produk_kosong' => [1, 1, 0, true],
            'id_user_kegedean' => [9999, 1, 1, false],
            'id_produk_kegedean' => [1, 9999, 1, false],
            'qty_kegedean' => [1, 1, 10000, false],
            'transaksi_aman' => [1, 1, 1, true],
        ];
    }
}
