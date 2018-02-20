<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 20.02.18
 * Time: 0:52
 */

namespace App\Formatters;


use App\Product;

class ProductFormatter
{

    public function format(Product $product)
    {
        return [
            'id' => (int) $product->id,
            'name' => $product->name,
            'price' => $product->getPrice()
        ];
    }

}