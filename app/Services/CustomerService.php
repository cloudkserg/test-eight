<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 20.02.18
 * Time: 5:13
 */

namespace App\Services;


use App\Customer;

class CustomerService
{
    /**
     * @param string $email
     * @return Customer|null
     */
    private function findItemByEmail($email)
    {
        return Customer::where('email', $email)->first();
    }

    /**
     * @param $name
     * @param $email
     * @return Customer|null
     */
    public function findOrCreateCustomer($name, $email)
    {
        $customer = $this->findItemByEmail($email);
        if (!isset($customer)) {
            $customer = new Customer();
            $customer->name = $name;
            $customer->email = $email;
            $customer->save();
        }
        return $customer;
    }

}