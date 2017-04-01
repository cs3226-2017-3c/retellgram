@extends('new_template_with_side_bar')
@section('title')
Home
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
  @if(Request::path()=="/")
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
                      <a href="#" class="anchor-username"><h4 class="media-heading">#1</h4></a>
                      <a href="#" class="anchor-time">51 mins</a>
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
                  <a href="#"><img src="characters/joker.png" class="img-rounded panel-resize-photo"><font color="white"> Welcome to Retellgram!</font></a>
                </div>
                <div class="row caption-new panel-text-color">
                  <p>It's not about the photo, it's about telling a story. Everything burns!</p>
                  &nbsp
                  <p>Here's what you need to know: </p>
                  Retellgram is where you can anonymously post any photos, and anonymously caption someone else's photos.<br>
                  <p></p>
                  <button class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#intro">Okay, I'm listening <i class="fa fa-beer fa-2x" aria-hidden="true"></i></button>
                  <div id="intro" class="collapse">
                    <br>You come here when you're tired of your newsfeed constantly bombarded by
                    <p style="color:#afc8e0">#ItsOurTenthAnniversaryLetsTortureEveryoneWithOurFacebookPDA
                      #NoICantEatMyFoodBecauseItsNotOnInstagramYet #IRatherTweetThenHaveALegitConversationWithThePersonNextToMe
                      #StopHashTaggingBecauseItDoesntEvenMakeSense
                    </p>
                    <p>Or you see something you're dying to post to #insta #fb but then you hesitate because you have no guts and your friends will judge you.<br>
                      Easy. Upload those photos to Retellgram and set fire to the photos with your dark sense of humor.
                    </p>
                  </div>
                  <p></p>
                  &nbsp
                  <p>The dramatic plot: </p>
                  In Retellgram, you are an identity thief.
                  <br>
                  <p></p>
                  <button class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#plot">Sounds Cool <i class="fa fa-sign-language fa-2x" aria-hidden="true"></i></button>
                  <div id="plot" class="collapse">
                    <br>You lurk in the shadows, masked behind one of Retellgram's nine characters.
                    And your mission?
                    <br>Usurp the throne and become Retellgram's most notorious ruler!
                    <br>There's just one problem, however.
                    The four great factions- Raid, Yaylou, Grin, Bluu have been at war since the ancient times.
                    <br>Betrayal is common within the factions, and the 'Eye' has decided to keep the factions' member list a secret.
                    This means that it is up to you to steal the identity of the reincarnates and uncover the ancient secret.
                    <p></p>
                  </div>
                </div>
              </div>
              <div class="panel panel-caption">
                <div class="row caption-new page-header">
                  <a href="#"><img src="logo/red.png" class="img-rounded panel-resize-photo"><font color="white"> Red Faction is the new ruler</font></a>
                </div>
                <div class="row caption-new">
                  <a href="#"><img src="logo/rookie.png" class="img-rounded notice-board-resize-photo"></a>
                  <a href="#"><img src="logo/pro.png" class="img-rounded notice-board-resize-photo"></a>
                  <a href="#"><img src="logo/threeWeeksAllKill.png" class="img-rounded notice-board-resize-photo"></a>
                  <a href="#"><img src="logo/sixWeeksAllKill.png" class="img-rounded notice-board-resize-photo"></a>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
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
                      <a href="/detail/{{$r->image->id}}?caption_id={{$r->id}}" class="anchor-username"><h4 class="media-heading">#{{$r->id}}</h4></a>
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
                  <p>{{$r->content}}<br>@foreach($r->hashtags as $t) <a class="hashtag" href="/search?query=%23{{$t->name}}">#{{$t->name}} </a>@endforeach</p>
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
