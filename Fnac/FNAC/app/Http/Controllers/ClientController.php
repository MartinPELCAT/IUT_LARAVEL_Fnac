<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Magasin;
use App\Pays;
use App\Adresses;
use App\Relais;
use App\RelaisAcquereur;
use Validator;
use Session;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
    	return view ("client-liste", ['clients'=>Client::all() ]);
    	
    }

    public function profil()
    {
        return view ("profil",
            ['clients'=>Client::all(),
            'Adresses'=>Adresses::orderBy("adr_type")->get(),
            'Pays'=>Pays::all(),
            "Magasins" => Magasin::all()]
        );
        
    }

    public function modifs()
    {
        return view ("modifCompte", ['clients'=>Client::all(),
            'Adresses'=>Adresses::all(),
            'Pays'=>Pays::all(),
            "Magasins" => Magasin::all()]
        );
        
    }


    public function creercompte()
    {

      return view("creer-compte", ["magasins" => Magasin::all(),
        "pays" => Pays::all(),
        "relais" => Relais::all()
    ]);

  }

  public function formConnexion()
  {
    if(Session::has('utilisateurConnecte.id'))
        {
            return redirect('/');
        }

        return view ("connexion", ['clients'=>Client::all() ]);
    }

    public function connexion(Request $request)
    {

        $clientConnecte = DB::select("select * from  t_e_acquereur_acq where acq_mel='".$request->input('email')."' and acq_motpasse='".$request->input('password')."'");
        if (empty($clientConnecte)) {
            $request->session()->put('ErreurDeConnexion',true);
            return view ("connexion");
        }
        else{
        /*
        $clientConnecte = DB::table('t_e_acquereur_acq')->where([
        ['acq_mel', '=', $request->input("email") ],
        ['acq_motpasse', '=', $request->input("password")],
        ])->get();
        */

        $request->session()->forget('ErreurDeConnexion');
        foreach($clientConnecte as $client)
        {
            $vars =  [
                "id" => $client->acq_id,
                "pseudo" => $client->acq_pseudo,
                "role" => $client->rol_id
            ];

            
            $request->session()->put('utilisateurConnecte', $vars);
        }
    }

    //Log::info("Connecté, nice");    
        //$request->input("email")
    return redirect('.'); 
}

public function deconnexion(Request $request)
{
    $request->session()->forget('panier');
    $request->session()->forget('utilisateurConnecte');
    return redirect('.'); 
}


public function update(request $request)
{

    $nombreAdresse = $request->input("nbrAdresse");
    for($i = 1; $i <= $nombreAdresse;$i++) {

     DB::table('t_e_adresse_adr')
     ->where('adr_id', $request->input("idadr".$i))
     ->update(['adr_nom' => $request->input("nomAdresse".$i),
      'adr_rue' => $request->input("rueAdresse".$i),
      'adr_complementrue' => $request->input("complementrueAdresse".$i),
      'adr_cp' => $request->input("cpAdresse".$i),
      'adr_ville' => $request->input("villeAdresse".$i),
      'pay_id' => $request->input("paysAdresse".$i),
      'adr_type' => $request->input("typeAdresse".$i)]);





 }
 DB::table('t_e_acquereur_acq')
 ->where('acq_id', $request->input("idacq"))
 ->update(['acq_mel' => $request->input("email"),
  'acq_motpasse' => $request->input("password"),
  'acq_pseudo' => $request->input("pseudo"),
  'acq_civilite' => $request->input("civilite"),
  'acq_nom' => $request->input("nom"),
  'acq_prenom' => $request->input("prenom"),
  'acq_telfixe' => $request->input("telfixe"),
  'acq_telportable' =>$request->input("telmobile"),
  'mag_id' => $request->input("magasin")]);


    //DB::table('')



 return redirect('/compte/profil');
}




public function addAresse()
{
    return view("ajouter-adresse", ["pays" => Pays::all()]);
}

public function adrSave(Request $request)
{

    $a = new Adresses;
    $a->timestamps = false;
    $a->acq_id = $request->session()->get('utilisateurConnecte.id');
    $a->adr_nom = $request->input("nomAdresse");
    $a->adr_type = $request->input("typeAdresse");
    $a->adr_rue = $request->input("rueAdresse");
    $a->adr_complementrue = $request->input("complementRueAdresse");
    $a->adr_cp = $request->input("cpAdresse");
    $a->adr_ville = $request->input("villeAdresse");
    $a->pay_id = $request->input("paysAdresse");
    $a->save();

    return redirect('/compte/profil');

}

public function save(Request $request)
{

        if (($request->input("nom")) != null && ($request->input("password")) != null && ($request->input("email")) != null && ($request->input("pseudo")) != null && ($request->input("civilite"))!= null && ($request->input("prenom")) != null && (($request->input("tel-port"))!= null || ($request->input("tel-fixe"))!= null))
        {
          $n = new Client;
          $n->timestamps = false;
          $n->acq_mel = $request->input("email");
          $n->acq_motpasse = $request->input("password");
          $n->acq_pseudo = $request->input("pseudo");
          $n->acq_civilite = $request->input("civilite");
          $n->acq_nom = strtoupper($request->input("nom"));
          $n->acq_prenom = ucfirst($request->input("prenom"));
          $n->acq_telfixe = $request->input("tel-fixe");
          $n->acq_telportable = $request->input("tel-port");
          $n->mag_id = $request->input('magasin');
          $n->save();

          $al = new Adresses;
          $al->timestamps = false;
          $al->acq_id = $n->acq_id;
          $al->adr_nom = $request->input("nomAdresseL");
          $al->adr_type = "Livraison";
          $al->adr_rue = $request->input("rueAdresseL");
          $al->adr_complementrue = $request->input("complementRueAdresseL");
          $al->adr_cp = $request->input("cpAdresseL");
          $al->adr_ville = $request->input("villeAdresseL");
          $al->pay_id = $request->input("paysAdresseL");

          $al->save();

          $af = new Adresses;
          $af->timestamps = false;
          $af->acq_id = $n->acq_id;
          $af->adr_nom = $request->input("nomAdresseF");
          $af->adr_type = "Facturation";
          $af->adr_rue = $request->input("rueAdresseF");
          $af->adr_complementrue = $request->input("complementRueAdresseF");
          $af->adr_cp = $request->input("cpAdresseF");
          $af->adr_ville = $request->input("villeAdresseF");
          $af->pay_id = $request->input("paysAdresseF");

          $af->save();



          $b = new RelaisAcquereur;
          $b->timestamps = false;
          $b->acq_id  = $n->acq_id;
          $b->rel_id = $request->input("relaisPref");
          $b->save();


          $verif = true;

          return redirect('./compteCree');

      }

      return redirect('.');
  }


}
