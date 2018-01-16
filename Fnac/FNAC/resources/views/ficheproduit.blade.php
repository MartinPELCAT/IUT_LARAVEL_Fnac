@extends('layouts.app')
 @section('title', 'Accueil')
@section('content')

<h1>Fiche {{$produits->ort_nompdt}}</h1>
<img src="../{{$photoUrl[0]->pho_url}}" width="300" height="300"></img>
	<div id="FPphoto">
@for ($i=2; $i <= $nbPhotos; $i++)
    <a target="_blank" href="{{$photoUrl[$i-1]->pho_url}}"><img src="{{$photoUrl[$i-1]->pho_url}}" width="100" height="100"></img></a>
@endfor
</div>
<div id="allFichePdt">

	<div id="ficheRegler">
		<span id="fichepdt">Nom produit :</span> <span> {{$produits->ort_nompdt}}</span></br></br>
		<span id="fichepdt">Nom processeur : </span> <span>{{$produits->ort_processeur}}</span></br></br>
		<span id="fichepdt">Mémoire RAM : </span>  <span>{{$produits->ort_ramgo}} Go </span> </br></br>
		<span id="fichepdt">Disque dur:  </span> <span>{{$produits->ort_disquedurgo}} Go </span></br></br>
		<span id="fichepdt">Taille écran : </span>  <span>{{$produits->ort_tailleecran}}"</span></br></br>
		<span id="fichepdt">Prix :  </span>  <span>{{$produits->ort_prixttc}} €</span></br></br></br>
	</div>
</div>
@if(Session::has('utilisateurConnecte.id'))
<a href="{{ url('/favoris/ajout',['id'=>$produits->ort_id] )}}"> Ajouter la fiche aux favoris</a></br>
@endif

	@if ($produits->ort_stock > 0)
		<p class="enstock" > En stock</p>
		@if((Session::has('utilisateurConnecte.id')))
				<a href="{{ url('/ajoutPanier',['id'=>$produits->ort_id] )}}"> Ajouter au panier</a>
				</br>  
				@else
				<p>Connectez vous pour ajouter ce produit au panier ou pour ajouter cette fiche aux favoris</p>
			@endif
		
	@else
		<p class="horsstock" > Rupture de stock</p>
	@endif
		<h2>Liste des avis</h2>
		<div class="orderAvis">
			<span> Trier les avis par :</span>
			<select id="OrderByAvis">
			<option value="null">--</option>
			<option value="{{url('/produit',['id'=>$produits->ort_id, 'orderBy'=>'avi_date'] )}}">Les plus récents</option> 
			<option value="{{url('/produit',['id'=>$produits->ort_id, 'orderBy'=>'avi_nbutilenon'] )}}">Les moins utiles</option>
			<option value="{{url('/produit',['id'=>$produits->ort_id, 'orderBy'=>'avi_note'] )}}">Les mieux notés</option>

		</select>
	</div>
		<div class="allAvis">
			
		@foreach($listeAvis as $avis)
			<div class="avis">
			
			<span class="pseudoAvis">{{$avis->acq_pseudo}}</span></br>
				Titre Avis : {{$avis->avi_titre}}</br>
				Details Avis : {{$avis->avi_detail}} <br>
				Note avis : {{$avis->avi_note}}/5 <br>
				Nb avis positifs : {{$avis->avi_nbutileoui}} 
			@if((Session::has('utilisateurConnecte.id')))
				<a class="actionAvis" href="{{url('/avis/aime',['idavis'=>$avis->avi_id, 'idproduit'=>$produits->ort_id])}}">J'aime</a><br>
			@endif

			Nb avis negatifs : {{$avis->avi_nbutilenon}} 

			@if((Session::has('utilisateurConnecte.id')))
				<a class="actionAvis" href="{{url('/avis/aimepas',['idavis'=>$avis->avi_id, 'idproduit'=>$produits->ort_id])}}">J'aime pas</a><br>
				@if(!in_array($avis->avi_id, $avisSignale ))
					<a id="actionSignale" href="{{url('/avis/signaler',['idavis'=>$avis->avi_id, 'idproduit'=>$produits->ort_id])}}">Signaler cet avis</a><br>
				@else
					<p id='avisDejaSignale'>Avis signalé</p>
				@endif
			@endif
			</div>
	@endforeach
</div>

@if((Session::has('utilisateurConnecte.id')) and ($avisok > 0 ))
<div id="DivAvis">
	<h2>Donner mon avis sur le produit</h2>
	<form method="post" action="{{ url('/avis/save') }}">
		<input type="text" id="titleAvis" name="title" placeholder="Titre de l'avis" min="10" max="100"></br>
		<textarea name="details" id="textAvis" cols="50" rows="5" max="2000"></textarea></br></br>
		<label for="note" name="Labelnote" id="titleAvis">Note du produit :</label>
		<select name="note" id="note">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option selected value="5">5</option>
		</select> 
		<input type="hidden" value="{{$produits->ort_id}}" name="idProduit">
		<input type="submit" name="sendAvis" id="sendAvis" value="Donner mon avis">
		  <input type="hidden" name="_token" value="{{ csrf_token() }}" >
	</form>
</div>
@endif
@endsection
