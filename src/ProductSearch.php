<?php
class ProductSearch
{
    public function search(array $products, string $keywoard = '', float $minPrice = 0, float $maxPrice = 99999): array
    {
        return array_filter($products, function ($p) use ($keywoard, $minPrice, $maxPrice) {
            $matchName = empty($keywoard) || str_contains(strtolower($p['name']), strtolower($keywoard));
            $matchPrice = $p['price'] >= $minPrice && $p['price'] <= $maxPrice;
            return $matchName && $matchPrice;
        });
    }
}
