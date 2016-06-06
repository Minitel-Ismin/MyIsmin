<div class="form-group">
	<label for="header">Nom de la page</label> <input name="name"
		class="form-control" value="{{$page_name}}">

</div>

<div class="form-group">

	<label for="article">Article</label> <select class="form-control"
		id="article" name="article_id"> @foreach($articles as $article)
		<option value={{$article->id}} @if($article_s == $article->id)
			selected @endif > {{$article->name}}</option> @endforeach
	</select>
</div>
<div class="form-group">
	<label for="chkbox">Activée : </label>

	<input type="checkbox" id="chkbox" name="enabled" value="true"><br>
</div>

<div class="form-group">
	<button type="submit" class="btn btn-default">Enregistrer</button>
</div>
