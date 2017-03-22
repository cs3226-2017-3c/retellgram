<?php
		$options = array( "7" => "Avata", 
							"5" => "Curry Puff", 
							"2" => "Deadpoo",
							"8" => "Dollraemon",
							"4" => "Donald Drunk", 
							"6" => "Genghis Khan",
							"1" => "Hairy Porter", 
							"3" => "Hermoney Changer",
							"10" => "Hulky",
							"11" => "Kimchi Jong-un",  
        					"9" => "Queen Kong",
        					"12" => "Super Maria" );
?>
@extends('template')
@section('title')
Create Image
@endsection
@section('header')
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.css" rel="stylesheet">
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
		</div>
	</div>
			
	<div class="row">
		<div class="col-md-12">
	
			<h2>Create Your Caption</h2>

			@if($chosen)
		    <img class="pull-left" id="caption_image" src="storage/images/{{$image_path}}" alt="Image {{ $image_path }} " width="300" height="300">
		   	@else
		   	<h3>Select Image</h3>

		   	<!--a href="/selectimage">
				<button type="button" class="btn btn-primary btn-lg" >
			  		Select Image
				</button>
			</a-->
		   	
		   	<button 
				   type="button" 
				   class="btn btn-primary btn-lg" 
				   data-toggle="modal" 
				   data-target="#imageModal">
			  	Select Image
			</button>
			<br>
			<br>

			<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
				<div class="modal-dialog full-screen" role="document">
				    <div class="modal-content">
				      	<div class="modal-header">
				        	<button type="button" class="close" 
				          		data-dismiss="modal" 
				          		aria-label="Close">
				          	<span aria-hidden="true">&times;</span></button>
				        	<h4 class="modal-title" id="imageModalLabel">Choose Image</h4>
				      	</div>
					   
						<div class="modal-body">
							<form role="form" action="/create" id="chooseImageForm" method="get">
					   			<div class="form-group">
									<select id="image_id" name="image_id" class="image-picker form-control">
										<option value=""></option>
										@foreach ($images as $image)
										<option data-img-src='storage/images/{{$image->file_path}}' value='{{$image->id}}'>{{$image->file_path}}</option>
										@endforeach
									</select>
								</div>
							</form>
						</div>	

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<span class="pull-right">
							    <input id="submitForm" type="submit" value="Choose Image" class="btn btn-primary"/>
							</span>
						</div>	
					</div>
				</div>
			</div>

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
				{!! Form::label('character', 'Choose one character:', ['class' => 'control-label']) !!}
				{!! Form::select('character', $options, null, ['placeholder' => 'Select character', 'class' => 'form-control']) !!}
       		</div>

       		<div class="form-group">
				{!! Form::label('hashtags', 'Enter hashtag: ( optional, maximum 5 hashtags )', ['class' => 'control-label']) !!}
				{!! Form::text('hashtags', null, ['placeholder' => 'e.g. #hashtag #retellgram', 'class' => 'form-control']) !!}
       		</div>

       		<div class="form-group">
	          	{!! Form::hidden('image_id', $image_id) !!}
	        </div>

			<div class="form-group"> 
				{!! Form::submit('Create', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
			</div>

			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
@section('footer')
<script type="text/javascript" src="js/image-picker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.js"></script>
<script>
	$(document).ready(function () {
		$('#caption_image').croppie({
			showZoomer:false,
			enableExif: true,
		    viewport: {
		        width: 400,
		        height: 400,
		        type: 'square'
		    },
		    boundary: {
		        width: 400,
		        height: 400
		    }
		});
		$("#submitForm").on('click', function() {
        	$("#chooseImageForm").submit();
    	});
	    $("#image_id").imagepicker({
	        hide_select: true,
	        limit: 1,
	        limit_reached: function(){swal('Please select only one image.')}, 
	    });
	});
</script>
@endsection