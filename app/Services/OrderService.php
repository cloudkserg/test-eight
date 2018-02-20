<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 20.02.18
 * Time: 3:25
 */

namespace App\Services;


use App\Customer;
use App\Events\PayedOrderEvent;
use App\Http\Requests\CheckoutRequest;
use App\Order;
use App\OrderItem;
use App\Payment\Stripe;
use App\Type\PaymentStatus;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * @var CustomerService
     */
    private $customerService;
    /**
     * @var Stripe
     */
    private $stripe;

    public function __construct(CustomerService $customerService, Stripe $stripe)
    {
        $this->customerService = $customerService;
        $this->stripe = $stripe;
    }


    public function getOrders()
    {
        return Order::all();
    }

    private function isOrderEmpty(Order $order)
    {
        return (empty($order->items));
    }

    private function updateOrder(Order $order, Customer $customer, CheckoutRequest $request)
    {
        $order->customer_id = $customer->id;
        $order->address = $request->address;
        $order->setPaymentStatus(new PaymentStatus(PaymentStatus::CREATED));
        $order->saveOrFail();
    }

    /**
     * @param Order $order
     * @param CheckoutRequest $request
     * @return Order
     * @throws \Exception
     */
    public function createOrderForCustomer(Order $order, CheckoutRequest $request)
    {
        if ($this->isOrderEmpty($order)) {
            throw new \Exception('empty order');
        }

        $customer = $this->customerService->findOrCreateCustomer($request->name, $request->email);


        DB::transaction(function () use ($customer, $order, $request) {
            $this->updateOrder($order, $customer, $request);
            $this->saveOrderItems($order);
        });


        return $order;
    }

    private function saveOrderItems(Order $order)
    {
        collect($order->items)->each(function (OrderItem $orderItem) use ($order) {
            unset($orderItem->product);
            $order->items()->save($orderItem);
        });
    }

    /**
     * @param Order $order
     * @param CheckoutRequest $request
     *
     * generate PayedOrderEvent
     *
     */
    public function checkoutOrder(Order $order, CheckoutRequest $request)
    {
        DB::transaction(function () use ($order, $request) {
            $this->stripe->checkout($request, $order);

            $order->setPaymentStatus(new PaymentStatus(PaymentStatus::PAYED));
            $this->saveOrder($order);
        });

        event(new PayedOrderEvent($order));
    }

    protected function saveOrder(Order $order)
    {
        $order->save();
    }

}