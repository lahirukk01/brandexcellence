<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'code', 'benchmark', 'panel_id'];

    public function brands()
    {
        return $this->hasMany('App\Brand');
    }

    public function panel()
    {
        return $this->belongsTo('App\Panel');
    }
}
