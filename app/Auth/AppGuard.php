<?php

namespace App\Auth;

use App\Data\Models\User;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use JWTAuth;
use JWTFactory;

class AppGuard implements Guard
{
    use GuardHelpers;

    /**
     * @var mixed
     */
    protected $user;

    protected $request;

    /**
     * Create a new authentication guard.
     */
    public function __construct(Request $request)
    {
        $this->user = null;
        $this->request = $request;
    }

    /**
     * Authenticate users using the phone number
     *
     * @param array $credentials
     * @return JWT Token|null
     */
    public function attempt()
    {
        $credentials = $this->request->only('phone');
        if ($this->validate($credentials)) {
            $data = json_encode($credentials);
            $user = app(User::class)->getUserByPayload(json_decode($data));

            if ($user !== null) {
                $claims = $user->getJWTCustomClaims();
                return JWTAuth::encode($this->generatePayload($claims))->get();
            }
        }
        return null;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if ($this->user !== null) {
            return $this->user;
        }

        $token = JWTAuth::getToken();

        if ($token !== null) {
            $payload = Arr::get(JWTAuth::getPayload($token), 'userData');
            $user = $this->getUserFromPayload($payload);
            $this->setUser($user->first());
            return $user;
        }

        return null;
    }

    /**
     * Retrieves a user using the payload
     *
     * @param array $payload user data
     * @return Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUserFromPayload($payload)
    {
        return app($this->getUserModel($payload->role))
            ->getUserByPayload($payload);
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials['phone'])) {
            return false;
        }
        return true;
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Generate a custom payload
     *
     * @param array $claims jwt custom claims
     *
     * @return Tymon\JWTAuth\Payload
     */
    public function generatePayload($claims)
    {
        return JWTFactory::customClaims($claims)->make();
    }

    /**
     * Gets a user model
     *
     * @param string $role user role
     * @return App\Data\Models\AuthUser
     */
    public function getUserModel($role)
    {
        return config('roles')[$role];
    }
}
