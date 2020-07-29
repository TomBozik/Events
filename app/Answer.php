<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $fillable = ['event_id', 'person_id', 'from', 'to'];

    public function person()
    {
        return $this->belongsTo('App\Person');
    }
    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
