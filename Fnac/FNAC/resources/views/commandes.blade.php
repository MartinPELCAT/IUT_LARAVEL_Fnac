@extends('layouts.app') 
 @section('title', 'Liste des clients')
 @section('content') 

 <a href="commandesEnCours">Voir les commandes en cours</a><br>
<a href="commandes">Voir <span>TOUTES</span> les commandes</a>


<div id="fullCommandes">
<div class="commande">

@if(count($commande) == NULL)
<span>Vous n'avez pas passer de commandes</span>

@else
@php
  $vTestBoucle = 0;
  $vPrixTotal=0;
  $vTestId = $commande[0]->ach_id;
@endphp
@for($i = 0; $i<count($commande);$i++)
	@if($commande[$i]->ach_id == $vTestId)
			
		@if($vTestBoucle==0)

			     <p id="nomCmd">
			     <span>Référence de commande : </span>{{$commande[$i]->ach_id}}</br>
			       {{ $commande[$i]->acq_nom }}
          	{{ $commande[$i]->acq_prenom }}</p>

            
        	@if($commande[$i]->adr_id!=null)
          	<span>Adresse : </span>{{ $commande[$i]->adr_nom }} </br>
          	<span>Rue : </span>{{ $commande[$i]->adr_rue }}</br>

          	<span>Ville : </span>{{ $commande[$i]->adr_ville }} </br>
        	@endif

         	 @if($commande[$i]->rel_id!=null)
	         	 <span>Nom relais : </span>{{ $commande[$i]->rel_nom }}</br>
	          	<span>Rue : </span>{{ $commande[$i]->rel_rue }}</br>
	          	<span>Ville : </span>{{ $commande[$i]->rel_ville }}</br>
         	 @endif

         	 @if($commande[$i]->mag_nom!=null)
	          	<span>Nom magasin : </span>{{ $commande[$i]->mag_nom }}</br>
	         	 <span>Ville : </span>{{ $commande[$i]->mag_ville }}</br>
          	@endif


          	@if($commande[$i]->ach_statut == "En attente")
	          	<span style="color: red; float: right;">En attente</span>
          	@endif

         	@if($commande[$i]->ach_statut == "En livraison")
         	 	<span style="color: orange; float: right;">En livraison</span>
         	@endif
         	@if($commande[$i]->ach_statut == "Livré")
         	 	<span style="color:green; float: right;">Livré</span>
         	@endif
         	
         	<span>Nom Produit :</span>{{$commande[$i]->ort_nompdt}}</br>
         	<span>Quantité : </span>{{$commande[$i]->lea_quantite}}</br>
         	<span>Prix : </span>{{$commande[$i]->ort_prixttc}} €</br>
           	@php
           	$vPrixTotal+=($commande[$i]->ort_prixttc*$commande[$i]->lea_quantite);
          	$vTestBoucle=1;
          	@endphp
      @else
        	<span>Nom Produit :</span>{{$commande[$i]->ort_nompdt}}</br>
         	<span>Quantité : </span>{{$commande[$i]->lea_quantite}}</br>
         	<span>Prix : </span>{{$commande[$i]->ort_prixttc}} €</br>
         	@php
         	$vPrixTotal+=($commande[$i]->ort_prixttc*$commande[$i]->lea_quantite);
          @endphp
    @endif

   @else
    	<span>Prix Total : </span>{{$vPrixTotal}} €</br>
    	</div>
    @php
      $vTestId=$commande[$i]->ach_id;
      $vTestBoucle=0;
      $i-=1;
      $vPrixTotal=0;
    @endphp
	 <div class="commande">



		


	@endif

@endfor
<span>Prix Total : </span>{{$vPrixTotal}} €</br>
</div>
</div>
@endif



@endsection

