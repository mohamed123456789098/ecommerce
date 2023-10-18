@extends('dashboard.layouts.app')
@section('title')
    الفروع
@endsection
@section('content')
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('assets/dashboard/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>
@if(session()->has('message') || session()->has('category_name'))
<div class="alert alert-success">

    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{session()->get('message')}}   <span style="color: black;font-weight:900">{{session()->get('category_name')}}</span>
</div>
@endif
@if(session()->has('delete')  || session()->has('subcategory_name'))
<div class="alert alert-danger">

    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{session()->get('delete')}}  <span style="font-weight: 900; color:darkslategrey;font-size:1.3rem">{{session()->get('subcategory_name')}}</span>
</div>
@endif


<form enctype="multipart/form-data"  style="margin-left:400px;" action="{{route('admin.subCategoryStore')}}" method="post" id="form">
    @csrf
    @error('name')
    <div class="error" style="width: fit-content;color:red;">{{ $message }}</div>
@enderror
    @error('category_id')
    <div class="error" style="width: fit-content;color:red;">{{ $message }}</div>
@enderror

<button type="submit" class="btn btn-outline-success">اضافه</button>
<input type="text" name="name" id="subcategory"  class="@error('title') is-invalid @enderror">
<label for="subcategory"> : ادخال فرع جديد</label>
<select style="width:200px;color:red;text-align:center" name="category_id" id="">
    <option style="font-weight: 900;color:red" value="" selected disabled>الاقسام</option>
    @foreach ($categories as $category)
        <option style="color: black" value="{{$category->id}}">{{$category->name}}</option>
    @endforeach
</select>

<h6 id="error" style="margin-left: 120px;height:15px;"></h6>

<br>
<div class="color" style="margin-left: 330px">
    <select style="width: 200px;text-align:center;"name="color" id="">
        <option value="" disabled selected>الالوان</option>
        <option value="1">متاح</option>
        <option value="0">غير متاح</option>
    </select>
    <label for="">: الالوان</label>
</div>
@error('color')
<div class="error" style="width: fit-content;color:red;margin-left: 330px">{{ $message }}</div>
@enderror
<div class="size" style="margin-left: 330px">
    <select style="width: 200px;text-align:center;"name="size" id="">
        <option value="" disabled selected>المقاسات</option>
        <option value="2">ارقام</option>
        <option value="1"> حروف</option>
        <option value="0"> غير متاح</option>
    </select>
    <label for="">: المقاسات</label>
</div>
@error('size')
<div class="error" style="width: fit-content;color:red;margin-left: 330px">{{ $message }}</div>
@enderror
<div class="status" style="margin-left: 330px">
    <select style="width: 200px;text-align:center;"name="status" id="">
        <option value="" disabled selected>الحاله</option>
        <option value="1">متاح</option>
        <option value="0"> غير متاح</option>
    </select>
    <label for="">: الحاله</label>
</div>
@error('status')
<div class="error" style="width: fit-content;color:red;margin-left: 330px">{{ $message }}</div>
@enderror
<div id="img_sub" style="margin-left: 200px;margin-top:20px">
    <div class="img">
      <img width="100px" id="profile-pic" src="{{asset('assets/default.png')}}" alt="">
 </div>
  <label style="cursor:pointer" for="input-file">تحميل الصوره </label>
  <input hidden name="image" onchange=" uploadImg()"  type="file" id="input-file" class="@error('title') is-invalid @enderror">
  @error('image')
  <div class="error" style="width: fit-content;color:red;">{{ $message }}</div>
@enderror
  </div>

</form>
<hr>
 @if(! $categories->isEmpty())
<div class="main" style="width: 70%;margin:auto;">
 <div dir="rtl" style="float: right;" class="category" >
    @foreach ($categories as $category)
    <h5 class="category_name" style="cursor: pointer;text-align:end;padding:10px;width:fit-content;background-color:azure">{{$category->name}}</h5>
   <input type="hidden" name="" value="{{$category->id}}">
    @endforeach
</div>
</div>
@else
<h2 style="text-align: center">لا يوجد اقسام متاحه</h2>
<h6 style="text-align: center"><a href="{{route('admin.category')}}">اضافه الاقسام</a></h6>
@endif


<table id="table"  dir="rtl" style="width: 60%; margin:auto;display:table;transition: 5.5s" class="table table-dark">


  </table>








  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script>

  </script>
  {{-- <script>
    var project_state = document.querySelectorAll(".project-state");
    console.log(project_state);

</script> --}}


<script>
var category_name = document.querySelectorAll(".category_name");
var table = document.querySelector("#table");

for(var i = 0 ; i<category_name.length; i++){
    category_name[i].addEventListener("click",function(){

       var id = this.nextElementSibling.value;
       $.ajax({
      url: "{{url('fetch_subcategory')}}",
                      method: "GET",
                      data: {'id':id},
                      success:function(result){
                      $("#table").html(result);
                      var project_state = document.querySelectorAll(".project-state");
                      for(var i = 0 ; i < project_state.length ; i++){
    project_state[i].addEventListener("click",function(){
        console.log(this);
        var status = this.children[0].value;
        var sub_category = this.children[1].value;
        var show_status = this.children[2];
           show_status.innerHTML = "";

        $.ajax({
url : "{{url('check_status_sub_categories')}}/"+sub_category,
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
                    }

  });

    });
}



$(document).ready(function(){
  $("#subcategory").on("blur",function(){
    var subcategory = this.value;
    $("#error").html("");
    if(subcategory == ""){
        $("h6").html("");
    $("#error").append('<span style="color: red"><img style="width:20px" src="{{asset("assets/remove.png")}}" alt=""> الفرع مطلوب  </span>');

}else if(subcategory.length <= 2){
    $("#error").html("");
        $("#error").append('<span style="color: red"> ثلاثه احرف علي الاقل <img style="width:20px" src="{{asset("assets/remove.png")}}" alt=""> </span>');
} else{

        $.ajax({

url: "{{url('validate-subcategory')}}/"+subcategory,
type : "GET",
data: {
_token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success:function(result){
         if(result == 'count = 1'){
            $("#error").html("");
        $("#error").append('<span style="color: red"> <img style="width:20px" src="{{asset("assets/remove.png")}}" alt="">الفرع موجود</span>');
         }else{
            $("#error").html("");
        $("#error").append('<span style="color: green;text-align:center;"> <img style="width:20px" src="{{asset("assets/right.png")}}" alt=""> الفرع متاح  </span>');

         }

      }
    });
    }

  });
});



function uploadImg(){
    let profilePic = document.getElementById("profile-pic");
  let inputFile= document.getElementById("input-file");
  profilePic.src = URL.createObjectURL(inputFile.files[0]);
  }

</script>

<style>

</style>

@endsection


