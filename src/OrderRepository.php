<?php
class OrderRepository
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function createOrder(int $userId, int $productId, int $qty): bool
    {
        $akuMulai = false;
        if (!$this->pdo->inTransaction()) {
            $this->pdo->beginTransaction();
            $akuMulai = true;
        }
        try {
            $stmt = $this->pdo->prepare("SELECT stock FROM products WHERE id = ? FOR UPDATE");
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$product || $product['stock'] < $qty || $qty < 0) {
                throw new Exception("Stok tidak mencukupi atau qty tidak valid");
            }
            $newStock = $product['stock'] - $qty;
            $update = $this->pdo->prepare("UPDATE products SET stock = ? WHERE id = ?");
            $update->execute([$newStock, $productId]);
            $sql = "INSERT INTO `transaction` (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $insert = $this->pdo->prepare($sql);
            $insert->execute([$userId, $productId, $qty]);
            if ($akuMulai) {
                $this->pdo->commit();
            }
            return true;
        } catch (Exception $e) {
            if ($akuMulai && $this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
    }
}
