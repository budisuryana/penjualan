
@extends('template')
@section('content')

<div class="row">
	<div class="col-md-12 page-404">
		<div class="number">
			 404
		</div>
		<div class="details">
			<h3>Oops! The Page Not Found.</h3>
			<p>
				 We can not find the page you're looking for.<br/>
				<a href="{{ url('dashboard') }}">
				Please Return home. </a>
			</p>
		</div>
	</div>
</div>

@endsection




