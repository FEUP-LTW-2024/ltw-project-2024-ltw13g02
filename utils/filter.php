<?php
require_once(__DIR__ . '/../database/get_from_db.php');


function filterByCondition($products, $condition) : array {
    $f = [];
    foreach ($products as $id) {
        $product = getProduct($id);
        if ($product->getCondition() == getCondition($condition)) {
            $f[] = $id;
        }
    }
    return $f;
}

function filterByPrice($products, $minPrice, $maxPrice) : array {
    $f = [];
    foreach ($products as $id) {
        $product = getProduct($id);
        if ($minPrice != NULL && $maxPrice != NULL) {
            if ($product->price < $maxPrice && $product->price > $minPrice) {
                $f[] = $id;
            }
        }
        else if ($minPrice != NULL) {
            if ($product->price > $minPrice) {
                $f[] = $id;
            }
        }
        else if ($maxPrice != NULL) {
            if ($product->price < $maxPrice) {
                $f[] = $id;
            }
        }
    }
    return $f;
}