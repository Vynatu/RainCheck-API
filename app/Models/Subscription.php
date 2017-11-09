<?php

namespace RainCheck\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
