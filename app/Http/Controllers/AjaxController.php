<?php namespace App\Http\Controllers;

use DB;
use App\Models\Photo;
use App\Models\User;
use App\Models\UserPs;
use App\Models\MarquePs;
use App\Models\Marque;
use App\Models\Avis;
use App\Models\Message;
use App\Models\Commande;
use App\Models\Disponibilite;
use Validator, File, Auth, Mail;
use Illuminate\Http\Request;
use Carbon;

class AjaxController extends Controller {

	public function __construct() 
	{
		$this->middleware('ajax');
        $this->middleware('auth', ['except' => ['getAvis', 'postDateReserver', 'postRecherche', 'getProfilClear']]);
        $this->middleware('ps', ['only' => ['getTarifs', 'updateTarifs', 'getPresentation', 'updatePs', 'getPhotos', 'getDisponibilites', 'postDisponibilites', 'postAddIndisp', 'postAddDisp', 'postDeleteDispo']]);
	}

    /*
    |--------------------------------------------------------------------------
    | Espace
    |--------------------------------------------------------------------------
    */

    public function upload_image(Request $request)
    {

		$image = $request->file('file');

		$validator = Validator::make(['image' => $image], ['image' => 'required|image|max:3000']);

		if ($validator->fails())
		{
			return response()->json(['status' => 'error', 'msg' => $validator->errors()->first()]);
		}

        // Pas plus de 5 photos
        if(Photo::where('user_id', Auth::id())->count() > 4) {
            return response()->json(['status' => 'error', 'msg' => 'Vous ne pouvez pas télécharger plus de 5 images !']);
        }

        $extension = $image->getClientOriginalExtension();
        $filename = sha1(mt_rand().time()).'.'.$extension;

        $image->move(base_path().'/public/uploads/photos/', $filename);

        $photo = new Photo;
        $photo->user_id = Auth::id();
        $photo->url = '/uploads/photos/'.$filename;
        $photo->description = $image->getClientOriginalName();
        $photo->save();

        return response()->json(['status' => 'ok', 'msg' => 'Terminé', 'id' => $photo->id]);

    }

    public function delete_image(Request $request)
    {

		$id = $request->input('id');

		$validator = Validator::make(['id' => $id], ['id' => 'required|integer']);

		if ($validator->fails())
		{
			return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
		}

		$photo = Photo::where('id', $id)->where('user_id', Auth::id())->first();

		if ($photo) {

			if (file_exists(base_path().'/public'.$photo->url)) {
            	File::delete(base_path().'/public'.$photo->url);
        	}

        	$photo->delete();

        	return response()->json(['success' => true, 'id' => $id, 'msg' => 'L\'image a bien été supprimé.']);

		} else {

			return response()->json(['success' => false, 'msg' => 'Erreur : la photo n\'existe pas ou ne vous appartient pas.']);

		}

    }

    public function getPlanning()
    {

        setlocale(LC_TIME, 'fr_FR');

        if (Auth::user()->check_ps) {

            $commandes = Commande::where('ps_id', Auth::id())->where('statut', 1)->where('date', '>=', Carbon::now()->toDateString())
                ->orderBy('date', 'ASC')->paginate(5);
        	return response()->json(['html' => view('ajax.espace_ps.planning', compact('commandes'))->render()]);

        } else {

            $commandes = Commande::where('user_id', Auth::id())->whereIn('statut', [1,3])->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))->from('avis')->whereRaw('`avis`.`commande_id` = `commandes`.`id`'); 
                })->orderBy('date', 'ASC')->paginate(5);
            return response()->json(['html' => view('ajax.espace.planning', compact('commandes'))->render()]);

        }

    }

    public function getTarifs()
    {

        $ps = UserPs::where('user_id', Auth::id())->first();
        return response()->json(['html' => view('ajax.espace_ps.tarifs', compact('ps'))->render()]);

    }

    public function updateTarifs(Request $request)
    {

        $validator = Validator::make($request->all(), ['tarif_sa' => 'required|integer']);

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }

        $userps = UserPs::where('user_id', Auth::id())->first();
        $userps->tarif_sa = $request->input('tarif_sa');
        $userps->save();

        return response()->json(['success' => true, 'msg' => 'Les tarifs ont bien été modifié !']);

    }

    public function getPaiements()
    {

        if (Auth::user()->check_ps) {

            $paiements = Commande::where('ps_id', Auth::id())->whereIn('statut', [1,3])->orderBy('date', 'DESC')->paginate(5);
            return response()->json(['html' => view('ajax.espace_ps.paiements', compact('paiements'))->render()]);

        } else {

            $paiements = Commande::where('user_id', Auth::id())->whereIn('statut', [1,3])->orderBy('created_at', 'DESC')->paginate(5);
            return response()->json(['html' => view('ajax.espace.paiements', compact('paiements'))->render()]);

        }

    }

    public function getPresentation()
    {

        $ps = UserPs::where('user_id', Auth::id())->first();
        $marques = Marque::orderBy('nom')->get();
        $checkmarques = array_column(MarquePs::where('user_id', Auth::id())->get()->toArray(), 'marque_id');
        return response()->json(['presentation' => true, 'html' => view('ajax.espace_ps.presentation', compact('ps', 'marques', 'checkmarques'))->render()]);

    }

    public function updatePs(Request $request)
    {

        Validator::extend('check_marques', function($attribute, $values, $parameters) {
            if(!is_array($values) || count($values) < 3 || count($values) > 10) { 
                return false;
            }
            foreach($values as $v) {
                if(!is_numeric($v) || !Marque::find($v)) {
                    return false;
                }
            }
            return true;
        });

        Validator::extend('check_icones', function($attribute, $values, $parameters) {
            $icones = explode(',', $values);
            if(count($icones) < 1 || count($icones) > 5) {
                return false;
            }
            return true;
        });

        $validator = Validator::make($request->all(),
        [
            'pitch' => 'required|string',
            'marques' => 'required|check_marques',
            'icones' => 'required|check_icones|string',
            'villes' => 'required|string',
            'specialite' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }

        $userps = UserPs::where('user_id', Auth::id())->first();
        $userps->pitch = $request->input('pitch');
        $userps->icones = $request->input('icones');
        $userps->villes = $request->input('villes');
        $userps->specialite = null;
        foreach ($request->input('specialite') as $specialite) {
            if ($specialite == 'H' || $specialite == 'F') {
                $userps->specialite = $userps->specialite.$specialite;
            }
        }
        $userps->save();

        MarquePs::where('user_id', Auth::id())->delete();

        foreach ($request->input('marques') as $marque) {
            $m = new MarquePs;
            $m->user_id = Auth::id();
            $m->marque_id = $marque;
            $m->save();
        } 

        return response()->json(['success' => true, 'msg' => 'Votre profil a bien été mofifié !']);

    }

    public function getPhotos()
    {

        $photos = Auth::user()->photos;
        return response()->json(['html' => view('ajax.espace_ps.photos', compact('photos'))->render(), 'upload' => true]);

    }

    public function getDisponibilites()
    {

        $rdisp = Disponibilite::where('user_id', Auth::id())->where('type', 'rec')->get();

        $horaires = [];
        $horaires["Monday"] = [];
        $horaires["Tuesday"] = [];
        $horaires["Wednesday"] = [];
        $horaires["Thursday"] = [];
        $horaires["Friday"] = [];
        $horaires["Saturday"] = [];
        $horaires["Sunday"] = [];

        foreach ($rdisp as $r) {
            $horaires[$r->jour] = explode(',', $r->horaires);
        }

        $disp = Disponibilite::where('user_id', Auth::id())->where('type', 'disp')->where('date', '>=', Carbon::now()->toDateString())->get();
        $indisp = Disponibilite::where('user_id', Auth::id())->where('type', 'indisp')->where('date', '>=', Carbon::now()->toDateString())->get();

        return response()->json(['html' => view('ajax.espace_ps.disponibilites', compact('horaires', 'disp', 'indisp'))->render()]);

    }

    public function postDisponibilites(Request $request)
    {

        Validator::extend('check_dispo', function($attribute, $values, $parameters) {
            if(!is_array($values)) { 
                return false;
            }
            foreach($values as $v) {
                if(!is_numeric($v) || $v < 8 || $v > 22) {
                    return false;
                }
            }
            return true;
        });

        $validator = Validator::make($request->all(),
        [
            'mon' => 'check_dispo',
            'tue' => 'check_dispo',
            'wed' => 'check_dispo',
            'thu' => 'check_dispo',
            'fri' => 'check_dispo',
            'sat' => 'check_dispo',
            'sun' => 'check_dispo'
        ]);

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }

        Disponibilite::where('user_id', Auth::id())->where('type', 'rec')->delete();

        $horaires = [];

        if (!empty($mon = $request->input('mon'))) {
            sort($mon); $mon = implode(',', $mon);
            $horaires["Monday"] = $mon;
        }

        if (!empty($tue = $request->input('tue'))) {
            sort($tue); $tue = implode(',', $tue);
            $horaires["Tuesday"] = $tue;
        }

        if (!empty($wed = $request->input('wed'))) {
            sort($wed); $wed = implode(',', $wed);
            $horaires["Wednesday"] = $wed;
        }

        if (!empty($thu = $request->input('thu'))) {
            sort($thu); $thu = implode(',', $thu);
            $horaires["Thursday"] = $thu;
        }

        if (!empty($fri = $request->input('fri'))) {
            sort($fri); $fri = implode(',', $fri);
            $horaires["Friday"] = $fri;
        }

        if (!empty($sun = $request->input('sun'))) {
            sort($sun); $sun = implode(',', $sun);
            $horaires["Sunday"] = $sun;
        }

        if (!empty($sat = $request->input('sat'))) {
            sort($sat); $sat = implode(',', $sat);
            $horaires["Saturday"] = $sat;
        }

        foreach ($horaires as $key => $horaire) {
            $disp = new Disponibilite;
            $disp->user_id = Auth::id();
            $disp->type = 'rec';
            $disp->jour = $key;
            $disp->horaires = $horaire;
            $disp->save();
        }

        return response()->json(['success' => true, 'msg' => 'Votre profil a bien été modifié !', 'dispo' => true]);

    }

    public function postAddIndisp(Request $request) {

        Validator::extend('check_dispo', function($attribute, $values, $parameters) {
            if(!is_array($values)) {
                return false;
            }
            foreach($values as $v) {
                if(!is_numeric($v) || $v < 8 || $v > 22) {
                    return false;
                }
            }
            return true;
        });

        $validator = Validator::make($request->all(),
        [
            'indisp_date' => 'required|date_format:d-m-Y|after:'.Carbon::now()->addDay(1)->toDateString(),
            'indisp' => 'required|check_dispo'
        ]);

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }

        $horaires = $request->input('indisp');
        sort($horaires); $horaires = implode(',', $horaires);

        $indisp = new Disponibilite;
        $indisp->user_id = Auth::id();
        $indisp->type = 'indisp';
        $indisp->date = Carbon::createFromFormat('d-m-Y', $request->input('indisp_date'))->toDateString();
        $indisp->horaires = $horaires;
        $indisp->save();

        return response()->json(['success' => true, 'msg' => 'Votre indisponibilité a bien été ajouté !', 'dispo' => true]);

    }

    public function postAddDisp(Request $request) {

        Validator::extend('check_dispo', function($attribute, $values, $parameters) {
            if(!is_array($values)) { 
                return false;
            }
            foreach($values as $v) {
                if(!is_numeric($v) || $v < 8 || $v > 22) {
                    return false;
                }
            }
            return true;
        });

        $validator = Validator::make($request->all(),
        [
            'disp_date' => 'required|date_format:d-m-Y|after:'.Carbon::now()->addDay(1)->toDateString(),
            'disp' => 'required|check_dispo'
        ]);

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }        
        
        $horaires = $request->input('disp');
        sort($horaires); $horaires = implode(',', $horaires);

        $disp = new Disponibilite;
        $disp->user_id = Auth::id();
        $disp->type = 'disp';
        $disp->date = Carbon::createFromFormat('d-m-Y', $request->input('disp_date'))->toDateString();
        $disp->horaires = $horaires;
        $disp->save();

        return response()->json(['success' => true, 'msg' => 'Votre disponibilité a bien été ajouté !', 'dispo' => true]);

    }

    public function postDeleteDispo($id) {

        $drec = Disponibilite::find($id);

        if (!$drec || $drec->user->id != Auth::id()) {
            return response()->json(['success' => false, 'msg' => 'Vous ne pouvez pas supprimer cette disponibilité !']);
        }  
        
        if ($drec->type == 'disp') { $dmsg = 'disponibilité'; } else { $dmsg = 'indisponibilité'; }

        $drec->delete();

        return response()->json(['success' => true, 'msg' => 'Votre '.$dmsg.' a bien été supprimé !', 'dispo' => true]);

    }

    public function getCommentaires()
    {

        if (Auth::user()->check_ps) {

            $avis = Avis::where('ps_id', Auth::id())->orderBy('created_at', 'DESC')->paginate(5);
            return response()->json(['html' => view('ajax.espace_ps.avis', compact('avis'))->render()]);

        } else {

            $avis = Avis::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->paginate(5);
            return response()->json(['html' => view('ajax.espace.avis', compact('avis'))->render()]);

        }

    }

    public function getMessages()
    {

        Carbon::setLocale('fr');
        $messages = Message::where('destinataire_id', Auth::id())->orderBy('created_at', 'DESC')->paginate(5);
        return response()->json(['html' => view('ajax.espace.messages', compact('messages'))->render()]);

    }

    public function getNewMessage()
    {

        if (Auth::user()->check_ps) {
            $commandes = Commande::where('ps_id', Auth::id())->whereIn('statut', [1,3])->lists('user_id');
        } else {
            $commandes = Commande::where('user_id', Auth::id())->whereIn('statut', [1,3])->lists('ps_id');
        }

        $users = User::whereIn('id', $commandes)->get();

        return response()->json(['html' => view('ajax.espace.new-message', compact('users'))->render()]);

    }

    public function postNewMessage(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'user' => 'required|integer|exists:users,id',
            'message' => 'required|string'
        ]);

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }

        if (Auth::user()->check_ps) {
            $commandes = Commande::where('ps_id', Auth::id())->whereIn('statut', [1,3])->get(['user_id'])->toArray();
            $commandes = array_column($commandes, 'user_id');
        } else {
            $commandes = Commande::where('user_id', Auth::id())->whereIn('statut', [1,3])->get(['ps_id'])->toArray();
            $commandes = array_column($commandes, 'ps_id');
        }
        
        if (!in_array($request->input('user'), $commandes)) {
            return response()->json(['success' => false, 'msg' => 'Vous ne pouvez pas envoyer de message à ce destinataire !']);
        }

        $msg = new Message;
        $msg->auteur_id = Auth::id();
        $msg->destinataire_id = $request->input('user');
        $msg->texte = $request->input('message');
        $msg->save();

        $data = ['msg' => $msg];

        Mail::send('emails.nouveau_message', $data, function($m) use ($msg) {
            $m->to($msg->destinataire->email, $msg->destinataire->prenom.' '.$msg->destinataire->nom)->subject('Nouveau message !');
        });

        return response()->json(['success' => true, 'msg' => 'Votre message a bien été envoyé', 'newmsg' => true]);

    }

    /*
    |--------------------------------------------------------------------------
    | Recherche - Profil - Réserver
    |--------------------------------------------------------------------------
    */

    public function getAvis($id)
    {

        $avis = Avis::where('ps_id', $id)->orderBy('created_at', 'DESC')->paginate(4);
        return response()->json(['html' => view('ajax.avis', compact('avis'))->render()]);

    }

    public function postDateReserver(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'id' => 'required|integer|exists:users,id',
            'date' => 'required|date_format:Y-m-d|after:'.Carbon::now()->addDay(1)->toDateString()
        ]);

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }

        $rec = Disponibilite::where('type', 'rec')->where('user_id', $request->input('id'))->where('jour', Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('l'))->first(['horaires']);
        $disp = Disponibilite::where('type', 'disp')->where('user_id', $request->input('id'))->where('date', $request->input('date'))->first(['horaires']);
        $indisp = Disponibilite::where('type', 'indisp')->where('user_id', $request->input('id'))->where('date', $request->input('date'))->first(['horaires']);
        $hcmd = Commande::whereIn('statut', [0,1])->where('ps_id', $request->input('id'))->where('date', $request->input('date'))->get(['horaires'])->toArray();

        if ($rec) { $rec = $rec->horaires; } else { $rec = ''; }
        if ($disp) { $disp = $disp->horaires; } else { $disp = ''; }
        if ($indisp) { $indisp = $indisp->horaires; } else { $indisp = ''; }
        if ($hcmd) { $hcmd = implode(',', array_column($hcmd, 'horaires')); } else { $hcmd = ''; }

        $horaires = array_diff(array_unique(array_merge(json_decode('['.$rec.']', true), json_decode('['.$disp.']', true))), array_unique(array_merge(json_decode('['.$indisp.']', true), json_decode('['.$hcmd.']', true))));
        sort($horaires);

        if (empty($horaires)) {
            return response()->json(['success' => false, 'msg' => 'Il n\'y a plus d\'horaires disponibles à cette date.']);
        } else {
            return response()->json(['success' => true, 'horaires' => $horaires]);
        }

    }

    public function postRecherche(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'ville' => 'string',
            'date' => 'date_format:d-m-Y',
            'heure' => 'integer',
            'budget' => 'string',
            'marques' => 'array',
            'specialite' => 'in:H,F'
        ]);

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()]);
        }

        $ps = User::with('ps');

        $sub_query = UserPs::where('active', 1)->where('villes', 'like', '%'.trim($request->input('ville')).'%')
            ->where('specialite', 'like', '%'.$request->input('specialite').'%')
            ->whereBetween('tarif_sa', explode(',', $request->input('budget')))
            ->lists('user_id');

        $ps = $ps->whereIn('id', $sub_query);


        if(!empty($request->input('marques'))) {

            $sub_query = MarquePs::whereIn('marque_id', $request->input('marques'))->lists('user_id');
            $ps = $ps->whereIn('id', $sub_query);

        }

        if(!empty($request->input('heure')) || !empty($request->input('date'))) {
            
            $sub_query = Disponibilite::where(function ($q) use ($request) {

                $q->where('type', 'rec');
                if(!empty($request->input('date'))) {
                    $q = $q->where('jour', Carbon::createFromFormat('d-m-Y', $request->input('date'))->format('l'));
                }
                $q = $q->where('horaires', 'like', '%'.$request->input('heure').'%');

            })->orWhere(function ($q) use ($request) {

                $q->where('type', 'disp');
                if(!empty($request->input('date'))) {
                    $q = $q->where('date', Carbon::createFromFormat('d-m-Y', $request->input('date'))->toDateString());
                }
                $q = $q->where('horaires', 'like', '%'.$request->input('heure').'%');

            })->lists('user_id');

            $ps = $ps->whereIn('id', $sub_query);

        }

        if(!empty($request->input('date'))) {

            $ps = $ps->whereNotExists(function ($query) use ($request) {

                $query->select(DB::raw(1))->from('disponibilites')
                ->where('date', Carbon::createFromFormat('d-m-Y', $request->input('date'))->toDateString())
                ->where('type', 'indisp')
                ->whereRaw('`disponibilites`.`user_id` = `users`.`id`');
                if(!empty($request->input('heure'))) {
                    $query = $query->where('horaires', 'like', '%'.$request->input('heure').'%');
                } else {
                    $query = $query->where('horaires', 'like', '%8,9,10,11,12,13,14,15,16,17,18,19,20,21,22%');
                }

            });

        }

        $ps = $ps->orderBy('updated_at', 'DESC')->paginate(12);

        $request->session()->flash('rps', $ps);
        $request->session()->keep(['rps']);
        
        if($ps->hasMorePages()) { $page = $ps->nextPageUrl(); } else { $page = false; };
        if($ps->count() > 0) { $count = true; } else { $count = false; }

        return response()->json(['html' => view('ajax.recherche', compact('ps', 'count'))->render(), 'count' => $count, 'page' => $page]);

    }

    public function getProfilClear(Request $request)
    {

        $request->session()->keep(['rps', 'espace']);
        $request->session()->forget('rcount');
        return response()->json(['response' => 'ok']);

    }

}