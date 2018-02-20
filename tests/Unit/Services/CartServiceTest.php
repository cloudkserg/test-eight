<?php

namespace Tests\Unit\Services;

use App\Cart\Cart;
use App\Order;
use App\Product;
use App\Services\CartService;
use App\Services\ProductService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInitOrderFromCartWithOneProduct()
    {
        $product = new Product();
        $product->id = 1;
        $product->name = 'Iphone';
        $product->setPrice(77);
        $productService = $this->createMock(ProductService::class);
        $productService->method('findItemById')
            ->willReturn($product);

        $cart = new Cart();
        $cart->addProduct($product, 2);


        $cartService = new CartService($cart, $productService);
        $order = $cartService->initOrderFromCart();

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($order->getTotalPrice(), 77*2);
        $this->assertCount(1, $order->items);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInitOrderFromCartWithZeroProduct()
    {
        $product = new Product();
        $product->name = 'Iphone';
        $product->price = 77;
        $productService = $this->createMock(ProductService::class);
        $productService->method('findItemById')
            ->willReturn($product);

        $cart = new Cart();

        $cartService = new CartService($cart, $productService);
        $order = $cartService->initOrderFromCart();

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($order->getTotalPrice(), 0);
        $this->assertCount(0, $order->items);
    }

    public function testAddProduct()
    {
        $product = new Product();
        $product->name = 'Iphone';
        $product->id = 1;
        $product->setPrice(1);

        $product2 = new Product();
        $product2->id = 2;
        $product2->name = 'Andorid';
        $product2->setPrice(2);

        $cart = new Cart();
        $productService = $this->createMock(ProductService::class);
        $productService->method('findItemById')
            ->will($this->onConsecutiveCalls($product, $product2));

        $cartService = new CartService($cart, $productService);

        $cartService->addProduct($product, 2);
        $cartService->addProduct($product2, 1);

        $order = $cartService->initOrderFromCart();
        $this->assertCount(2, $order->items);
        $this->assertEquals($order->getTotalPrice(), 4);
    }
}
