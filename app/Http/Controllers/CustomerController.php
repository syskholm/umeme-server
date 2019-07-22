<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Repositories\CustomerInterface;

class CustomerController extends Controller
{
    public function __construct(CustomerInterface $customerService)
    {
        $this->customerService = $customerService;
    }

    public function store(RegisterUserRequest $request)
    {
        $customer = $this->customerService->createCustomer($request->validated());
        return response(
            [
                'message' => $customer ? 'Registration successful' : 'Registration failed',
                'customer' => $customer,
            ],
            $customer ? 201 : 422
        );
    }
}
