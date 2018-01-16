
@extends('layouts.app') 
 @section('title', 'Profil')
 @section('content') 
  <div class="container">
  <form method="post" action="{{ url('/compte/update') }}">
            @foreach ($clients as $client)
                @if ($client->acq_id  ==  Session::get('utilisateurConnecte.id'))
                <input type="hidden" name="idacq" value="{{$client->acq_id}}">
                    <p>Pseudo : <input type="text" name="pseudo" placeholder="Pseudo" value="{{ $client->acq_pseudo }}" required></p>
                    <p>Mot de passe : <input type="password" name="password" placeholder="Mot de passe" value="" required></p>
                <p>Civilité : {{ $client->acq_civilite }}</p>





                <select id="civilite" name="civilite">
                @if($client->acq_civilite == "M.")
					<option value="M." selected>M</option>
        			<option value="Mme">Mme</option>
        			<option value="Mlle">Mlle</option>

                @elseif($client->acq_civilite == "Mlle")

					<option value="M.">M</option>
        			<option value="Mme">Mme</option>
        			<option value="Mlle" selected>Mlle</option>




                @else

					<option value="M.">M</option>
        			<option value="Mme" selected>Mme</option>
        			<option value="Mlle">Mlle</option>
        			@endif
        		</select>


                <p>Prénom :  <input type="text" name="prenom" placeholder="Prenom" value="{{ $client->acq_prenom }}" required></p>
                <p>Nom :  <input type="text" name="nom" placeholder="Nom" value="{{ $client->acq_nom }}" required></p>
                <p>Mail : <input type="text" name="email" placeholder="Email" value="{{ $client->acq_mel }}" required></p>
                <p>Tel Fixe : <input type="text" name="telfixe" placeholder="Telephone fixe" value="{{ $client->acq_telfixe }}"></p>
                <p>Tel Portable : <input type="text" name="telmobile" placeholder="Telephone Mobile" value="{{ $client->acq_telportable }}"></p>


               <select id="pays" name = "magasin">
        
            @foreach ($Magasins as $magasin)
            @if($client->mag_id == $magasin->mag_id)
                <option value='{{ $magasin->mag_id }}' selected>{{ $magasin->mag_nom }} </option>
            @else 
            <option value='{{ $magasin->mag_id }}'>{{ $magasin->mag_nom }} </option>
            @endif
             @endforeach
             </select>



                @endif   
             @endforeach







             <input type="hidden"  value="{{$compt = 0 }}">
             @foreach($Adresses as $adresse)
                @if ($adresse->acq_id  ==  Session::get('utilisateurConnecte.id'))
                    <input type="hidden" value="{{ $compt = $compt+1}}">
                    @if($adresse->adr_type=="Livraison")
                        <div class='adressetotal'>
                            <p class='adresselivraison'>Adresse Livraison : </p>
                            <a class='adressesperso'>
                            <input type="hidden" name="idadr{{$compt}}" value="{{$adresse->adr_id}}">

                            <p>Nom adresse : <input type="text" name="nomAdresse{{$compt}}" placeholder="Nom Adresse" value="{{ $adresse->adr_nom}}"></p>
                            <p>Rue : <input type="text" name="rueAdresse{{$compt}}" placeholder="Rue adresse" value="{{ $adresse->adr_rue}}"></p>
                            <p>Complement adresse : <input type="text" name="complementrueAdresse{{$compt}}" placeholder="complement rue" value="{{ $adresse->adr_complementrue}}"></p>
                            <p>Ville : <input type="text" name="villeAdresse{{$compt}}" placeholder="Ville" value="{{ $adresse->adr_ville}}"></p>
                            <p>Code postal : <input type="text" name="cpAdresse{{$compt}}" placeholder="Code postal" value="{{ $adresse->adr_cp}}"></p>
                            <p>Type d'adresse
                            <select id="typeAdresse" name="typeAdresse{{$compt}}">
                                @if($adresse->adr_type == "Livraison")
                                    <option value="Livraison" selected>Livraison</option>
                                    <option value="Facturation">Facturation</option>

                                @else
                                    <option value="Livraison">Livraison</option>
                                    <option value="Facturation" selected>Facturation</option>

                                @endif
                            </select>
                            </p>
                            <p>Pays
                            <select id="paysAdresse" name="paysAdresse{{$compt}}">
                                @foreach ($Pays as $etat)
                                @if($etat->pay_id == $adresse->pay_id)
                                    <option value='{{ $etat->pay_id }}' selected>{{ $etat->pay_nom }} </option>
                                @else
                                
                                <option value='{{ $etat->pay_id }}'>{{ $etat->pay_nom }} </option>
                                @endif

                                @endforeach
                                 </select>
                                 </p>

                            </a>
                        </div>
                        @else
                            <div class='adressetotal'>
                            <p class='adresselivraison'>Adresse Facturation :</p> 
                            <a class='adressesperso'>
                            <input type="hidden" name="idadr{{$compt}}" value="{{$adresse->adr_id}}">

                            <p>Nom adresse : <input type="text" name="nomAdresse{{$compt}}" placeholder="Nom Adresse" value="{{ $adresse->adr_nom}}"></p>
                            <p>Rue : <input type="text" name="rueAdresse{{$compt}}" placeholder="Rue adresse" value="{{ $adresse->adr_rue}}"></p>
                            <p>Complement adresse : <input type="text" name="complementrueAdresse{{$compt}}" placeholder="complement rue" value="{{ $adresse->adr_complementrue}}"></p>
                            <p>Ville : <input type="text" name="villeAdresse{{$compt}}" placeholder="Ville" value="{{ $adresse->adr_ville}}"></p>
                            <p>Code postal : <input type="text" name="cpAdresse{{$compt}}" placeholder="Code postal" value="{{ $adresse->adr_cp}}"></p>

                            <p>Type d'adresse
                            <select id="typeAdresse" name = "typeAdresse{{$compt}}">
                                @if($adresse->adr_type == "Livraison")
                                    <option value="Livraison" selected>Livraison</option>
                                    <option value="Facturation">Facturation</option>

                                @else
                                    <option value="Livraison">Livraison</option>
                                    <option value="Facturation" selected>Facturation</option>

                                @endif
                            </select>
                            </p>


                            <p>Pays
                            <select id="paysAdresse" name = "paysAdresse{{$compt}}">
                                @foreach ($Pays as $etat)
                                @if($etat->pay_id == $adresse->pay_id)
                                    <option value='{{ $etat->pay_id }}' selected>{{ $etat->pay_nom }} </option>
                                @else
                                
                                <option value='{{ $etat->pay_id }}'>{{ $etat->pay_nom }} </option>
                                @endif

                                @endforeach
                                 </select>
                                 </p>
                            </a>
                        </div>

                    @endif
                    <input type="hidden" name="nbrAdresse" value="{{$compt}}">
                @endif
            @endforeach
            

        <input type="submit" name="enregistrer" value="Enregistrer modifs">

        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        </form>
        </div>
        @endsection