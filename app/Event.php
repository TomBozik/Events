<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['code', 'name', 'admin_id', 'description', 'max_answers', 'password'];

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
    public function peoples()
    {
        return $this->hasMany('App\Person');
    }
}
