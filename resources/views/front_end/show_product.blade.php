@extends('front_end.layouts.app')
@section('title')
Show Product
@endsection
@section('content')
<section class="ftco-section" style="">

    <div class="container">
        <div class="row">

            <div class="col-lg-6 mb-5 ftco-animate" style="position: relative;" >
                <a href="{{asset('assets/dashboard/images/product/'.$product->name.'/'.$product->image)}}" class="image-popup prod-img-bg"><img src="{{asset('assets/dashboard/images/product/'.$product->name.'/'.$product->image)}}"
                    class="img-fluid" alt="Colorlib Template"></a>

                    <a class="next" style="cursor:pointer;text-decoration: none;">❯</a>
                    <a class="prev" style="cursor:pointer;text-decoration: none;">❮</a>

            </div>

<style>
    .next{
        position: absolute;
        top:50%;
        right: 0;

    }
    .prev{
        position: absolute;
        top:50%;
        left: 0;

    }
</style>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                <h3>{{$product->name}}</h3>
                <div class="rating d-flex">
                        <p class="text-left mr-4">
                            <a href="#" class="mr-2">5.0</a>
                            <a href="#"><span class="ion-ios-star-outline"></span></a>
                            <a href="#"><span class="ion-ios-star-outline"></span></a>
                            <a href="#"><span class="ion-ios-star-outline"></span></a>
                            <a href="#"><span class="ion-ios-star-outline"></span></a>
                            <a href="#"><span class="ion-ios-star-outline"></span></a>
                        </p>
                        <p class="text-left mr-4">
                            <a href="#" class="mr-2" style="color: #000;">100 <span style="color: #bbb;">Rating</span></a>
                        </p>
                        <p class="text-left">
                            <a href="#" class="mr-2" style="color: #000;">500 <span style="color: #bbb;">Sold</span></a>
                        </p>
                    </div>
                <p class="price"><span>جنيه {{$product->main_price}}</span></p>
                <p>{{$product->details}}</p>
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <div class="form-group d-flex">
                  <div class="select-wrap">
                  <div class="icon"><span class="ion-ios-arrow-down"></span></div>


                  <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">



                  <select name="" id="colors" class="form-control">
                      <option value="" disabled selected>الالوان المتاحه</option>

                      @for ($i = 0 ; $i < count($arr_color_id) ; $i++)

                      @foreach ( DB::table('product_colors')->where('id',$arr_color_id[$i])->get() as $value)

                     <option value= {{$value->id}}>
                            {{$value->name}}
                        @endforeach
                     </option>

                      @endfor

                  </select>


                </div>
                </div>
                <form style="" action="{{route('test')}}" method="post">
                    @csrf
                    <div class="size" style="margin-top: 20px;display:flex;justify-content: space-between;  flex-wrap:wrap">
                    @if ($sub_category_size == '1')
                    @foreach ($sizes as $size)
                        @if (is_numeric($size->name) !== true)

                               <div class="box" style="border:1px solid #ddd;text-align:center;color:#ddd;margin-bottom:5px;width:15%">

                                   <label class="label" style="width:100%;height:100%;cursor:ns-resize;display:flex;align-items:center;justify-content:center;" for="{{$size->id}}">
                                    {{$size->name}}

                                    <input class="input_size"  type="hidden"  value="{{$size->id}}">

                                     {{-- <input class="input_radio" hidden type="radio" name="size" id="{{$size->name}}" value="{{$size->id}}"> --}}
                                   </label>
                               </div>




                        @endif
                    @endforeach

                    @endif

                    @if ($sub_category_size == '2')
                    @foreach ($sizes as $size)
                        @if (is_numeric($size->name) === true)

                               <div class="box" style="border:1px solid #ddd;text-align:center;color:#ddd;margin-bottom:5px;width:15%">

                                   <label class="label" style="width:100%;height:100%;cursor:ns-resize;display:flex;align-items:center;justify-content:center;" for="{{$size->id}}">
                                    {{$size->name}}

                                    <input class="input_size"  type="hidden"  value="{{$size->id}}">

                                     {{-- <input class="input_radio" hidden type="radio" name="size" id="{{$size->name}}" value="{{$size->id}}"> --}}
                                   </label>
                               </div>




                        @endif
                    @endforeach

                    @endif




                   </div>

                                 <button type="submit">test</button>
                       </form>
                        </div>
                        <div class="w-100"></div>
                        <div class="input-group col-md-6 d-flex mb-3">
                 <span class="input-group-btn mr-2">
                    <button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
                   <i class="ion-ios-remove"></i>
                    </button>
                    </span>
                 <input type="text" id="quantity" name="quantity" class="quantity form-control input-number" value="1" min="1" max="100">
                 <span class="input-group-btn ml-2">
                    <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                     <i class="ion-ios-add"></i>
                 </button>
                 </span>
              </div>
              <div class="w-100"></div>
              <div class="col-md-12">
                  <p style="color: #000;">80 piece available</p>
              </div>
          </div>
          <p><a href="cart.html" class="btn btn-black py-3 px-5 mr-2">Add to Cart</a><a href="cart.html" class="btn btn-primary py-3 px-5">Buy now</a></p>
            </div>
        </div>




        <div class="row mt-5">
      <div class="col-md-12 nav-link-wrap">
        <div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <a class="nav-link ftco-animate active mr-lg-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Description</a>

          <a class="nav-link ftco-animate mr-lg-1" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Manufacturer</a>

          <a class="nav-link ftco-animate" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Reviews</a>

        </div>
      </div>
      <div class="col-md-12 tab-wrap">

        <div class="tab-content bg-light" id="v-pills-tabContent">

          <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="day-1-tab">
              <div class="p-4">
                  <h3 class="mb-4">Nike Free RN 2019 iD</h3>
                  <p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
              </div>
          </div>

          <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-day-2-tab">
              <div class="p-4">
                  <h3 class="mb-4">Manufactured By Nike</h3>
                  <p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
              </div>
          </div>
          <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-day-3-tab">
              <div class="row p-4">
                               <div class="col-md-7">
                                   <h3 class="mb-4">23 Reviews</h3>
                                   <div class="review">
                                       <div class="user-img" style="background-image: url({{asset('assets/front-end/images/person_1.jpg')}})"></div>
                                       <div class="desc">
                                           <h4>
                                               <span class="text-left">Jacob Webb</span>
                                               <span class="text-right">14 March 2018</span>
                                           </h4>
                                           <p class="star">
                                               <span>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                               </span>
                                               <span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
                                           </p>
                                           <p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrov</p>
                                       </div>
                                   </div>
                                   <div class="review">
                                       <div class="user-img" style="background-image: url({{asset('assets/front-end/images/person_2.jpg')}})"></div>
                                       <div class="desc">
                                           <h4>
                                               <span class="text-left">Jacob Webb</span>
                                               <span class="text-right">14 March 2018</span>
                                           </h4>
                                           <p class="star">
                                               <span>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                               </span>
                                               <span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
                                           </p>
                                           <p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrov</p>
                                       </div>
                                   </div>
                                   <div class="review">
                                       <div class="user-img" style="background-image: url({{asset('assets/front-end/images/person_3.jpg')}})"></div>
                                       <div class="desc">
                                           <h4>
                                               <span class="text-left">Jacob Webb</span>
                                               <span class="text-right">14 March 2018</span>
                                           </h4>
                                           <p class="star">
                                               <span>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                                   <i class="ion-ios-star-outline"></i>
                                               </span>
                                               <span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
                                           </p>
                                           <p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrov</p>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="rating-wrap">
                                       <h3 class="mb-4">Give a Review</h3>
                                       <p class="star">
                                           <span>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               (98%)
                                           </span>
                                           <span>20 Reviews</span>
                                       </p>
                                       <p class="star">
                                           <span>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               (85%)
                                           </span>
                                           <span>10 Reviews</span>
                                       </p>
                                       <p class="star">
                                           <span>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               (98%)
                                           </span>
                                           <span>5 Reviews</span>
                                       </p>
                                       <p class="star">
                                           <span>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               (98%)
                                           </span>
                                           <span>0 Reviews</span>
                                       </p>
                                       <p class="star">
                                           <span>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               <i class="ion-ios-star-outline"></i>
                                               (98%)
                                           </span>
                                           <span>0 Reviews</span>
                                       </p>
                                   </div>
                               </div>
                           </div>
          </div>
        </div>
      </div>
    </div>
    </div>
</section>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
input_radio = document.querySelectorAll(".input_radio");


    for (let i = 0; i < input_radio.length; i++) {

         if(input_radio[i].checked){


            }

    }









    $(document).ready(function(){

   $("#colors").on("change",function(){
    label = document.querySelectorAll(".label");
    label.forEach(e => {
             e.style.background = 'none';
        });
    input_size = document.querySelectorAll(".input_size");

    color_id = this.value;
    product_id = document.getElementById("product_id").value;
    $.ajax({
url : "{{url('fetch_product_size')}}/"+product_id + color_id,
type : "GET",
data: {
_token: '{{csrf_token()}}'
      },
      dataType: 'json',
      success:function(data){
for (let i = 0; i < input_size.length; i++) {
    $(input_size[i]).next('.input_radio').remove();
    input_size[i].parentElement.style = 'border:1px solid #ddd;text-align:center;color:#ddd;margin-bottom:5px;width:100%;cursor:ns-resize;height:100%;display:flex;align-items:center;justify-content:center;';

    if(data['avilable_size_id'].includes(Number(input_size[i].value)) === true){

    $("<input hidden class='input_radio' id="+input_size[i].value+"  type='radio' name='size' value=" + input_size[i].value + ">").insertAfter(input_size[i]);

          input_size[i].parentElement.style = 'border:1px solid black;text-align:center;color:black;margin-bottom:5px;width:100%;cursor:pointer;height:100%;display:flex;align-items:center;justify-content:center;';

        //   input_size[i].parentElement.addEventListener("mouseover",function(){
        //     this.style = 'width:100%;height:100%;cursor:pointer ;display:flex;align-items:center;justify-content:center; background-color:#999;color:white'
        // });

        // input_size[i].parentElement.addEventListener("mouseleave",function(){
        //   this.style = 'width:100%;height:100%;cursor:pointer ;display:flex;align-items:center;justify-content:center;'
        //    });
    }

}

input_radio = document.querySelectorAll(".input_radio");
input_radio[0].checked = true;

for (let i = 0; i < input_radio.length; i++) {
    if(input_radio[i].checked){
        // input_radio[i].parentElement.style = 'border:1px solid black;text-align:center;color:black;margin-bottom:5px;width:100%;cursor:pointer;height:100%;display:flex;align-items:center;justify-content:center; background:black;color:white';
        $( input_radio[i] ).parent().css( "background-color", "black");
        $( input_radio[i] ).parent().css( "color", "white");
    }
}

      }
});

   });




    });

    ////
    box = document.querySelectorAll(".box");
    label = document.querySelectorAll(".label");

for (let i = 0; i < box.length; i++) {
    box[i].addEventListener("click",function(){

        if(box[i].querySelector(".label").querySelector(".input_radio")){

            label.forEach(e => {
                if(e.querySelector(".input_radio")){
                    e.style.background = 'none';
                    e.style.color = 'black';
                }

        });
            if(box[i].querySelector(".label").querySelector(".input_radio").checked){
                box[i].querySelector(".label").style.background = 'black';
                box[i].querySelector(".label").style.color = 'white';
        }
        }

    });

}
/////




</script>
@endsection
