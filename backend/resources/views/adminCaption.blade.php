@extends('new_template')
@section('title')
Admin
@endsection
@section('header')
@endsection
@section('main')


<div class="row">
    <div class="container">
    	<div class="panel panel-default">
          <div class="panel-body">
			@foreach ($captions as $caption)
		    <div class="col-md-4">
		    	<div style="width:200px;height:200px;position:relative;margin-bottom:20px;">
			      	
			      		<p>{{$caption->content}}</p>
			      	
					<form action="/caption/{{$caption->id}}/delete" method="post">
						{{ csrf_field() }}
						<button type="submit" style="position:absolute;">Delete Caption</button>
					</form>	
				</div>
			</div>
			@endforeach
		  </div>
		</div>
	</div>
</div>



@endsection
@section('footer')
@endsection