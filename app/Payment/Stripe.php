<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 20.02.18
 * Time: 5:19
 */

namespace App\Payment;


use App\Http\Requests\CheckoutRequest;
use App\Order;

class Stripe
{
    const DEFAULT_CURRENCY='usd';

    public function __construct()
    {
        \Stripe\Stripe::setApiKey(getenv('APP_STRIPE_SECRET'));
    }


    public function checkout(CheckoutRequest $request, Order $order)
    {
        $token  = $request->get('stripeToken');

        $customer = \Stripe\Customer::create(array(
            'email' => $order->customer->email,
            'source'  => $token
        ));

        $charge = \Stripe\Charge::create(array(
            'customer' => $customer->id,
            'amount'   => $order->getTotalPrice(),
            'currency' => 'usd'
        ));

        return $charge;

    }

}