<?php

namespace App\Services;

use App\Repositories\AuthInterface;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthInterface
{
    /**
     * Authenticate user
     *
     * @param object $credentials
     * @return mixed
     */
    public function loginUser()
    {
        return Auth::attempt();
    }
}
