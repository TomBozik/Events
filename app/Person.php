<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['code', 'event_id', 'email', 'username'];

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
