<?php

namespace Tests;

use App\Data\Models\AuthUser;

class TestUser extends AuthUser
{
    protected $defaultAttributes = [
        'id' => 1,
        'user_id' => 1,
        'email' => 'baker@gmail.com',
        'name' => 'Baker Sekitoleko',
        'phone' => '0712733800',
        'role' => 'admin',
    ];

    /**
     * Creates an instance of the test user
     * @param array|null $attributes
     */
    public function __construct(array $attributes = null)
    {
        $this->forceFill($attributes ?: $this->defaultAttributes);
    }

    public function getUserByPayload($payload)
    {
        return $this->forceFill($payload);
    }
}
