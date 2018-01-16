
@extends('layouts.app') 
 @section('title', 'Profil')
 @section('content') 
  <div class="container">
            @foreach ($clients as $client)
                @if ($client->acq_id  ==  Session::get('utilisateurConnecte.id'))
                <p>Pseudo : {{ $client->acq_pseudo }}</p>
                <p>Civilité : {{ $client->acq_civilite }}</p>
                <p>Prénom :  {{ $client->acq_prenom }}</p>
                <p>Nom :  {{ $client->acq_nom }}</p>
                <p>Mail : {{ $client->acq_mel }}</p>
                <p>Tel Fixe : {{ $client->acq_telfixe }}</p>
                <p>Tel Portable : {{ $client->acq_telportable }}</p>
                @foreach ($Magasins as $mag)
                    @if ($client->mag_id == $mag->mag_id)
                    <p>Magasin préféré : {{ $mag->mag_nom }}</p>
                    @endif
                @endforeach

                @endif   
             @endforeach
             @foreach($Adresses as $adresse)
                @if ($adresse->acq_id  ==  Session::get('utilisateurConnecte.id'))
                    @if($adresse->adr_type=="Livraison")
                        <div class='adressetotal'>
                            <p class='adresselivraison'>Adresse Livraison : </p>
                            <a class='adressesperso'>
                            {{$adresse->adr_nom}}</br>
                            {{$adresse->adr_rue}}
                            {{$adresse->adr_complementrue}}</br>
                            {{$adresse->adr_ville}}
                            {{$adresse->adr_cp}}</br>
                            @foreach($Pays as $pays)
                                @if($pays->pay_id === $adresse->pay_id)
                                    {{$pays->pay_nom}}
                                @endif
                            @endforeach
                            </a>
                        </div>
                        @else
                            <div class='adressetotal'>
                            <p class='adresseFacturation'>Adresse Facturation :</p> 
                            <a class='adressesperso'>
                            {{$adresse->adr_nom}}</br>
                            {{$adresse->adr_rue}}
                            {{$adresse->adr_complementrue}}</br>
                            {{$adresse->adr_ville}}
                            {{$adresse->adr_cp}}</br>
                            @foreach($Pays as $pays)
                                @if($pays->pay_id === $adresse->pay_id)
                                    {{$pays->pay_nom}}
                                @endif
                            @endforeach
                                
                            </a>
                        </div>
                    @endif
                @endif

            @endforeach
<button id="BtnModif"><a style="color: white; text-decoration: none;" href="{{url('/compte/addAdresse')}}">Ajouter une adresse</a></button>
        </div>
        
        <button id="BtnModif"><a style="color: white; text-decoration: none;" href="{{url('/compte/modifs')}}">Modifier</a></button>
        <div class="container">
        

        

        
        </div>
        @endsection