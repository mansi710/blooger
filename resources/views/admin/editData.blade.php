@extends('layouts.mainCss')
@section('content')
<div class="col-12 grid-margin stretch-card">
   <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Data</h4>
                <p class="card-description">
                    @if($message=Session::get('success'))
                        <div class="alert alert-success">
                             <p>{{$message}}</p>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong>There were some problem with your input<br><br>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                @endforeach
                                </ul>
                        </div>
                    @endif
                  </p>
                  <form class="forms-sample" action="{{route('update.data',$blogs->id)}}" method="post" enctype="">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="exampleInputName1">Title</label>
                      <input type="text" class="form-control" name="title" value="{{$blogs->title}}"id="formGroupExampleInput" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                      <label for="exampleTextarea1">Description</label>
                      <textarea class="form-control" name="description" id="textAreaExample1" rows="4" placeholder="enter  description">{{$blogs->description}}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Status</label>
                      <input type="text" class="form-control" name="status" value="{{$blogs->status}}"id="formGroupExampleInput" placeholder="Enter Category">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Tag</label>
                      <input type="text" class="form-control" name="tag" value="{{$blogs->tag}}"id="formGroupExampleInput" placeholder="Enter Category">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                  </form>
         </div>
     </div>
</div>
@endsection