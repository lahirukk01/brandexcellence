<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockedEntry extends Model
{
    protected $fillable = ['judge_id', 'brand_id'];
}
