<?php
class OrderCalculator
{
    public function hitungDiskon(float $total, float $persen, float $maksimal = 0): float
    {
        $potongan = $total * ($persen / 100);
        if ($maksimal > 0 && $potongan > $maksimal) {
            return $maksimal;
        }
        return $potongan;
    }
    public function hitungPajak(float $total, float $tarif = 11): float
    {
        return $total * ($tarif / 100);
    }
    public function hitungOngkir(float $beratKg, bool $luarNegri = false, float $total = 0): float
    {
        if ($total >= 50000) return 0;
        $biayaPerKg = $luarNegri ? 2000 : 1000;
        return $beratKg * $biayaPerKg;
    }
}
