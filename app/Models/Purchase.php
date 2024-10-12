<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'invoice',
        'date',
        'payment_status',
        'payment_method',
        'note',
        'total_cost',
    ];

    public function purchaseLists()
    {
        return $this->hasMany(PurchaseList::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
