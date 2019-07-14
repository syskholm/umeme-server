<?php

namespace App\Services;

use App\Data\Models\Customer;
use App\Repositories\CustomerInterface;

class CustomerService implements CustomerInterface
{
    public function createCustomer($customerInfo)
    {
        return Customer::firstOrCreate([
            'name' => $customerInfo['firstname'] . ' ' . $customerInfo['lastname'],
            'phone' => $customerInfo['phone'],
            'email' => $customerInfo['email'],
        ]);
    }
}
