<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caption extends Model
{
    protected $fillable = array('image_id', 'content','likes');

    public function image()
    {
        return $this->belongsTo('App\Image');
    }
}
