<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmeScore extends Model
{
    protected $fillable = [
        'opportunity', 'satisfaction', 'description', 'targeting', 'decision', 'pod', 'identity',
        'marketing', 'performance', 'engagement', 'total', 'good', 'bad', 'improvement',
        'sme_id', 'judge_id', 'round'
    ];
}
