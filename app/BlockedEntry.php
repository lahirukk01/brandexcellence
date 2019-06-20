<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockedEntry extends Model
{
    protected $fillable = ['user_id', 'brand_id'];
}
