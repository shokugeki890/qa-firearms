<?php
class TransactionRepository
{
    private PDO $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function tambahBarang($userId, $productId, $quantity)
    {
        $stmt = $this->pdo->prepare("INSERT INTO transaction (user_id, product_id, quantity, status) VALUES (?, ?, ?, 'cart')");
        return $stmt->execute([$userId, $productId, $quantity]);
    }
    public function jumlahKeranjangBarang($userId)
    {
        $stmt = $this->pdo->prepare("SELECT SUM(quantity) FROM transaction WHERE user_id = ? AND status = 'cart'");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }
}
