<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrdiTablette;
use App\OrdiTabletteController;

class FabricantController extends Controller
{
    public function index()
    {

    	return view ("recherche-orditablette", ['Fabricant'=>Fabricant::all()]);
    }
}