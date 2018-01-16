<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');

});

Route::get('/compteCree', function () {
    return view('compteCree');

});

Route::get('/listeclient', "ClientController@index");
Route::get('/favoris', "FavorisController@listeFavoris");
Route::get('/serviceVente', "ServiceVenteController@index")->name("serviceVente");

Route::post('/serviceVente/addPhotos', "ServiceVenteController@addPhotos");

Route::post('/serviceVente/add', 'ServiceVenteController@add');

Route::get('/compte/add', 'ClientController@creercompte');

Route::get('/compte/connexion', 'ClientController@formConnexion');

Route::post('/compte/connexion', 'ClientController@connexion');

Route::get('/compte/deconnexion', 'ClientController@deconnexion');

Route::post('/suppressionContenuPanier', 'PanierController@suppressionContenuPanier');
Route::get('/suppressionProduitPanier/{id}', 'PanierController@suppressionProduitPanier');
Route::get('/ajoutProduitPanier/{id}', 'PanierController@ajoutProduitPanier');
Route::get('/ajoutPanier/{id}', 'PanierController@ajoutPanier');

Route::post('/compte/save', 'ClientController@save');

Route::post('/compte/adrSave', 'ClientController@adrSave');

Route::post('/compte/update', 'ClientController@update');

Route::get('/produit', 'OrdiTabletteController@recherchetype');

Route::post('/produit', 'OrdiTabletteController@recherchetype');

Route::get('/panier', 'PanierController@gestionPanier');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/compte/profil', 'ClientController@profil');


Route::get('/compte/modifs', 'ClientController@modifs');

Route::get('/compte/addAdresse', 'ClientController@addAresse');

Route::post('/avis/save', 'AvisController@save');

Route::get('/serviceCom', 'AvisController@GetAllAvisSignaler');

Route::post('serviceCom/delete/{id}', 'AvisController@supprimerAvisSignaler');
Route::post('serviceCom/cancel/{id}', 'AvisController@annulerAvisSignaler');

Route::post('serviceclient/livrer/{id}', 'ServiceClientController@livrer');

Route::post('/commande/modalitesCommande', 'PanierController@validationPanier');
Route::get('/commande/modalitesCommande', 'PanierController@validationPanier');
Route::post('/commande/passerCommande', 'CommandesController@passerCommande');




Route::get('/serviceclient', 'ServiceClientController@voirCommande');

Route::get('/produit/{id}', 'FicheProduitController@checkProduit');
Route::get('/produit/{id}/{orderby}', 'FicheProduitController@checkProduit');

Route::get('/favoris/ajout/{id}', 'FavorisController@ajouterFavori');
Route::get('/favoris/suppression/{id}', 'FavorisController@supprimerFavori');

Route::get('/commandes','CommandesController@voirlescommandes');
Route::get('/commandesEnCours','CommandesController@voirlescommandesencours');

Route::get('/avis/signaler/{idavis}/{idproduit}', 'AvisController@signaler');
Route::get('/avis/aime/{idavis}/{idproduit}', 'AvisController@aime');
Route::get('/avis/aimepas/{idavis}/{idproduit}', 'AvisController@aimepas');

Route::get('/carteBleue/formAjout', 'CarteBleueController@formulaireAjout');
Route::post('/carteBleue/ajout', 'CarteBleueController@ajouter');

