<?php

namespace App\Http\Controllers;

use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    public function index(){
        $product_color = ProductColor::all();
        return view('dashboard.product_color.product_color',compact('product_color'));
    }


    public function store(Request $request){

        $request->validate([
       'name'=>'required|unique:product_colors|max:25|min:3',

        ]);
        ProductColor::create([
       'name'=>$request->name,
        ]);
        return redirect()->back()->with('message',"  تم اضافه اللون  بنجاح ")->with('product_color',$request->name);
       }

       public function delete($id){
        $product_color = ProductColor::findorfail($id)->name;

        ProductColor::findorfail($id)->delete();

         return redirect()->back()->with('delete',"تم حذف القسم بنجاح")->with('product_color2', $product_color);
       }


    //ajax
    public function validate_product_color(Request $request,$product_color){

        if( ProductColor::where('name',$product_color)->count() > 0 ){
            $data = 'count = 1';
        }else{
            $data = 'count = 0';
           }
            return response()->json($data);
        }
}
