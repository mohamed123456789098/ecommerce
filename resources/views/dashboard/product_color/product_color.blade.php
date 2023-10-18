@extends('dashboard.layouts.app')
@section('title')
    الوان المنتجات
@endsection
@section('content')

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('assets/dashboard/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>
  @if(session()->has('message') || session()->has('product_color'))
  <div class="alert alert-success">

      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
      {{session()->get('message')}}   <span style="color: black;font-weight:900">{{session()->get('product_color')}}</span>
  </div>
  @endif
  @if(session()->has('delete')  || session()->has('product_color2'))
  <div class="alert alert-danger">

      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
      {{session()->get('delete')}}     <span style="font-weight: 900; color:darkslategrey;font-size:1.3rem">{{session()->get('product_color2')}}</span>
  </div>
  @endif
  <form style="margin-left:400px;" action="{{route('admin.productColorStore')}}" method="post" id="form">
    @csrf
    @error('name')
    <div class="error" style="width: fit-content;color:red;">{{ $message }}</div>
@enderror
<button type="submit" class="btn btn-outline-success">اضافه</button>
<input type="text" name="name" id="product_color"  class="@error('title') is-invalid @enderror">
<label for="category"> : ادخال لون جديد</label>
    <h6 id="error" style="margin-left: 120px;height:15px;"></h6>
</form>
<hr>
<div class="main" style="justify-content:space-evenly;display:flex;flex-wrap:wrap">

    <table dir="rtl" style="width: 60%; margin:auto;" class="table table-dark">

        <thead>
          <tr>
            <th scope="col">الرقم</th>
            <th scope="col">اللون</th>
            <th scope="col">الحذف/التعديل</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <?php $i = 1?>
            @foreach($product_color as $value)
            <th scope="row"><?= $i++ ?></th>
            <td>{{$value->name}}</td>


            <td>
             <form action="{{route('admin.productColorDelete',$value->id)}}" method="post">
                @csrf
                <button onclick="return confirm('Are you sure you want to delete this item?')" type="submit" class="btn btn-danger">حذف</button>
             </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>


</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>


// const globalRegex = new RegExp('foo*', 'g');
// console.log(/[^a-zA-Z]/.test('f2'));




$(document).ready(function(){
  $("#product_color").on("blur",function(){
    var product_color = this.value;
    $("#error").html("");
    if(product_color == ""){
        $("h6").html("");
    $("#error").append('<span style="color: red"><img style="width:20px" src="{{asset("assets/remove.png")}}" alt=""> اللون مطلوب  </span>');
}else if(product_color.length <= 2){
    $("#error").html("");
        $("#error").append('<span style="color: red"> ثلاثه احرف علي الاقل <img style="width:20px" src="{{asset("assets/remove.png")}}" alt=""> </span>');
} else{

        $.ajax({

url: "{{url('validate-product_color')}}/"+product_color,
type : "GET",
data: {
_token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success:function(result){
        console.log(result);

         if(result == 'count = 1'){

            $("#error").html("");
        $("#error").append('<span style="color: red"> <img style="width:20px" src="{{asset("assets/remove.png")}}" alt="">اللون موجود</span>');
         }else{
            $("#error").html("");
        $("#error").append('<span style="color: green;text-align:center;"> <img style="width:20px" src="{{asset("assets/right.png")}}" alt=""> اللون متاح  </span>');

         }

      }
    });
    }

  })
})
</script>
@endsection
