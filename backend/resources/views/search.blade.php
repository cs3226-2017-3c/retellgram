@extends('new_template_with_side_bar')
@section('title')
Snap
@endsection
@section('header')
@endsection
@section('main-content')

<div class="page-content-wrapper">
<div class="col-md-1"></div>
<div class="col-md-2 gap-frm-top-posts">

  @foreach ($result as $r)
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
                      <a href="detail/{{$r->image_id}}" class="anchor-username"><h4 class="media-heading">#{{$r->image_id}}</h4></a> 
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
                <a href="#"><img src="characters/{{ $r->{'character_path'} }}" class="img-rounded panel-resize-photo"><font color="white"> {{ $r->{'character_name'} }}</font></a>
              </div>
              <div class="row caption-new panel-text-color">
                <p>{{ $r->content }}</p>
              </div>
              </div>
              <img src="storage/images/{{ $r->{'image_path'} }}" class="img-rounded panel-img-position">
            </section>
            <section class="post-footer">
              <hr>  
                <div class="post-footer-option container">
                  <ul class="list-unstyled">
                    <li><a href="#"><i class="fa fa-heart" aria-hidden="true"></i> {{$r->likes}} Likes</a></li>
                    <li><a href="/tell?image_id={{$r->id}}"><i class="fa fa-bomb" aria-hidden="true"></i> Tell</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-share-alt"></i> Share</a></li>
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
<div class="col-md-7 col-sm-9 col-xs-10"></div>
  <div class="col-md-2 col-sm-2 col-xs-2">
      <div class="page-header notice-board-style">
        Retellgram <i class="fa fa-copyright" aria-hidden="true"></i> 2017.
      </div>
  </div>
</div>
@endsection
@section('footer')
@endsection