<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Canbo;

class User extends Authenticatable
{
    use Notifiable;
    // protected $connection = 'coredb';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'idcanbo', 'idnhomquyen', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function canbos()
    {
        return $this->belongsTo('App\Canbo', 'idcanbo');
    }
}
