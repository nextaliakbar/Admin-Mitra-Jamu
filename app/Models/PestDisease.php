<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PestDisease extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    public $incrementing = false;

    protected $fillable = [
        'code',
        'label',
        'description',
        'treatment',
        'day'
    ];

    protected $cast = [
        'treatment' => 'array',
    ];

    public function conditions(): HasMany
    {
        return $this->hasMany(Condition::class);
    }
}
