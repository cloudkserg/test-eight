<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App
 *
 * @property int $id
 * @property string $name
 * @property float $price
 *
 *
 *
 */
class Product extends Model
{
    public function getPrice()
    {
        return ($this->price_raw / 100);
    }


    public function setPrice(float $price)
    {
        $this->price_raw = ($price * 100);
    }
}
