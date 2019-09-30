<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ambient extends Model
{
    protected $fillable = ['name', 'code', 'description', 'area_id'];

    public function area ()
    {
        return  $this->belongsTo('App\Area');
    }
}
