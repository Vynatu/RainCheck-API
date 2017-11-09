<?php

namespace RainCheck\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $with = 'subregions';

    public function subregions()
    {
        return $this->hasMany(Subregion::class);
    }

    public function getNameAttribute()
    {
        return trans("countries.{$this->country_code}.name");
    }
}
