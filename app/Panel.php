<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    protected $fillable = ['name', 'auditor_id'];

    public function auditor()
    {
        return $this->belongsTo('App\Auditor');
    }

    public function judges()
    {
        return $this->belongsToMany('App\Judge');
    }

    public function categories()
    {
        return $this->hasMany('App\Category');
    }
}
