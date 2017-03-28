@extends('new_template_with_side_bar')
@section('title')
Detail
@endsection
@section('header')
<meta property="og:image:width" content="200" />
<meta property="og:image:height" content="200" />
<meta property="og:type" content="article" />
<meta id="og-title" property="og:title" content="{{$og_title}}" />
<meta property="og:image" content="http://www.retellgram.com{{$image_path}}" />
<link href="/css/scroll-area.css" rel="stylesheet">
@endsection
@section('main-content')

<div id="fb-root"></div>
	<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 tell-panel">
      <div class="page-content-wrapper">
        <div class="panel panel-primary">
          <div class="panel-body">
            <div class="row">
		        <div class="col-md-6">
			         <div class="panel panel-default">
                <div class="panel-heading" id="author">
                </div>
				        <div class="panel-body">
					         <img id="image" class="img-responsive mg-rounded" src="{{$image_path}}" style="height:300px;"/>
					         <div id="caption"></div>
				        </div>
				        <div class="panel-footer">
					         <div id="likes"></div>
				        </div>	
			         </div>
              </div>
            <div class="col-md-6">
              <div id="all_caption" class="list-group scroll-area"></div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="btn btn-primary btn-lg" onclick="addCaption({{$image_id}});">
                  <span class="glyphicon glyphicon-plus"></span> Add Caption
                </div>
                <div id="fb-share-button"
                     class="fb-share-button hidden-xs"
                     style="margin-top:20px;"
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
  getCaptions("{{$image_id}}", "{{$caption_id}}");
});
</script>
@endsection
