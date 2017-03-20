@extends('template')
@section('title')
Detail
@endsection
@section('header')
@endsection
@section('main')

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<img id="image" class="img-responsive" src="" style="height:300px;"/>
					<div id="caption"></div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div id="all_caption"></div>
		</div>
	</div>
</div>
@endsection
@section('footer')
<script>
//get the image
$.getJSON("../image/{{$image_id}}", function(data) {
	$("#image").attr("src",data['path']);
});
</script>
<script>
//get captions
$.getJSON("../caption/{{$image_id}}", function(data){
	$("#caption").append("<p>" + data[0]['content'] + "</p>");

	$.each(data, function(i, object){
      $("#all_caption").append("<p>" + object['content'] + "</p>");
    });
})
</script>

@endsection
