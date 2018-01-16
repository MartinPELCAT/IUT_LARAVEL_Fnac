
@extends('layouts.app') 
 @section('title', 'Connexion')
 @section('content') 
  <h3 id="title">Me connecter</h3>

        <div class="container">
        <form method="post" action="{{ url('/compte/connexion') }}">
        <input type="email" name="email" placeholder="Email" size="30" max="80" 
        @if(isset($_POST['email']))
        value="{{$_POST['email']}}" 
        @endif
        >

       
        </br>
        <input type="password" name="password" placeholder="Mot de passe" size="30" max="128">
        </br>
        @if(Session::get('ErreurDeConnexion') == true)
           <span class="ErrorMessageConnexion">*Le mail ou le mot de passe ne correspond pas<span>
        @ENDIF


        <input type="submit" name="connec" value="Connexion">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        </form>
        </div>
        @endsection