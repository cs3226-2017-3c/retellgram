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
				<div class="btn btn-primary btn-lg btn-block" onclick="addCaption({{$image_id}});">
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
<script src="../js/detail.js"></script>
<script>
$( document ).ready(function() {
    getImage("{{$image_id}}");
    getCaptions("{{$image_id}}", "{{$caption_id}}");
});
</script>
@endsection
