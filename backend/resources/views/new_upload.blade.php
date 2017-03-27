@extends('new_template_with_side_bar')
@section('title')
Upload Image
@endsection
@section('header')
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.css" rel="stylesheet">
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
    <div class="col-md-2"></div>
    <div class="col-md-8 tell-panel">
        <div class="page-content-wrapper">
          <div class="panel panel-primary">

            <div class="panel-heading">
              <h3 class="panel-title panel-tell-title">snap your picture perfect</h3>
            </div>

            <div class="panel-body">
              {!! Form::open(['files' => 'true']) !!} 
              <div class=" col-md-4">
                <button type="button" class="btn btn-lg btn-primary"><i class="fa fa-camera-retro fa-2x" aria-hidden="true"></i></button>
                <!--button type="button" class="btn btn-lg btn-warning"><i class="fa fa-upload fa-2x" aria-hidden="true"></i></button-->
                
                <div class="form-group">
                    {!! Form::file('uploading',['id' => 'uploading']) !!}
                </div>
                
              </div>

              <div class=" col-md-8">
                <div class="panel panel-primary">
                  <div class="panel-body">
                    <div id="new_crop"></div>
                  </div>
                </div>
              </div>

              <div class="col-md-8">
                <button type="submit" class="btn btn-lg btn-success">post <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i></button>
              </div>
              {!! Form::close() !!}
            </div>
        
          </div>
        </div>
    </div>
  </div>
@endsection
@section('footer')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.js"></script>

<script>
$( document ).ready(function(){

  $uploadCrop = $('#new_crop').croppie({
    showZoomer:false,
      enableExif: true,
      viewport: {
          width: 200,
          height: 200,
          type: 'square'
      },
      boundary: {
          width: 200,
          height: 200
      }
  });

  function readURL(file) {
      if(file) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#new_crop').addClass('ready');
          $uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });
        }

        reader.readAsDataURL(file);
      }
  }

  $("#uploading").change(function() {
    //console.log("triggered");
      readURL(this.files[0]);
  });
});
</script>
@endsection