<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = array('file_path', 'md5','likes');

    public function captions()
    {
        return $this->hasMany('App\Caption');
    }
}
