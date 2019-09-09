<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->data = ['phone' => '0712733888'];
        $this->user = [
            'firstname' => 'Baker',
            'lastname' => 'Sekitoleko',
            'phone' => '0712733888',
            'email' => 'test@email.com',
            'role' => 'customer',
        ];
    }

    public function testCannotCreateCustomerWithoutFirstName()
    {
        unset($this->user['firstname']);
        $response = $this->post('/api/v1/auth/customer/register', $this->user);

        $response->assertStatus(422);
        $this->assertSame($response->decodeResponseJson()['message'], 'The given data was invalid.');
    }

    public function testCannotCreateCustomerWithAdminRole()
    {
        $this->user['role'] = 'admin';
        $response = $this->post('/api/v1/auth/customer/register', $this->user);

        $response->assertStatus(422);
        $this->assertSame($response->decodeResponseJson()['message'], 'Registration failed');
    }

    public function testCreateCustomerSuccess()
    {
        $response = $this->post('/api/v1/auth/customer/register', $this->user);

        $response->assertStatus(201);
        $this->assertSame($response->decodeResponseJson()['message'], 'Registration successful');
    }

    public function testCreateAdminSuccess()
    {
        $this->withDefaultAuthentication();
        $this->user['role'] = 'admin';
        $response = $this->post('/api/v1/user/register', $this->user);

        $response->assertStatus(201);
        $this->assertSame($response->decodeResponseJson()['message'], 'User has been created successfully');
    }
}
