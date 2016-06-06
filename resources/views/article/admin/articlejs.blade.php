<script type="text/javascript"
	src="{{URL::asset('assets/js/jquery.js')}}"></script>
<link rel="stylesheet" type="text/css"
	href="{{URL::asset('assets/css/jquery-ui.css')}}">
<script type="text/javascript"
	src="{{URL::asset('assets/js/moment-with-locales.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('assets/js/collapse.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('assets/js/transition.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('assets/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-ui.min.js')}}"></script>


<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/form.css')}}">

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
  images_upload_base_path: '/some/basepath'
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
                    element.val(null);
                    $(this).parents(".input-file").find('input').val('');
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