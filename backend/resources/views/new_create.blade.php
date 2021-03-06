<?php
    $options = array( "7" => "Avata", 
              "5" => "Curry Puff", 
              "2" => "Deadpoo",
              "8" => "Dollraemon",
              "4" => "Donald Drunk", 
              "6" => "Genghis Khan",
              "1" => "Hairy Porter", 
              "3" => "Hermoney Changer",
              "10" => "Hulky",
              "11" => "Kimchi Jong-un",  
                  "9" => "Queen Kong",
                  "12" => "Super Maria" );
?>
@extends('new_template_with_side_bar')
@section('title')
Tell
@endsection
@section('header')
<link href="/enjoyhint/enjoyhint.css" rel="stylesheet">
<link href="css/image-picker.css" rel="stylesheet">
<script type="text/javascript">
  //auto expand textarea
  function adjust_textarea(h) {
    h.style.height = "20px";
    h.style.height = (h.scrollHeight)+"px";
  }

  function submitCharacter() {
    var selected_image_src = $(".selected img").attr("src");
    var selected_option = $("#character_id option[data-img-src='" + selected_image_src + "']");
    var value = selected_option.val();
    var name = selected_option.html();
    $("input[name='character_id']").val(value);
    //$(".character-chosen").css('display','none');
    $("#characterModal").modal("hide");
    $(".character-chosen").fadeOut( function() {
      $(".character-chosen").text("Posted as " + name).fadeIn();
    });
  }


</script>
@endsection
@section('sidebar')
  @foreach($hashtags as $t)
  <li>
      <a class="hashtag" href="/search?query=%23{{$t->name}}">#{{$t->name}} </a>
  </li>
  @endforeach
@endsection
@section('main-content')
  <div class="row">  
    <div class="col-md-2"></div>
    <div class="col-md-8">
      @if (count($errors) > 0) 
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      @include('flash::message')
      {{ Session::forget('flash_notification') }}
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-8 tell-panel">
      <div class="page-content-wrapper">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title panel-tell-title">tell a different story</h3>
          </div>
          <div class="panel-body">

            <div class=" col-md-12">
              <div class="panel panel-primary">
                <div class="panel-body">
                  @if($image_id)
                  <img class="img-rounded" id="caption_image" src="storage/images/{{$image_path}}" alt="Image {{ $image_path }} ">
                  @else
                  <img src="images/cat.jpg" id="caption_image" class="img-rounded">
                  @endif
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <p class="character-chosen">Please choose character</p>
              <button type="button" data-toggle="modal" data-target="#characterModal" class="choose-character btn btn-md btn-warning">choose someone famous <i class="fa fa-hand-lizard-o" aria-hidden="true"></i></button>
            </div>

            <!--Select character modal-->
              <div class="modal fade" id="characterModal" tabindex="-1" role="dialog" aria-labelledby="characterModalLabel">
                <div class="modal-dialog full-screen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" 
                              data-dismiss="modal" 
                              aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="characterModalLabel">Choose Character</h4>
                        </div>
                    

                        <div class="modal-body character-modal-body">
                          <form role="form" action=javascript:submitCharacter() id="chooseCharacterForm" method="get">
                            <div class="form-group">
                              <input id="image_id" name="image_id" type="hidden" value="{{$image_id}}">
                            </div>
                            <div class="form-group">
                              <select id="character_id" name="character_id" class="image-picker form-control">
                                <option value=""></option>
                                @foreach ($characters as $character)
                                <option data-img-src='characters/{{$character->path}}' value='{{$character->id}}'>{{$character->name}}</option>
                                @endforeach
                              </select>
                            </div>
                          </form>
                        </div>  

                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <span class="pull-right">
                              <input id="submitCharacterForm" type="submit" value="Choose Character" class="btn btn-primary"/>
                          </span>
                        </div>  

                    </div>
                </div>
              </div>

      
            {!! Form::open() !!}
            <div class="form-group">
              {!! Form::hidden('image_id', $image_id) !!}
            </div>

            <div class="form-group">
              {!! Form::hidden('character_id', old('character_id')) !!}
            </div>

            <div class=" col-md-6">
              <div class="form-group form-style-8"> 
                <textarea id="caption" name="caption" placeholder="Caption" onkeyup="adjust_textarea(this)">{!! old('caption') !!}</textarea>
              </div>  
            </div>
            <div class="col-md-4"></div>
            <div class=" col-md-6">
              <div class="form-group form-style-8"> 
                <textarea id="hashtags" name="hashtags" placeholder="#English #hashtags #maximumFiveAllowed" onkeyup="adjust_textarea(this)">{!! old('hashtags') !!}</textarea>
              </div>  
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-8">
              <button type="submit" id="retell-button" class="btn btn-lg btn-success">Post <i class="fa fa-heart" aria-hidden="true"></i></button>
            </div>
            {!! Form::close() !!}

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('footer')
<script type="text/javascript" src="js/image-picker.min.js"></script>
<script src="/enjoyhint/enjoyhint.min.js"></script>
<script>
  $(document).ready(function () {

    var char_id;
    if ( char_id = $("input[name='character_id']").val() ){
      var selected_option = $("#character_id option[value='"+ char_id +"']");
      var name = selected_option.html();
      $(".character-chosen").text("Posted as " + name);
    }
   
    $("#submitCharacterForm").on('click', function() {
        $("#chooseCharacterForm").submit();
    });

    $("#character_id").imagepicker({
        hide_select: true,
         limit: 1,
         show_label: true,
         limit_reached: function(){swal('Please select only one character.')}, 
    });

  });
</script>
@if (!$visited)
<script>
  $(document).ready(function () {
        var enjoyhint_instance = new EnjoyHint({});

        var enjoyhint_script_steps = [
          {
            'next .choose-character' : 'Retellgram has 4 factions and 12 characters. <br>Each character belongs to one of the 4 factions - Red, Yellow, Green, Blue. <br>Likes earned by characters contribute to the total votes for each faction.',
          },
          {
            'next #caption' : 'Tell your new story here',
          },
          {
            'next #hashtags' : 'You may want to add hashtags for your post',
          },
          {
            'next #retell-button' : 'Finally click Retell to post. Enjoy!',
            'shape': 'circle',
            'radius':50
          }
          
        ];

        //set script config
        enjoyhint_instance.set(enjoyhint_script_steps);

        //run Enjoyhint script
        enjoyhint_instance.run();
       
  });
</script>
@endif
@endsection