<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

require_once 'src/OrderCalculator.php';

class OrderCalculatorTest extends TestCase
{
    #[DataProvider('diskonProvider')]
    public function testDiskon($total, $persen, $max, $hasil)
    {
        $calculator = new OrderCalculator();
        $this->assertEquals($hasil, $calculator->hitungDiskon($total, $persen, $max));
    }
    #[DataProvider('pajakProvider')]
    public function testPajak($total, $tarif, $hasil)
    {
        $calculator = new OrderCalculator();
        $this->assertEquals($hasil, $calculator->hitungPajak($total, $tarif));
    }
    #[DataProvider('ongkirProvider')]
    public function testOngkir($berat, $luarNegri, $total, $hasil)
    {
        $calculator = new OrderCalculator();
        $this->assertEquals($hasil, $calculator->hitungOngkir($berat, $luarNegri, $total));
    }
    public static function diskonProvider(): array
    {
        return [
            'diskon_10_persen' => [10000, 10, 0, 1000],
            'diskon_setengah' => [10000, 50, 0, 5000],
            'batas_max' => [50000, 10, 2000, 2000],
            'tidak_kena_batas' => [5000, 10, 1000, 500],
            'diskon_100_persen' => [10000, 100, 0, 10000],
            'tanpa_diskon' => [10000, 0, 0, 0],
            'tanpa_harga' => [0, 10, 0, 0],
            'max_kecil' => [1000, 10, 1, 1],
            'harga_kegedean' => [100000, 50, 0, 50000],
            'persen_desimal' => [10000, 2.5, 0, 250],
        ];
    }
    public static function pajakProvider(): array
    {
        return [
            'ppn_standar' => [10000, 11, 1100],
            'ppn_5_persen' => [10000, 5, 500],
            'ppn_barang_mahal' => [100000, 11, 11000],
            'ppn_nol' => [10000, 0, 0],
            'ga_belanja' => [0, 11, 0],
            'ppn_desimal' => [10000, 2.5, 250],
            'ppn_12_persen' => [10000, 12, 1200],
            'barang_murah' => [1000, 11, 110],
            'ppn_mahal' => [10000, 50, 5000],
            'input_float' => [5000.5, 10, 500.05],
        ];
    }
    public static function ongkirProvider(): array{
        return [
            'dalam_negri_1kg'=> [1, false, 1000, 1000],
            'dalam_negri_5kg'=> [5, false, 1000, 5000],
            'luar_negri_1kg'=> [1, true, 1000, 2000],
            'luar_negri_5kg'=> [5, true, 1000, 10000],
            'gratis_ongkir_dalam'=> [1, false, 75000, 0],
            'gratis_ongkir_luar'=> [1, true, 75000, 0],
            'tidak_gratis_ongkir'=> [1, false, 40000, 1000],
            'berat_nol'=> [0, false, 1000, 0],
            'berat_desimal'=> [2.5, false, 1000, 2500],
            'luar_negri_desimal'=> [2.5, true, 1000, 5000],
        ];
    }
}
