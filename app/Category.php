<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'code'];

    public function brands()
    {
        return $this->hasMany('App\Brand');
    }
}
