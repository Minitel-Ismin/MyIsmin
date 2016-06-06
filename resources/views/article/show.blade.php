@extends('common.layout')

@section('title')
{{$article_name}}
@endsection

@section('content')

@if(Entrust::hasRole('admin') || Entrust::hasRole('prez'))	
	<div class="col-md-2 col-md-offset-10">
		<a class="btn btn-default " aria-hidden="true" href={{URL::to('/article/'.$id.'/edit')}} title="Editer l'article">
			<div class="glyphicon glyphicon-pencil"></div>
		</a>
	</div>
@endif

<p class="text-justify">
	{!!$content!!}
</p>

@endsection