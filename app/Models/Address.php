<?php

namespace RainCheck\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'company', 'address1', 'address2', 'zip',
        'phone', 'country_id', 'state_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function subregion()
    {
        return $this->belongsTo(Subregion::class);
    }
}
