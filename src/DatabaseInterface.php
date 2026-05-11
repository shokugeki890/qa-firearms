<?php
interface DatabaseInterface
{
    public function cekStok(int $produkId): int;
}
