<?php

namespace App\Data\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class AuthUser extends Model implements JWTSubject, AuthenticatableContract
{
    use Authenticatable;
    use Notifiable;

    /**
     * Get the identifier that will be store in the subject claim
     * of the JWT
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get a key value array cotaining any custom claims to added to
     * the JWT
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'iss' => config('app.name'),
            'iat' => Carbon::now()->timestamp,
            'exp' => Carbon::now()->addWeeks(2)->timestamp,
            'nbf' => Carbon::now()->timestamp,
            'sub' => env('API_ID'),
            'jti' => uniqid(),
            'userData' => [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'role' => $this->role,
            ],
        ];
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $payload
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    abstract public function getUserByPayload($payload);
}
