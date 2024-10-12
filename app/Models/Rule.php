<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'code',
        'pest_disease_id',
    ];

    public function pestDisease()
    {
        return $this->belongsTo(PestDisease::class);
    }

    public function symptoms()
    {
        return $this->belongsToMany(Symptoms::class);
    }
}
