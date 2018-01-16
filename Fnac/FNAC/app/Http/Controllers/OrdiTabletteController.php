<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrdiTablette;
use App\TypeOrdiTablette;
use App\Rubrique;
use App\Fabricant;
use App\Photo;


use Illuminate\Support\Facades\DB;

class OrdiTabletteController extends Controller
{
    public function index()
    {

    	return view ("recherche-orditablette", ['OrdiTablettes'=>OrdiTablette::all() ]);
    }

	public function recherchetype(Request $request)
	{
		$typeo = $request->Typeorditablette;
		$rubriqueo = $request->lRubriques;
		$fabricanto = $request->Fabricants;

		if($typeo == null and $rubriqueo == null and  $fabricanto == null)
		{
		$vars = $request->session()->get('memoireRecherchePrecedente');
		$typeo = $vars[0];
		$rubriqueo = $vars[1];
		$fabricanto = $vars[2];
		}
		else
		{
		$vars = array($typeo,$rubriqueo,$fabricanto);
		$request->session()->put('memoireRecherchePrecedente', $vars);
		}
		

			$produits = DB::select("select ort_nompdt, MAX(pho_url) AS pho_url, orditab.ort_id, ort_processeur, ort_prixttc
				from t_e_orditablette_ort orditab
				join t_j_typeorditab_tot typeid on orditab.ort_id=typeid.ort_id
				join t_e_photo_pho photo on photo.ort_id=orditab.ort_id
				join t_r_type_typ typelib on typeid.typ_id=typelib.typ_id
				where typ_libelle='$typeo' 
				group by ort_nompdt, orditab.ort_id, ort_processeur, ort_prixttc"
				);
				

			$rubriques = DB::select("select ort_nompdt, MAX(pho_url) AS pho_url, orditab.ort_id, ort_processeur, ort_prixttc
				from t_e_orditablette_ort orditab
				join t_j_rubriqueorditab_ruo rubodt on orditab.ort_id=rubodt.ort_id
				join t_e_photo_pho photo on photo.ort_id=orditab.ort_id
				join t_r_rubrique_rub rub on rubodt.rub_id=rub.rub_id
				where rub_nom='$rubriqueo'
				group by ort_nompdt, orditab.ort_id, ort_processeur, ort_prixttc"
				);

			$fabricants = DB::select("select ort_nompdt, MAX(pho_url) AS pho_url, orditab.ort_id, ort_processeur, ort_prixttc
				from t_e_orditablette_ort orditab
				join t_e_fabricant_fab fab on orditab.fab_id= fab.fab_id
				join t_e_photo_pho photo on photo.ort_id=orditab.ort_id
				where fab_nom='$fabricanto' 
				group by ort_nompdt, orditab.ort_id, ort_processeur, ort_prixttc"
				);


		/* DB::table('t_e_avis_avi')
        ->join('t_e_acquereur_acq','t_e_acquereur_acq.acq_id','=','t_e_avis_avi.acq_id')
    	->where('ort_id','=',$id)
    	->get();*/
    
		return view('recherche-orditablette',['produits'=>$produits,
											  'Rubriques' => $rubriques,
											  'fabricants' =>$fabricants,
											  'TypeOrdiTablettes'=>TypeOrdiTablette::all(),
											   'RubriqueNom'=>Rubrique::all(),
											   'FabricantsNom'=>Fabricant::all(),
											   'ChoixType'=>$typeo,
											   'ChoixRubrique'=>$rubriqueo,
											   'ChoixFabricant' =>$fabricanto,
											   ]);

	}
}
