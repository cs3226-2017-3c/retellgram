@extends('new_template_with_side_bar')
@section('title')
404
@endsection
@section('header')
@endsection
@section('main-content')
  <div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8 error-page-position">
      <div class="row">
        <i class="fa fa-meh-o fa-5x" aria-hidden="true"></i>
        <div class="col-md-8">
          Dude, you are drunk.
          This page does not exist.
          <a href="/" class="btn btn-lg btn-success">go back to retellgram <i class="fa fa-heart" aria-hidden="true"></i></a>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('footer')
@endsection