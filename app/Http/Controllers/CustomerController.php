<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterCustomerRequest;
use App\Repositories\CustomerInterface;

class CustomerController extends Controller
{
    public function __construct(CustomerInterface $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Create a new customer
     *
     * @param RegisterCustomerRequest $request
     */
    public function store(RegisterCustomerRequest $request)
    {
        $this->customerService->createCustomer($request->validated());

        return response(
            ['message' => 'Customer has been created successfully'],
            201
        );
    }
}
