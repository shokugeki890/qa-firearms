<?php

use PHPUnit\Framework\TestCase;
require_once 'src/ProductRepository.php';

abstract class DatabaseTest extends TestCase
{
    private ProductRepository $repo;
    protected PDO $pdo;
    #[Override]
    protected function setUp(): void
    {
        $host = 'mysql';
        $database = 'test_rhys_firearms';
        $username = 'root';
        $password = 'password';

        $this->pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        parent::setUp();
        $this->repo = new ProductRepository($this->pdo);
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->pdo->exec("DELETE FROM transaction");
        $this->pdo->exec("DELETE FROM order_items");
        $this->pdo->exec("DELETE FROM products");
        $this->pdo->exec("INSERT IGNORE INTO teams (id, name) VALUES (1, 'Team Alpha')");
        $this->pdo->exec("INSERT IGNORE INTO category (id, name) VALUES (1, 'General')");
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
        $this->pdo->beginTransaction();
    }
    #[Override]
    protected function tearDown(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }
}
