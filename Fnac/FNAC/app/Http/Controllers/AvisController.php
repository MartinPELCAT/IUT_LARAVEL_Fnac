<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Avis;
use App\AvisAbusifs;
use Session;
use DB;

class AvisController extends Controller
{
    public function signaler ($idavis, $idproduit)
    {
    	DB::table('t_j_avisabusif_ava')->insert(
        ['acq_id' => Session::get('utilisateurConnecte.id'), 'avi_id' => $idavis]);
         return redirect('/produit/'.$idproduit);
    }

    public function aime ($idavis, $idproduit)
    {
    	
    	$query = DB::table('t_e_avis_avi')
            ->where('avi_id', $idavis);
          $query  ->increment('avi_nbutileoui');
        return redirect('/produit/'.$idproduit);
    }

    public function aimepas ($idavis, $idproduit)
    {

            $query = DB::table('t_e_avis_avi')
            ->where('avi_id', $idavis);
          $query  ->increment('avi_nbutilenon');
         return redirect('/produit/'.$idproduit);
        }

    public function save(Request $req)
    {
    	//verifs

    	$b = new Avis;
    	$b->timestamps = false;
    	$b->acq_id =  Session::get('utilisateurConnecte.id');
    	$b->ort_id = $req->input('idProduit');
    	$b->avi_titre = $req->input('title');
    	$b->avi_detail = $req->input('details');
    	$b->avi_note = $req->input('note');
    	$b->avi_nbutileoui= 0;
    	$b->avi_nbutilenon= 0;
    	$b->save();


    	return redirect('/produit/' . $req->input('idProduit'));
    }


    public function GetAllAvisSignaler()
    {
        return view ("ServiceCom", ['AvisAbusifs'=>AvisAbusifs::select(DB::raw('distinct(t_e_avis_avi.avi_id),avi_detail,t_e_orditablette_ort.ort_nompdt,count(t_j_avisabusif_ava.avi_id) as nbsignalements'))
            ->join("t_e_avis_avi", "t_j_avisabusif_ava.avi_id", "=","t_e_avis_avi.avi_id")
            ->join("t_e_orditablette_ort", "t_e_orditablette_ort.ort_id","=","t_e_avis_avi.ort_id")
            ->groupBy('t_e_avis_avi.avi_id','t_e_orditablette_ort.ort_nompdt')
            ->orderBy("nbsignalements",'desc')
            ->get()]);
        
    }

    public function supprimerAvisSignaler($id)
    {   
       AvisAbusifs::where('avi_id', '=', $id)->delete();
       Avis::where('avi_id', '=', $id)->delete();
       return redirect("/serviceCom");
    }

    public function annulerAvisSignaler($id)
    {   
       AvisAbusifs::where('avi_id', '=', $id)->delete();
       return redirect("/serviceCom");
    }

}