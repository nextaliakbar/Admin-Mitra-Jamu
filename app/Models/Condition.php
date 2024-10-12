<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condition extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'status',
        'value',
        'treatment',
        'is_after',
        'day',
        'pest_disease_id'
    ];

    protected $casts = [
        'treatment' => 'array',
    ];

    public function pestDiseases(): BelongsTo
    {
        return $this->belongsTo(PestDisease::class);
    }
}
