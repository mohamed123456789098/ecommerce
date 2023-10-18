@extends('dashboard.layouts.app')
@section('title')
    الاقسام
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
@if(session()->has('delete')  || session()->has('category_name2'))
<div class="alert alert-danger">

    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{session()->get('delete')}}     <span style="font-weight: 900; color:darkslategrey;font-size:1.3rem">{{session()->get('category_name2')}}</span>
</div>
@endif
<form style="margin-left:400px;" action="{{route('admin.categoryStore')}}" method="post" id="form">
    @csrf
    @error('name')
    <div class="error" style="width: fit-content;color:red;">{{ $message }}</div>
@enderror
<button type="submit" class="btn btn-outline-success">اضافه</button>
<input type="text" name="name" id="category"  class="@error('title') is-invalid @enderror">
<label for="category"> : ادخال قسم جديد</label>
    <h6 id="error" style="margin-left: 120px;height:15px;"></h6>
</form>
@if(! $categories->isEmpty())

<table dir="rtl" style="width: 60%; margin:auto;" class="table table-dark">

    <thead>
      <tr>
        <th scope="col">الرقم</th>
        <th scope="col">الاقسام</th>
        <th scope="col">الحذف/التعديل</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <?php $i = 1?>
        @foreach($categories as $category)
        <th scope="row"><?= $i++ ?></th>
        <td>{{$category->name}}</td>


        <td>
         <form action="{{route('admin.categoryDelete',$category->id)}}" method="post">
            @csrf
            <button onclick="return confirm('Are you sure you want to delete this item?')" type="submit" class="btn btn-danger">حذف</button>
         </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <div style="background-color: black;color:white;text-align:center">لا يوجد أقسام </div>
  @endif

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>


// const globalRegex = new RegExp('foo*', 'g');
// console.log(/[^a-zA-Z]/.test('f2'));




$(document).ready(function(){
  $("#category").on("blur",function(){
    var category = this.value;
    $("#error").html("");
    if(category == ""){
        $("h6").html("");
    $("#error").append('<span style="color: red"><img style="width:20px" src="{{asset("assets/remove.png")}}" alt=""> القسم مطلوب  </span>');
    // }else if(/[^a-zA-Z]/.test(category) == true){
    //     $("#error").html("");
    //     $("#error").append('<span style="color: red"> Category  Must Not Contain a NUMBER <img style="width:20px" src="{{asset("assets/remove.png")}}" alt=""> </span>');
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

  })
})
</script>


@endsection


