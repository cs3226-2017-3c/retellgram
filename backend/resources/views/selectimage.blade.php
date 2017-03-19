@extends('template')
@section('title')
Select Image
@endsection
@section('header')
<link href="/css/image-picker.css" rel="stylesheet">
@endsection
@section('main')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			@if (count($errors) > 0) 
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			{!! Form::open() !!}

			<div class="form-group"> 
				{!! Form::label('select_image', 'Select Your Image:', ['class' => 'control-label']) !!}
				<select id="selectImage" name="selectImage" class="image-picker form-control">
					<option value=""></option>
					@foreach ($images as $image)
					<option data-img-src='storage/images/{{$image->file_path}}' value='{{$image->id}}'>{{$image->file_path}}</option>
					@endforeach
				</select> 
			</div>

			<div class="form-group"> 
				{!! Form::submit('Select', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
			</div>
			
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
@section('footer')
<script type="text/javascript" src="js/image-picker.min.js"></script>
<script>
$(document).ready(function () {
	    $("#selectImage").imagepicker({
	        hide_select: true,
	        limit: 1,
	        limit_reached: function(){alert('Please select only one image.')}, 
	    });
	});
</script>
@endsection