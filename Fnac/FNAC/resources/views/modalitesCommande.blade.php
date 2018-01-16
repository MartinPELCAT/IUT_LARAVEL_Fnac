
@extends('layouts.app') 
 @section('title', 'modalitesCommande')
 @section('content') 
<h2>Modalités de la commande</h2></br>
            <form method="post" action="{{ url('/commande/passerCommande') }}">

  <h3>Mode de Paiement</h3>
            @if(count($cartesBleues)==0)
            <p>Vous n'avez aucune carte enregistrée</p>
            <p>Veuillez en ajouter une pour passer la commande :</p>
            @else

            <select id="selectRech" name="modePaiement">
                <option value="">-</option>
            @foreach ($cartesBleues as $carteBleue)   
                <option value='{{$carteBleue->cab_id}}'> type: {{ $carteBleue->cab_type}} | titulaire: {{ $carteBleue->cab_titulaire}} | num: {{ $carteBleue->cab_numero}} | mois exp: {{ $carteBleue->cab_moisexpiration}} | année exp: {{ $carteBleue->cab_anneeexpiration}} | crypto: {{ $carteBleue->cab_cvs}} </option> 
            @endforeach
            </select>
            @endif
            <a class="" href="{{ url('/carteBleue/formAjout') }}">Ajouter une carte</a>
  <h3>Mode de livraison</h3>
            <select id="selectRech" name="modeLivraison" required>
            <option>-</option>
            @foreach ($adressesLivraison as $adresse)   
                <option value='{{$adresse->adr_id}}|adr'>Adresse de livraison : {{ $adresse->adr_nom }} {{ $adresse->adr_rue}} {{ $adresse->adr_cp}} {{ $adresse->adr_ville}}</option> 
            @endforeach
            @foreach ($magasins as $magasin)   
                <option value='{{$magasin->mag_id}}|mag'>Magasin préféré : {{ $magasin->mag_nom }} {{ $magasin->mag_ville}}</option> 
            @endforeach
            @foreach ($relais as $leRelais)   
                <option value='{{$leRelais->rel_id}}|rel'>Relais préféré : {{ $leRelais->rel_nom }} {{ $leRelais->rel_rue}} {{ $leRelais->rel_cp}} {{ $leRelais->rel_ville}}</option> 
            @endforeach
            </select>
            <input type="submit" value="Passer la commande">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
  
           </form>
       </br>
       </br>
       </br>
       </br>
            <a class="" href="{{ url('/panier') }}">X Annuler la commande</a>
  
  
        
@endsection