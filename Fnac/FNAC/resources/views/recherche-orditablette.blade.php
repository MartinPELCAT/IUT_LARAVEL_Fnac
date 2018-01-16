
@extends('layouts.app') 
 @section('title', 'Recherche de produits')
 @section('content') 



<form method="post" action="{{ url('/produit') }}">
       <div id="all">
       <div id="rechType"> 
       <h3 id="titleType">Recherche par type</h3>


            <select id="selectRech" name="Typeorditablette">
                <option value="null">-</option>
            @foreach ($TypeOrdiTablettes as $type)   
                <option value='{{ $type->typ_libelle }}'>{{ $type->typ_libelle }}</option> 
            @endforeach
            </select>
            </div>


            <div id="rechRub"> 
            <h3 id="titleRub">Recherche par rubriques</h3>

           <select id="selectRech" name="lRubriques">
                <option value="null">-</option>
            @foreach ($RubriqueNom as $rub)   
                <option value='{{ $rub->rub_nom }}'>{{ $rub->rub_nom }}</option> 
            @endforeach
            </select>
            </div>


            <div id="rechFab">
            <h3 id="titleFab"> Recherche par fabricant</h3>

            <select id="selectRech" name="Fabricants">
                <option value="null">-</option>
            @foreach ($FabricantsNom as $fab)   
                <option value='{{ $fab->fab_nom }}'>{{ $fab->fab_nom }}</option> 
            @endforeach
            </select>

            </div>
           
            </div>
            


            <input type="submit" value="Recherche" /> 
            <input type="hidden" name="_token" value="{{ csrf_token() }}" >

        @if(!isset($produits) || $produits!=null)
            
            <h3 id="repType">Réponses pour : {{$ChoixType}}</h3>
             <div id="resType">        
            @foreach($produits as $produit)
                   
                <p id="a">
                <img width="100" height="100" src="{{$produit->pho_url}}">
                {{$produit->ort_nompdt}}</br>
                {{$produit->ort_processeur}}</br>
                {{$produit->ort_prixttc}}€</br></br>
                <a href="{{ url('/produit',['id'=>$produit->ort_id,'orderBy'=>'avi_date'])}}"> Voir fiche produit</a></br>
                @if((Session::has('utilisateurConnecte.id')))
               <a href="{{ url('/ajoutPanier',['id'=>$produit->ort_id] )}}"> Ajouter au panier</a>
            @endif
                
                </p>         
            @endforeach
            </div>
            

        @endif

        @if($Rubriques!=null)


            <h3 id="repType">Réponses pour : {{$ChoixRubrique}}</h3>
            <div id="resRub">              
            @foreach($Rubriques as $rub)
            
            <p id="b">
              <img width="100" height="100" src="{{$rub->pho_url}}">
                {{$rub->ort_nompdt}}  </br>   
                {{$rub->ort_processeur}}</br> 
                {{$rub->ort_prixttc}}€</br></br>
            <a href="{{ url('/produit',['id'=>$rub->ort_id, 'orderBy'=>'avi_date'])}}"> Voir fiche produit</a></br>
             @if((Session::has('utilisateurConnecte.id')))
               <a href="{{ url('/ajoutPanier',['id'=>$rub->ort_id] )}}"> Ajouter au panier</a>
            @endif
           
            </p>
            @endforeach
            </div>

        @endif

        @if($fabricants!=null)


            <h3 id="repFab">Réponses pour : {{$ChoixFabricant}}</h3>
            <div id="resFab">           
            @foreach($fabricants as $fabricant)
          
            <p id="c">
                  <img width="100" height="100" src="{{$fabricant->pho_url}}">
                {{$fabricant->ort_nompdt}}</br>    
                {{$fabricant->ort_processeur}}</br>
                {{$fabricant->ort_prixttc}}€</br></br>
                <a href="{{ url('/produit',['id'=>$fabricant->ort_id, 'orderBy'=>'avi_date'] )}}"> Voir fiche produit</a></br>

                 @if((Session::has('utilisateurConnecte.id')))
               <a href="{{ url('/ajoutPanier',['id'=>$fabricant->ort_id] )}}"> Ajouter au panier</a> 
            @endif
               
            @endforeach
            </div>

        @endif
        </form>
        @endsection
