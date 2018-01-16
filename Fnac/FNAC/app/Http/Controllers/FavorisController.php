<?php 
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Favoris;
    use App\OrdiTablette;
    use Illuminate\Support\Facades\DB;

    class FavorisController extends Controller
    {
        public function listeFavoris(Request $request)
        {

            
            $vars = "(";
            $nbFavoris = 0;
            foreach( Favoris::all() as $v)
            {

                if($request->session()->get('utilisateurConnecte.id')==$v->acq_id)
                {
                  $nbFavoris+=1;
                    $vars.="'".$v->ort_id."'";
                    $vars.=","; 
                } 
            }
            $vars = trim($vars,',');
            $vars.=")";

            $favoris = array();
            if($nbFavoris!=0)
            {
              $favoris = DB::select( "select distinct on (orditab.ort_id) orditab.ort_id,photo.pho_id,orditab.ort_nompdt,orditab.ort_processeur,orditab.ort_prixttc,photo.pho_url
                             from t_e_orditablette_ort orditab
                             join t_e_photo_pho photo on photo.ort_id=orditab.ort_id
                             where  orditab.ort_id IN $vars
                             order by orditab.ort_id,photo.pho_id");
            }
                            



        	return view ("favoris",['favoris'=>$favoris]);
        }

        public function supprimerFavori(Request $request,$id)
        {
            Favoris::where('ort_id', '=', $id)->delete();
            
            return redirect()->back();
        }

        public function ajouterFavori(Request $request,$id)
        {
            $results = DB::table('t_j_favori_fav')
            ->where([
                ['acq_id', '=', $request->session()->get('utilisateurConnecte.id')],
                ['ort_id', '=', $id]
                ])->get()->count();

            if($results==0)
            {
              DB::table('t_j_favori_fav')
              ->insert(['ort_id' => $id,
                  'acq_id' => $request->session()->get('utilisateurConnecte.id')]);

          }
          return redirect()->back();
      }
  }