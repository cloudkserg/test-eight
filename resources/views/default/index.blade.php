@extends('layout')

@section('content')
<div id="alert-order" class="alert alert-info" style="display: none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Note!</strong> Item added to order.
</div>
    <div class="raw">
        <div class="col-md-12">
            <a href="/order/preview" class="btn btn-default pull-right">Cart</a>
        </div>
    </div>
    <h1>Store</h1>
    <table class="table">
        <thead>
        <tr>
            <th width="*">Product</th>
            <th width="10%">Price</th>
            <th width="10%">Qty</th>
            <th width="20%">Action</th>
        </tr>
        </thead>

        @foreach ($products as $product)
            <tr>
                <td>{{  $product->name }}</td>
                <td>${{ $product->getPrice() }}</td>
                <td>
                    <div class="form-group">
                        <input class="product-id" type="hidden" value="{{ $product->id }}" />
                        <input name="qty" value="1" class="form-control form-qty"/>
                    </div>
                </td>
                <td>
                    <button class="order-btn btn btn-success">Order</button>
                </td>
            </tr>
        @endforeach
    </table>



@endsection

@section('javascripts')

    <script>
        $(document).ready(function () {
            $('.order-btn').click(function (e) {
                var t = $(e.target),
                    row = t.parent().parent(),
                    productId = row.find('.product-id').val(),
                    formQty = row.find('.form-qty').val();

                $.post('order/add', {'product_id': productId, 'qty': formQty}, function () {
                    $('#alert-order').show();
                    setTimeout("$('#alert-order').hide()",2000);
                });
            })
        })
    </script>
@endsection

