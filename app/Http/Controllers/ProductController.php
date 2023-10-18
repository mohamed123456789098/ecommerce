<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\SubCategory;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductColorSize;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{


    public function index(){
        $products = Product::all();
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $colors = ProductColor::all();
        $sizes = ProductSize::all();
        return view('dashboard.product.product',compact('categories','colors','sizes','products','sub_categories'));
    }
public function store(Request $request){

if($request->size_color){
    $request->validate([
        'name'=>'required|max:25|min:3',
        'details'=>'required|max:250',
        'status'=>'required|regex:/^[0-1]+$/|min:1|max:1',
        'image'=>'required',
        'main_price'=>'required|numeric|between:40,999999',
        'main_discount'=>'nullable|numeric|between:5,999999',
        'sub_category_id'=>'required|exists:sub_categories,id',
        'quantity'=>'required|regex:/^[0-9]+$/|min:1|max:2',
        ]);
}else{


    $request->validate([
    'name'=>'required|max:25|min:3',
    'details'=>'required|max:250',
    'status'=>'required|regex:/^[0-1]+$/|min:1|max:1',
    'image'=>'required',
    'main_price'=>'required|numeric|between:40,999999',
    'main_discount'=>'nullable|numeric|between:5,999999',
    'sub_category_id'=>'required|exists:sub_categories,id',
    'quantity'=>'nullable|regex:/^[0-9]+$/|min:1|max:2',
    ]);
}
    $image = array();
    if($files = $request->file('image')){
     foreach($files as $file){
        // $originalName =$file->getClientOriginalName();
        $file->store($request->name,'product');
        $image[] = $file->hashName();
     }
    }
$string = implode(" ",$image);

Product::create([
    'name'=>$request->name,
    'details'=>$request->details,
    'status'=>$request->status,
    'image'=>$string,
    'main_discount'=>$request->main_discount,
    'main_price'=>$request->main_price,
    'sub_category_id'=>$request->sub_category_id,
     'total_quantity'=>$request->quantity,

]);
return redirect()->back()->with('message',"تم اضافه المنتج بنجاح")->with('product_name',$request->name);;
}

   public function delete($id){

   $product =  Product::findorfail($id)->name;;
      Product::findorfail($id)->delete();
      return redirect()->back()->with('delete'," تم حذف المنتج بنجاح")->with('product_name2',$product);
   }




public function add_products($id){


    $product = Product::findorfail($id);

if($product->sub_category->color == '0' && $product->sub_category->size == '0'){
    return view('errors.404');
}
       $images = ProductImage::where('product_id',$id)->get();
       $color = ProductColorSize::where('product_id',$id)->get();

        $products = Product::all();
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $colors = ProductColor::all();
        $sizes = ProductSize::all();
        $products_color = ProductColorSize::where('product_id',$id)->get();

        if(ProductImage::where('product_id',$id)->exists()){
            $avilable_color = ProductImage::where('product_id',$id)->get('product_color_id');

            foreach($avilable_color as $val){
           $arr_color_id[] = $val->product_color_id;
            }
        }else{
            $arr_color_id = [];
            $avilable_color = [];
        }


    //    return $arr_color_id;
        return view('dashboard.product.add_products',compact('categories','colors','sizes','products','product','sub_categories','color','arr_color_id','avilable_color','images','products_color'));


}







    //AJAX

    public function fetch_subcategory_select($category_id){
        $subcategories = SubCategory::where("category_id",$category_id)->get();
   return response()->json($subcategories);
    }



    public function check_status($product_id){

     $product= Product::findorfail($product_id);

if($product->status == "1"){
    $product->update([
   'status'=>'0'
    ]);
    $product->save();
}else{
    $product->update([
        'status'=>'1'
         ]);
         $product->save();
}

   return response()->json(Product::find($product_id)->status);
    }
}
