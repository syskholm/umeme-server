<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Repositories\UserInterface;

class UserController extends Controller
{
    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Create a new user
     *
     * @param RegisterUserRequest $request
     */
    public function store(RegisterUserRequest $request)
    {
        $this->userService->createUser($request->validated());

        return response(
            ['message' => 'User has been created successfully'],
            201
        );
    }
}
