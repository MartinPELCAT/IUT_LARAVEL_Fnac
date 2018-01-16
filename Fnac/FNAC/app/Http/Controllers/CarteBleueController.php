<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CarteBleue;
use Illuminate\Support\Facades\DB;
use App\Session;

class CarteBleueController extends Controller
{
   public function formulaireAjout()
    {
        return view ("ajoutCarteBleue");
    }


    public function ajouter(Request $request)
    {
      if($request->typeCarte!=null and $request->titulaireCarte!=null and $request->numCarte!=null and $request->moisExpiration!=null and $request->anneeExpiration!=null and $request->crypto!=null)
      {
          $results = DB::table('t_e_cartebleue_cab')
              ->where([
                  ['acq_id', '=', $request->session()->get('utilisateurConnecte.id')],
                  ['cab_numero', '=', $request->numCarte]
                  ])->get()->count();

        if($results==0)
        {
          DB::table('t_e_cartebleue_cab')
          ->insert(['acq_id' => $request->session()->get('utilisateurConnecte.id'),'cab_type'=>$request->typeCarte,'cab_titulaire'=>$request->titulaireCarte,'cab_numero'=>$request->numCarte,'cab_moisexpiration'=>$request->moisExpiration,'cab_anneeexpiration'=>$request->anneeExpiration,'cab_cvs'=>$request->crypto]);
        
        } 
      	

          
    }
    return redirect('/commande/modalitesCommande');

  }


}