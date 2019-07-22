<?php

namespace App\Data\Models;

class User extends AuthUser
{
    /**
     * The models table
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'role',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $payload
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUserByPayload($payload)
    {
        $user = self::where(['phone' => $payload->phone])->first();
        $role = $user->role ?? null;
        switch ($role) {
            case 'admin':
                $user->setAttribute('type_id', $user->admin()->first()->id);
                return $user;
            case 'customer':
                $user->setAttribute('type_id', $user->customer()->first()->id);
                return $user;
            default:
                return;
        }
    }

    /**
     * Retrieves a customer
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer()
    {
        return $this->hasOne(Customer::class, 'user_id', 'id');
    }

    /**
     * Retrieves an admin
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }
}
