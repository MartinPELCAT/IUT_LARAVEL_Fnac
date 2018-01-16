
@extends('layouts.app') 
 @section('title', 'Panier')
 @section('content')
 @php
$prixTot = 0
@endphp 
  <h2>Mon panier</h2>
  @if(Session::has('panier'))
  @foreach($ordiTablettes as $ordiTablette)
            
            
                <div id="c">
 
                </br>
                <img width="100" height="100" src="{{$ordiTablette->pho_url}}">
                {{$ordiTablette->ort_nompdt}}</br>    
                {{$ordiTablette->ort_processeur}}</br>
                {{$ordiTablette->ort_prixttc}}€</br></br>
                @php

                    $panier  = Session::get('panier');
                    $quantiteProduit = $panier[$ordiTablette->ort_id];
                @endphp
                <p>Quantité :  {{$quantiteProduit}}</p>
                <a href="{{ url('/produit',['id'=>$ordiTablette->ort_id] )}}"> Voir fiche produit</a></br>
                <a href="{{ url('/suppressionProduitPanier',['id'=>$ordiTablette->ort_id]) }}"> (-) Retirer</a></br>
                <a href="{{ url('/ajoutProduitPanier',['id'=>$ordiTablette->ort_id])}}"> (+) Ajouter</a></br>
                </div>
                </br>
                
                @php
                $prixTot += $ordiTablette->ort_prixttc
                @endphp

            @endforeach
            <div id="c">
              Prix total : {{$prixTot}} €
            </div>

          </br> 
          <div class="container">
            <form method="post" action="{{ url('/commande/modalitesCommande') }}">

            <input type="submit" value="Valider le panier">

            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
            </form>
            <form method="post" action="{{ url('/suppressionContenuPanier') }}">

            <input type="submit" name="supPanier" value="Supprimer le contenu du panier">

            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
            </form>
          </div>
  @else
  <p>Votre panier est tristement <b>vide.</b><p>
  @endif

  
  
        
@endsection