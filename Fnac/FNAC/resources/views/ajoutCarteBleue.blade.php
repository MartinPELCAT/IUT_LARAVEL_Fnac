
@extends('layouts.app') 
 @section('title', 'ajoutCarteBleue')
 @section('content') 
<h2>Ajout d'une carte bleue</h2></br>
        <form method="post" action="{{ url('/carteBleue/ajout') }}">
            <div id='formAjoutCarte'>
            <label>Type de carte</label>
            <select name="typeCarte" required>
            <option>-</option>
            <option value='Mastercard'>Mastercard</option>
            <option value='Visa'>Visa</option>
            <option value='American Express'>American Express</option>  
            </select>
            <p><input type="text" name="titulaireCarte" placeholder="Titulaire de la carte" required></p>
            <p><input type="text" name="numCarte" placeholder="Numéro de la carte" required></p>
            <p><input type="text" name="moisExpiration" placeholder="mois d'expiration de la carte" required></p>
            <p><input type="text" name="anneeExpiration" placeholder="Année d'expiration de la carte" required></p>
            <p><input type="text" name="crypto" placeholder="Cryptogramme de la carte" required></p>
            </div>
            <input type="submit" value="Enregistrer la carte">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        </form>
            <a class="" href="{{ url('/panier') }}"><- Retour à la commande</a>

        
@endsection