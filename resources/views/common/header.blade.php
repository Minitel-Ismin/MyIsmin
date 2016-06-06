@if ($banner)
<header class="intro-header" style="background-image: url('{{ URL::asset($banner) }}')">
@else
<header class="intro-header" style="background-image: url('{{ URL::asset('assets/img/CMP2.jpg') }}')">
@endif
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <h1>My ISMIN</h1>
                    <hr class="small">
                    @if ($content_header)
                    	<span class="subheading">{{$content_header}}</span>
                    @else
                    	<span class="subheading">The website all ISMIN must use !</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>

