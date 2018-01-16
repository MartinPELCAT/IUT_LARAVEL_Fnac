<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class MagasinController extends Controller
{
    public function index()
    {

    	return view ("client-liste", ['magasins'=>Magasin::all() ]);
    }

}
