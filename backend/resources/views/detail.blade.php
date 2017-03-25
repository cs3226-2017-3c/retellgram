@extends('new_template_with_side_bar')
@section('title')
Detail
@endsection
<style>
.selected {background-color: rgba(0,0,0,0.1);}
</style>
@section('header')
@endsection
@section('main-content')

<div id="fb-root"></div>
	<div class="row">
    <div class="col-md-8 tell-panel">
      <div class="page-content-wrapper">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title panel-tell-title">Detail</h3>
          </div>
          <div class="panel-body">
            <div class="row">
		        <div class="col-md-6">
			         <div class="panel panel-default">
                <div class="panel-heading" id="author">
                </div>
				        <div class="panel-body">
					         <img id="image" class="img-responsive mg-rounded" src="" style="height:300px;"/>
					         <div id="caption"></div>
				        </div>
				        <div class="panel-footer">
					         <div id="likes"></div>
				        </div>	
			         </div>
              </div>
            <div class="col-md-6">
              <ol id="all_caption"></ol>
            </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="btn btn-primary btn-lg" onclick="addCaption({{$image_id}});">
                  <span class="glyphicon glyphicon-plus"></span> Add Caption
                </div>
                <div class="fb-share-button"
                     style="margin-top:20px;"
                     data-href="document.URL"
                     data-layout="button" data-size="large" data-mobile-iframe="true">
                     Share
                </div>
              </div>
            </div>
			    </div>
		    </div>
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
<script src="/js/detail.js"></script>
<script>
$( document ).ready(function() {
    getImage("{{$image_id}}");
    getCaptions("{{$image_id}}", "{{$caption_id}}");
});
</script>
@endsection
