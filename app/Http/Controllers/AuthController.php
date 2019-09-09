<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Repositories\AuthInterface;

class AuthController extends Controller
{
    /**
     * Create a new controller instance
     *
     * @param AuthInterface $authService
     */
    public function __construct(AuthInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Get the JWT using the provided credentials
     *
     * @param LoginCustomerRequest $request
     */
    public function index(LoginUserRequest $request)
    {
        $token = $this->authService->loginUser();
        return response(
            [
                'message' => $token ? 'Login successful' : 'User not found',
                'token' => $token,
            ],
            $token ? 200 : 404
        );
    }
}