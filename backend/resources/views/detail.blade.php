@extends('template')
@section('title')
Detail
@endsection
@section('header')
@endsection
@section('main')

<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="thumbnail">
				<img id="image" class="img-responsive" src="" />
				<div id="caption"></div>
			</div>
		</div>
		<div class="col-md-6">
			<div id="all_caption"></div>
		</div>
	</div>
</div>
@endsection
@section('footer')
<script>
//get the image
$.ajax({
    type: 'GET',
    beforeSend: function(request) {
        request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
    },
    url: "../image/{{$image_id}}", 
    success: function(data) {
        $("#image").attr("src",data);
    }
})
</script>
<script>
$.getJSON("../caption/{{$image_id}}", function(data){
	$("#caption").append("<p>" + data[0]['content'] + "</p>");

	$.each(data, function(i, object){
      $("#all_caption").append("<p>" + object['content'] + "</p>");
    });
})
</script>

@endsection
