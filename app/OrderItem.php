<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderItem
 * @package App
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $price_raw
 * @property int $qty
 *
 * @property float $price
 *
 * @property Product $product
 */
class OrderItem extends Model
{


    public function getPrice() : float
    {
        return ($this->price_raw / 100);
    }


    public function setPrice(float $price)
    {
        $this->price_raw = ($price * 100);
    }

    public function getTotalPrice() : float
    {
        return ($this->getPrice() * $this->qty);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
