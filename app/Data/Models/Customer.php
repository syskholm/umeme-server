<?php

namespace App\Data\Models;

class Customer extends BaseModel
{
    /**
     * The models table
     *
     * @var string
     */
    protected $table = 'customers';

    protected $fillable = [
        'name',
        'phone',
        'email',
    ];
}
