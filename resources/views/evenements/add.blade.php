@extends('layouts.app') 


@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<form role="form" class="col-md-12 go-right" method="post"
				action="{{URL::to('/admin/event')}}">
				{!! csrf_field()!!}
				<h2>Ajout d'un évènement</h2>
				@include('evenements.event_form')

			</form>
		</div>
	</div>
</div>


@endsection
<script type="text/javascript"
	src="{{URL::asset('assets/js/jquery.js')}}"></script>
<link rel="stylesheet" type="text/css"
	href="{{URL::asset('assets/css/jquery-ui.css')}}">
<link href="{{URL::asset('assets/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
<script type="text/javascript"
	src="{{URL::asset('assets/js/moment-with-locales.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('assets/js/collapse.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('assets/js/transition.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('assets/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-ui.min.js')}}"></script>



<script type="text/javascript">
		$(function () {
            $('#datetimepicker').datetimepicker({
            	locale:'fr'
            });
        });
		$(function () {
	        $('#datetimepicker1').datetimepicker({
            	locale:'fr'
            });
	    });
</script>