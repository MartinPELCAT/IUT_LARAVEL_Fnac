<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\OrdiTablette;
use App\OrdiTabletteController;

use App\Photo;
use App\Fabricant;

class ServiceVenteController extends Controller
{
    public function index()
    {
    	$produits = DB::table('t_e_orditablette_ort')->select('ort_id', 'ort_nompdt')->get();
    	return view ("serviceVente", ['produits'=>$produits]);
    }

    public function addPhotos(Request $request)
    {
        $results = DB::table('t_e_photo_pho')->select('pho_url')->where('pho_url',$request->input("urlPhoto"))->get()->count();
        if ($results == 0)
        {
        $photo = new photo;
        $photo->timestamps = false;
        $photo->ort_id = $request->input("id");
        $photo->pho_url = $request->input("urlPhoto");
        $photo->save();
        }

            return redirect("serviceVente");
    }

    public function add(Request $request)
    {
        $results = DB::table('t_e_fabricant_fab')->select('fab_nom')->where('fab_nom',ucfirst($request->input("nomFabricant")))->get()->count();

        if ($results==0)
        {
        $fabricant = new fabricant;
        $fabricant->timestamps = false;  
        $fabricant->fab_nom = ucfirst($request->input("nomFabricant"));
        $fabricant->save();
        $request->session()->forget('FabricantExiste');
         return redirect("serviceVente");
        }
     else
     {
        $request->session()->put('FabricantExiste',true);
        return redirect("serviceVente");
     }
        
    }

}