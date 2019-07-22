<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Login a default user
     */
    public function withDefaultAuthentication()
    {
        return $this->actingAs(new TestUser());
    }
}
