<?php

namespace App\Data\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class BaseModel extends Model implements JWTSubject
{
    use Authenticatable;

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
        return [];
    }
}
