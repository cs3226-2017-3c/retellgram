<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caption extends Model
{
    protected $fillable = array('image_id', 'content','likes','approved','character_id');

    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    public function character()
    {
        return $this->belongsTo('App\Character');
    }

    public function hashtags()
    {
        return $this->belongsToMany('App\Hashtag')->withTimestamps();
    }
}
