@extends('layouts.app') 

@include('article.admin.articlejs')


@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<form role="form" class="col-md-12 go-right" 
			method="post" action={{URL::to('/article/'.$id) }} enctype="multipart/form-data">
				<input type="hidden" name="_method" value="PUT">
				{!! csrf_field()!!}
				<h2>Edition d'un article</h2>
				@include('article.admin.articleform')

			</form>
		</div>
	</div>
</div>


@endsection




