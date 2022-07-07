@extends('layouts.mainCss')
@section('content')
<div class="card">
        <div class="card-body">
            <div class="text-center mt-50">
               <div class="p-3 mb-2 "> <a href="{{route('userBlogList')}}" id="shoppingPage"><h2>Detail Page<h2></a></div>
            </div>
        </div>
            <!-- show the detail of specific blog -->
            <div class='mt-50'>
                <div class="col-md-12 mt-60">
                    <div class="form-group row col-md-12">     
                
                        <div class="col-md-12  mt-50" style="width: 20rem;pull-left">
                            <h3 class="display-3">Title:-{{ $blog->title }}</h3>
                            <h4 class="display-4">Description:- {{ $blog->description }}</h4>
                            <h4 class="display-4">Status:-   {{$blog->status}}</h3>
                            <h4 class="display-4">Tag:-  {{$blog->tag}}</h3>
                            <span  data-id="{{$blog->id}}" class="star">&#9733;</span> 
                            <br/>
                            <a href="#" class="btn btn-primary addToFavourite" data-id="{{$blog->id}}" id="addTocart">
                                Add To Favourite</a>
                        </div>
                    </div>
                </div>         
            </div>
            <!-- details section complete here -->
        </div>          
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        
        $("span").hide();

        $('.addToFavourite').click(function(){

            var id=$(this).data('id'); 

            $.each($(".star"),function(){
                // console.log(id);
                // console.log(id==$(this).data('id'));
                id==$(this).data('id') ? $(this).toggle():console.log('');
            });
         
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            var id=$(this).data('id');   
            alert(id) ;
            var rating_data = $('#InputStatus').text();
            // alert(rating_data);

            $.ajax({
                
                type: "POST", 
                url: "{{ route('post.rating') }}",
                    data: {
                        id:id,
                        rating_data: rating_data,
                //   order: order,
                    _token: CSRF_TOKEN
                },
                success: function(response) {
                    if (response.status == "success") {
                    console.log(response);
                    } else {
                    console.log(response);
                    }
                }
            });

        }); 
});
</script>
@endsection