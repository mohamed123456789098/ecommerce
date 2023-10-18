<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductColorSizeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Fetch-Data_Ajax
Route::get('validate-category/{category}',[CategoryController::class,'validate_category']);
Route::get('validate-product_color/{product_color}',[ProductColorController::class,'validate_product_color']);

Route::get('validate-product-size/{product_size}',[ProductSizeController::class,'validate_product_size']);

Route::get('validate-subcategory/{subcategory}',[SubCategoryController::class,'validate_subcategory']);
Route::get('check_quantity/{sub_category_id}',[SubCategoryController::class,'check_quantity']);
Route::get('fetch_subcategory',[SubCategoryController::class,'fetch_subcategory']);
Route::get('fetch_subcategory_select/{category_id}',[ProductController::class,'fetch_subcategory_select']);
Route::get('check_status_sub_categories/{subcategory_id}',[SubCategoryController::class,'check_status']);
Route::get('check_status_projects/{product_id}',[ProductController::class,'check_status']);

Route::get('fetch_size/{color_id}{product_id}',[ProductColorSizeController::class,'fetch_size']);
Route::get('fetch_size_table/{color_id}{product_id}',[ProductColorSizeController::class,'fetch_size_table']);


Route::prefix('admin')->name('admin.')->group(function(){

Route::middleware('isAdmin')->group(function(){
Route::view('index','dashboard.index')->name('index');



//category
Route::controller(CategoryController::class)->group(function(){
Route::get('category','index')->name('category');
Route::post('category/store','store')->name('categoryStore');
Route::post('category/delete{id}','delete')->name('categoryDelete');
});

//subcategory
Route::controller(SubCategoryController::class)->group(function(){
Route::get('subcategory','index')->name('subCategory');
Route::post('subcategory/store','store')->name('subCategoryStore');
Route::post('subcategory/delete{id}','delete')->name('subCategoryDelete');
});

//product
Route::controller(ProductController::class)->group(function(){
Route::get('product','index')->name('product');
Route::get('add_products{id}','add_products')->name('addProducts');
Route::post('product/store','store')->name('productStore');
Route::post('product/delete{id}','delete')->name('productDelete');

});

//product_color
Route::controller(ProductColorController::class)->group(function(){
    Route::get('product/color','index')->name('productColor');
    Route::post('product/color/store','store')->name('productColorStore');
    Route::post('product/color/delete{id}','delete')->name('productColorDelete');
});
//product_color
Route::controller(ProductSizeController::class)->group(function(){
    Route::get('product/size','index')->name('productSize');
    Route::post('product/size/store','store')->name('productSizeStore');
    Route::post('product/size/delete{id}','delete')->name('productSizeDelete');
});
//product_color_size
Route::controller(ProductColorSizeController::class)->group(function(){
    Route::post('productcolorsizestore','store')->name('productColorSizeStore');
    Route::post('productcolorsize/delete{id}','delete')->name('productSizeDelete');
});



});

Route::get('livewire',function(){
return view('test');
});
require __DIR__.'/admin_auth.php';

});

