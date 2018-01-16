<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Session;
use App\Achats;
use App\Magasin;
use App\Adresses;
use App\Relais;
use App\Client;
use Carbon\Carbon;

class ServiceClientController extends Controller
{
	public function index()
    {
    	return view ("serviceClient");
    }

    public function voirCommande()
    {
    	$datehier=Carbon::now('Europe/Paris')->subDay()->format('d/m/Y');

    	$commandes = DB::table('t_e_achat_ach')
        ->leftjoin('t_e_adresse_adr','t_e_adresse_adr.adr_id','=','t_e_achat_ach.adr_id')
        ->leftjoin('t_e_relais_rel','t_e_relais_rel.rel_id','=','t_e_achat_ach.rel_id')
        ->leftjoin('t_r_magasin_mag','t_r_magasin_mag.mag_id','=','t_e_achat_ach.mag_id')
        ->leftjoin('t_e_acquereur_acq','t_e_achat_ach.acq_id','=','t_e_acquereur_acq.acq_id')
        ->where('ach_date','>=',$datehier)
        ->get();

        return view ("serviceClient", [
         'commandes'=>$commandes
     ]);
    }


    public function livrer($id)
    {   
        Achats::where('ach_id','=', $id)->update(['ach_statut' => "En livraison"]);
        return redirect("/serviceclient");
    }
}
