<?php
class CartManager
{
    public function hitungTotal(array $cart_items): float
    {
        $total = 0;
        foreach ($cart_items as $item) {
            if ($item['quantity'] > 0) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        return $total;
    }
    public function hitungJumlahBarang(array $cart_items): int
    {
        $count = 0;
        foreach ($cart_items as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
    public function tambahBarang(array $items, int $stokAman, int $jumlahDiminta): bool{
        if ($jumlahDiminta > $stokAman){
            return false;
        }
        if($jumlahDiminta <= 0){
            return false;
        }
        return true;
    }
}
