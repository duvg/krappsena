<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name', 'status', 'user_id'];

    public function user ()
    {
        return $this->belongsTo('App\User');
    }

    public function ambients ()
    {
        return $this->hasMany('App\Ambient');
    }
}
