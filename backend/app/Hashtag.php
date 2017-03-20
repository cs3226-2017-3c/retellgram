<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $fillable = array('name');

    public function captions()
    {
        return $this->belongsToMany('App\Caption')->withTimestamps();
    }
}
