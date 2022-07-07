@extends('layouts.mainCss')
@section('content')
<div class="col-12 grid-margin stretch-card">
   <div class="card">
        <div class="card-body">
            <h4 class="card-title">Choose Csv File</h4>
                <p class="card-description">
                    @if($message=Session::get('success'))
                        <div class="alert alert-success">
                             <p>{{$message}}</p>
                        </div>
                    @endif
                  </p>
                  <form class="forms-sample" action="{{route('storeCsvFile')}}" method="post" 
                   enctype="multipart/form-data">
                      @csrf
                    <div class="form-group">
                    <label for="csv_file" class="col-md-4 control-label">CSV file to import</label>

                        <div class="col-md-6">
                            <input type="file" name="csv" value="">
                         
                        </div>
                    </div>
                
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">Parse CSV</button>
                    </div>
                  </form>
      
         </div>
     </div>
</div>
@endsection