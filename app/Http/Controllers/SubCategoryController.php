<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
   public function index(){
    $categories = Category::all();
    return view('dashboard.subcategory.sub_category',compact('categories'));
   }

   public function store(Request $request){

// return $request->file('image')->getClientOriginalName();
    $request->validate([
        'name'=>'required|unique:sub_categories|max:25|min:3',
        'image'=>'required|image|mimes:jpeg,png,jpg',
        'category_id'=>'required|exists:categories,id',
        'status'=>'required|regex:/^[0-1]+$/|min:1|max:1',
        'color'=>'required|regex:/^[0-1]+$/|min:1|max:1',
        'size'=>'required|regex:/^[0-2]+$/|min:1|max:1',
    ]);

    $path = $request->file('image')->store($request->name,'sub_category');
    SubCategory::create([
        'name'=>$request->name,
        'category_id'=>$request->category_id,
        'image'=>$path,
        'status'=>$request->status,
        'color'=>$request->color,
        'size'=>$request->size,
    ]);
    return redirect()->back()->with('message',"{{ $request->name }} تم الاضافه بنجاح");
}

public function delete($id){

    $subcategory = SubCategory::findorfail($id)->name;

   SubCategory::findorfail($id)->delete();

     return redirect()->back()->with('delete',"تم حذف الفرع بنجاح")->with('subcategory_name',$subcategory);
   }

//AJAX

public function validate_subcategory($subcategory){
    if( SubCategory::where('name',$subcategory)->count() > 0 ){
        $data = 'count = 1';
    }else{
        $data = 'count = 0';
       }
        return response()->json($data);
    }



public function fetch_subcategory(Request $request){
$subcategories = SubCategory::where('category_id',$request->id)->get();
$category = Category::findorfail($request->id)->name;
return view('dashboard.subcategory.table',compact('subcategories','category'));

}


public function check_status($subcategory_id){

    $subcategory= SubCategory::findorfail($subcategory_id);

if($subcategory->status == "1"){
   $subcategory->update([
  'status'=>'0'
   ]);
   $subcategory->save();
}else{
   $subcategory->update([
       'status'=>'1'
        ]);
        $subcategory->save();
}

  return response()->json(SubCategory::find($subcategory_id)->status);
   }

   public function check_quantity($sub_category_id){
   $subcategory = SubCategory::findorfail($sub_category_id);
   if($subcategory->size == '0' && $subcategory->color == '0'){
    return response()->json($subcategory->id);
   }
   }
}


