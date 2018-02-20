<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 19.02.18
 * Time: 18:25
 */

namespace App\Services;


use App\Cart\Cart;
use App\Cart\CartProduct;
use App\Order;
use App\OrderItem;
use App\Product;

class CartService
{
    /**
     * @var Cart
     */
    private $cart;
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(Cart $cart, ProductService $productService)
    {
        $this->cart = $cart;
        $this->productService = $productService;
    }


    public function addProduct(Product $product, int $qty)
    {
        $this->cart->addProduct($product, $qty);

    }

    /**
     * @return Order
     */
    public function initOrderFromCart()
    {
        $order = new Order();
        collect($this->cart->getProducts())->each(function (CartProduct $cartProduct) use (&$order) {
            $orderItem = $this->createOrderItem($cartProduct);
            $order->items[] = $orderItem;
        });
        return $order;
    }


    private function createOrderItem(CartProduct $cartProduct)
    {
        $product = $this->productService->findItemById($cartProduct->productId);

        $orderItem = new OrderItem();
        $orderItem->qty = $cartProduct->qty;
        $orderItem->product_id = $cartProduct->productId;
        $orderItem->product = $product;
        $orderItem->setPrice($product->getPrice());

        return $orderItem;

    }

}
