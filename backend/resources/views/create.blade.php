@extends('template')
@section('title')
Create Image
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
		</div>
	</div>
			
	<div class="row">
		<div class="col-md-12">
	
			<h2>Create Your Caption</h2>
			
			@if($chosen)
		    <img class="pull-left" id="caption_image" src="{{Storage::url($image_path)}}" alt="Image {{ $image_path }} " width="300" height="300">
		   	@else
		   	<h3>Select Images</h3>
		   	@endif
		</div>
	</div>
			
	<div class="row">
		<div class="col-md-12">
			{!! Form::open() !!} 
			
		    <div class="form-group"> 
				{!! Form::label('caption', 'Caption:', ['class' => 'control-label']) !!}
				{!! Form::text('caption', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('position', 'Position:', ['class' => 'control-label']) !!}
				{!! Form::select('position', ['top'=>'Top', 'bottom'=>'Bottom'], null, ['placeholder' => 'Select caption position', 'class' => 'form-control']) !!}
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