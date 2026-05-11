<?php

use PHPUnit\Framework\TestCase;

require_once 'src/TransactionRepository.php';

class TransactionTest extends TestCase
{
    private PDO $pdo;
    private $repo;
    protected function setUp(): void
    {
        $host = 'mysql';
        $database = 'test_rhys_firearms';
        $username = 'root';
        $password = 'password';

        $this->pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $this->repo = new TransactionRepository($this->pdo);
        $this->pdo->exec("DELETE FROM transaction");
    }
    public function testSimpanDatabase()
    {
        $this->repo->tambahBarang(1, 1, 5);
        $jumlah = $this->repo->jumlahKeranjangBarang(1);
        $this->assertEquals(5, $jumlah);
    }
}
