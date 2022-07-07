@extends('layouts.mainCss')
@section('content')
<div id="myDivs">
    <div class="cube" >
        <h1>cube 1</h1>
    </div>

    <div class="cube">
        <h1>cube 2</h1>
    </div>


    <div class="cube">
        <h1>cube 3</h1>
    </div>
</div>
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" defer></script>
<script type="text/javascript">
    $(document).ready(function(){
        console.log('abc');
        $('#myDivs').sortable();
    });
</script>
@endsection
