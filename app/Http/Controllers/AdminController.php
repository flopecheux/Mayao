<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPs;
use App\Models\Marque;
use App\Models\MarquePs;
use App\Models\Avis;
use App\Models\Message;
use App\Models\Commande;
use App\Models\Photo;
use App\Models\Disponibilite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth, Validator, File, Carbon, Mail, DB;

class AdminController extends Controller {

	public function __construct()
	{
		$this->middleware('admin', ['except' => ['postLogin']]);
	}

	public function postLogin(Request $request)
	{

		$validator = Validator::make($request->all(),
        [
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

       	if ($validator->fails())
        {
            return redirect('admin')->withErrors($validator);
        }

        if ($request->input('user') == env('ADMIN_USER') && $request->input('password') == env('ADMIN_PASS')) {

        	$request->session()->put('admin', 'm@y@0');
        	return redirect('admin');

        } else {

        	return redirect('admin')->withErrors('Les identifiants sont incorrects !');

        }

	}

	public function getLogout(Request $request)
	{

		$request->session()->forget('admin');
		return redirect('admin')->withErrors('Vous êtes déconnecté !');

	}

	public function getIndex()
	{

		$count_commandes = Commande::count();
		$count_users = User::has('ps', '<', 1)->count();
		$count_ps = User::has('ps')->count();

		return view('admin.index', compact('count_commandes', 'count_users', 'count_ps'));

	}

	public function getUsers()
	{

		$users = User::has('ps', '<', 1)->orderby('created_at', 'DESC')->paginate(20);
		return view('admin.users', compact('users'));

	}

	public function postSearch(Request $request)
	{

		$validator = Validator::make($request->all(), ['recherche' => 'required|string']);

       	if ($validator->fails())
        {
            return back()->withErrors($validator);
        }

        $recherche = explode(' ', $request->input('recherche'));
        $users = User::query();

        foreach ($recherche as $r) {
        	$users = $users->where('nom', 'like', '%'.$r.'%')->orWhere('prenom', 'like', '%'.$r.'%');
        }

		$users = $users->distinct()->paginate(20);

		return view('admin.users', compact('users', 'recherche'));

	}

	public function getPs()
	{

		$ps = User::has('ps')->orderby('created_at', 'DESC')->paginate(20);
		return view('admin.ps', compact('ps'));

	}

	public function getCommandes()
	{

		$commandes = Commande::orderBy('created_at', 'DESC')->paginate(20);
		return view('admin.commandes', compact('commandes'));

	}

	public function getCommande($id)
	{

		$commande = Commande::find($id);

        if (!$commande) {
            return back()->withErrors('Commande inexistante !');
        }

		return view('admin.display-commande', compact('commande'));

	}

	public function getUser($id)
	{

		$user = User::find($id);

        if (!$user) {
            return back()->withErrors('Utilisateur inexistant !');
        }

        $commandes = Commande::where('user_id', $id)->orWhere('ps_id', $id)->paginate(5);

		return view('admin.display-user', compact('user', 'commandes'));

	}

	public function getUserLogin($id)
	{

		$user = User::find($id);

        if (!$user) {
            return back()->withErrors('Utilisateur inexistant !');
        }

		Auth::loginUsingId($id);

		return redirect('espace');

	}
 
	public function getActive($id)
	{

		$user = User::find($id);

        if (!$user || !$user->checkps) {
            return back()->withErrors('Utilisateur inexistant !');
        }

        if($user->ps->active == 1) {
        	$user->ps->active = 0;
        	$user->ps->save();
        	return back()->with('success', 'Le compte du personal shopper est désormais bloqué !');
        } else {
         	$user->ps->active = 1;
        	$user->ps->save();
        	return back()->with('success', 'Le compte du personal shopper est désormais débloqué !');    	
        }

	}

	public function getMarques()
	{

		$marques = Marque::orderBy('nom')->paginate(30);
		return view('admin.marques', compact('marques'));

	}

	public function getDeleteMarque($id)
	{

		$marque = Marque::find($id);

        if (!$marque) {
            return back()->withErrors('Marque inexistante !');
        }

        if (MarquePs::where('marque_id', $id)->count() > 0) {
        	return back()->withErrors('Cette marque est utilisée par plusieurs personal shoppers et ne peut pas être supprimée !');
        } else {
        	$marque->delete();
        	return back()->with('success', 'La marque a été supprimé !'); 
        }

	}	

	public function postMarque(Request $request)
	{

		$validator = Validator::make($request->all(), ['marque' => 'required|string']);

       	if ($validator->fails())
        {
            return redirect('admin/marques')->withErrors($validator);
        }

        $marque = new Marque;
        $marque->nom = $request->input('marque');
        $marque->save();

        return back()->with('success', 'La marque "'.$marque->nom.'" a été ajouté !'); 

	}

	public function postStatut(Request $request, $id)
	{

		$validator = Validator::make($request->all(), ['statut' => 'required|integer|in:0,1,2,3']);

       	if ($validator->fails())
        {
            return back()->withErrors($validator);
        }

		$commande = Commande::find($id);

        if (!$commande) {
            return back()->withErrors('Commande inexistante !');
        }

        $commande->statut = $request->input('statut');
        $commande->save();

        return back()->with('success', 'Le statut de la commande a été modifié !'); 

	}

	public function getUserDelete($id)
	{

		$user = User::find($id);

        if (!$user) {
            return redirect('admin')->withErrors('Utilisateur inexistant !');
        }

        Message::where('auteur_id', $id)->orWhere('destinataire_id', $id)->delete();

        if ($user->checkps) {

        	MarquePs::where('user_id', $id)->delete();
        	Disponibilite::where('user_id', $id)->delete();
        	UserPs::where('user_id', $id)->delete();
        	Commande::where('ps_id', $id)->delete();
        	Avis::where('ps_id', $id)->delete();

	        $photos = Photo::where('user_id', $id)->get();

			foreach ($photos as $photo) {
				if (file_exists(base_path().'/public'.$photo->url)) {
	            	File::delete(base_path().'/public'.$photo->url);
	        	}
	        	$photo->delete();
	        }

        } else {

        	Commande::where('user_id', $id)->delete();
        	Avis::where('user_id', $id)->delete();

        }

        $user->delete();

        return redirect('admin')->with('success', 'Utilisateur supprimé !'); 

	}

}