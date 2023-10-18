<?php

namespace App\Http\Controllers;

use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    public function index(){
        $product_size = ProductSize::all();
        return view('dashboard.product_size.product_size',compact('product_size'));
    }


    public function store(Request $request){

        $request->validate([
       'name'=>'required|unique:product_sizes|max:25',

        ]);
        ProductSize::create([
       'name'=>$request->name,
        ]);
        return redirect()->back()->with('message',"  تم اضافه المقاس  بنجاح ")->with('product_size',$request->name);
       }

       public function delete($id){
        $product_size = ProductSize::findorfail($id)->name;

        ProductSize::findorfail($id)->delete();

         return redirect()->back()->with('delete',"تم حذف المقاس بنجاح")->with('product_size2', $product_size);
       }


    //ajax
    public function validate_product_size ($product_size){
    //   return response()->json($product_size);
        if( ProductSize::where('name',$product_size)->count() > 0 ){
            $data = 'count = 1';
        }else{
            $data = 'count = 0';
           }
            return response()->json($data);
        }
}
