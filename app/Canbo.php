<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;

class Canbo extends Authenticatable
{
    use Notifiable;
    // protected $connection = 'coredb';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "tbl_canbo";
    protected $fillable = [
        'idconnguoi', 'idcapbac', 'idchucvu', 'id_iddoi_iddonvi'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function users()
    {
        return $this->hasMany('App\User', 'idcanbo');
    }
}
