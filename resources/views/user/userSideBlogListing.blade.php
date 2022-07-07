@extends('layouts.mainCss')
@section('content')
<!-- <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">List Of Data</h4>
            <div class="table-responsive">
            <p>
               <div class="row mt-50  " style="align:center"> 
              
                   <div class="col-lg-12 margin-tb">
                        <div class="">
                            <form action="{{route('userBlogList')}}" method="get">
                            
                                <input type="text" 
                                 name="id"value="{{request('id')}}" 
                                  placeholder="Serach By Id" /> 

                                <input type="text" 
                                 name="title"value="{{request('title')}}" 
                                  placeholder="Serach By Title" />

                                  <input type="text" 
                                 name="description"value="{{request('description')}}" 
                                  placeholder="Serach By description" />

                                  <input type="text" 
                                 name="tag"value="{{request('tag')}}" 
                                  placeholder="Serach By Tag" />

                                  <input type="text"
                                 name="status"value="{{request('status')}}" 
                                  placeholder="Serach By status" />

                                <input type="date" name="created_at" 
                                value="{{request('created_at')}}"  placeholder="Serach By Date" id="createdDate" />                        
                                <button type="submit" class="btn btn-secondary" id="filter" >Search</button>
                            </form>
                        </div>
                    </div>
                </div>

                
             </p>
                <table class="table table-striped" id="datatable" style="">
                    <thead>
                        <tr>
                          <th>Id</th>
                          <th>Title</th>
                          <th>Description</th>
                          <th>status</th>
                          <th>Tag</th>
                          <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="display-data">       
                       @if(count($blogdata)>0)
                            @foreach($blogdata as $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td>{{ $blog->title }}</td>
                                <td>{{ $blog->description }}</td>
                                <td>{{ $blog->status }}</td>
                                <td>{{ $blog->tag }}</td>
                                <td>{{ $blog->created_at }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                 </table>
               
            </div>
        </div>
    </div>
</div> -->
<div class="container">
        <p>
            <div class="row mt-50  " style="align:center"> 
                <h4 class="card-title">List Of Data</h4>
                   <div class="col-lg-12 margin-tb">
                        <div class="">
                            <form action="{{route('userBlogList')}}" method="get">
                            
                                <!-- <input type="text" 
                                 name="id"value="{{request('id')}}" 
                                  placeholder="Serach By Id" /> -->

                                <input type="text" 
                                 name="title"value="{{request('title')}}" 
                                  placeholder="Serach By Title" />

                                  <input type="text" 
                                 name="description"value="{{request('description')}}" 
                                  placeholder="Serach By description" />

                                  <input type="text" 
                                 name="tag"value="{{request('tag')}}" 
                                  placeholder="Serach By Tag" />

                                  <input type="text"
                                 name="status"value="{{request('status')}}" 
                                  placeholder="Serach By status" />

                                <input type="date" name="created_at" 
                                value="{{request('created_at')}}"  placeholder="Serach By Date" id="createdDate" />                        
                                <button type="submit" class="btn btn-secondary" id="filter" >Search</button>
                            </form>
                        </div>
                    </div>
                </div>
             </p>
            @if(count($blogdata)>0)
                @foreach($blogdata as $blog)
                <div id="imageListId" class="card-deck mb-2"  style="width:30rem; text-align:center;display:inline-block;">
                    <div class="card text-center">
                        <div class="card-block" class="listitemClass">
                            <h4 class="card-title">{{ $blog->title }}</h4>
                            <p class="card-text">
                            {{ $blog->description }}<br />
                            {{$blog->status}}<br/>
                            {{$blog->tag}}<br/>
                            {{$blog->created_at}}<br/>
                            </p>
                        </div>
                      
                            <span data-id="{{$blog->id}}" class="star" name="favourites_data" id="InputStatus">&#9733;</span> 
                       
                        <div class="card-footer">
                        <a href="#" class="btn btn-primary addToFavourite" data-id="{{$blog->id}}">
                                Add To Favourite</a>
                        <a href="{{route('blogDetailPage',$blog->id)}}" class="btn btn-secondary" id="detailPage"> Detail Page</a>
                        </div>
                    </div>
                    </a>
                </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $("span").hide();

        $('#detailPage').click(function() {
            window.location.href = this.id + '.html';
        });

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
            var favourites_data = $('#InputStatus').text();
            // alert(rating_data);

            $.ajax({
                
                type: "POST", 
                url: "{{ route('post.rating') }}",
                    data: {
                        id:id,
                        favourites_data: favourites_data,
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

