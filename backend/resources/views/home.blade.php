@extends('template')
@section('title')
Home
@endsection
@section('header')
@endsection
@section('main')

<div class="container">
	<div class="row">
		<div class="col-md-3">

		</div>
		<div class="col-md-9">
			@foreach($result as $r)
				<div><img src="/storage/images/{{$r->file_path}}" width="100" height="100">, {{$r->likes}} likes, {{$r->popular->content}}</div>
			@endforeach
		</div>
	</div>
</div>
@endsection
@section('footer')
@endsection
