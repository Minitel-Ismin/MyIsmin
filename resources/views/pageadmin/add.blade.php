@extends('layouts.app') 

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<form role="form" class="col-md-12 go-right" method="post"
			action={{URL::to('/admin/page') }} >
				{!! csrf_field() !!}
				<h2>Ajout d'une page</h2>
				@include('pageadmin.formpage')
	
			</form>
		</div>
	</div>
</div>


@endsection
<script type="text/javascript"
	src="{{URL::asset('assets/js/jquery.js')}}"></script>
<link rel="stylesheet" type="text/css"
	href="{{URL::asset('assets/css/jquery-ui.css')}}">

<script type="text/javascript"
	src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-ui.min.js')}}"></script>