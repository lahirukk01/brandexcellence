<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'code', 'benchmark'];

    public function brands()
    {
        return $this->hasMany('App\Brand');
    }

    public function panels()
    {
        return $this->belongsToMany('App\Panel');
    }
}
