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
				<div class="panel panel-default">
					<div class="panel-body">
						<img src="/storage/images/{{$r->file_path}}" height="200">
						<div class="caption">
							{{$r->popular->content}}
						</div>
					</div>
					<div class="panel-footer">
						<span class="glyphicon glyphicon-thumbs-up"></span> {{$r->likes}} likes
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
@endsection
@section('footer')
@endsection
