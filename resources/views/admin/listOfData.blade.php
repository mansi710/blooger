@extends('layouts.mainCss')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">List Of Data</h4>
            <p class="card-description pull-right">
               <div class="row mt-40 pull-right  mt-20  ">
                   <div class="col-lg-12 margin-tb">
                        <div class="">
                             <p class="card-description">
                                @if($message=Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>{{$message}}</p>
                                    </div>
                                @endif

                                @if($message=Session::get('message-deleted'))
                                    <div class="alert alert-danger">
                                        <p>{{$message}}</p>
                                    </div>
                                @endif

                                <div>
                                    <div class="row  mt-20 " style="float:right">
                                            <div class="col-lg-12 margin-tb">
                                                    <a class="btn btn-success" href="{{route('data.create')}}">Add New Data</a>  
                                            </div>
                                        </div>
                                        <br>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
             </p>
            <div class="table-responsive" id="myDivs"> 
                <table class="table table-striped"  id="tblLocations">
                    <thead>
                        <tr>
                          <th>Id</th>
                          <th>Title</th>
                          <th>Description</th>
                          <th>status</th>
                          <th>Tag</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="display-data" class="row_position">       
                       @if(count($blogs)>0)
                            @foreach($blogs as $blog)
                            <tr class="row1" data-id="{{ $blog->id }}">
                                <td >{{ $blog->id }}</td>
                                <td>{{ $blog->title }}</td>
                                <td>{{ $blog->description }}</td>
                                <td id="updateStatus">{{ $blog->status }}</td>
                                <td>{{ $blog->tag }}</td>
                                <td>
                                    <form action="{{route('data.destroy',$blog->id)}}" method="get">
                                        <a class="btn btn-primary" href="{{route('data.edit',$blog->id)}}">Edit</a>
                                      
                                        <button type="submit" class="btn btn-danger">Delete</button>

                                        @if($blog->status != 'archive')
                                            <a class="btn btn-info archiveButton" data-id="{{$blog->id}}" data-status="{{$blog->status}}" href="#" >Add To Archive</a>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                 </table>
            </div>

            <!-- <div class="divTable">
                <div class="headRow">
                    <div class="divCell" >Id</div>
                    <div  class="divCell">Title</div>
                    <div  class="divCell">Description</div>
                    <div  class="divCell">Status</div>
                    <div  class="divCell">Tag</div>
                    <div  class="divCell">Action</div>
                </div>
                <div class="divRow">
                    @if(count($blogs)>0)
                         @foreach($blogs as $blog)
                            <div class="divCell">{{ $blog->id }}</div>
                            <div class="divCell">{{ $blog->title }}</div>
                            <div class="divCell">{{ $blog->description }}</div>
                            <div class="divCell">{{ $blog->status }}</div>
                            <div class="divCell">{{ $blog->tag }}</div>
                            <div class="divCell">
                                   
                            </div>
                        @endforeach
                    @endif
                </div>
            
            </div> -->

            <!-- <div id="resp-table" class="table table-striped">
                <div id="resp-table-body">
                    <div class="resp-table-row"> 
                        <div class="table-body-cell">
                            Id
                        </div>
                        <div class="table-body-cell">
                            Title
                        </div>
                        <div class="table-body-cell">
                            Description 
                        </div>
                        <div class="table-body-cell">
                            Status
                        </div>
                        <div class="table-body-cell">
                            Tag
                        </div>
                        <div class="table-body-cell">
                            Action
                        </div>
                    </div>
        
                
                    @if(count($blogs)>0)
                        @foreach($blogs as $blog)
                        <div class="resp-table-row" id="sortableDiv">
                            <div class="table-body-cell">
                                {{$blog->id}}
                            </div>
                            <div class="table-body-cell">
                                {{$blog->title}}
                            </div>
                            <div class="table-body-cell">
                                {{$blog->description}}
                            </div>
                            <div class="table-body-cell">
                                {{$blog->status}}
                            </div>
                            <div class="table-body-cell">
                                {{$blog->tag}}
                            </div>
                            <div class="table-body-cell">
                                <form action="{{route('data.destroy',$blog->id)}}" method="get">
                                    <a class="btn btn-primary" href="{{route('data.edit',$blog->id)}}">Edit</a>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @endif
        
                </div>
            </div> -->
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" defer></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/themes/smoothness/jquery-ui.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/jquery-ui.min.js"></script>
<script type="text/javascript">
// function updateStatus(id)
// {
//     alert(id);
// }
$(document).on('click','.archiveButton',function()
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var id=$(this).data('id');    
    var status=$(this).data('status');    
    alert(status);

    $.ajax({
        
        url:'{{route("update.status")}}',
        // url:"{{url('admin/update.status/')}}",
        method:"post",
        // datatype: "json",
        data:{
            _token: CSRF_TOKEN,
            id:id,
            status:status
            // status: $('#updateStatus').val(),
           
        },
        success:function(response){
            // response = JSON.parse(response);
            if(response)
            {
                //  alert(response);
                // res=response;
                // $("#tblLocations").val(response);
                //  alert("success");
                window.location = "lisDataOfCsvFile";
                // $(".archiveButton").hide();
                //     var res='';
                
                //         $.each (response, function (key, value) {
                //             alert('abc');
                //         res +=
                //         '<tr>'+
                //             '<td>'+value.id+'</td>'+
                //             '<td>'+value.title+'</td>'+
                //             '<td>'+value.description+'</td>'+
                //             '<td>'+value.status+'</td>'+
                //             '<td>'+value.status+'</td>'+
                //     '</tr>';
                //     });
                // $('tbody').html(res);
            }
             else
             {
                alert("Internal Server Error");
             }
        }
    });
       
});
 $(function () {
        // $("#table").DataTable();

        $( ".row_position" ).sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
              sendOrderToServer();
          }
        });

        function sendOrderToServer() {
          var order = [];
          var token = $('meta[name="csrf-token"]').attr('content');
          $('tr.row1').each(function(index,element) {
            order.push({
              id: $(this).attr('data-id'),
              position: index+1
            });
          });

          $.ajax({
            type: "POST", 
            dataType: "json", 
            url: "{{ route('post-sortable') }}",
                data: {
                    order:order,
            //   order: order,
              _token: token
            },
            success: function(response) {
                if (response.status == "success") {
                  console.log(response);
                } else {
                  console.log(response);
                }
            }
          });
        }
      });


   

          
// });
//      $(function () {
//     $("#tblLocations").sortable({
//         items: 'tr:not(tr:first-child)',
//         cursor: 'pointer',
//         axis: 'y',
//         dropOnEmpty: false,
//         start: function (e, ui) {
//             ui.item.addClass("selected");
//         },
//         stop: function (e, ui) {
//             ui.item.removeClass("selected");
//             $(this).find("tr").each(function (index) {
//                 if (index > 0) {
//                     $(this).find("td").eq(1).html(index);
//                 }
//             });
//         }
//     });
// });
    // $(document).ready(function(){
    //     console.log('abc');
    //     $("#sortableDiv").sortable();
    //     // $(document).on('click','#abc',function()
    //     // {
    //     //     console.log('abc')
    //     //     var id=$(this).data('id');
    //     //     alert(id)
    //     // });
    //     // // var id=$('#abc').data('id');
    //     // // alert(id);
    //     // $('.row_'+id).sortable();
    // });
</script>
<style type="text/css">

    table th, table td
    {
        width: 100px;
        padding: 5px;
        border: 1px solid #ccc;
        font-size:20px;
    }
    .selected
    {
        background-color: #666;
        color: #fff;
    }
   /* #resp-table {
        width: 100%;
        display: table;
    }
    #resp-table-body{
        display: table-row-group;
    }
    .resp-table-row{
        display: table-row;
    }
    .table-body-cell{
        display: table-cell;
        border: 1px solid #dddddd;
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
    } */
</style>

@endscript

