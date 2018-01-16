@extends('layouts.app')
 @section('title', 'Service ventes')
@section('content')

@if(Session::get('utilisateurConnecte.role') == 2)

<div id="ServiceVente">

<section id="serviceVenteAjouterPhotos">
<h3 id="title">Ajouter des photos sur un article</h3></br>
<form method="post" action="{{ url('/serviceVente/addPhotos') }}">
<select id="product" name="id">
<option value='null' selected>Choix du produit</option>
@foreach ($produits as $prod)   
        <option value='{{ $prod->ort_id }}'>{{ $prod->ort_nompdt }}</option> 
@endforeach
</select>
<label id="lien" for="url">Lien de la photo :</label>
<input id="url" type="text" name="urlPhoto" placeholder="URL de la photo">
<input type="submit" name="addPhoto" value="Ajouter la photo"></br></br></br>
<input type="hidden" name="_token" value="{{ csrf_token() }}" >
</form>
</section>
<section id="serviceVenteCreerFabriquant">
<form method="post" action="{{ url('/serviceVente/add') }}">

       <h3 id="title">Création d'un fabricant</h3></br>

       <input type="text" name="nomFabricant" placeholder="Nom du fabricant" size="30" max="128" required>
       @if(Session::get('FabricantExiste') == true)
           <span class="ErrorMessageConnexion">*Ce fabricant existe deja<span>
        @ENDIF
       <input type="submit" name="ajouter" value="Ajouter">
       <input type="hidden" name="_token" value="{{ csrf_token() }}" >

</form>
</section>
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