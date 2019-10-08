<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name', 'status'];

    public function users ()
    {
        return $this->hasMany('App\User');
    }

    public function ambients ()
    {
        return $this->hasMany('App\Subarea');
    }
}
