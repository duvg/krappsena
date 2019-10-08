<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'lastname',
        'birthdate',
        'telephone',
        'rol_id',
        'occupation_id',
        'headquarter_id',
        'area_id',
        'status'
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

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }


    public function rol ()
    {
        return $this->belongsTo('App\Rol');
    }

    public function headquarter ()
    {
        return $this->belongsTo('App\Headquarter');
    }

    public function occupation ()
    {
        return $this->belongsTo('App\Occupation');
    }

    public function area ()
    {
        return $this->belongsTo('App\Area');
    }

    public function novelties ()
    {
        return $this->hasMany('App\Novelty');
    }
}
