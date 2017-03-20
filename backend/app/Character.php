<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = array('name', 'faction');

    public function captions()
    {
        return $this->hasMany('App\Caption');
    }
}
