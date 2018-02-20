@extends('layout')

@section('content')
    <div class="raw">
        <div class="col-md-12">
            <form method="post" action="/logout">
                @csrf
                <input type="submit" value="Logout" class="btn btn-default pull-right" />
            </form>
        </div>
    </div>
    <h1>Orders</h1>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Name</th>
            <th>Address</th>
            <th>Items</th>
            <th>Grand Total</th>
            <th>Status</th>
        </tr>
        </thead>

        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
            <td>
                @if (isset($order->customer))
                    <a href="mailto:{{ $order->customer->email }}">{!! $order->customer->name !!}</a>
                @endif
            </td>
            <td>{!! $order->address !!}</td>
            <td>
                <table class="table table-condensed">
                    @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->qty }} pcs</td>
                        <td>$ {{ $item->getTotalPrice() }}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
            <td>
                <strong>${{ $order->getTotalPrice() }}</strong>
            </td>
            <td>
                <span class="label label-success">{{ $order->getPaymentStatus()->getTitle() }}</span>
            </td>
        </tr>
        @endforeach
    </table>
@endsection