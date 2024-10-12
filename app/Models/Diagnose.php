<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnose extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'customer_id',
        'pest_disease_id',
        'history',
    ];

    protected $casts = [
        'history' => 'array',
    ];

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

    public function pestDiseases()
    {
        return $this->hasMany(PestDisease::class);
    }
}
