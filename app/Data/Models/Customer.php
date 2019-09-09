<?php

namespace App\Data\Models;

use App\Observers\CustomerObserver;

class Customer extends AuthUser
{
    /**
     * The table name
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'user_id',
    ];

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $payload
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUserByPayload($payload)
    {
        return self::where(['email' => $payload->email])
            ->first();
    }

    /**
     * Eevery customer is a user
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Register the customer observer
     */
    public static function boot()
    {
        parent::boot();
        self::observe(new CustomerObserver());
    }
}
