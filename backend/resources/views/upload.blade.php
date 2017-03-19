@extends('template')
@section('title')
Upload Image
@endsection
@section('header')
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.css" rel="stylesheet">
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

			<div class="row">
		  		<div class="col-md-5 text-center">
					<div id="upload-into"></div>
		  		</div>
		  		<div id="upload-button" class="col-md-3">
					<strong>Choose Your Image:</strong>
					<br/>
					<input type="file" id="uploading">
					<br/>
					<button class="btn btn-success upload-result">Upload Image</button>
		  		</div>
		  		<div class="col-md-4" style="">
					<div id="upload-demo-i"></div>
		  		</div>
		  	</div>

		</div>
	</div>

	<br>
	<br>
	<br>
	<br>
	<br>
	<div class="row">
		<div id="createButton" class="col-md-12" style="display:none">
			<a class="btn btn-primary btn-lg btn-block">Go to create Caption</a>
		</div>
	</div>
</div>
@endsection
@section('footer')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.js"></script>
<script>
$( document ).ready(function(){
$uploadCrop = $('#upload-into').croppie({
    enableExif: true,
    viewport: {
        width: 300,
        height: 300,
        type: 'square'
    },
    boundary: {
        width: 400,
        height: 400
    }
});

function failValidation(msg, detail) {
    swal(msg, detail); 
    return false;
}

function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}



function isImage(filename) {
    var ext = getExtension(filename);
    switch (ext.toLowerCase()) {
    case 'jpg':
    case 'gif':
    case 'bmp':
    case 'png':
        return true;
    }
    return false;
}

function readFile(input) {
 	if (input){
	    var reader = new FileReader();

	    reader.onload = function (e) {
			$('.upload-into').addClass('ready');
	        $uploadCrop.croppie('bind', {
	            url: e.target.result
	        }).then(function(){
	            console.log('jQuery bind complete');
	        });
	    }

	    reader.readAsDataURL(input);
	}
	else {
		swal("Sorry :(","Your browser doesn't support the FileReader API");
	}
}

$('#uploading').on('change', function () { 
	if (this.files[0]) {
		console.log("Verifying file..")
		var file = $('#uploading');

		if (this.files[0].size > 2097152) {
			return failValidation('Image too large','Please upload an image less than 2Mb');
		}

        if (!isImage(file.val())) {
            return failValidation('Invalid Image', 'Please upload a valid image, supported formats: jpg,gif,bmp,png');
        }
		readFile(this.files[0]);
	} else {
		failValidation('No Image Chosen','Please select your image first');
	}
});

$('.upload-result').on('click', function (ev) {
	if ($('#upload-into .cr-boundary .cr-image').attr("src") == null) {
		return failValidation('No Image Chosen','Please select your image first');
	}

	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {
	    $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	        }
	    });
		$.ajax({
			url: "/uploadCrop",
			type: "POST",
			data: {"image":resp},
			success: function (data) {
				html = '<img src="' + resp + '" />';
				$("#upload-demo-i").html(html);

				$("#createButton").css('display','block');
				console.log(data);
				$("#createButton a").attr('href','/create?image_id=' + data['image_id']);
				swal("Congratulation!","Image upload successfully, please go to create your caption!");

			},
            error: function(xhr, textStatus, thrownError) {
           		console.log(xhr.responseText);
            }
		});
	});
});

});
</script>
@endsection