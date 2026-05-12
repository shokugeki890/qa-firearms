<?php
use PHPUnit\Framework\TestCase;
abstract class DatabaseTest extends TestCase{
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
        $this->pdo->beginTransaction();
    }
    #[Override]
    protected function tearDown(): void
    {
        $this->pdo->rollBack();
    }
}