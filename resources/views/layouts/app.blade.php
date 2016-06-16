<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="//fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">


    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Retour sur le site
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">



                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                  @if(Entrust::hasRole('admin') || Entrust::hasRole('prez'))
                     <li class="dropdown">
                       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                           Menu<span class="caret"></span>
                       </a>
                       <ul class="dropdown-menu" role="menu">
                       @role('admin')
                         <li><a href="{{URL::to('/admin/user')}}">Gestion des utilisateurs</a></li>
                         <li><a href="{{URL::to('/admin/article')}}">Gestion des articles</a></li>
                         <li><a href="{{URL::to('/admin/asso')}}">Gestion des assos</a>
                         <li><a href="{{URL::to('/admin/club')}}">Gestion des clubs</a>
                         <li><a href="{{URL::to('/admin/page')}}">Gestion des pages</a>
                       @endrole
                       @if(Entrust::hasRole('admin') || Entrust::hasRole('prez'))
                         <li><a href="{{URL::to('/admin/event')}}">Calendrier</a></li>
                       @endif
                     </ul>
                     </li>
                  @endif
                    <!-- Authentication Links -->
                    	@if (!Auth::guest())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>


                        </li>
                        @endif

                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    {{--
	<script src="{{ URL::asset('assets/js/jquery.js') }}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
