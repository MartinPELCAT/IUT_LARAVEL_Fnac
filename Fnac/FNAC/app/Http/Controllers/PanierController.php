<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Panier;
use App\OrdiTablette;
use App\Adresses;
use App\Magasin;
use App\Relais;
use App\CarteBleue;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{

    public function gestionPanier(Request $request)
    {
        if($request->session()->has('utilisateurConnecte'))
        {



            if( $request->session()->has('panier'))
            {
                $vars = "(";
                foreach( $request->session()->get('panier') as $k => $v)
                {
                    if($k != "quantitePanier")
                    {
                        $vars.="'".$k."'";
                        $vars.=",";
                    }
                }
                $vars = trim($vars,','); 
                $vars.=")";
                /*
                $ordiTablettes = DB::table('t_e_orditablette_ort')
                        ->join('t_e_photo_pho','t_e_orditablette_ort.ort_id','=','t_e_photo_pho.ort_id')
                        ->whereIn('t_e_orditablette_ort.ort_id', $vars)->min('t_e_photo_pho.pho_id');
                */
                        $ordiTablettes = DB::select( "select distinct on (orditab.ort_id) orditab.ort_id,photo.pho_id,orditab.ort_nompdt,orditab.ort_processeur,orditab.ort_prixttc,photo.pho_url
                           from t_e_orditablette_ort orditab
                           join t_e_photo_pho photo on photo.ort_id=orditab.ort_id
                           where  orditab.ort_id IN $vars
                           order by orditab.ort_id,photo.pho_id");



                    //->join('t_e_photo_pho','t_e_orditablette_ort.ort_id','=','t_e_photo_pho.ort_id')
                    }
                    else
                        $ordiTablettes = array();


                    return view ("panier",['ordiTablettes'=> $ordiTablettes]);
                }
                else
                 return redirect()->back();  

         }

         public function validationPanier(Request $request)
         {
            $idUtilisateur = $request->session()->get('utilisateurConnecte.id');
            //$adressesLivraison = array();
            $adressesLivraison = Adresses::where([['acq_id', '=',$idUtilisateur ],['adr_type', '=', 'Livraison']])->get();
            $magasins = Magasin::join('t_e_acquereur_acq','t_r_magasin_mag.mag_id','=','t_e_acquereur_acq.mag_id')->where('t_e_acquereur_acq.acq_id',$idUtilisateur)->get();
            $relais = Relais::join('t_j_relaisacquereur_rea','t_e_relais_rel.rel_id','=','t_j_relaisacquereur_rea.rel_id')->join('t_e_acquereur_acq','t_j_relaisacquereur_rea.acq_id','=','t_e_acquereur_acq.acq_id')->where('t_e_acquereur_acq.acq_id',$idUtilisateur)->get();
            $cartesBleues = CarteBleue::join('t_e_acquereur_acq','t_e_cartebleue_cab.acq_id','=','t_e_acquereur_acq.acq_id')->where('t_e_acquereur_acq.acq_id',$idUtilisateur)->get();
            //$adressesLivraison += Magasin::where([['acq_id', '=',$idUtilisateur ],['adr_type', '=', 'Livraison']])->get();
            
            
            //$adressesLivraison += Adresses::where('acq_id',$idUtilisateur)->get();
            return view ("modalitesCommande",['adressesLivraison'=>$adressesLivraison,
                'magasins'=>$magasins,
                'relais'=>$relais,'cartesBleues'=>$cartesBleues]);
         }

         public function ajoutPanier(Request $request,$id)
         {

           if ($request->session()->has('panier'))
           {
              $vars = $request->session()->get('panier');
         /*
         if(!in_array($id, $vars))
         {
            */
            print_r($vars);
            if (array_key_exists($id, $vars)) 
            {
             $quantite = $vars[$id];

             $vars[$id] = ($quantite + 1); 
         }
         else
         {
             $quantite = 1;
             $vars[$id] = $quantite;

         }

            //$prod = array($id=>$id);
            //$vars = $vars + $prod; 
         $quantitePanier =0;
         foreach($vars as $k => $v)
         {
            if($k != "quantitePanier")
                $quantitePanier+= $v;
        }
        $vars["quantitePanier"] = $quantitePanier;
        $request->session()->put('panier', $vars); 


    }
    else
    {
          //$prod = array($id=>$id);
      $quantite = 1;
      $quantitePanier = 1;
      $vars["quantitePanier"] =  1;
      $vars = array($id => $quantite);
      $vars["quantitePanier"] = $quantitePanier;
      $request->session()->put('panier', $vars);




  }


    	/*
    	$test =  [
            1,3,5,7
            ];
        $request->session()->put('panier', $test);
    	*/




        return redirect()->back(); 
    }

    public function suppressionContenuPanier (Request $request)
    {
    	$request->session()->forget('panier');
    	return redirect()->back(); 
    }

    public function suppressionProduitPanier (Request $request, $id)
    {
        $vars = $request->session()->get('panier');
        if($vars['quantitePanier']>1)
        {
            if($vars[$id]>1)
                $vars[$id] = $vars[$id] - 1;
            else
               unset($vars[$id]);

           $vars['quantitePanier'] -= 1;
           $request->session()->put('panier', $vars); 
       }
       else
        $request->session()->forget('panier');

    return redirect()->back(); 
}
public function ajoutProduitPanier (Request $request, $id)
{
    $vars = $request->session()->get('panier');
    $vars[$id] = $vars[$id] + 1;
    $vars['quantitePanier'] += 1;
    $request->session()->put('panier', $vars); 
    return redirect()->back(); 
}


}
