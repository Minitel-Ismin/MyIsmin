 @if(count($errors))
<div class="row">
	<div class="alert alert-danger col-md-12 go-right" role="alert">
		@foreach($errors as $error) <span
			class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<span class="sr-only">Error:</span> {{$error}} </br> @endforeach
	</div>
</div>

@endif
<input type="hidden" name="admin" value="true">
@if($file)
	<input type="hidden" name="old_file" value={{$file}} id="old-file">
@endif
</br>

<div class="form-group">
	<div class="input-group input-file" name="header_image">
		<span class="input-group-btn">
			<button class="btn btn-default btn-choose" type="button">Choisir</button>
		</span> <input type="text" class="form-control"
			placeholder=@if($file) {{$file}} @else 'Choisir un fichier' @endif id="file-show"> <span
			class="input-group-btn">
			<button class="btn btn-warning btn-reset" type="button">Reset</button>
		</span>
	</div>
</div>

<div class="form-group">
	<label for="title">Nom de l'article</label> <input name="name"
		type="text" class="form-control" required value={{$name}}>

</div>

<div class="form-group">

	<label for="owner">Propriétaire</label> <select class="form-control"
		id="owner_id" name="owner_id">
		@foreach($users as $user)
			<option value={{$user->id}} @if($owner_id == $user->id) selected @endif >{{$user->name}}</option>
		@endforeach
		<option value=0 @if($owner_id == 0) selected @endif >Aucun </option>
	</select>
</div>
<div class="form-group">
	<label for="header">Texte de la bannière:</label> <input name="header"
		class="form-control" value="{{$header_text}}">

</div>

<div class="form-group">
	<label for="contenu">Texte de l'article:</label>
	<textarea id="contenu" name="contenu" class="form-control">{!!$content!!}</textarea>

</div>
<div class="col-sm-offset-2 col-sm-10">
	<button type="submit" class="btn btn-primary">Enregistrer</button>
</div>

