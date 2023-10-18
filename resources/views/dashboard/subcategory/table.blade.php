@if(! $subcategories->isEmpty())
<thead >
    <tr>
        <td style="background-color: rgba(18,10,144,.5);text-align:center;font-size:1.3rem;color:aqua" colspan="7">{{$category}}</td>
    </tr>

      <tr class="text-primary">
        <th scope="col" style="text-align:center;">الرقم</th>
        <th scope="col" style="text-align:center;">الفرع</th>
        <th scope="col" style="text-align:center;">الالوان</th>
        <th scope="col" style="text-align:center;">المقاسات</th>
        <th scope="col" style="text-align:center;">الحاله</th>
        <th scope="col" style="text-align:center;width:100px">الصوره</th>
        <th scope="col" style="text-align:center;">الحذف/التعديل</th>
      </tr>
    </thead>

    <tbody >
        <?php $i = 1?>
    @foreach($subcategories as $subcategory)
    <tr>
        <th style="text-align:center;" class="align-middle" scope="row"><?= $i++ ?></th>

        <td style="text-align:center;" class="align-middle">{{$subcategory->name}}</td>

        <td style="text-align:center;"  class="align-middle">
         @if ($subcategory->color == '1')
             متاح
             @else
             غير متاح
         @endif
        </td>

        <td style="text-align:center;" class="align-middle">
           @if ($subcategory->size == '2')
               ارقام
           @elseif ($subcategory->size == '1')
             حروف
             @else
             غير متاح
           @endif
        </td>

        <td class="project-state" style="cursor:pointer;text-align:center;">
            <input type="hidden" name="" value="" class="status">
            <input type="hidden" name="" value="{{$subcategory->id}}" class="subcategory_id">

            @if ($subcategory->status == '1')

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
        <td >
<img  style="width:100px;" src="{{asset('assets/dashboard/images/sub_category/'.$subcategory->image)}}" alt="">
        </td>

        <td style="text-align:center;" class="align-middle">
            <button onclick="return confirm('Are you sure you want to delete this item?')" type="submit" class="btn btn-primary">تعديل</button>


            <form style="display: inline-block" action="{{route('admin.subCategoryDelete',$subcategory->id)}}" method="POST">
                @csrf
                <button onclick="return confirm('Are you sure you want to delete this item?')" type="submit" class="btn btn-danger">حذف</button>
             </form>
        </a>
        </td>
      </tr>
@endforeach
    </tbody>
@else

<h2 style="text-align: center">لا يوجد فروع متاحه </h2>

@endif
