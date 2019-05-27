<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name', 'description',
        'entry_kit', 'logo',
        'id_string', 'company_id',
        'category_id'
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function getAttributeLogo()
    {
        return asset( 'uploads/' . $this->logo);
    }
}
