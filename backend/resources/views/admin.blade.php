@extends('new_template')
@section('title')
Admin
@endsection
@section('header')
@endsection
@section('main')


<div class="row">
    <div class="container">
    	<div class="panel panel-default">
          <div class="panel-body">
			@foreach ($images as $image)
		    <div class="col-md-4">
		    	<div style="width:200px;height:200px;position:relative;margin-bottom:20px;">
			      	<a href="/thisrouteshouldhidefromuseradmin/{{$image->id}}">
			      		<img style="max-width:200px;max-height:200px;" src="/storage/images/{{ $image->file_path }}" class="img-rounded">
			      	</a>
					<form action="image/{{$image->id}}/delete" method="post">
						{{ csrf_field() }}
						<button type="submit" style="position:absolute;">Delete Image</button>
					</form>
					<br>
					<br>	
					@if(Request::path()=="report")
					<form action="image/{{$image->id}}/resetReports" method="post">
						{{ csrf_field() }}
						<button type="submit" style="position:absolute;">Reset Reports({{$image->reports}})</button>
					</form>	
					@endif
				</div>
			</div>
			@endforeach
		  </div>
		</div>
	</div>
</div>



@endsection
@section('footer')
@endsection