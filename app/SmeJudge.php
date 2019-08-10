<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmeJudge extends Model
{
    protected $fillable = ['judge_id'];

    public function judge()
    {
        return $this->belongsTo('App\Judge');
    }
}
