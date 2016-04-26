<?php

namespace App\Models;

use Moloquent;

class User extends Moloquent
{
    /**
     * Collection name
     * @var users
     */
    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'country',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
