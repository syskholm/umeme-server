<?php

namespace App\Services;

use App\Data\Models\User;
use App\Repositories\UserInterface;

class UserService implements UserInterface
{
    /**
     * Creates a new user
     *
     * @param object $userInfo
     * @return mixed
     */
    public function createUser($userInfo)
    {
        $userInfo['name'] = $userInfo['firstname'] . ' ' . $userInfo['lastname'];

        $user = User::Create($userInfo);

        $userInfo['user_id'] = $user->id;
        $type = '\\App\\Data\\Models\\' . ucfirst($userInfo['role']);
        app($type)->create($userInfo);

        return $user;
    }
}
