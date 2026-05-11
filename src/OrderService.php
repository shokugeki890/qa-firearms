<?php
require_once 'src/DatabaseInterface.php';
class OrderService
{
    private DatabaseInterface $db;
    public function __construct(DatabaseInterface $databaseAsisten)
    {
        $this->db = $databaseAsisten;
    }
    public function ajukanPesanan($produkId, $jumlah)
    {
        $stokTersedia = $this->db->cekStok($produkId);
        if ($jumlah > $stokTersedia) {
            return "Stok kurang";
        }
        return "Pesanan berhasil";
    }
}
