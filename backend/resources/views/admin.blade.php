@extends('new_template')
@section('title')
Admin
@endsection
@section('header')
@endsection
@section('main')
<div id="wrapper">

<div class="row">
    <div class="container">
		@foreach ($images as $image)
	    <div class="col-md-4">
	      	<img src="storage/images/{{ $image->file_path }}" class="img-rounded">
			<form action="image/{{$image->id}}/delete" method="post">
				{{ csrf_field() }}
				<button type="submit">Delete Image</button>
			</form>	
		</div>
		@endforeach
	</div>
</div>


</div>
@endsection
@section('footer')
@endsection