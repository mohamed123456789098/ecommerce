<?php

namespace App\Models;

use App\Models\ProductColor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'product_image';
    protected $guarded = [];


    public function product_color()
    {
        return $this->belongsTo(ProductColor::class,'product_color_id');
    }
}


