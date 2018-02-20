Оплачен заказ #{{ $order->id }} От {{ $order->updated_at->format('d.m.Y H:i') }}
Сумма заказа: {{ $order->getTotalPrice() }}