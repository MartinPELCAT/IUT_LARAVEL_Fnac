@extends('layouts.app') 
 @section('title', 'Panier')
 @section('content') 

  <h2>Fiches favorites</h2>
@if(count($favoris)>0)

@foreach($favoris as $fav)
             <p id="a">
                <img width="100" height="100" src="{{$fav->pho_url}}">
                {{$fav->ort_nompdt}}</br>
                {{$fav->ort_processeur}}</br>
                {{$fav->ort_prixttc}}€</br></br>
                <a href="{{ url('/produit',['id'=>$fav->ort_id] )}}"> Voir fiche produit</a></br>
                <a href="{{ url('/favoris/suppression',['id'=>$fav->ort_id] )}}"> Supprimer la fiche des favoris</a></br>
              </p>          
@endforeach

@else
<p>Vous n'avez aucune fiche favorite</p>
@endif


  
  
        
@endsection