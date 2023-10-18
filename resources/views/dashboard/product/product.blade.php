@extends('dashboard.layouts.app')
@section('title')
    المنتجات
@endsection
@section('content')
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('assets/dashboard/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif




@if(session()->has('message') || session()->has('product_name'))
<div class="alert alert-success">

    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{session()->get('message')}}   <span style="color: black;font-weight:900">{{session()->get('product_name')}}</span>
</div>
@endif


@if(session()->has('delete')  || session()->has('product_name2'))
<div class="alert alert-danger">

    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{session()->get('delete')}}     <span style="font-weight: 900; color:darkslategrey;font-size:1.3rem">{{session()->get('product_name2')}}</span>
</div>
@endif


<h6 id="error" style="margin-left: 120px;height:15px;"></h6>


<!-- Large modal -->
<div >
<button style="float: right" type="button" class="btn btn-primary mb-5 mr-3" data-toggle="modal" data-target=".bd-example-modal-lg"> اضافه منتج رئيسي</button>
<br>
<br>
<br>
<br>

</div>
<?php
$y = 1;
?>
@foreach ($categories as $category)
<div  style="text-align:center;padding:10px 0;margin-bottom:10px;font-size:1.6rem"  class="bg-warning"> قسم {{$category->name}}</div>
@foreach ($category->sub_category as $subcategory)


<?php
$y++;

?>


<button  style="width:50%;margin:auto" type="button" data-toggle="collapse" data-target="#multiCollapseExample<?= $y ?>" aria-expanded="false" aria-controls="multiCollapseExample<?= $y ?>" class="btn btn-primary btn-lg btn-block"> {{$subcategory->name}}</button>
<br>
<div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample<?= $y ?>">
      <div class="card card-body">

          <section class="content">

            <div class="card">

              <div class="card-body p-0">
                 @if (! $subcategory->product->isEmpty())

                <table class="table table-striped projects" dir="rtl">

                    <thead  style="text-align:center">
                        <tr>
                            <th  style="width: 10%;">
                                اسم المنتج
                            </th>
                            <th style="width: 15%">
                                التفاصيل
                            </th>
                            <th style="width: 10%">
                                الكميه
                            </th>
                            <th style="width: 10%">
                                السعر الاساسي
                            </th>
                            <th style="width: 15%" >
                                الخصم الاساسي
                            </th>
                            <th style="width: 10%">
                                الحاله
                            </th>
                            {{-- <th style="width: 1%">
                                الكميه
                            </th> --}}
                            <th style="width: 16%">
                                الصور
                            </th>
                            <th style="width: 20%">
                                الاعدادت
                            </th>
                        </tr>
                    </thead>
                    <tbody  style="text-align:center">



                    @foreach ($subcategory->product as $product)


                        <tr>

                            <td>
                               {{$product->name}}
                            </td>

                            <td >
                             <div style="height: 25px;overflow:hidden" >
                                {{$product->details}}
                            </div>
                            <button style="border: none;font-size:.7rem;margin-top:10px;color:blue" class="btn_show_more">تفاصيل اكثر </button>
                            </td>

                            <td >
                             <div>
                                @if ($product->total_quantity == '')
                                    لا يوجد
                                    @else
                                    {{$product->total_quantity}}
                                @endif
                            </div>
                            </td>
                            <td >
                             <div>
                                {{$product->main_price}}  EG
                            </div>
                            </td>

                            <td>
                                @if ($product->main_discount!= null)
                                <div>
                                    {{$product->main_discount}}  EG
                                </div>
                                @else
                                <div>
                                لا يوجد خصم حاليا
                                </div>
                                @endif

                            </td>

                            <td class="project-state" style="cursor: pointer;">
                                    <input type="hidden" name="" value="" class="status">
                                    <input type="hidden" name="" value="{{$product->id}}" class="product_id">
                                     @if ($product->status == '1')


                                    <div class="show_status">

                                        <span  class="btn btn-success" style="padding: 5px 15px">
                                            متاح
                                        </span>
                                      @else
                                        <span  class="btn btn-danger" style="padding: 5px 15px">
                                            غير متاح
                                        </span>

                                    </div>

                                    @endif
                            </td>

                            <td>

                             <div class="main_image" style="position:relative;width:200px; height:100px;margin:auto">
                                <input class="n" type="hidden" name="" value="0">
                                <?php
                                $image = explode(" ",$product->image);
                               for ($i=0; $i < count($image) ; $i++) {
                                ?>
<img class="images" style="width:200px; height:100px; display:none " src="{{asset('assets/dashboard/images/product/'.$product->name."/".$image[$i])}}" alt="">
                              <?php }?>

                                <a class="next" style="position: absolute;top:50%;right:10%;cursor:pointer">❮</a>
                                <a class="prev" style="position: absolute;top:50%;left:10%;cursor:pointer">❯</a>

                             </div>

                              </td>

                            <td  style="" class="project-actions text-right">
                              <button style=""  class="btn btn-danger btn-sm" type="submit">
                                <i class="fas fa-trash">
                                </i>
                                حذف
                            </button>

                                <button style="margin-bottom: 5px"  class="btn btn-info btn-sm" href="#">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    تعديل
                                </button>

                                   @if ($product->sub_category->color == '0' && $product->sub_category->size == '0')
                                   <a href="{{route('admin.addProducts',$product->id)}}" class="btn btn-primary btn-sm disabled">
                                    <i class="fas fa-folder">
                                    </i>
                                    عرض منتجات
                                  </a>
                                  @else
                                  <a href="{{route('admin.addProducts',$product->id)}}" class="btn btn-primary btn-sm ">
                                    <i class="fas fa-folder">
                                    </i>
                                    عرض منتجات

                                  </a>
                                   @endif









                            </td>
                        </tr>

                        <tr>
                            <td style="justify-content: space-evenly" colspan="8" style="text-align:right;">

                              <div class="all_details" style="display:none">
                              {{$product->details}}
                              </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h3 style="color:blue;text-align:center">لا يوجد منتجات متاحه</h3>
                @endif

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </section>



      </div>
    </div>
  </div>

@endforeach
@endforeach




<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header bg-primary" >
            <h5  class="modal-title">اضافه منتج جديد</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <section class="content">
            <div class="row">
              <div class="col-md-9 m-auto" >
                <div class="card card-primary">

        <form action="{{route('admin.productStore')}}" method="post" enctype="multipart/form-data" >

                @csrf
                  <div dir="rtl"  class="card-body" style="text-align: right" >
                    <div class="form-group" >
                      <label for="inputName">اسم المنتج</label>
                      <input  type="text" id="inputName" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                      <label for="inputDescription">الوصف</label>
                      <textarea id="inputDescription" class="form-control" rows="4" name="details"></textarea>
                    </div>

                    <div style="justify-content: space-between;display:flex;text-align: center">

                     <div class="form-group" style="width: 18%" >
                      <label for="inputStatus"> الاقسام</label>

                      <select class="form-control custom-select"  name="category" id="category">
                        <option style="font-weight: 900;" value="" selected disabled>الاقسام</option>
                        @foreach ($categories as $category)
                            <option style="color: black" value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    </div>

                     <div class="form-group" style="width: 18%">
                      <label for="inputStatus"> الفروع</label>
                      <select class="form-control custom-select"  name="sub_category_id" id="sub_category">
                        <option style="font-weight: 900;" value="" selected disabled>الفروع</option>

                    </select>
                    </div>





                     <div class="form-group" style="width: 18%">
                      <label for="inputStatus">حاله المنتج</label>
                      <select id="inputStatus" class="form-control custom-select" name="status">
                        <option selected disabled> المنتج </option>
                        <option value="1">متاح </option>
                        <option value="0">غير متاح </option>
                      </select>
                    </div>
                    </div>


                    <div class="form-group">
                      <label for="inputClientCompany">السعر الاساسي</label>
                      <input type="number" id="inputClientCompany" class="form-control" name="main_price">
                    </div>

                    <div class="form-group">
                      <label for="inputClientCompany">الخصم الاساسي</label>
                      <input type="number" id="inputClientCompany" class="form-control" name="main_discount">
                      <span style="color:red">(اختياري)</span>
                    </div>

                    <div class="form-group">
                        <div class="quantity">

                        </div>

                    </div>

                    <div id="img_sub" style="margin-top:20px">
                        <div class="img" id="myImg" style="min-height:170px">
                     </div>
                      <label style="cursor:pointer" for="input-file" class="btn btn-danger ">تحميل الصور </label>
                      <input hidden multiple  name="image[]"   type="file" id="input-file" class="@error('title') is-invalid @enderror">
                      @error('image')
                      <div class="error" style="width: fit-content;color:red;">{{ $message }}</div>
                    @enderror
                      </div>



                    <button type="submit" class="btn btn-success float-right">اضافه منتج جديد</button>
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>

            </div>

          </section>
    </div>
  </div>
</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
   $("#sub_category").on("change",function(){
   sub_category_id = this.value;
   $(".quantity").html("");
   $.ajax({
url : "{{url('check_quantity')}}/"+sub_category_id,
type : "GET",
data: {
_token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success:function(result){
      if(result){
        console.log(result);
       $(".quantity").html('<label for="inputClientCompany"> الكميه</label><input type="number" id="inputClientCompany" class="form-control" name="quantity"><input type="hidden" name="size_color" value="'+result+'">');
      }


      }
});
   });
    });
  </script>
<script>
    var project_state = document.querySelectorAll(".project-state");

for(var i = 0 ; i < project_state.length ; i++){
    project_state[i].addEventListener("click",function(){
        var status = this.children[0].value;
        var product_id = this.children[1].value;
        var show_status = this.children[2];
           show_status.innerHTML = "";

        $.ajax({
url : "{{url('check_status_projects')}}/"+product_id,
type : "GET",
data: {
_token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success:function(result){
        if(result == "0"){
            const span = document.createElement("span");
            const node = document.createTextNode("غير متاح");
            span.classList.add("btn-danger");
            span.classList.add("btn");
            span.style.padding = "5px 15px";
            span.appendChild(node);
            show_status.appendChild(span);
        }else{
            const span = document.createElement("span");
            const node = document.createTextNode(" متاح");
            span.classList.add("btn-success");
            span.classList.add("btn");
            span.style.padding = "5px 15px";
            span.appendChild(node);
            show_status.appendChild(span);
        }


      }
});
    });
}
</script>










<script>
var btn_show_more = document.querySelectorAll(".btn_show_more");

var all_details =document.querySelectorAll(".all_details");
// console.log(btn_show_more);
for(var i = 0 ; i < btn_show_more.length ; i++){
    btn_show_more[i].addEventListener("click",function(){


        if(this.parentElement.parentElement.nextElementSibling.children[0].children[0].style.display == "none"){


            all_details.forEach((x) => {
            x.style.display = "none";
           });

           btn_show_more.forEach((x) => {
            x.style.color = "blue";
            x.innerHTML = "تفاصيل اكثر ";
           });

           this.parentElement.parentElement.nextElementSibling.children[0].children[0].style.display = "block";
           this.style.color = "green";
           this.innerHTML = "تفاصيل اقل ";

        }else if(this.parentElement.parentElement.nextElementSibling.children[0].children[0].style.display == "block"){

        all_details.forEach((x) => {
        x.style.display = "none";
           });

           btn_show_more.forEach((x) => {
            x.style.color = "blue";
            x.innerHTML = "تفاصيل اكثر ";
           });
        }



    });



}


</script>



<script>
var next = document.querySelectorAll(".next");
var prev = document.querySelectorAll(".prev");

var main_image = document.querySelectorAll(".main_image");

    for(var i = 0 ; i < main_image.length ; i++){
        main_image[i].children[1].style.display = 'inline-block';

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

$(document).ready(function(){
$("#category").on("change",function(){
var category_id = this.value ;
$(".quantity").html("");
$("#sub_category").html("<option style='font-weight: 900;color:red' selected disabled>الفروع</option>");
$.ajax({
url : "{{url('fetch_subcategory_select')}}/"+category_id,
type : "GET",
data: {
_token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success:function(result){
        if(result.length == false){
            $("#sub_category").html("<option disabled selected>لا يوجد فروع </option>");
        }
       result.forEach(value => {
           $("#sub_category").append("<option value="+ value.id+">"+value.name+"</option>");
       });

      }
});
});
});





$(document).ready(function(){
  $("#product").on("blur",function(){
    var category = this.value;
    $("#error").html("");
    if(category == ""){
        $("h6").html("");
    $("#error").append('<span style="color: red"><img style="width:20px" src="{{asset("assets/remove.png")}}" alt=""> القسم مطلوب  </span>');

}else if(category.length <= 2){
    $("#error").html("");
        $("#error").append('<span style="color: red"> ثلاثه احرف علي الاقل <img style="width:20px" src="{{asset("assets/remove.png")}}" alt=""> </span>');
} else{

        $.ajax({

url: "{{url('validate-category')}}/"+category,
type : "GET",
data: {
_token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success:function(result){
         if(result == 'count = 1'){
            $("#error").html("");
        $("#error").append('<span style="color: red"> <img style="width:20px" src="{{asset("assets/remove.png")}}" alt="">القسم موجود</span>');
         }else{
            $("#error").html("");
        $("#error").append('<span style="color: green;text-align:center;"> <img style="width:20px" src="{{asset("assets/right.png")}}" alt=""> القسم متاح  </span>');

         }

      }
    });
    }

  });
});

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
};

</script>


@endsection


