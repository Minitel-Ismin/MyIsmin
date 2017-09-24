@section('css')
	<link rel="stylesheet" type="text/css"
	href="{{URL::asset('assets/css/event-form.css')}}">
@endsection

@if(count($errors))
	<div class="row">
		<div class="alert alert-danger col-md-12 go-right" role="alert">
			@foreach($errors as $error) 
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span> {{$error}} 
				</br>
			@endforeach
		</div>
	</div>

@endif
</br>
<div class="form-group">
	<label for="title">Nom de l'évènement</label> 
	<input name="title" type="text" class="form-control" value="{{$title}}" required>
</div>

<div class="form-group">
	<label for="lieu">Organisateur</label> <select class="form-control"
		id="orga" name="orga">
		@foreach($organisateurs as $organisateur)
			@if(($organisateur->user && Entrust::hasRole('prez') && Auth::user()->id == $organisateur->user->id)||Entrust::hasRole('admin'))
				<option value={{$organisateur->id}} @if($organisateur_s == $organisateur->id) selected @endif > {{$organisateur->name}}</option>
			@endif
		@endforeach
		<option value="0" @if($organisateur_s==0) selected @endif>Autre</option>
	</select>
</div>
<div class="form-group">

	<label for="description">Description</label>
	<textarea name="description" class="form-control" required>{{$desc}}</textarea>
</div>
<div class="form-group">

	<label for="lieu">Lieu</label> 
	<select class="form-control"
		id="lieu" name="lieu">
		@foreach($lieus as $lieu)
			<option value={{$lieu->id}} @if($lieu_s == $lieu->id) selected @endif >{{$lieu->name}}</option>
		@endforeach
		<option class="editable" value="Autre">Autre</option>
	</select>
	<input class="editOption" style="display:none;"></input>
</div>
<div class="form-group">

	<div class="row">
		<div class='col-sm-12'>
			<label for="start">Debut</label> <input name="start"
				class="form-control" id='datetimepicker' value={{$start}} type="text" required>
		</div>
	</div>
</div>
<div class="form-group">

	<div class="row">
		<div class='col-sm-12'>
			<label for="end">Fin</label> <input name="end" class="form-control"
				id='datetimepicker1' value={{$end}} type="text" required>
		</div>
	</div>
</div>

<div class="form-group">

	<label for="periodicite">Periodicité</label> 
	<select class="form-control" id="periodicite" name="periodicite">
		<option value="none">Aucune</option>
		<option value="hebdomadaire">Hebdomadaire</option>
		<option value="bimensuelle">Bimensuelle</option>
		<option value="mensuelle">Mensuelle</option>

	</select>
</div>

<div class="form-group" style="display: none;" id="end-periodicite">

	<div class="row">
		<div class='col-sm-12'>
			<label for="end-periodicite">Fin periodicité</label> 
			<input name="end-periodicite" class="form-control" id='datetimepicker2' type="hidden" required>
		</div>
	</div>
</div>

<div class="col-sm-offset-2 col-sm-10">
	<button type="submit" class="btn btn-primary">Enregistrer</button>
</div>

@section('footerscript')

<script type="text/javascript" src="{{URL::asset('assets/js/jquery.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/jquery-ui.css')}}">
<link href="{{URL::asset('assets/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
<script type="text/javascript" src="{{URL::asset('assets/js/moment-with-locales.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/collapse.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/transition.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/build/js/bootstrap-datetimepicker.min.js')}}"></script>
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

		$(function () {
			
	        $('#datetimepicker2').datetimepicker({
            	locale:'fr'
            });
	    });
</script>


<script type="text/javascript">
$(document).ready(function(){
	var initialText = $('.editable').val();
	$('.editOption').val(initialText);

	$('#lieu').change(function(){
		var selected = $('option:selected', this).attr('class');
		var optionText = $('.editable').text();

		if(selected == "editable"){
			$('.editOption').show();

			
			$('.editOption').keyup(function(){
				var editText = $('.editOption').val();
				$('.editable').val(editText);
				$('.editable').html(editText);
			});

		}else{
			$('.editOption').hide();
		}
	});

	$("#periodicite").change(function(){
		var selected = $('option:selected', this).val();
		console.log(selected);
		if(selected != "none"){
			$('#datetimepicker2').attr('type', 'text');
			$("#end-periodicite").show();
		}else{
			$('#datetimepicker2').attr('type', 'hidden');
			$("#end-periodicite").hide();
		}
	});
});

</script>

@endsection