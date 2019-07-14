<?php

namespace App\Repositories;

interface CustomerInterface
{
    /**
     * Creates a new customer
     *
     * @param object $customerInfo
     * @return mixed
     */
    public function createCustomer($customerInfo);
}
