<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function labels()
    {
        return $this->belongsToMany(ProductLabel::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function purchaseLists()
    {
        return $this->hasMany(PurchaseList::class);
    }

    public function productHighlights()
    {
        return $this->hasMany(ProductHighlight::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
