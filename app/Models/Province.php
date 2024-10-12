<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'province_id';

    public function city()
    {
        return $this->hasMany(City::class);
    }
}
