<?php
class Formatter
{
    public function rupiah(float $angka): string
    {
        return "Rp " . number_format($angka, 0, ',', '.');
    }
}
