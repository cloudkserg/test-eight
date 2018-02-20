<?php

namespace Tests\Unit;

use App\Customer;
use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\OrderAddRequest;
use App\Mail\PayedOrderMail;
use App\Order;
use App\OrderItem;
use App\Payment\Stripe;
use App\Services\CustomerService;
use App\Services\OrderService;
use App\Type\PaymentStatus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateEmptyOrderForCustomer()
    {
        $customerService = new CustomerService();
        $stripe = $this->createMock(Stripe::class);
        $orderService = new OrderService($customerService, $stripe);

        $order = new Order();
        $request = new CheckoutRequest();

        $this->expectException(\Exception::class);
        $orderService->createOrderForCustomer($order, $request);
    }

    public function testCreateOrderForCustomer()
    {
        $customerService = new CustomerService();
        $stripe = $this->createMock(Stripe::class);
        $orderService = new OrderService($customerService, $stripe);

        $order = new Order();

        $item = new OrderItem();
        $item->id = 1;
        $item->setPrice(3);
        $item->qty = 1;
        $order->items[] = $item;

        $item = new OrderItem();
        $item->id = 2;
        $item->setPrice(2);
        $item->qty = 2;
        $order->items[] = $item;

        $request = new CheckoutRequest();
        $request->name = 1;
        $request->email = '1@1.ru';

        $order = $orderService->createOrderForCustomer($order, $request);
        $this->assertEquals(1, $order->customer->name);
        $this->assertEquals('1@1.ru', $order->customer->email);
        $this->assertCount(2, $order->items);
        $this->assertEquals(7, $order->getTotalPrice());

    }

    public function testCheckoutOrder()
    {
        $order = new Order();
            $customer = new Customer();
            $customer->id = 1;
            $customer->name = '1';
            $customer->email = '1@1.ru';
        $order->id = 1;
        $order->customer_id = 1;
        $order->customer = $customer;

        $item = new OrderItem();
        $item->id = 2;
        $item->setPrice(2);
        $item->qty = 2;
        $order->items[] = $item;


        $request = new CheckoutRequest();
        \Mail::fake();

        $customerService = new CustomerService();
        $stripe = $this->createMock(Stripe::class);
        $stripe->method('checkout')
            ->with($request, $order);

        $orderService = new OrderService($customerService, $stripe);
        $orderService->checkoutOrder($order, $request);

        $this->assertEquals(PaymentStatus::PAYED, (string)$order->getPaymentStatus());
        // Perform order shipping...

        \Mail::assertSent(PayedOrderMail::class, function ($mail) use ($order) {
            return $mail->order->id === $order->id;
        });



    }
}
