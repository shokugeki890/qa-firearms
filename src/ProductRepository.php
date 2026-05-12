<?php
class ProductRepository
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function save(array $data): bool
    {
        $sql = "INSERT INTO products (name, price, stock, category_id, team_id) VALUES (:name, :price, :stock, :category_id, :team_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':price' => $data['price'],
            ':stock' => $data['stock'],
            ':category_id' => $data['category_id'] ?? 1,
            ':team_id' => $data['team_id'] ?? 1,
        ]);
    }
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function update(int $id, int $stock): bool
    {
        $stmt = $this->pdo->prepare("UPDATE products SET stock = ? WHERE id = ?");
        return $stmt->execute([$stock, $id]);
    }
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function search(string $category): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
