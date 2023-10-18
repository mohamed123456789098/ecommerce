<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductColorSize;

class FrontEndController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('front_end.index',compact('products'));
    }

    public function show_product($id){
      ProductColorSize::where('product_id',10)->where('product_color_id',3)->first()->product_size_id;
          $product = Product::find($id);
          $sub_category_size = Product::find($id)->sub_category->size ;

          $sizes = ProductSize::all();

        if(ProductImage::where('product_id',$id)->exists()){
            $avilable_color = ProductImage::where('product_id',$id)->get('product_color_id');

            foreach($avilable_color as $val){
           $arr_color_id[] = $val->product_color_id;
            }
        }else{
            $arr_color_id = [];
            $avilable_color = [];
        }

        $avilable_size = ProductColorSize::where('product_id',$id)->get('product_size_id');

return view('front_end.show_product',compact('product','arr_color_id','sub_category_size','sizes'));
    }

public function test(Request $request){
    return $request;

}


//ajax

public function fetch_product_size($product_id,$color_id){

$avilable_size= ProductColorSize::where('product_id',$product_id)->where('product_color_id',$color_id)->get();
$data['size'] = ProductSize::all();
foreach($avilable_size as $value){
    $data['avilable_size_id'][] = $value->product_size_id;
}


    return response()->json($data);

}
}
