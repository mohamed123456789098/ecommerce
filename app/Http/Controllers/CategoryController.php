<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   public function index(){
    $categories = Category::all();
    return view('dashboard.category.category',compact('categories'));
   }

   public function store(Request $request){
    $request->validate([
   'name'=>'required|unique:categories|max:25|min:3',

    ]);

    Category::create([
   'name'=>$request->name,
    ]);
    return redirect()->back()->with('message',"  تم اضافه القسم بنجاح ")->with('category_name',$request->name);
   }

   public function delete($id){
    $Category = Category::findorfail($id)->name;

    Category::findorfail($id)->delete();

     return redirect()->back()->with('delete',"تم حذف القسم بنجاح")->with('category_name2',$Category);
   }

   //ajax

public function validate_category(Request $request,$category){
    if( Category::where('name',$category)->count() > 0 ){
        $data = 'count = 1';
    }else{
        $data = 'count = 0';
       }
        return response()->json($data);
    }
}
