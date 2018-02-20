<?php

namespace App;

use App\Type\PaymentStatus;
use Faker\Provider\Payment;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App
 *
 * @property int $id
 * @property int $customer_id
 * @property int $qty
 * @property string $payment_status
 * @property string $address
 *
 * @property float $price
 * @property Customer $customer
 * @property \Illuminate\Database\Eloquent\Collection|OrderItem[] $items
 * @property \Carbon\Carbon $create_time
 *
 */
class Order extends Model
{

    protected $dates = ['created_at'];



    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }




    public function getPaymentStatus() : PaymentStatus
    {
        return new PaymentStatus($this->payment_status);
    }

    public function setPaymentStatus(PaymentStatus $paymentStatus)
    {
        $this->payment_status = (string) $paymentStatus;
    }



    public function getTotalPrice() : float
    {
        return $this->items->sum(function (OrderItem $item) {
            return $item->getTotalPrice();
        });
    }
}
