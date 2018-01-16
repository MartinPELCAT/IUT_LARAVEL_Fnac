
@extends('layouts.app') 
 @section('title', 'Recherche de produits')
 @section('content') 



@if(Session::get('utilisateurConnecte.role') == 3)
 <table align="center" style="width:90%; margin-right: auto;margin-left: auto;"" >
  <tr>
    <th style="text-align: center;">Nom de l'article</th>
    <th style="text-align: center;">Detail de l'avis</th>
    <th style="text-align: center;">Nombre de signalement</th>

    <th style="text-align: center;">Supprimer l'avis</th>
    <th style="text-align: center;">Annuler signalement</th> 
  </tr>
@php
$ligne = 0
@endphp
@foreach($AvisAbusifs as $AvisAbusif)
@php
$ligne++;
@endphp
@if($ligne % 2 == 0)
  <tr style="background-color: white";>
@else
      <tr style="background-color: lightgray";>
@endif

    <td align="center">{{$AvisAbusif->ort_nompdt}}</td>
    <td align="center">{{$AvisAbusif->avi_detail}}</td>
    <td align="center" style="color:orange; font-size: 20px;">{{$AvisAbusif->nbsignalements}}</td> 
    <td>
    	<form method="post" action="serviceCom/delete/{{$AvisAbusif->avi_id}}">
   		<input id="ComButton" type="submit" value="Supprimer"/> 
   		<input type="hidden" name="_token" value="{{ csrf_token() }}"/>

		</form>
	</td>
    <td>
      <form method="post" action="serviceCom/cancel/{{$AvisAbusif->avi_id}}">
      <input  id="ComButton" type="submit" value="Annuler"/> 
      <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

    </form>
  </td>

  </tr>

@endforeach
</table>



@else

@section('content')
<div style="margin-right: auto;margin-left: auto;width: 630px;">
<h1 style="font-size: 100px;">Hop hop hop !</h1>
<p style="font-size: 42px; color: orange;">Tu n'a pas accès à cette page !</p>
</div>
@endsection


@endif

        @endsection