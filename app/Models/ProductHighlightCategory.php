<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHighlightCategory extends Model
{
    use HasFactory, Uuids;

    protected $guarded = [];

    public function productHighlights()
    {
        return $this->hasMany(ProductHighlight::class);
    }
}
