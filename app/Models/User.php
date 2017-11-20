<?php

namespace RainCheck\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use RainCheck\Support\Eloquent\HasIncludes;
use Illuminate\Database\Eloquent\SoftDeletes;
use RainCheck\Support\Eloquent\HasUniqueToken;
use Illuminate\Foundation\Auth\User as Authenticatable;
use RainCheck\Support\Contracts\Eloquent\HasUniqueToken as HasUniqueTokenContract;

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
        'password', 'remember_token', 'is_admin',
    ];

    protected $casts = [
        'is_admin' => 'bool',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function currentAddress()
    {
        return $this->addresses()->orderByDesc('created_at')->first();
    }
}
