<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\OrderAddRequest;
use App\Services\CartService;
use App\Services\OrderService;
use Egulias\EmailValidator\Exception\ExpectingCTEXT;
use http\Env\Response;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @var CartService
     */
    private $cartService;
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }


    public function showCheckout()
    {
        return view('order.checkout');
    }

    public function checkout(CheckoutRequest $request)
    {
        $order = $this->cartService->initOrderFromCart();

        try {
            $order = $this->orderService->createOrderForCustomer($order, $request);
            $this->orderService->checkoutOrder($order, $request);
        } catch (\Exception $e) {
            return view('order.fail');
        }


        return view('order.success');
    }

    public function preview()
    {
        $order = $this->cartService->initOrderFromCart();
        return view('order.preview', ['order' => $order]);
    }


    public function add(OrderAddRequest $request)
    {
        $this->cartService->addProduct($request->getProduct(), $request->qty);
        return response()->json();
    }
}
