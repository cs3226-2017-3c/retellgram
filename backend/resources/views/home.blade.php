@extends('new_template_with_side_bar')
@section('title')
Home
@endsection
@section('header')
@endsection
@section('main-content')
<div class="page-content-wrapper">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="well col-md-8">
      <p><i class="fa fa-bolt" aria-hidden="true"></i> Ruling Faction</p>
      <b>
        <spanRed>
          RED<br />
          is superior<br />
          is on fire<br />
          cannot be challenged <br />
          dares you to REBEL
        </spanRed>
      </b>
    </div>
  </div>

@foreach($result as $r)
  <div class="row">
    <div class="container">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-body">
            <section class="post-heading">
              <div class="row">
                <div class="col-md-11">
                  <div class="media">
                    <div class="media-body">
                      <a href="#" class="anchor-username"><h4 class="media-heading">#{{$r->id}}</h4></a>
                      <a href="#" class="anchor-time">51 mins</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <a href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                </div>
              </div>
            </section>
            <section class="post-body">
              <img src="{{'/storage/images/'.$r->file_path}}" class="img-rounded">
              <p>
                <button type="button" class="btn btn-xs btn-primary">Hulky</button>
              </p>
            </section>
            <section class="post-footer">
              <hr>
                <div class="post-footer-option container">
                  <ul class="list-unstyled">
                    <li><a href="#"><i class="fa fa-heart" aria-hidden="true"></i> {{$r->likes}} Likes</a></li>
                    <li><a href="#"><i class="fa fa-bomb" aria-hidden="true"></i> Tell</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-share-alt"></i> Share</a></li>
                  </ul>
                </div>
                @foreach($r->captions as $c)
                <div class="post-footer-comment-wrapper">
                  <div class="comment">
                    <div class="media">
                      <div class="media-left">
                        <button type="button" class="btn btn-xs btn-primary">{{$c->character->name}}</button>
                      </div>
                      <div class="media-body">
                        {{$c->content}}
                        <a href="#" class="pull-right">
                          <font size="1"> {{$c->likes}} </font><i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
            </section>
          </div>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>
@endforeach
</div>
@endsection
@section('footer')
@endsection
