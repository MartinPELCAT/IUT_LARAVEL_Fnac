<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\OrdiTablette;
use App\OrdiTabletteController;
use Illuminate\Support\Facades\DB;
use Session;
use Avis;
use Client;

class FicheProduitController extends Controller
{
    public function index()
    {

    	return view ("recherche-orditablette");
    }

    public function checkProduit($id, $orderBy="null")
    {
    	$produit = new OrdiTablette;
    	$produit = DB::table('t_e_orditablette_ort')->where('ort_id', $id)->first();

    	$avisok = DB::table('t_j_ligneachat_lea')

    			->join('t_e_achat_ach','t_j_ligneachat_lea.ach_id','=','t_e_achat_ach.ach_id')
    			->select('t_e_achat_ach.acq_id','t_j_ligneachat_lea.ort_id')
    			->where('acq_id','=', Session::get('utilisateurConnecte.id'))
    			->where('ort_id','=',$id)
                ->orderBy('avi_date', 'desc')
    			->count();

if($orderBy == "null"){
    $orderBy = 'avi_note';
    	
    }
    $avis = DB::table('t_e_avis_avi')
        ->join('t_e_acquereur_acq','t_e_acquereur_acq.acq_id','=','t_e_avis_avi.acq_id')
        ->where('ort_id','=',$id)
        ->orderby($orderBy, 'desc')
        ->get();
    
        $signaler = array ();

        $signalements = DB::table('t_j_avisabusif_ava')->where('acq_id', Session::get('utilisateurConnecte.id'))->get();
       
        foreach ($avis as $av) {
            foreach ($signalements as $signalement) {
                if($signalement->avi_id == $av->avi_id)
                {
                    array_push($signaler, $signalement->avi_id);
                }
            }
        }


        
    $url = DB::table('t_e_photo_pho')
    ->select('pho_url')
    ->where('ort_id', '=', $id)
    ->get();

    $countUrl = count($url);


        return view ("ficheproduit",['produits'=>$produit,'avisok'=>$avisok, 'listeAvis'=>$avis, 'lepseudo'=>$avis, 'avisSignale'=>$signaler, 'photoUrl'=>$url, 'nbPhotos'=>$countUrl] );
    }
}