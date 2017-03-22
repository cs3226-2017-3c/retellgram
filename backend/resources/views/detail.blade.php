@extends('template')
@section('title')
Detail
@endsection
<style>
.selected {background-color: rgba(0,0,0,0.1);}
</style>
@section('header')
@endsection
@section('main')
<div id="fb-root"></div>
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
					<div id="likes"></div>
				</div>	
			</div>
			<div>
				<div class="btn btn-primary btn-lg btn-block" onclick="addCaption();">
					<span class="glyphicon glyphicon-plus"></span> Add Caption</div>
				<div class="fb-share-button"
					style="margin-top:20px;"
					data-href="document.URL"
					data-layout="button" data-size="large" data-mobile-iframe="true">
					Share
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
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>
//get the image
$.getJSON("../image/{{$image_id}}", function(data) {
	$("#image").attr("src",data['path']);
});
</script>
<script>
//get captions
$.getJSON("../caption?likes=1&image_id={{$image_id}}", function(data){
	$("#caption").html("<p>"+data[0]['content']+"</p>");
	var thumb = "<div onclick=like(event) id="+data[0]['id']+" class='glyphicon glyphicon-thumbs-up'>"+data[0]['likes']+"</div>";
	$("#likes").html(thumb);

	$.each(data, function(i, object){
	  var thumb = "<div onclick=like(event) id="+object['id']+" class='glyphicon glyphicon-thumbs-up'>"+object['likes']+"</div>";
	  var caption_content = "<div onclick=changeCaption(event)>"+object['content']+"</div>";
	  var li_content = caption_content + thumb;
      $("#all_caption").append("<li href='#'>"+li_content+"</li>");
    });
	$("ol#all_caption li:first").addClass("selected");
})
</script>

<script>
function addCaption(){
	console.log("add caption!");
	window.open("../create?image_id={{$image_id}}");
}

function changeCaption(event){
	$(".selected").removeClass("selected");
	$(event.target).parent().addClass("selected");
	var this_caption = $(event.target).html();
	$("#caption").html("<p>"+this_caption+"</p>");
	var this_likes = $(event.target).next().clone();
	$("#likes").html(this_likes);
};

function like(event){
	var this_caption_id = $(event.target).context.id;
	$.ajax({
    	type: 'PUT',
    	beforeSend: function(request) {
    		request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        url: "../caption/" + this_caption_id, 
        success: function(data) {
            updateLikeDisplay(event, this_caption_id)
        },
        error: function(jqXHR, textStatus, errorThrown) {
        	if (errorThrown == "Bad Request") {
        		alert("You have liked this caption");
        	} else {
        		console.log(textStatus, errorThrown);
        	}
		}
    });
}
function updateLikeDisplay(event, id) {
	$.getJSON("../caption/"+id, function(data){
		$(event.target).html(data['likes']);
		if($("#likes div:last").attr('id') == id) {
			$("#likes div:last").html(data['likes']);
		}

		var aCaption = $("ol#all_caption li:first");
		var like = aCaption.children().last();
		if (like.attr('id') == id) {
			like.html(data['likes']);
		}
		while (aCaption.next().is('li')) {
			aCaption = aCaption.next();
			like = aCaption.children().last();
			if (like.attr('id') == id) {
				like.html(data['likes']);
			}
		}	
	})
}
</script>

@endsection
