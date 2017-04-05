@extends('new_template_with_side_bar')
@section('title')
ReTell Your Story
@endsection
@section('header')
<link href="/enjoyhint/enjoyhint.css" rel="stylesheet">
 
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
          <div class="panel panel-default">
            <div class="panel-body">
              <section class="post-heading">
                <div class="row">
                  <div class="col-md-11">
                    <div class="media">
                      <div class="media-body">
                        <a href="#" class="anchor-username"><h4 class="media-heading">Welcome</h4></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1">
                  </div>
                </div>
              </section>
              <section class="post-body">
                @if (!$visited)
                <div id="introduction-panel" class="panel panel-caption">
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
                      <br>You lurk in the shadows, masked behind one of Retellgram's 12 characters.
                      And your mission?
                      <br>Usurp the throne and become Retellgram's most notorious ruler!
                      <br>There's just one problem, however.
                      The four great factions- Red, Yellow, Green, Blue have been at war since the ancient times.
                      <br>Betrayal is common within the factions, and the 'Eye' has decided to keep the factions' member list a secret.
                      This means that it is up to you to steal the identity of the reincarnates and uncover the ancient secret.
                      <p></p>
                    </div>
                  </div>
                </div>
                @endif
                <div class="panel panel-caption">
                  <!-- <div class="row caption-new page-header"> -->
                  @foreach ($rule_factions as $rule_faction => $level)
                  <div id="rulers" class="row caption-new">  
                    <img src="logo/{{$rule_faction}}.png" class="img-rounded panel-resize-photo"><font color="white"> {{ucwords($rule_faction)}} Faction is the new ruler</font>
                    <a id="levels" href="#"><img src="logo/level_{{$level}}.gif" class="img-rounded notice-board-resize-photo"></a>
                  </div>
                  @endforeach
                  <div class="row caption-new">  
                    <font color="white">Ruler faction refreshing in:    <div style="font-size:50px;" id="countdown"></div></font>
                  </div>
                  <!-- <div class="row caption-new">
                    <a href="#"><img src="logo/rookie.png" class="img-rounded notice-board-resize-photo"></a>
                    <a href="#"><img src="logo/pro.png" class="img-rounded notice-board-resize-photo"></a>
                    <a href="#"><img src="logo/threeWeeksAllKill.png" class="img-rounded notice-board-resize-photo"></a>
                    <a href="#"><img src="logo/sixWeeksAllKill.png" class="img-rounded notice-board-resize-photo"></a>
                  </div> -->
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
    
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
                    <li><a href="#" onclick=like(event) id="{{$r->id}}"><i class="fa fa-heart" aria-hidden="true"></i> {{$r->likes}} Likes</a></li>
                    <li class="tell-link"><a href="/tell?image_id={{$r->image->id}}"><i class="fa fa-bomb" aria-hidden="true"></i> Tell</a></li>
                    <li class="share-link"><a href="#" onclick=shareFB("{{env('APP_URL')}}","{{$r->image->id}}","{{$r->id}}")><i class="glyphicon glyphicon-share-alt"></i> Share</a></li>
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
<script src="/enjoyhint/enjoyhint.min.js"></script>
<script>
$(document).ready(function () {

  function roundMinutes(date) {

      date.setHours(date.getHours() + 1);
      date.setMinutes(0);

      return date;
  }

  var date = new Date();
  countDownDate = roundMinutes(date); 

  // Update the count down every 1 second
  var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    $("#countdown").html("    " + minutes + "m " + seconds + "s ");

    // If the count down is finished, write some text 
    if (distance < 0) {
      clearInterval(x);
      $("#countdown").html("    Refresh to see new ruler!");
    }
  }, 1000);

  if ($('#introduction-panel').length!=0){
    var enjoyhint_instance = new EnjoyHint({});

    //simple config. 
    //Only one step - highlighting(with description) "New" button 
    //hide EnjoyHint after a click on the button.
    var enjoyhint_script_steps = [
      {
        'next #hint-navbar' : 'Click Snap to upload. Click Tell to add captions',
      },
      {
        'next #rulers' : 'This ruler faction is based on number of likes in recent hour. <br>Four factions are Red, Yellow, Green, Blue. Each has 3 characters.',
      },
      {
        'next #levels' : 'If a faction continues become ruler, it will level up. <br>We have five levels: Rookie, Amateur, Pro, Veteran, Legend.',
        'shape': 'circle',
        'radius':80
      },
      {
        'next #countdown' : 'Time remaining to refresh ruler faction',
      },
      {
        'next .tell-link' : 'Retell your stories on the same image.',
        'shape': 'circle',
        'radius':50
      },
      {
        'next .share-link' : 'Share this story on FB.',
        'shape': 'circle',
        'radius':50
      },
    ];

    //set script config
    enjoyhint_instance.set(enjoyhint_script_steps);

    //run Enjoyhint script
    enjoyhint_instance.run();
  }
  
});
</script>
@endsection
