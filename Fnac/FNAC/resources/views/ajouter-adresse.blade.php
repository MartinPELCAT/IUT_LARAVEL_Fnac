@extends('layouts.app') 
 @section('title', 'Ajouter une adresse')
 @section('content') 

        <div class="container">
        <form method="post" action="{{ url('/compte/adrSave') }}">	

        <h3 id="title">Ajouter une adresse</h3>

        <input type="text" name="nomAdresse" placeholder="Nom adresse" size="30" max="50" >
 		<select id="typeAdresse" name="typeAdresse">
 		<option value='Livraison'>Livraison </option>
 		<option value='Facturation'>Facturation </option>
 		</select>

        <input type="text" name="rueAdresse" placeholder="Rue" size="30" max="50" >

        <input type="text" name="complementRueAdresse" placeholder="Complement rue adresse" size="30" max="50" >
        <input type="text" name="cpAdresse" placeholder="Code postale" size="30" max="50" >
        <input type="text" name="villeAdresse" placeholder="Ville" size="30" max="50" >

        <select id="pays" name = "paysAdresse">
        
            @foreach ($pays as $etat)
                <option value='{{ $etat->pay_id }}'>{{ $etat->pay_nom }} </option>

             @endforeach
             </select>
             <input type="submit" name="Ajouter" value="Ajouter">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" >
             </form>

        @endsection