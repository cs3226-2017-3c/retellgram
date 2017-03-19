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
		  		<div class="col-md-6 text-center">
					<div id="upload-into" style="width:350px;height:350px;margin-top:30px"></div>
		  		</div>
		  		<div class="col-md-2" style="padding-top:30px;">
					<strong>Choose Your Image:</strong>
					<br/>
					<input type="file" id="uploading">
					<br/>
					<button class="btn btn-success upload-result">Upload Image</button>
		  		</div>
		  		<div class="col-md-4" style="">
					<div id="upload-demo-i" style="background:#e1e1e1;width:350px;padding:30px;height:350px;margin-top:30px"></div>
		  		</div>
		  	</div>

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
		alert("Sorry - you're browser doesn't support the FileReader API");
	}
}

$('#uploading').on('change', function () { readFile(this.files[0]); });

$('.upload-result').on('click', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {
		console.log("before ajax")
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