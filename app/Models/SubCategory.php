<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;
     protected $guarded = [];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
