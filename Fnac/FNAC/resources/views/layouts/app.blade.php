<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Fnac - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">

    <!-- JS -->
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    
</head>
<body>

    @section('nav') 

    <div class="menu">
       <a class="list-menu" href="{{url('/')}}">Acceuil</a>
       {{--<a class="list-menu" href="{{ url('/listeclient') }}">Liste des clients</a>--}}
       <a class="list-menu" href="{{ url('/produit') }}">Recherche produit</a> 

       
       
       
       @if((Session::has('utilisateurConnecte.id')) )
       @if (Session::get('utilisateurConnecte.role') == null)
       @php

       $panier  = Session::get('panier');
       if($panier != null)
       $quantitePanier = $panier['quantitePanier'];
       else
       $quantitePanier = 0;
       @endphp
       <a class="list-menu" href="{{ url('/favoris') }}">Favoris</a>
       <a class="list-menu" href="{{ url('/panier') }}">Panier ({{ $quantitePanier }})</a>
       <a class="list-menu" href="{{ url('/commandes') }}">Historique des commandes</a>
       
       @elseif (Session::get('utilisateurConnecte.role') == 1)
       <a class="list-menu" href="{{ url('serviceclient') }}">Service client</a>
       @elseif (Session::get('utilisateurConnecte.role') == 2)
       <a class="list-menu" href="{{ url('serviceVente') }}">Service ventes</a>
       @elseif (Session::get('utilisateurConnecte.role') == 3)
       <a class="list-menu" href="{{url('/serviceCom')}}">Service communication</a>
       @endif

       <a class="list-menu" href="{{ url('/compte/profil') }}"> {{ Session::get('utilisateurConnecte.pseudo') }}</a>
       <a class="list-menu" href="{{ url('/compte/deconnexion') }}">[Déconnexion]</a>
       @else

       <a class="list-menu" href="{{ url('/compte/connexion') }}">Me connecter</a>
       <a class="list-menu" href="{{ url('/compte/add') }}">Créer un compte</a>

       @endif

       

   </div>
   @show
   {{-- <div id="app">
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
                    {{ config('app.name', 'Fnac') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>


</div>
--}}

@yield('content')



<!-- Scripts -->
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>
