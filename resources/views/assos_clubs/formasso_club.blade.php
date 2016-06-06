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
	<button type="submit" class="btn btn-default">Enregistrer</button>
</div>
