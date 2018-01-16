
@extends('layouts.app') 
 @section('title', 'Créer un compte')
 @section('content') 
<h3 id="title">Première visite ?</br>Création d'un compte</h3>

        <div class="container">
        <form method="post" action="{{ url('/compte/save') }}">
        <input type="text" name="pseudo" placeholder="Pseudo" size="30" max="20" required>
            </br>
        <input type="email" name="email" placeholder="Email" size="30" max="80" required>
            </br>
        <select id="civilite" name="civilite">
        <option value="M.">M</option>
        <option value="Mme">Mme</option>
        <option value="Mlle">Mlle</option>
        </select>
        </br>
        <input type="password" name="password" placeholder="Mot de passe" size="30" max="128" required>
        </br>
        <input type="text" name="nom" placeholder="Nom" size="30" max="50" required>
        </br>
        <input type="text" name="prenom" placeholder="Prénom" size="30" max="50" required>
        </br>
        <input type="tel" name="tel-fixe" placeholder="Tel Fixe" size="30" max="10">
        </br>
        <input type="tel" name="tel-port" placeholder="Tel Portable" size="30" max="50">
        </br>
        <select id="mag" name = "magasin">
        
            @foreach ($magasins as $magasin)
                <option value='{{ $magasin->mag_id }}'>{{ $magasin->mag_nom }} </option>

             @endforeach
             </select>

        <h3 id="title">Adresses Livraison</h3>
        <input type="text" name="nomAdresseL" placeholder="Nom adresse" size="30" max="50" >


        <input type="text" name="rueAdresseL" placeholder="Rue" size="30" max="50" >

        <input type="text" name="complementRueAdresseL" placeholder="Complement rue adresse" size="30" max="50" >
        <input type="text" name="cpAdresseL" placeholder="Code postale" size="30" max="50" >
        <input type="text" name="villeAdresseL" placeholder="Ville" size="30" max="50" >

        <select id="pays" name = "paysAdresseL">
        
            @foreach ($pays as $etat)
                <option value='{{ $etat->pay_id }}'>{{ $etat->pay_nom }} </option>

             @endforeach
             </select>


             <h3 id="title">Adresses Facturation</h3>
        <input type="text" name="nomAdresseF" placeholder="Nom adresse" size="30" max="50" >


        <input type="text" name="rueAdresseF" placeholder="Rue" size="30" max="50" >

        <input type="text" name="complementRueAdresseF" placeholder="Complement rue adresse" size="30" max="50" >
        <input type="text" name="cpAdresseF" placeholder="Code postale" size="30" max="50" >
        <input type="text" name="villeAdresseF" placeholder="Ville" size="30" max="50" >

        <select id="pays" name = "paysAdresseF">
        
            @foreach ($pays as $etat)
                <option value='{{ $etat->pay_id }}'>{{ $etat->pay_nom }} </option>

             @endforeach
             </select>

            <h3 id="title">Choisir le relais Préféré</h3>
             <select id="pays" name ="relaisPref">
        
            @foreach ($relais as $relai)
                <option value='{{$relai->rel_id}}'>{{ $relai->rel_nom }} ({{ $relai->rel_ville }})</option>

             @endforeach
             </select>

<!--  


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif




-->


<input type="submit" name="create" value="Créer compte">

        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        </form>        
            </div>
        @endsection