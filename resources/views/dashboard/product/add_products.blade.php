@extends('dashboard.layouts.app')
@section('title')
    المنتجات
@endsection
@section('content')
@if(session()->has('error') )
<div class="alert alert-danger">
  <div> {{session()->get('error')}} </div>
</div>
@endif
@if(session()->has('delete') )
<div class="alert alert-success">
  <div> {{session()->get('delete')}} </div>
</div>
@endif

<form action="{{route('admin.productColorSizeStore')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
    <input type="hidden" name="name" id="name" value="{{$product->name}}">

    <h3 style="text-align: center">اسم المنتج الاساسي : <span style="color: red">{{$product->name}}</span> </h3>



    <select  name="color" id="color">
    <option value="" selected disabled>اختر اللون</option>
    @foreach ($colors as $color)
    @if( ! in_array($color->id,$arr_color_id))
    <option value="{{$color->id}}">{{$color->name}}</option>
    @endif
    @endforeach
    </select>

    <br>



    @if ($product->sub_category->size == '1')
    @foreach ($sizes as $size)

     @if (! is_numeric($size->name))
     <label for="{{$size->id}}">{{$size->name}}</label>
     <input type="checkbox" name="size[]" id="{{$size->id}}" value="{{$size->id}}">

     <div style="height: 30px"></div>
     <br>
    @endif


    @endforeach

    @elseif ($product->sub_category->size == '2')
    @foreach ($sizes as $size)
    @if ( is_numeric($size->name))
    <label for="{{$size->id}}">{{$size->name}}</label>
    <input type="checkbox" name="size[]" id="{{$size->id}}" value="{{$size->id}}">

    <div style="height: 30px"></div>
    <br>

   @endif
   @endforeach

   @else

   <label for="">quantity</label>
   <input type="number" name="quantity">

    @endif

    <select name="status" id="">
    <option value="" selected disabled>الحاله</option>
    <option value="1">متاح</option>
    <option value="0">غير متاح</option>
    </select>


    <div id="img_sub" style="margin-top:20px">
        <div class="img" id="myImg" style="min-height:170px">

     </div>

      <label style="cursor:pointer" for="input-file" class="btn btn-danger ">تحميل الصور </label>

      <input hidden multiple  name="image[]"   type="file" id="input-file" class="imgss">

      </div>



      <button type="submit">اضافه</button>
    </form>











@if($product->sub_category->size == '1' || $product->sub_category->size == '2')
<?php

for ($i=0; $i < count($avilable_color); $i++) {
foreach (DB::table('product_colors')->where('id', $avilable_color[$i]->product_color_id)->get() as $key => $value) {?>
<div class="main" style="width: 70%;margin:auto;">
<input type="hidden" name="" value="{{$value->id}}" class="color_id">
<input type="hidden" name="" value="{{$product->id}}" class="product_id">
<h3 style="text-align: center ;"> اللون : <?= $value->name ?></h3>
<button style="margin-left: 300px;" type="button" class="btn btn-primary add_product"   data-toggle="modal" data-target="#exampleModal">
    اضافه
  </button>
<?php
foreach (DB::table('product_image')->where('product_id',$product->id)->where('product_color_id',$avilable_color[$i]->product_color_id)->get() as $key => $value) {

$image = explode(" ", $value->image);?>

<div class="imgs" style="display:flex;justify-content: center;position:relative;" class="images">
<input class="n" type="hidden" name="" value="0">

<?php  for ($y=0; $y <count($image) ; $y++) { ?>

<img class="images"  style="height: 100px;display:none;" src="{{asset('assets/dashboard/images/product_color_size/'. $product->name . '/' . $image[$y])}}" alt="">

<?php
}?>
<a class="next" style="position: absolute;top:50%;right:40%;cursor:pointer;text-decoration: none;">❯</a>
<a class="prev" style="position: absolute;top:50%;left:40%;cursor:pointer;text-decoration: none;">❮</a>

</div>
<?php
}


?>

<table  dir="rtl" style="width: 60%; margin:auto;margin-bottom:100px" class="table table-dark">

<thead >
  <tr>
    <th style="background-color: red" style="text-align: right"  scope="col">المقاس</th>
    <th style="background-color: red" style="text-align: right" scope="col">الكميه</th>
    <th style="background-color: red" style="text-align: right" scope="col">السعر</th>
    <th style="background-color: red" style="text-align: right" scope="col">الخصم</th>
    <th style="background-color: red" style="text-align: center" scope="col">العمليات</th>
    {{-- <th style="background-color: red" style="text-align: center" scope="col"> <button sty type="button" class="btn btn-primary " data-toggle="modal" data-target=".bd-example-modal-lg"> اضافه منتج رئيسي</button></th> --}}

  </tr>
</thead>

<tbody>
  <tr>
    <?php
    if(! empty($avilable_color)){


    foreach ( DB::table('product_color_size')->where('product_color_id',$avilable_color[$i]->product_color_id)->where('product_id', $product->id)->get(['product_size_id','quantity','price','discount','id']) as $key => $value) {?>

    <td><?php
     foreach (DB::table('product_sizes')->where('id',$value->product_size_id)->get('name') as $size) {
        echo $size->name;
     }
    ?></td>
    <td><?= $value->quantity?></td>
    <td><?= $value->price ?></td>
    <td><?= $value->discount ?></td>
    <td>
        <form style="display: inline-block" action="{{route('admin.productSizeDelete',$value->id)}}" method="post">
            @csrf
            <button type="submit">حذف</button>
        </form>
        <button>test</button>
    </td>
  </tr>

<?php
 }
}
?>
</tbody>
</table>
</div>
<?php
}}
?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('admin.productColorSizeStore')}}" method="post">
            @csrf
            <div class="color"></div>
            <input type="hidden" name="product_id" value="{{$product->id}}" class="product_id">

       <div id="select"></div>


        </div>
        <select name="status" id="">
            <option value="" selected disabled>الحاله</option>
            <option value="1">متاح</option>
            <option value="0">غير متاح</option>
            </select>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">اضافه</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@else


<table dir="rtl" style="width: 60%; margin:auto;margin-bottom:100px" class="table table-dark">
<tr>
    <th>اللون</th>
    <th>الكميه</th>
    <th>الخصم</th>
    <th>السعر</th>
    <th>الحاله</th>
    <th>الصوره</th>
    <th>العمليات</th>
</tr>
@foreach ( $products_color as $value )
<tr>
    <td>
    @php
 echo(  DB::table('product_colors')->where('id',$value ->product_color_id)->first()->name);
  @endphp
    </td>

    <td>{{$value ->quantity}}</td>
    <td>{{$value ->discount}}</td>
    <td>{{$value ->price}}
    <td>{{$value ->status}}
    <td>
    @php
   $image_product  = DB::table('product_image')->where('id',$value ->product_image_id)->first()->image;
   $imgs_arr =  explode(" ",$image_product);
//    echo $imgs_arr[0];
    @endphp

<div class="imgs" style="display:flex;justify-content: center;position:relative;" class="images">
    <input class="n" type="hidden" name="" value="0">

    <?php  for ($z=0; $z <count($imgs_arr) ; $z++) { ?>

    <img class="images"  style="height: 100px;display:none;" src="{{asset('assets/dashboard/images/product_color_size/'.$product->name.'/' . $imgs_arr[$z])}}" alt="">

    <?php
    }?>
    <a class="next" style="position: absolute;top:50%;right:40%;cursor:pointer;text-decoration: none;">❯</a>
    <a class="prev" style="position: absolute;top:50%;left:40%;cursor:pointer;text-decoration: none;">❮</a>

    </div>





    </td>

    <td></td>
</tr>
@endforeach
</table>

@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>

var add_product = document.querySelectorAll(".add_product");
$(document).ready(function(){

for (let i = 0; i < add_product.length; i++) {
    add_product[i].addEventListener("click",function(){
        var parent = this.parentElement;
        var color_id = parent.querySelector(".color_id").value;
        var product_id = parent.querySelector(".product_id").value;
    $(".color").html('<input type="hidden" name="color" value='+color_id+' class="color_id">')
        $.ajax({
url : "{{url('fetch_size_table')}}/"+color_id + product_id,
type : "GET",
data: {
_token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success:function(size){

        $("#select").html("");
        var size_exept = [];


        $.each(size.size_exept, function (key, value) {
            size_exept.push(value.product_size_id);
                    });

                    $.each(size.sizes , function(key ,value){
          if(! size_exept.includes(value.id)){

            if(size.type == 2 && !isNaN(value.name) === true){
                $("#select").append('<label  for="'+ value.name +'">'+value.name+'</label><input class="checkbox" value ='+value.id+ ' type="checkbox" name="size[]" id="'+ value.name +'"><h2></h2>');
            }else if(size.type == 1 && isNaN(value.name) === true){
                $("#select").append('<label  for="'+ value.name +'">'+value.name+'</label><input class="checkbox" value ='+value.id+ ' type="checkbox" name="size[]" id="'+ value.name +'"><h2></h2>');
            }

          }
     });

var add_checkbox = document.querySelectorAll(".checkbox");
for (let i = 0; i < add_checkbox.length; i++) {

add_checkbox[i].addEventListener("change",function(){

 if(this.checked === true){

        this.nextElementSibling.innerHTML = '<label style="font-size:.8rem" for="quantity">quantity</label><input type="number" name="quantity[]" id="" style="width:90px;height:15px;font-size:.8rem"><label style="font-size:.8rem" for="price">price</label><input type="number" name="price[]" id="" style="width:90px;height:15px;font-size:.8rem"><label style="font-size:.8rem" for="discount">discount</label><input type="number" name="discount[]" id="" style="width:90px;height:15px;font-size:.8rem">'
    }else{
        this.nextElementSibling.innerHTML = "";
    }
});
}


      }
});

    });
}
});
</script>



<script>
    var imgs = document.querySelectorAll(".imgs");
    var next = document.querySelectorAll(".next");
var prev = document.querySelectorAll(".prev");
    // console.log(imgs);
for (let i = 0; i < imgs.length; i++) {
    imgs[i].children[1].style.display = 'inline-block';

}

for(var i = 0 ; i < next.length ; i++){
next[i].addEventListener("click",function(){
var parent = (this.parentElement);

parent.querySelector(".n").value++;
var n = parent.querySelector(".n").value;

var images =  parent.querySelectorAll(".images");

images.forEach((x) => {
 x.style.display = "none";
});
if(n == images.length){
    parent.querySelector(".n").value = '0';
    n = 0 ;
}

images[n].style.display = 'inline-block';
});
}

for(var i = 0 ; i < prev.length ; i++){
prev[i].addEventListener("click",function(){
var parent = (this.parentElement);
parent.querySelector(".n").value--;
var n = parent.querySelector(".n").value;

var images =  parent.querySelectorAll(".images");


images.forEach((x) => {
 x.style.display = "none";
});
if(n < 0 ){
    parent.querySelector(".n").value = images.length - 1;
    n =images.length - 1 ;
}

images[n].style.display = 'inline-block';
});
}
</script>














<script>

var checkBox = document.querySelectorAll('input[type="checkbox"]');

for (let i = 0; i < checkBox.length; i++) {

checkBox[i].addEventListener("change",function(){

    if(this.checked === true){

        this.nextElementSibling.innerHTML = '<label for="quantity">quantity</label><input type="number" name="quantity[]" id=""><label for="price">price</label><input type="number" name="price[]" id=""><label for="discount">discount</label><input type="number" name="discount[]" id="">'
    }else{
        this.nextElementSibling.innerHTML = "";
    }
});
}
</script>





<script>
    $(document).ready(function(){
$("#color").on("change",function(){
product_id = document.getElementById("product_id").value;
var color_id = this.value ;
$("#size").html("    <option selected disabled>اختر المقاس</option>");
$.ajax({
url : "{{url('fetch_size')}}/"+color_id + product_id,
type : "GET",
data: {
_token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success:function(size){

        var size_exept = [];
        //  console.log(size.sizes);
        //  console.log(size.size_exept);

        $.each(size.size_exept, function (key, value) {
            size_exept.push(value.product_size_id);
                    });

    //  console.log( size_exept);

     $.each(size.sizes , function(key ,value){

          if(! size_exept.includes(value.id)){
            $("#size").append('<option value ="'+value.id+'">' + value.name + '</option>');
          }
     });

      }
});
});
});
</script>





<script>
  $(function() {
  $(":file").change(function() {
    if (this.files && this.files[0]) {
      for (var i = 0; i < this.files.length; i++) {
        var reader = new FileReader();
        reader.onload = imageIsLoaded;
        reader.readAsDataURL(this.files[i]);
      }
    }
  });
});

function imageIsLoaded(e) {
  $('#myImg').append('<img style="width:120px;height:120px;margin:4px " src=' + e.target.result + '>');
//   $('.test').append('<img style="width:120px;height:120px;margin:4px " src=' + e.target.result + '>');
};
</script>
{{-- <script>
const arr = ['zero', 'one', 'two'];

const obj1 = Object.assign({}, arr);
console.log(arr);
console.log(obj1);
</script> --}}
    {{-- <script>
    $( document ).ready(function() {
        console.log( "document loaded" );
    });

    $( window ).on( "load", function() {
        alert( "window loaded" );
    });
    </script> --}}

@endsection


