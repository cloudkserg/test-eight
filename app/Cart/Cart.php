<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 19.02.18
 * Time: 18:35
 */

namespace App\Cart;


use App\Product;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;

class Cart
{
    const CART_SESSION_KEY = 'cart';



    /**
     * @return CartProduct[]
     */
    public function getProducts()
    {
        return session()->get(self::CART_SESSION_KEY, []);
    }

    public function addProduct(Product $product, int $qty)
    {
        $products = $this->getProducts();
        $products[$product->id] = new CartProduct($product, $qty);
        $this->save($products);

    }

    private function save(array $products)
    {
        session()->put(self::CART_SESSION_KEY, $products);
    }



}
