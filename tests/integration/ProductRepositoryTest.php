<?php
require_once 'tests/integration/DatabaseTest.php';
require_once 'src/ProductRepository.php';
class ProductRepositoryTest extends DatabaseTest
{
    private ProductRepository $repo;
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new ProductRepository($this->pdo);
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->pdo->exec("TRUNCATE TABLE order_items");
        $this->pdo->exec("TRUNCATE TABLE products");
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS  = 1");
    }
    public function testSimpanProduk()
    {
        $data = ['name' => 'R-15 Tactical Rifle', 'price' => 12000, 'stock' => 50, 'category_id' => 1];
        $this->assertTrue($this->repo->save($data));
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM products");
        $this->assertEquals(1, $stmt->fetchColumn());
    }
    public function testSimpanProdukMurah()
    {
        $data = ['name' => 'Sample', 'price' => 0, 'stock' => 10, 'category_id' => 2];
        $this->assertTrue($this->repo->save($data));
    }
    public function testSimpanProdukStokBanyak()
    {
        $data = ['name' => 'RP9 9mm Pistol', 'price' => 4000, 'stock' => 999, 'category_id' => 1];
        $this->assertTrue($this->repo->save($data));
    }
    public function testCariId()
    {
        $this->pdo->exec("INSERT INTO products (id, name, price, stock, category_id, team_id) VALUES (10, 'RS12 Tactical Shotgun', 8000, 50, 1, 1)");
        $found = $this->repo->findById(10);
        $this->assertNotNull($found);
        $this->assertEquals('RS12 Tactical Shotgun', $found['name']);
    }
    public function testCariIdTidakAda()
    {
        $this->assertNull($this->repo->findById(99));
    }
    public function testCariProdukKosong()
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $this->assertEmpty($stmt->fetchAll());
    }
    public function testUpdate()
    {
        $this->pdo->exec("INSERT INTO products (id, name, price, stock, category_id, team_id) VALUES (1, 'R-10 Compact Rifle', 10000, 10, 1, 1)");
        $this->repo->update(1, 5);
        $updated = $this->repo->findById(1);
        $this->assertEquals(5, $updated['stock']);
    }
    public function testUpdateStok()
    {
        $this->pdo->exec("INSERT INTO products (id, name, price, stock, category_id, team_id) VALUES (2, 'RP45 .45 ACP Pistol', 7000, 10, 1, 1)");
        $this->repo->update(2, 0);
        $this->assertEquals(0, $this->repo->findById(2)['stock']);
    }
    public function testUpdateProdukKosong()
    {
        $status = $this->repo->update(99, 10);
        $this->assertTrue($status);
    }
    public function testHapus()
    {
        $this->pdo->exec("INSERT INTO products (id, name, price, stock, category_id, team_id) VALUES (5, 'R-700 Bolt Action', 9000, 100, 1, 1)");
        $this->repo->delete(5);
        $this->assertNull($this->repo->findById(5));
    }
    public function testHapusProdukKosong()
    {
        $this->assertTrue($this->repo->delete(88));
    }
    public function testHapusSemua()
    {
        $this->pdo->exec("INSERT INTO products (name, price, category_id, team_id) VALUES ('A', 1000, 1, 1), ('AA', 2000, 1, 1)");
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->pdo->exec("DELETE FROM transaction");
        $this->pdo->exec("DELETE FROM products");
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM products");
        $this->assertEquals(0, $stmt->fetchColumn());
    }
    public function testCari()
    {
        $this->pdo->exec("INSERT INTO products (name, category_id, price, team_id) VALUES ('RP9 9mm Pistol', 1, 4000, 1), ('R-15 Tactical Rifle', 1, 12000, 1)");
        $hasil = $this->repo->search(1);
        $this->assertCount(2, $hasil);
    }
    public function testCariKategoriKosong()
    {
        $hasil = $this->repo->search(4);
        $this->assertCount(0, $hasil);
    }
    public function testCariCaseSensitive()
    {
        $this->pdo->exec("INSERT INTO products (name, price, stock, category_id, team_id) VALUES ('R-700 BOLT ACTION', 9000, 50, 1, 1)");
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE name = ?");
        $stmt->execute(['R-700 bolt action']);
        $hasil = $stmt->fetchAll();
        $this->assertNotEmpty($hasil, "Cari nama walau huruf besar kecil");
    }
}
