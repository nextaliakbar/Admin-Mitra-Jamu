<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receivable extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'transaction_id',
        'paid_amount',
        'due_date',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
