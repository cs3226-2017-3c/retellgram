@extends('new_template_with_side_bar')
@section('title')
Home
@endsection
@section('header')
@endsection
@section('main-content')
<div class="page-content-wrapper">
  @foreach($result as $r)
  <div class="row">
    <div class="container">
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-body">
            <section class="post-heading">
              <div class="row">
                <div class="col-md-11">
                  <div class="media">
                    <div class="media-body">
                      <a href="/detail/{{$r->image->id}}" class="anchor-username"><h4 class="media-heading">#{{$r->image->id}}</h4></a>
                      <a href="#" class="anchor-time">{{ $r->created_at->diffForHumans() }}</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                </div>
              </div>
            </section>
            <section class="post-body">
              <div class="panel panel-caption">
                <div class="row caption-new page-header">
                  <a href="#"><img src="characters/{{$r->character->path}}" class="img-rounded panel-resize-photo"><font color="white"> {{$r->character->name}}</font></a>
                </div>
                <div class="row caption-new panel-text-color">
                  <p>{{$r->content}}</p>
                </div>
              </div>
              <img src="{{'/storage/images/'.$r->image->file_path}}" class="img-rounded panel-img-position">
            </section>
            <section class="post-footer">
              <hr>
              <div class="post-footer-option container">
                <ul class="list-unstyled">
                  <li><a href="#"><i class="fa fa-heart" aria-hidden="true"></i> {{$r->likes}} Likes</a></li>
                  <li><a href="/tell?image_id={{$r->image->id}}"><i class="fa fa-bomb" aria-hidden="true"></i> Tell</a></li>
                  <li><a href="#" id="share" onclick=shareFB(event)><i class="glyphicon glyphicon-share-alt"></i> Share</a></li>
                </ul>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
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
@endsection
