<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 19.02.18
 * Time: 13:33
 */

namespace App\Type;


class PaymentStatus
{
    const CREATED = 0;
    const PAYED = 1;

    private static function getStatuses()
    {
        return [
            self::CREATED => 'CREATED',
            self::PAYED => 'PAYED'
        ];
    }

    private $status;


    public function __construct(string $string)
    {
        if (!$this->validStatus($string)) {
            throw new \Exception('not right payment_status');
        }
        $this->status = $string;
    }

    private function validStatus(string $status) :  bool
    {
        $statuses = array_keys(self::getStatuses());
        return in_array($status, $statuses);
    }

    public function getTitle()
    {
        return self::getStatuses()[$this->status];
    }

    public function __toString() : string
    {
        return $this->status;
    }


}