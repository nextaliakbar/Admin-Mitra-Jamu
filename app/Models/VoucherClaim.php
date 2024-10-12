<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherClaim extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    public function scopeUsed($query)
    {
        return $query->where('is_used', 1);
    }

    public function scopeUnused($query)
    {
        return $query->where('is_used', 0);
    }

    public function scopeUsedAt($query, $date)
    {
        return $query->where('used_at', $date);
    }
}
