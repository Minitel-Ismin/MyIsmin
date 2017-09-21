<div class="form-group">
	<label for="header">Nom {{$type}}</label> <input name="name"
		class="form-control" value="{{$asso_name}}">

</div>

<div class="form-group">

	<label for="lieu">Article</label> <select class="form-control"
		id="lieu" name="article_id"> @foreach($articles as $article)
		<option value={{$article->id}} @if($article_s == $article->id)
			selected @endif > {{$article->name}}</option> @endforeach
	</select>
</div>

<div class="form-group">
	<label for="header">Lien de l'url (alias)</label> <input name="lien"
		class="form-control" value="{{$lien}}">

</div>

<div class="form-group">

	<label for="lieu">Président</label> 
		<select class="form-control" id="lieu" name="prez_id"> 
			@foreach($prezs as $prez)
				<option value={{$prez->id}} @if($prez_s == $prez->id) selected @endif >{{$prez->name}}</option>
			@endforeach
			<option value=0 @if($prez_s == 0) selected @endif >Aucun </option>
		</select>
</div>


@if($type == 'asso')
<div class="form-group">
	<label for="header">Couleur de l'asso dans l'agenda</label> 
	<input name="color" class="form-control" value="{{$color}}">

</div>
<div class="form-group">
	<label for="header">Couleur du texte de l'asso dans l'agenda</label> 
	<input name="text_color" class="form-control" value="{{$text_color}}">

</div>
@endif

<div class="form-group">
	<button type="submit" class="btn btn-default">Enregistrer</button>
</div>
