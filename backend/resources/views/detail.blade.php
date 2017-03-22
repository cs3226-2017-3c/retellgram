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
				<div class="panel-footer">
					<div id="likes">
						<span class="glyphicon glyphicon-thumbs-up"></span>
					</div>
				</div>
						
			</div>
		</div>
		<div class="col-md-3">
			<ol id="all_caption"></ol>
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
	$("#likes").append(data[0]['likes']);

	var thumb = "<span class='glyphicon glyphicon-thumbs-up'></span>"
	$.each(data, function(i, object){
	  var li_content = "<div onclick=updateCaptionDisplay(event)>"+object['content']+"</div>"+
	  "<div onclick=like(event) id="+object['id']+">"+thumb+object['likes']+"</div>";
      $("#all_caption").append("<li href='#'>"+li_content+"</li>");
    });
})
</script>

<script>
function updateCaptionDisplay(event){
	console.log($(event.target));
	var this_caption = $(event.target).context.innerHTML;
	$("#caption").html("<p>" + this_caption + "</p>");
};
function like(event){
	var this_caption_id = $(event.target).context.id;
	console.log(this_caption_id);
	$.ajax({
    	type: 'PUT',
    	beforeSend: function(request) {
    		request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        url: "http://localhost:8000/caption/" + this_caption_id, 
        data: "",
        success: function(data) {
            console.log("success");
        }
    });
}
</script>

@endsection
