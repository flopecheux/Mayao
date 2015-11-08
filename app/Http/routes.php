<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| AUTH & REGISTER & UPDATE
|--------------------------------------------------------------------------
*/

Route::get('/register/{select?}', 'Auth\AuthController@register')->where('select', '[0-1]');
Route::post('/register', 'Auth\AuthController@register');
Route::get('/register/ps', 'Auth\AuthController@register_ps');
Route::post('/register/ps', 'Auth\AuthController@register_ps');
Route::post('/login', 'Auth\AuthController@login');
Route::get('/logout', 'Auth\AuthController@logout');
Route::get('/update', 'Auth\AuthController@update');
Route::post('/update', 'Auth\AuthController@update');
Route::get('/password/email', 'Auth\PasswordController@getEmail');
Route::post('/password/email', 'Auth\PasswordController@postEmail');
Route::get('/password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('/password/reset', 'Auth\PasswordController@postReset');

/*
|--------------------------------------------------------------------------
| AJAX
|--------------------------------------------------------------------------
*/

// UPLOAD & DELETE PHOTOS
Route::post('/upload/image', 'AjaxController@upload_image');
Route::post('/delete/image', 'AjaxController@delete_image');
Route::post('/recherche/ajax', 'AjaxController@postRecherche');
// ESPACE
Route::get('/espace/planning', 'AjaxController@getPlanning');
Route::get('/espace/reservations', 'AjaxController@getReservations');
Route::get('/espace/tarifs', 'AjaxController@getTarifs');
Route::post('/espace/tarifs/update', 'AjaxController@updateTarifs');
Route::get('/espace/paiements', 'AjaxController@getPaiements');
Route::get('/espace/presentation', 'AjaxController@getPresentation');
Route::post('/espace/presentation/update', 'AjaxController@updatePs');
Route::get('/espace/photos', 'AjaxController@getPhotos');
Route::get('/espace/disponibilites', 'AjaxController@getDisponibilites');
Route::post('/espace/disponibilites/update', 'AjaxController@postDisponibilites');
Route::post('/espace/disp/add', 'AjaxController@postAddDisp');
Route::post('/espace/indisp/add', 'AjaxController@postAddIndisp');
Route::get('/espace/dispo/delete/{id}', 'AjaxController@postDeleteDispo')->where('id', '[0-9]+');
Route::get('/espace/commentaires', 'AjaxController@getCommentaires');
Route::get('/espace/messages', 'AjaxController@getMessages');
Route::get('/espace/message/new', 'AjaxController@getNewMessage');
Route::post('/espace/message/new', 'AjaxController@postNewMessage');
// PROFIL
Route::post('/reserver/date', 'AjaxController@postDateReserver');
Route::get('/avis/{id}', 'AjaxController@getAvis')->where('id', '[0-9]+');
Route::get('/profil/clear', 'AjaxController@getProfilClear');

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', 'HomeController@getIndex');
Route::get('/profil/{id}', 'HomeController@getProfil')->where('id', '[0-9]+');
Route::get('/note/{id}', 'HomeController@getNewAvis')->where('id', '[0-9]+');
Route::post('/note/{id}', 'HomeController@postNewAvis')->where('id', '[0-9]+');
Route::post('/reserver', 'HomeController@postReserver');
Route::get('/recherche', 'HomeController@getRecherche');
Route::post('/recherche', 'HomeController@getRecherche');
Route::get('/espace', 'HomeController@getEspace');
Route::get('/payment/callback', 'HomeController@getCallbackPayment');
Route::get('/confirmation', 'HomeController@getPaymentConfirmation');
Route::get('/message/{id}', 'HomeController@getMessage')->where('id', '[0-9]+');
Route::post('/message/reply/{id}', 'HomeController@postReplyMessage')->where('id', '[0-9]+');
Route::get('/update/bank', 'HomeController@getUpdateBank');
Route::post('/update/bank', 'HomeController@postUpdateBank');
Route::get('/mentions', 'HomeController@getMentions');
Route::get('/cgu', 'HomeController@getCgu');
Route::get('/cgv', 'HomeController@getCgv');
Route::get('/contact', 'HomeController@getContact');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin'], function () {
	Route::get('/', 'AdminController@getIndex');
	Route::post('/login', 'AdminController@postLogin');
	Route::get('/logout', 'AdminController@getLogout');
	Route::get('/users', 'AdminController@getUsers');
	Route::get('/ps', 'AdminController@getPs');
	Route::get('/marques', 'AdminController@getMarques');
	Route::get('/marquedelete/{id}', 'AdminController@getDeleteMarque')->where('id', '[0-9]+');
	Route::post('/marqueadd', 'AdminController@postMarque');
	Route::post('/recherche', 'AdminController@postSearch');
	Route::get('/commandes', 'AdminController@getCommandes');
	Route::get('/userlogin/{id}', 'AdminController@getUserLogin')->where('id', '[0-9]+');
	Route::get('/user/{id}', 'AdminController@getUser')->where('id', '[0-9]+');
	Route::get('/active/{id}', 'AdminController@getActive')->where('id', '[0-9]+');
	Route::get('/commande/{id}', 'AdminController@getCommande')->where('id', '[0-9]+');
	Route::post('/statut/{id}', 'AdminController@postStatut')->where('id', '[0-9]+');
	Route::get('/userdelete/{id}', 'AdminController@getUserDelete')->where('id', '[0-9]+');
});
