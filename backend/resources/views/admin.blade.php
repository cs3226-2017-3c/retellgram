@extends('template')
@section('title')
Admin Page
@endsection
@section('header')
@endsection
@section('main')

@foreach ($unverified as $caption)
<p value='{{$caption->id}}'>{{$caption->content}}</p>
<form action="caption/{{$caption->id}}/delete" method="post">
<button type="submit">Delete caption</button>
</form>	
<form action="caption/{{$caption->id}}" method="post">
<button type="submit">Accept caption</button>
</form>			
@endforeach


@endsection
@section('footer')
@endsection