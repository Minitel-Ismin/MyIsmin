@extends('common.layout')

<link rel="stylesheet" type="text/css" href={{URL::asset('assets/css/form.css')}}>

<script type="text/javascript"
	src="{{URL::asset('assets/js/jquery.js')}}"></script>
<script src={{URL::asset('assets/js/tinymce/js/tinymce/tinymce.min.js')}}></script>

<script type="text/javascript">


tinymce.init({
  selector: 'textarea',
  height: 500,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code jbimages'
  ],
  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link jbimages',
  content_css: "{{URL::asset('assets/js/tinymce/js/tinymce/themes/modern/custom_content.css')}}",
  theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
  font_size_style_values : "10px,12px,13px,14px,16px,18px,20px",
  language: "fr_FR",
  relative_urls: false,	
});


function bs_input_file() {
    $(".input-file").before(
        function() {
            if ( ! $(this).prev().hasClass('input-ghost') ) {
                var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                element.attr("name",$(this).attr("name"));
                element.change(function(){
                    element.next(element).find('input').val((element.val()).split('\\').pop());
                });
                $(this).find("button.btn-choose").click(function(){
                    element.click();
                });
                $(this).find("button.btn-reset").click(function(){
//                     element.val(null);
//                     $(this).parents(".input-file").find('input').val('');
					$("#old-file").remove();
					$("#file-show").attr("placeholder", "Choisir un fichier");
                });
                $(this).find('input').css("cursor","pointer");
                $(this).find('input').mousedown(function() {
                    $(this).parents('.input-file').prev().click();
                    return false;
                });
                return element;
            }
        }
    );
}
$(function() {
    bs_input_file();
});
</script>

@section('title')

{{$article_name}}

@endsection

@section('content')

<div class="container">
	<div class="row">
		@if($errors[0])
			<div class="alert alert-danger col-md-9 go-right" role="alert">
				@foreach($errors as $error)
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span> {{$error}}
				</br>
				@endforeach
			</div>
		
		@endif
	
		<form role="form" class="col-md-9 go-right" method="post"
			action={{URL::to('/article/'.$id) }} enctype="multipart/form-data">
			<input type="hidden" name="_method" value="PUT">
			@if($file)
			<input type="hidden" name="old_file" value={{$file}} id="old-file">
			@endif
			{!! csrf_field() !!}
			<div class="form-group">
		        <div class="input-group input-file" name="header_image">
		            <span class="input-group-btn">
		                <button class="btn btn-default btn-choose" type="button">Choisir</button>
		            </span>
		            <input type="text" class="form-control" placeholder=@if($file) {{$file}} @else 'Choisir un fichier' @endif id="file-show">
		            <span class="input-group-btn">
		            
		                 <button class="btn btn-warning btn-reset" type="button">Reset</button>
		            </span>
		        </div>
			</div>
			<div class="form-group">
				<label for="header">Texte de la bannière:</label>
				<input name="header" class="form-control" value="{{$content_header}}">
			
			</div>

			<div class="form-group">
				<label for="contenu">Texte de l'article:</label>
				<textarea id="contenu" name="contenu" class="form-control" >{!!$content!!}</textarea>

			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-default">Enregistrer les
					modifications</button>
			</div>

		</form>
		
	</div>
</div>

@endsection()
