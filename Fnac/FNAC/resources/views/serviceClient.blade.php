
@extends('layouts.app') 
@section('title', 'ServiceClient')
@section('content') 

@if(Session::get('utilisateurConnecte.role') == 1)

<h3 id="title"> Liste des commandes passsées hier</h3>
<div id="z">
  @foreach ($commandes as $commande)
  <div id="cmdPasse">

      <p id="nomCmd">{{ $commande->acq_nom }}
          {{ $commande->acq_prenom }}</p>

          @if($commande->adr_id!=null)
          <span>Adresse : </span>{{ $commande->adr_nom }} </br>
          <span>Rue : </span>{{ $commande->adr_rue }}</br>

          <span>Ville : </span>{{ $commande->adr_ville }} </br>
          @endif

          @if($commande->rel_id!=null)
          <span>Nom relais : </span>{{ $commande->rel_nom }}</br>
          <span>Rue : </span>{{ $commande->rel_rue }}</br>
          <span>Ville : </span>{{ $commande->rel_ville }}</br>
          @endif

          @if($commande->mag_nom!=null)
          <span>Nom magasin : </span>{{ $commande->mag_nom }}</br>
          <span>Ville : </span>{{ $commande->mag_ville }}</br>
          @endif

          @if($commande->ach_statut == "En attente")
          <span style="color: red; float: left;">En attente</span>
         

          <form method="post" action="serviceclient/livrer/{{$commande->ach_id}}">
         <input style="float: right; background-color: white; color: red; border: 1px dashed darkred; padding: 5px 5px; margin-top: 0" type="submit" name="statutAchat" value="Livrer">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

        </form>
          @endif

          @if($commande->ach_statut == "En livraison")
          <span style="color: orange; float: right;">En livraison</span>
          @endif
      </div>
      @endforeach
  </div>



  @else

  @section('content')
  <div style="margin-right: auto;margin-left: auto;width: 630px;">
    <h1 style="font-size: 100px;">Hop hop hop !</h1>
    <p style="font-size: 42px; color: orange;">Tu n'a pas accès à cette page !</p>
</div>
@endsection


@endif

@endsection