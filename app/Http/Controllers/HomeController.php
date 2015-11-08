<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPs;
use App\Models\Marque;
use App\Models\MarquePs;
use App\Models\Avis;
use App\Models\Message;
use App\Models\Commande;
use App\Models\Disponibilite;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator, Carbon, Mail, DB;

class HomeController extends Controller {

	protected $auth;

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
		$this->middleware('auth', ['only' => ['getEspace', 'getPaymentConfirmation', 'getMessage', 'postReplyMessage', 'getNewAvis', 'postNewAvis']]);
		$this->middleware('ps', ['only' => ['getUpdateBank', 'postUpdateBank']]);
	}

	public function getIndex()
	{
		return view('home');
	}

	public function getProfil(Request $request, $id)
	{

		$user = User::with('ps')->find($id);

		if(!$user->ps || ($user->ps->active == 0 && $id != $this->auth->id())) {
			return redirect('/')->withErrors('L\'utilisateur n\'existe pas !');
		}

		$rec = Disponibilite::where('type', 'rec')->where('user_id', $id)->get(['jour'])->toArray();
		$disp = Disponibilite::where('type', 'disp')->where('date', '>=', Carbon::now()->addDays(2)->toDateString())->where('user_id', $id)->get(['date'])->toArray();
		$indisp = Disponibilite::where('type', 'indisp')->where('date', '>=', Carbon::now()->addDays(2)->toDateString())->where('user_id', $id)->whereExists(function ($query) use ($id) {
                $query->select('horaires', 'date')
                      ->from('disponibilites as drec')
                      ->where('drec.user_id', $id)
                      ->where('drec.type', 'rec')
                      ->whereRaw('DAYNAME(disponibilites.date) = drec.jour')
                      ->whereRaw("disponibilites.horaires LIKE CONCAT('%',drec.horaires,'%')");
		        })->get(['date'])->toArray();
		$hcmd = Commande::whereIn('statut', [0,1])->where('date', '>=', Carbon::now()->addDays(2)->toDateString())->where('ps_id', $id)->whereExists(function ($query) use ($id) {
                $query->select('horaires', 'date')
                      ->from('disponibilites as drec')
                      ->where('ps_id', $id)
                      ->where('drec.type', 'rec')
                      ->whereRaw('DAYNAME(commandes.date) = drec.jour')
                      ->whereRaw("commandes.horaires LIKE CONCAT('%',drec.horaires,'%')");
          		})->get(['date'])->toArray();

		$rec = json_encode(array_column($rec, 'jour'));
		$disp = json_encode(str_replace('-0', '-', array_column($disp, 'date')));
		$indisp = json_encode(str_replace('-0', '-', array_unique(array_merge(array_column($indisp, 'date'), array_column($hcmd, 'date')))));

		$avis = Avis::where('ps_id', $id)->orderBy('created_at', 'DESC')->paginate(4);

		$user->ps->visites++;
		$user->ps->save();

		if ($request->session()->has('rps')) {
			if ($request->session()->has('rcount')) {
				$request->session()->flash('rcount', $request->session()->get('rcount') + 1);
			} else {
				$request->session()->flash('rcount', 1);
			}
		}

		$request->session()->keep(['rps', 'espace', 'rcount']);

		return view('profil', compact('user', 'rec', 'disp', 'indisp', 'avis'));
		
	}

	public function postReserver(Request $request)
	{

		$validator = Validator::make($request->all(),
        [
        	'id' => 'required|integer|exists:users,id',
            'horaire1' => 'required|integer',
            'horaire2' => 'required|integer',
            'date' => 'required|date_format:Y-m-d|after:'.Carbon::now()->addDay(1)->toDateString(),
            //'service' => 'required|string'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator);
        }

		if(!$this->auth->check()) {
			return redirect('/profil/'.$request->input('id'))->withErrors('Vous devez vous inscrire ou vous connecter pour effectuer une réservation !');
		}

		if($this->auth->user()->check_ps) {
			return redirect('/profil/'.$request->input('id'))->withErrors('Vous ne pouvez pas effectuer de réservation en tant que personal shopper.<br>Vous devez vous créer un second compte client.');
		}

        $user = User::find($request->input('id'));

        if (!$user->ps || $user->ps->active == 0) {
        	return redirect('/')->withErrors('Personal shopper inexistant !');
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

        $user_horaires = [];

        for ($i = $request->input('horaire1'); $i < $request->input('horaire2'); $i++) { 
        	if (!in_array($i, $horaires)) {
        		return redirect('/profil/'.$request->input('id'))->withErrors('Date et horaires non disponibles !');
        	} else {
        		array_push($user_horaires, $i);
        	}
        }

        $user_tarif = ($request->input('horaire2') - $request->input('horaire1')) * $user->ps->tarif_sa;

        try {

	        $api = app('mangopay-api');

			$PayIn = new \MangoPay\PayIn();
			$PayIn->CreditedWalletId = $user->ps->wallet_id;
			$PayIn->AuthorId = $this->auth->user()->mangopay_id;
			$PayIn->PaymentType = "CARD";
			$PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
			$PayIn->PaymentDetails->CardType = "CB_VISA_MASTERCARD";
			$PayIn->DebitedFunds = new \MangoPay\Money();
			$PayIn->DebitedFunds->Currency = "EUR";
			$PayIn->DebitedFunds->Amount = str_replace('.', '', number_format($user_tarif, 2));
			$PayIn->Fees = new \MangoPay\Money();
			$PayIn->Fees->Currency = "EUR";
			$PayIn->Fees->Amount = 0;
			$PayIn->ExecutionType = "WEB";
			$PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
			$PayIn->ExecutionDetails->ReturnURL = "http".(isset($_SERVER['HTTPS']) ? "s" : null)."://".$_SERVER["HTTP_HOST"].'/confirmation';
			$PayIn->ExecutionDetails->Culture = "FR";

			$result = $api->PayIns->Create($PayIn);

		} catch (MangoPay\Libraries\ResponseException $e) {
		    
		    MangoPay\Libraries\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
		    MangoPay\Libraries\Logs::Debug('Message', $e->GetMessage());
		    MangoPay\Libraries\Logs::Debug('Details', $e->GetErrorDetails());
		    
		} catch (MangoPay\Libraries\Exception $e) {

		    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
		    
		}

        $commande = new Commande;
        $commande->user_id = $this->auth->user()->id;
        $commande->ps_id = $user->id;
        $commande->date = $request->input('date');
        $commande->horaires = implode(',', $user_horaires);
        $commande->tarif = $user_tarif;
        $commande->payment_id = $result->Id;
        $commande->type = 'sa';
        $commande->statut = 0;
        $commande->save();

        return redirect($result->ExecutionDetails->RedirectURL);

	}

	public function getCallbackPayment(Request $request)
	{

		$validator = Validator::make($request->all(),
        [
        	'RessourceId' => 'required|integer|exists:commandes,payment_id',
            'EventType' => 'required|string|in:PAYIN_NORMAL_SUCCEEDED,PAYIN_NORMAL_FAILED'
        ]);

        if ($validator->fails())
        {
            die();
        }

        $api = app('mangopay-api');

		$payment = $api->PayIns->Get($request->input('RessourceId'));

        if ($payment->Status == 'SUCCEEDED' && $request->input('EventType') == 'PAYIN_NORMAL_SUCCEEDED') {

        	$commande = Commande::where('statut', 0)->where('payment_id', $payment->Id)->first();
        	$commande->statut = 1;
        	$commande->save();

        	$data = ['commande' => $commande];

        	Mail::send('emails.confirmation_commande_client', $data, function($m) use ($commande) {
	            $m->to($commande->user->email, $commande->user->prenom.' '.$commande->user->nom)->subject('Confirmation de commande !');
	        });

        	Mail::send('emails.confirmation_commande_ps', $data, function($m) use ($commande) {
	            $m->to($commande->userps->email, $commande->userps->prenom.' '.$commande->userps->nom)->subject('Nouvelle réservation !');
	        });

        } elseif ($payment->Status == 'FAILED' && $request->input('EventType') == 'PAYIN_NORMAL_FAILED') {

        	$commande = Commande::where('statut', 0)->where('payment_id', $payment->Id)->first();
        	$commande->statut = 2;
        	$commande->save();
        	
        } else {

        	die();

        }

	}

	public function getPaymentConfirmation(Request $request)
	{

		$validator = Validator::make($request->all(),
        [
        	'transactionId' => 'required|integer|exists:commandes,payment_id'
        ]);

		if ($validator->fails())
        {
            return redirect('/')->withErrors('Erreur');
        }
		
		$api = app('mangopay-api');

		$payment = $api->PayIns->Get($request->input('transactionId'));

        if ($payment->Status == 'SUCCEEDED' || $payment->Status == 'FAILED') {

        	$commande = Commande::where('user_id', $this->auth->user()->id)->where('payment_id', $payment->Id)->first();
        	return view('payment-ok', compact('commande', 'payment'));

        } else {

        	return redirect('/')->withErrors('Erreur');

        }

	}

	public function getRecherche(Request $request)
	{

		$sub_query = UserPs::where('active', 1);

		if ($request->isMethod('get')) {

			$ville = null;

		} else {

			$validator = Validator::make($request->all(),
	        [
	        	'ville' => 'string'
	        ]);

			if ($validator->fails())
	        {
	            return redirect('/')->withErrors('Veuillez renseigner une ville');
	        }

	        $ville = $request->input('ville');

	        if(!empty($ville)) {
				$sub_query = $sub_query->where('villes', 'like', '%'.trim($ville).'%');
	        }

		}
		
		$maxprix = UserPs::where('active', 1)->max('tarif_sa');
		$marques = Marque::orderBy('nom')->get();
		$userps = User::with('ps')->whereIn('id', $sub_query->lists('user_id'))->orderBy('updated_at', 'DESC')->paginate(12);

		$request->session()->flash('rps', $userps);

		return view('recherche', compact('userps', 'marques', 'ville', 'maxprix'));

	}

	public function getEspace(Request $request)
	{

		$user = $this->auth->user();
		setlocale(LC_TIME, 'fr_FR');

		$nbmsg = Message::where('destinataire_id', $user->id)->where('destinataire_read', 0)->count();

		$request->session()->flash('espace', 1);

		if ($user->check_ps) {

			$marques = Marque::orderBy('nom')->get();
			$commandes = Commande::where('ps_id', $user->id)->where('statut', 1)->where('date', '>=', Carbon::now()->toDateString())
				->orderBy('date', 'ASC')->paginate(5);
			$commandes->setPath('espace/planning');
			$avis = Avis::where('ps_id', $user->id)->orderBy('created_at', 'DESC')->paginate(5);
			$avis->setPath('espace/commentaires');
			$checkmarques = array_column(MarquePs::where('user_id', $user->id)->get()->toArray(), 'marque_id');
			if (Disponibilite::where('user_id', $user->id)->where('type', 'rec')->count() < 1 && Disponibilite::where('user_id', $user->id)->where('type', 'disp')->where('date', '>', Carbon::now()->toDateString())->count() < 1) {
				$request->session()->flash('dispo', 1);
			}
			return view('espace_ps', compact('user', 'marques', 'checkmarques', 'commandes', 'avis', 'nbmsg'));

		} else {

			$commandes = Commande::where('user_id', $user->id)->whereIn('statut', [1,3])->whereNotExists(function ($query) {
                	$query->select(DB::raw(1))->from('avis')->whereRaw('`avis`.`commande_id` = `commandes`.`id`'); 
            	})->orderBy('date', 'ASC')->paginate(5);
			$commandes->setPath('espace/planning');
			$avis = Avis::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(5);
			$avis->setPath('espace/commentaires');
			return view('espace', compact('user', 'commandes', 'avis', 'nbmsg'));

		}

	}

	public function getMessage($id) {

		$message = Message::find($id);
		$user = $this->auth->user();
		
		if (!$message || ($message->auteur_id != $user->id && $message->destinataire_id != $user->id)) {
			return redirect('/')->withErrors('Ce message n\'existe pas !');
		}

		$reply_id = $message->reply_id;
		if ($reply_id != 0) {
			$message = Message::find($reply_id);
			$reponses = Message::where('reply_id', $reply_id)->orderBy('created_at', 'ASC')->get();
		} else {
			$reponses = Message::where('reply_id', $id)->orderBy('created_at', 'ASC')->get();
		}

		Message::where('destinataire_id', $user->id)
		->where(function ($query) use ($id, $reply_id) {
    		$query->where('id', ($reply_id != 0 ? $reply_id : $id))
          	->orWhere('reply_id', ($reply_id != 0 ? $reply_id : $id));
		})->update(['destinataire_read' => 1]);

		Carbon::setLocale('fr');
		return view('message', compact('message', 'reponses'));

	}

	public function postReplyMessage(Request $request, $id) {

		$message = Message::find($id);
		$user = $this->auth->user();
		
		if (!$message || ($message->auteur_id != $user->id && $message->destinataire_id != $user->id)) {
			return redirect('/')->withErrors('Vous ne pouvez pas répondre à ce message !');
		}

		$validator = Validator::make($request->all(),
        [
        	'message' => 'required|string'
        ]);

		if ($validator->fails())
        {
            return back()->withErrors('Vous ne pouvez pas envoyer un message vide');
        }

		$reponse = new Message;
		$reponse->auteur_id = $user->id;
		$reponse->destinataire_id = ($message->auteur_id == $user->id ? $message->destinataire_id : $message->auteur_id);
		$reponse->reply_id = $message->id;
		$reponse->texte = $request->input('message');
		$reponse->save();

		$data = ['msg' => $reponse];

        Mail::send('emails.nouveau_message', $data, function($m) use ($reponse) {
            $m->to($reponse->destinataire->email, $reponse->destinataire->prenom.' '.$reponse->destinataire->nom)->subject('Nouveau message !');
        });

		return redirect('/message/'.$message->id.'#'.$reponse->id)->with('success', 'Votre message a bien été envoyé !');

	}

	public function getUpdateBank() {

        $api = app('mangopay-api');
        $bank = $api->Users->GetBankAccount($this->auth->user()->mangopay_id, $this->auth->user()->ps->bank_id);

        return view('update-bank', compact('bank'));

	}

	public function postUpdateBank(Request $request) {

		$request->merge(str_replace(' ', '', $request->all()));

		$validator = Validator::make($request->all(),
        [
            'iban' => 'required|iban',
            'bic' => 'required|bic'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $user = $this->auth->user();

    	try {

        	$api = app('mangopay-api');

			$BankAccount = new \MangoPay\BankAccount();
			$BankAccount->Type = "IBAN";
			$BankAccount->Details = new \MangoPay\BankAccountDetailsIBAN();
			$BankAccount->Details->IBAN = $request->input('iban');
			$BankAccount->Details->BIC = $request->input('bic');
			$BankAccount->OwnerName = $user->nom.' '.$user->prenom;
			$BankAccount->OwnerAddress = $user->adresse.', '.$user->codepostal.' '.$user->ville;
			$result_b = $api->Users->CreateBankAccount($user->mangopay_id, $BankAccount);

        } catch (MangoPay\Libraries\Exception $e) {

		    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
			return back()->withErrors('Il y a eu un problème lors de la modification, merci de réessayer plus tard !');

		}

		$user->ps->bank_id = $result_b->Id;
		$user->ps->save();

		return redirect('/update/bank')->with('success', 'Vos informations bancaires ont bien été modifiées !');

	}

	public function getNewAvis($id) {

		$commande = Commande::find($id);

		if (!$commande || $commande->user->id != $this->auth->user()->id) {
			return redirect('/')->withErrors('Vous ne pouvez pas laisser un avis pour cette prestation !');
		}

		if (Avis::where('commande_id', $commande->id)->first()) {
			return redirect('/')->withErrors('Vous avez déjà laissé un avis pour cette prestation !');
		}

		return view('avis-new', compact('commande'));

	}

	public function postNewAvis(Request $request, $id) {

		$commande = Commande::find($id);

		if (!$commande || $commande->user->id != $this->auth->user()->id) {
			return redirect('/')->withErrors('Vous ne pouvez pas laisser un avis pour cette prestation !');
		}

		if (Avis::where('commande_id', $commande->id)->first()) {
			return redirect('/')->withErrors('Vous avez déjà laissé un avis pour cette prestation !');
		}
		
		$validator = Validator::make($request->all(),
        [
            'note' => 'required|integer|between:0,5',
            'commentaire' => 'required|string'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $avis = new Avis;
        $avis->user_id = $this->auth->user()->id;
        $avis->ps_id = $commande->userps->id;
        $avis->commande_id = $commande->id;
        $avis->commentaire = $request->input('commentaire');
        $avis->note = $request->input('note');
        $avis->save();

        $notes = Avis::where('ps_id', $commande->userps->id)->avg('note');

        $userps = UserPs::where('user_id', $commande->ps_id)->first();
        $userps->note = $notes;
        $userps->save();

        return redirect('/espace')->with('success', 'Merci pour votre avis, celui-ci a bien été ajouté !');

	}

	public function getMentions()
	{
		return view('mentions');
	}

	public function getCgu()
	{
		return view('cgu');
	}

	public function getCgv()
	{
		return view('cgv');
	}

	public function getContact()
	{
		return view('contact');
	}

}
