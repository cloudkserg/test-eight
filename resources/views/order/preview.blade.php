@extends('layout')

@section('content')
    <div class="raw">
        <div class="col-md-12">
            <a href="/order/checkout" class="btn btn-default pull-right">Checkout</a>
        </div>
    </div>
    <h1>Cart items</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Qty</th>
            <th>Product</th>
            <th>Price</th>
            <th>Grand Total</th>
        </tr>
        </thead>

        @foreach ($order->items as $orderItem)
            <tr>
                <td>{{ $orderItem->qty }}</td>
                <td>{{ $orderItem->product->name }}</td>
                <td>{{ $orderItem->getPrice() }}</td>
                <td>{{ $orderItem->getTotalPrice() }}</td>
            </tr>
        @endforeach
    </table>

@endsection
