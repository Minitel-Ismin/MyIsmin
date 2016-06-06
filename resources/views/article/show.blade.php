@extends('common.layout')

@section('title')
{{$article_name}}
@endsection

@section('content')

@role('admin','prez')	
	<div class="col-md-2 col-md-offset-10">
		<a class="btn btn-default " aria-hidden="true" href={{URL::to('/article/'.$id.'/edit')}} title="Editer l'article">
			<div class="glyphicon glyphicon-pencil"></div>
		</a>
	</div>
@endrole

<p class="text-justify">
	{!!$content!!}
</p>

@endsection