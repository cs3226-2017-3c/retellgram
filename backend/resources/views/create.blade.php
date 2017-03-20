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
<!--link href="/css/image-picker.css" rel="stylesheet"-->
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

		   	<a href="/selectimage">
				<button type="button" class="btn btn-primary btn-lg" >
			  		Select Image
				</button>
			</a>
		   	

		   	<!--button 
				   type="button" 
				   class="btn btn-primary btn-lg" 
				   data-toggle="modal" 
				   data-target="#imageModal">
			  	Select Image
			</button>
			
			<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
				<div class="modal-dialog" role="document">
				    <div class="modal-content">
				      	<div class="modal-header">
				        	<button type="button" class="close" 
				          		data-dismiss="modal" 
				          		aria-label="Close">
				          	<span aria-hidden="true">&times;</span></button>
				        	<h4 class="modal-title" id="imageModalLabel">Choose Image</h4>
				      	</div>
					   	<form role="form" id="chooseImageForm" method="post">
					   		{!! csrf_field() !!}
					   		<div class="form-group">
							    <div class="modal-body">
									<select id="selectImage" class="image-picker form-control">
								    	<option value=""></option>
								    	<option data-img-src='http://png.findicons.com/files/icons/2689/kitchen/128/4.png' value='1'>test-01.png</option>
								    </select>
							    </div>
							    <div class="modal-footer">
							    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							        <span class="pull-right">
							        	<input type="submit" value="Choose Image" class="btn btn-primary"/>
							        </span>
							    </div>
							</div>
						    
					    </form>
					</div>
				</div>
			</div-->

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
				{!! Form::label('hashtags', 'Enter hashtag:', ['class' => 'control-label']) !!}
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
<!--script type="text/javascript" src="js/image-picker.min.js"></script>
<script>
	$(function(){
	    $('#chooseImageForm').on('submit', function(e){
	        console.log("here");
	        e.preventDefault();
	        $.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
		        }
		    });

	        $.ajax({
	            url: "/chooseImage", 
	            type: 'POST', 
	           	data: $('#chooseImageForm').serialize(),
	            success: function(data){
	                 alert('successfully submitted')
	            }
	        });
	    });
	});

	$(document).ready(function () {
	    $("#selectImage").imagepicker({
	        hide_select: true,
	        limit: 1,
	        limit_reached: function(){alert('Please select only one image.')}, 
	    });
	});
</script-->
@endsection