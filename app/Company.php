<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'address',
        'ceo_name',
        'ceo_email',
        'ceo_contact_number',
        'user_id',
    ];

    public function brands()
    {
        return $this->hasMany('App\Brand');
    }
}
