@extends('template')
@section('title')
Upload Image
@endsection
@section('header')
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
			
			<h2>Upload Your Image</h2>
			{!! Form::open(['files' => 'true']) !!} 
			
		    <div class="form-group">
	          {!! Form::label('avatar', 'Avatar:', ['class' => 'control-label']) !!}
	          {!! Form::file('avatar') !!}
	        </div>

			<div class="form-group"> 
				{!! Form::submit('Upload', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
			</div>

			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
@section('footer')
@endsection