<?php

namespace App\Models;

use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductColorSize extends Model
{
    use HasFactory;
    protected $guarded =[];

    protected $table = 'product_color_size';


    public function color()
    {
        return $this->belongsTo(ProductColor::class,'product_color_id');
    }

    public function image()
    {
        return $this->belongsTo(ProductImage::class);
    }
}
