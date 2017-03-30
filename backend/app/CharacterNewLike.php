<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterNewLike extends Model
{
    protected $table = 'character_new_like';
    protected $fillable = array('character_id', 'new_like');

    public function character()
    {
        return $this->belongsTo('App\Character');
    }
}
