<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 20.02.18
 * Time: 3:24
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Services\OrderService;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function index()
    {
        $orders = $this->orderService->getOrders();
        return view('order.index', ['orders' => $orders]);
    }
}