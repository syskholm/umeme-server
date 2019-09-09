<?php

namespace App\Repositories;

interface UserInterface
{
    /**
     * Creates a new user
     *
     * @param object $userInfo
     * @return mixed
     */
    public function createUser($userInfo);
}
