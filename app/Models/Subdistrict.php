<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    protected $primaryKey = 'subdistrict_id';

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }
}
