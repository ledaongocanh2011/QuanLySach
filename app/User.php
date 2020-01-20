<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    //use SoftDeletes;
    const ADMIN = 1;
    const USER = 0;
    const DANGXEM = 1;
    const COTHEMUON = 0;
    const DAMUON = 2;
    const CHUAGUI = 0;
    const DAGUI = 1;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function dataUser()
    {
        $users = $this->all();

        return $users;
    }
}
