@extends('template')
@section('title')
Admin Page
@endsection
@section('header')
@endsection
@section('main')

@foreach ($unverified as $caption)
<p value='{{$caption->id}}'>{{$caption->content}}</p>							
@endforeach

@endsection
@section('footer')
@endsection