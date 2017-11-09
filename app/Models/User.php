<?php

namespace RainCheck\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use RainCheck\Support\Contracts\Eloquent\HasUniqueToken as HasUniqueTokenContract;
use RainCheck\Support\Eloquent\HasIncludes;
use RainCheck\Support\Eloquent\HasUniqueToken;

class User extends Authenticatable implements HasUniqueTokenContract
{
    use Notifiable, HasApiTokens, HasUniqueToken, SoftDeletes, HasIncludes;

    protected static $includable = [
        'addresses', 'currentAddress',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'is_admin', 'address_id',
    ];

    protected $casts = [
        'is_admin' => 'bool'
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function currentAddress()
    {
        return $this->belongsTo(Address::class);
    }
}
