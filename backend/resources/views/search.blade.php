<?php
    $faction_colors = array( "red" => "#fd5f67", 
              "yellow" => "#e4c556", 
              "green" => "#58d774",
              "blue" => "#65e9e9");
?>
@extends('new_template_with_side_bar')
@section('title')
Search
@endsection
@section('header')
@endsection
@section('sidebar')
  @foreach($hashtags as $t)
  <li>
      <a class="hashtag" href="/search?query=%23{{$t->name}}">#{{$t->name}} </a>
  </li>
  @endforeach
@endsection
@section('main-content')

<div class="page-content-wrapper">
<div class="col-md-1"></div>
<div class="col-md-2 gap-frm-top-posts">
  <div class="row">
    <div class="container">
    <div class="col-md-8">
      @include('flash::message')
      {{ Session::forget('flash_notification') }}
    </div>
  </div>
</div>
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
                      <a href="detail/{{$r->image_id}}?caption_id={{$r->id}}" class="anchor-username"><h4 class="media-heading">#{{$r->id}}</h4></a> 
                      <p class="anchor-time">{{ $r->created_at->diffForHumans() }}</p>
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
                <a href="#"><img src="characters/{{ $r->{'character_path'} }}" class="img-rounded panel-resize-photo"><font color="{{$faction_colors[$r->character->faction]}}"> {{ $r->{'character_name'} }}</font></a>
              </div>
              <div class="row caption-new panel-text-color">
                <p>{{ $r->content }}<br>@foreach($r->hashtags as $t) <a class="hashtag" href="/search?query=%23{{$t->name}}">#{{$t->name}} </a>@endforeach</p>
              </div>
              </div>
              <img src="storage/images/{{ $r->{'image_path'} }}" class="img-rounded panel-img-position">
            </section>
            <section class="post-footer">
              <hr>
                <div class="post-footer-option container">
                  <ul class="list-unstyled">
                    <li><a href="#" onclick=like(event) id="{{$r->id}}"><i class="fa fa-heart" aria-hidden="true"></i> {{$r->likes}} Likes</a></li>
                    <li><a href="/tell?image_id={{$r->image->id}}"><i class="fa fa-bomb" aria-hidden="true"></i> Retell</a></li>
                    <li><a href="#" onclick=shareFB("{{env('APP_URL')}}","{{$r->image->id}}","{{$r->id}}")><i class="fa fa-facebook-official"></i> Share</a></li>
                    <li><a href="#" onclick=report(event) id="{{$r->image->id}}"><i class="fa fa-eye" aria-hidden="true"></i> Report</a></li>
                  </ul>
                </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  <div class="row">
    <div class="container">
      <div class="col-md-8">
        
        
          @if($result->previousPageUrl())
            <a href="{{ $result->previousPageUrl() }}" class="btn btn-success btn-sm"><i class="fa fa-arrow-circle-left"></i> Back</a>
          @endif
        
        
          @if($result->nextPageUrl())
              <a href="{{ $result->nextPageUrl() }}" class="btn btn-success pull-right btn-sm">Next <i class="fa fa-arrow-circle-right"></i></a>
          @endif
      </div>
    </div>
  </div>

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
