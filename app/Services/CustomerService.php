<?php

namespace App\Services;

use App\Data\Models\User;
use App\Repositories\CustomerInterface;

class CustomerService implements CustomerInterface
{
    /**
     * Create customer
     * @param array $customerInfo
     */
    public function createCustomer($customerInfo)
    {
        // if the user has an admin role, we return immediately
        if (strtolower($customerInfo['role']) === 'admin') {
            return null;
        }

        $customerInfo['name'] = $customerInfo['firstname'] . ' ' . $customerInfo['lastname'];

        $user = User::Create($customerInfo);

        $customerInfo['user_id'] = $user->id;
        return app(\App\Data\Models\Customer::class)->create($customerInfo);
    }
}
