<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrdiTablette;
use App\OrdiTabletteController;
use App\Achats;
use Illuminate\Support\Facades\DB;
use App\Session;

class CommandesController extends Controller
{
    public function index()
    {

    	return view ("commandes");
    }


    public function voirlescommandes(request $request)
    {
    	$allCommande = DB::table('t_e_achat_ach')
    	->leftjoin('t_e_adresse_adr','t_e_adresse_adr.adr_id','=','t_e_achat_ach.adr_id')
        ->leftjoin('t_e_relais_rel','t_e_relais_rel.rel_id','=','t_e_achat_ach.rel_id')
        ->leftjoin('t_r_magasin_mag','t_r_magasin_mag.mag_id','=','t_e_achat_ach.mag_id')
    	->leftjoin('t_e_acquereur_acq','t_e_acquereur_acq.acq_id','=','t_e_achat_ach.acq_id')
    	->leftjoin('t_j_ligneachat_lea','t_j_ligneachat_lea.ach_id','=','t_e_achat_ach.ach_id')
    	->leftjoin('t_e_orditablette_ort','t_e_orditablette_ort.ort_id','=','t_j_ligneachat_lea.ort_id')
    	->where('t_e_achat_ach.acq_id','=',$request->session()->get('utilisateurConnecte.id'))
        //->where('t_e_achat_ach.ach_statut','<>', 'Livré')
    	->orderBy('t_j_ligneachat_lea.ach_id')
        ->get();



       /*$idnbachat=db::table(select distinct t_e_achat_ach.ach_id
       from t_e_achat_ach
       join t_j_ligneachat_lea on t_j_ligneachat_lea.ach_id=t_e_achat_ach.ach_id
       where t_e_achat_ach.acq_id=$request->session()->get('utilisateurConnecte.id')
       order by t_e_achat_ach.ach_id


       */

        return view ("commandes",['commande'=>$allCommande]);
    }

    public function voirlescommandesencours(Request $request)
    {
        $allCommande = DB::table('t_e_achat_ach')
        ->leftjoin('t_e_adresse_adr','t_e_adresse_adr.adr_id','=','t_e_achat_ach.adr_id')
        ->leftjoin('t_e_relais_rel','t_e_relais_rel.rel_id','=','t_e_achat_ach.rel_id')
        ->leftjoin('t_r_magasin_mag','t_r_magasin_mag.mag_id','=','t_e_achat_ach.mag_id')
        ->leftjoin('t_e_acquereur_acq','t_e_acquereur_acq.acq_id','=','t_e_achat_ach.acq_id')
        ->leftjoin('t_j_ligneachat_lea','t_j_ligneachat_lea.ach_id','=','t_e_achat_ach.ach_id')
        ->leftjoin('t_e_orditablette_ort','t_e_orditablette_ort.ort_id','=','t_j_ligneachat_lea.ort_id')
        ->where('t_e_achat_ach.acq_id','=',$request->session()->get('utilisateurConnecte.id'))
        ->where('t_e_achat_ach.ach_statut','<>', 'Livré')
        ->orderBy('t_j_ligneachat_lea.ach_id')
        ->get();



       /*$idnbachat=db::table(select distinct t_e_achat_ach.ach_id
       from t_e_achat_ach
       join t_j_ligneachat_lea on t_j_ligneachat_lea.ach_id=t_e_achat_ach.ach_id
       where t_e_achat_ach.acq_id=$request->session()->get('utilisateurConnecte.id')
       order by t_e_achat_ach.ach_id


       */

        return view ("commandes",['commande'=>$allCommande]);
    }

    public function passerCommande (request $request)
    {
        if($request->modeLivraison !=null and $request->modePaiement!=null)
        {
           $result_explode = explode('|', $request->modeLivraison);
        if($result_explode[1]==="adr")
        {
          $adrID = $result_explode[0];
            $relID=null;
            $magID=null;  
        }
             
        elseif($result_explode[1]==="mag")
        {
         $magID = $result_explode[0];
            $relID=null;
            $adrID=null;   
        }
            

        elseif($result_explode[1]==="rel")
        {
          $relID = $result_explode[0];
            $adrID=null;
            $magID=null;  
        }

         DB::table('t_e_achat_ach')
              ->insert(['acq_id' => $request->session()->get('utilisateurConnecte.id'),'rel_id'=>$relID,'adr_id'=>$adrID,'cab_id'=>$request->modePaiement,'mag_id'=>$magID,'ach_date' => date("Y-m-d")]);

        $idAchatAjoute = DB::table('t_e_achat_ach')->max('ach_id');   
        foreach( $request->session()->get('panier') as $k => $v)
                {
                    if($k != "quantitePanier")
                    {
                        DB::table('t_j_ligneachat_lea')
                        ->insert(['ach_id' => $idAchatAjoute,'ort_id' => $k, 'lea_quantite' => $v]);
                    }
                }
        $request->session()->forget('panier');

        $path = 'commandes';

        }
        else
        {
          $path = 'commande/modalitesCommande';
        }
        return redirect($path);
    }

}