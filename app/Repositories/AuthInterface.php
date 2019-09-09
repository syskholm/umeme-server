<?php

namespace App\Repositories;

interface AuthInterface
{
    /**
     * Authenticate user
     *
     * @param object $credentials
     * @return mixed
     */
    public function loginUser();
}
