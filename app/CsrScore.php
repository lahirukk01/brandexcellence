<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsrScore extends Model
{
    protected $fillable = ['brand_id', 'judge_id', 'intent', 'recipient', 'purpose',
        'vision', 'mission', 'identity', 'strategic', 'activities', 'communication',
        'internal', 'total', 'good', 'bad', 'improvement', 'round', 'judge_finalized'];

    public function judge()
    {
        return $this->belongsTo('App\Judge');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
}
