<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustryCategory extends Model
{
    protected $fillable = ['name', 'code'];

    public function brands()
    {
        return $this->hasMany('App\Brand');
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
