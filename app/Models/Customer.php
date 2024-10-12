<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
// use Tymon\JWTAuth\Contracts\JWTSubject as ContractsJWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes, Uuids;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        'provider',
        'provider_id',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'string',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function voucherClaim()
    {
        return $this->hasMany(VoucherClaim::class);
    }

    public function getAvatarAttribute($value)
    {
        return $value ? asset('storage/customers/avatars/' . $value) : asset('images/avatar-male.png');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
