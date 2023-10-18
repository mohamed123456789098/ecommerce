<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductColorSize;
use Illuminate\Support\Facades\DB;

class ProductColorSizeController extends Controller
{

public function store(Request $request){

if(Product::find($request->product_id)->sub_category->size != "0"){

     for($i = 0 ; $i<count($request->size) ; $i++){

        if( ProductColorSize::where('product_id',$request->product_id)->Where('product_size_id',$request->size[$i])->where('product_color_id',$request->color)->exists() == 1){
            return redirect()->back()->with('error',"المقاس واللون موجودين من قبل ");
        }
     }
    }

if(ProductImage::where("product_id",$request->product_id)->where("product_color_id",$request->color)->exists() == 1){
  $image_id = ProductImage::where("product_id",$request->product_id)->where("product_color_id",$request->color)->first()->id;
}else{
    $image = array();
    if($files = $request->file('image')){
     foreach($files as $file){
        // $originalName =$file->getClientOriginalName();
        $file->store($request->name,'product_color_size');
        $image[] = $file->hashName();
     }
    }
$string = implode(" ",$image);



    ProductImage::create([
        'image'=>$string,
        'product_id'=> $request->product_id,
        'product_color_id'=>$request->color,

    ]);

        $image_id =  ProductImage::where('product_id',$request->product_id)->where('product_color_id',$request->color)->first()->id;
}

        $discount = Product::find($request->product_id)->main_discount;
        $price = Product::find($request->product_id)->main_price ;



        if(Product::find($request->product_id)->sub_category->size != "0"){
        for($i = 0 ; $i<count($request->size) ; $i++){
            $product_color_size = new ProductColorSize();
            $product_color_size->product_id = $request->product_id;
            $product_color_size->product_color_id = $request->color;
            $product_color_size->product_size_id = $request->size[$i];
            $product_color_size->sub_category_id = Product::find($request->product_id)->sub_category->id;
            $product_color_size->product_image_id = $image_id;
            $product_color_size->quantity = $request->quantity[$i];
            $product_color_size->status = $request->status;

                     if($request->discount[$i] == null){
                        $product_color_size->discount = $discount;

                      }else{
                        $product_color_size->discount = $request->discount[$i];
                      }
                     if($request->price[$i] == null){
                        $product_color_size->price = $price;

                      }else{
                        $product_color_size->price = $request->price[$i];
                      }
$product_color_size ->save();


           }
        }else{
            $product_color_size = new ProductColorSize();
            $product_color_size->product_id = $request->product_id;
            $product_color_size->product_color_id = $request->color;
            $product_color_size->sub_category_id = Product::find($request->product_id)->sub_category->id;
            $product_color_size->product_image_id = $image_id;
            $product_color_size->quantity = $request->quantity;
            $product_color_size->status = $request->status;

            if($request->discount == null){
                $product_color_size->discount = $discount;

              }else{
                $product_color_size->discount = $request->discount;
              }
             if($request->price == null){
                $product_color_size->price = $price;

              }else{
                $product_color_size->price = $request->price;
              }
              $product_color_size ->save();
        }
        return redirect()->back();


}

public function delete($id){
ProductColorSize::find($id)->delete();
return redirect()->back()->with('delete',"تم حذف المنتج بنجاح ");
}

//Ajax

public function fetch_size($color_id,$product_id){

    $size['sizes'] = ProductSize::get(['id','name']);
    $size['size_exept']= ProductColorSize::get()->where('product_color_id',$color_id)->where('product_id',$product_id);

return response()->json($size);

}

public function fetch_size_table($color_id,$product_id){

    $size['sizes'] = ProductSize::get(['id','name']);
    $size['size_exept']= ProductColorSize::where('product_color_id',$color_id)->where('product_id',$product_id)->get();
    $size['type'] = Product::findorfail($product_id)->sub_category->size;

return response()->json($size);

}
}
