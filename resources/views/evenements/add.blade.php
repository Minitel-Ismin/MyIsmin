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

