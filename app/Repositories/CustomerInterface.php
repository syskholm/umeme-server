<?php

namespace App\Repositories;

interface CustomerInterface
{
    /**
     * Create customer
     * @param array $customerInfo
     */
    public function createCustomer($customerInfo);
}
