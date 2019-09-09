<?php

namespace Tests\Feature;

use App\Auth\AppGuard;
use App\Data\Models\Admin;
use App\Data\Models\Customer;
use App\Data\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use JWTAuth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->data = ['phone' => '0712733888'];
        $this->user = [
            'name' => 'Baker Sekitoleko',
            'phone' => '0712733888',
            'email' => 'test@email.com',
        ];
    }

    public function testUserCanLogin()
    {
        $user = factory(\App\Data\Models\User::class)->create();
        factory(\App\Data\Models\Customer::class)->create([
            'user_id' => $user,
            'email' => $user->email,
        ]);

        $response = $this->post('/api/v1/auth/login', $this->data);

        $response->assertStatus(200);
        $this->assertSame($response->decodeResponseJson()['message'], 'Login successful');
    }

    public function testAdminCanLogin()
    {
        $user = factory(\App\Data\Models\User::class)->create(['role' => 'admin']);
        factory(\App\Data\Models\Admin::class)->create([
            'user_id' => $user,
            'email' => $user->email,
        ]);

        $response = $this->post('/api/v1/auth/login', $this->data);

        $response->assertStatus(200);
        $this->assertSame($response->decodeResponseJson()['message'], 'Login successful');
    }

    public function testUnregisteredUserCannotLogin()
    {
        $response = $this->post('/api/v1/auth/login', $this->data);

        $response->assertStatus(404);
        $this->assertSame($response->decodeResponseJson()['message'], 'User not found');
    }

    public function testUserCannotLoginWithWrongPhoneNumber()
    {
        $response = $this->post('/api/v1/auth/login', ['phone' => '071273388']);

        $response->assertStatus(422);
        $this->assertSame($response->decodeResponseJson()['message'], 'The given data was invalid.');
    }

    public function testPhoneNumberIsRequiredToLogin()
    {
        $response = $this->post('/api/v1/auth/login', []);

        $response->assertStatus(422);
        $this->assertSame($response->decodeResponseJson()['message'], 'The given data was invalid.');
    }

    public function testCreateCustomerUserWhenTokenIsPresent()
    {
        $this->user['role'] = 'customer';
        JWTAuth::shouldReceive('getToken', 'getPayload')
            ->andReturn($this->makeUser(Customer::class, User::class, $this->user));
        $this->getJson('api/v1/test');

        $this->assertAuthenticated();
    }

    public function testCreateAdminUserWhenTokenIsPresent()
    {
        $this->user['role'] = 'admin';
        JWTAuth::shouldReceive('getToken', 'getPayload')
            ->andReturn($this->makeUser(Admin::class, User::class, $this->user));
        $this->getJson('api/v1/test');

        $this->assertAuthenticated();
    }

    public function testEmptyUserCredentials()
    {
        $guard = new AppGuard(app(Request::class));
        $result = $guard->validate([]);
        $this->assertFalse($result);
    }

    /**
     * Creates a customer
     *
     * @param Illuminate\Database\Eloquent\Model $modal User
     * @param array $attributes
     * @return array
     */
    public function makeUser($modal, $userModal, $attributes = [])
    {
        return with(factory($userModal)->create($attributes), function ($user) use ($modal) {
            factory($modal)->create([
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
            return ['userData' => $user];
        });
    }
}