@extends('layouts.app') 

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<form role="form" class="col-md-12 go-right" method="post"
			action={{URL::to('/admin/lieu') }} >
				{!! csrf_field() !!}
				<h2>Ajout d'un lieu</h2>
				@include('lieu.form_lieu')
	
			</form>
		</div>
	</div>
</div>


@endsection

@section('footerscript')
<script type="text/javascript"
	src="{{URL::asset('assets/js/jquery.js')}}"></script>
<link rel="stylesheet" type="text/css"
	href="{{URL::asset('assets/css/jquery-ui.css')}}">

<script type="text/javascript"
	src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-ui.min.js')}}"></script>
@endsection