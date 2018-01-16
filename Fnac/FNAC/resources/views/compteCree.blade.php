
@extends('layouts.app') 
 @section('title', 'Liste des clients')
 @section('content') 
  <h1>Compte créé avec succès</h1>

  <p>Vous pouvez maintenant vous connecter en cliquant<a href="{{ url('/compte/connexion') }}"> ICI.</a></p>
        @endsection