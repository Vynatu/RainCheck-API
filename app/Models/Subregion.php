<?php

namespace RainCheck\Models;

use Illuminate\Database\Eloquent\Model;

class Subregion extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getNameAttribute()
    {
        return trans("countries.{$this->country_code}.subregions.{$this->subregion_code}");
    }
}
