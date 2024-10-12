<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->product->price;
    }

    public function getWeightAttribute()
    {
        return $this->quantity * $this->product->weight;
    }

    public function getWeightInKgAttribute()
    {
        return $this->weight / 1000;
    }

    public function getWeightInGramsAttribute()
    {
        return $this->weight;
    }
}
