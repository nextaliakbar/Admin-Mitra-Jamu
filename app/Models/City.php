<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    protected $primaryKey = 'city_id';

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function subdistrict()
    {
        return $this->hasMany(Subdistrict::class, 'city_id');
    }
}
