<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BrandJudge extends Pivot
{
    protected $fillable = ['intent', 'content', 'process', 'health', 'performance',
        'total', 'good', 'bad', 'improvement', 'round', 'brand_id', 'judge_id', 'judge_finalized'];
}
