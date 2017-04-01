@extends('new_template_with_side_bar')
@section('title')
Story
@endsection
@section('header')
<meta property="fb:app_id" content="164946997359533" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{$og_title}}" />
<meta property="og:image:width" content="200" />
<meta property="og:image:height" content="200" />
<meta property="og:image" content="{{env('APP_URL')}}{{$image_path}}" />
<link href="/css/scroll-area.css" rel="stylesheet">
@endsection
@section('main-content')

  <div id="fb-root"></div>
	<div class="row">
    <div class="col-md-12">
      @include('flash::message')
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-10 tell-panel">
      <div class="page-content-wrapper">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <section class="post-heading">

              </section>
              <section class="post-body">
                <div class="panel panel-caption">
                  <div class="row caption-new page-header">
                    <a href="#" id="author" style="color:#ffffff;"></a>
                  </div>
                  <div id="caption" class="row caption-new panel-text-color">
                  </div>
                </div>
                <img class="img-responsive img-rounded panel-img-position"
                    src="{{$image_path}}" style="width:800px;">
              </section>
              <section class="post-footer">
                <hr>
                <div class="post-footer-option container">
                  <ul class="list-unstyled">
                    <li><div id="likes"></div></li>
                    <li><a href="/tell?image_id={{$image_id}}"><i class="fa fa-bomb" aria-hidden="true"></i> Tell</a></li>
                    <li><a href="#" id="share" onclick=shareFB(event)>
                        <i class="glyphicon glyphicon-share-alt"></i> Share</a>
                    </li>
                  </ul>
                </div>
              </section>
            </div>
          </div>
		    </div>
        <div class="col-md-6">
          <div id="all_caption" class="list-group scroll-area"></div>
        </div>
	    </div>
    </div>
  </div>
@endsection
@section('footer')
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : 164946997359533,
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<script>
function shareFB(event){
  event.preventDefault();
  FB.ui({
    method: 'share',
    href: document.location.href,
  }, function(response){});
}
</script>
<script src="/js/detail.js"></script>
<script>
$( document ).ready(function() {
  getCaptions("{{$image_id}}", "{{$caption_id}}");
});
</script>
@endsection
