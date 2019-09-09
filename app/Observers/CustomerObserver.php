<?php

namespace App\Observers;

use App\Data\Models\Customer;

class CustomerObserver
{
    /**
     * Handle the Customer retrieve event and add User attributes to a customer.
     *
     * @param  \App\Data\Models\Customer  $customer
     */
    public function retrieved(Customer $customer)
    {
        $attributes = $customer->user()->get()->first()->toArray();
        unset($attributes['id'], $attributes['email']);
        foreach ($attributes as $key => $value) {
            $customer->setAttribute($key, $value);
        }
    }
}
