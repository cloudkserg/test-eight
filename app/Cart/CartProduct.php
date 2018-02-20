<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 19.02.18
 * Time: 18:37
 */

namespace App\Cart;


use App\Product;

class CartProduct
{

    public $productId;
    public $qty;

    public function __construct(Product $product, int $qty)
    {
        $this->productId = $product->id;
        $this->qty = $qty;
    }


}