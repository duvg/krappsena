<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Headquarter extends Model
{
    private $fillable = ['name'];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
