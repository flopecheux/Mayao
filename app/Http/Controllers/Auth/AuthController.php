<?php namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Photo;
use App\Models\Marque;
use App\Models\MarquePs;
use App\Models\UserPS;
use Hash, Mail, Validator, Carbon, File, Log;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class AuthController extends Controller
{

	protected $auth;

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
		$this->middleware('guest', ['only' => ['register', 'login']]);
		$this->middleware('auth', ['only' => ['logout', 'register_ps', 'update']]);
	}

    public function register(Request $request, $select = null)
    {

    	if($select == 1) {
    		$request->session()->flash('ps', '1');
    	}

    	if ($request->isMethod('get') && $select == null) {

		    return view('register_select');

		} elseif ($request->isMethod('get') && $select != null) {

			return view('register');

		} else {

			$request->session()->reflash();

			$request->merge(array_map('trim', $request->except('password')));
			$request->merge(str_replace(' ', '', $request->only('tel')));

	        $validator = Validator::make($request->all(),
	        [
	            'nom' => 'required|string',
	            'prenom' => 'required|string',
	            'email' => 'required|email|unique:users',
	            'password' => 'required|between:6,38|confirmed',
	            'birthday' => 'required|date_format:d/m/Y|before:'.Carbon::now()->format('d/m/Y'),
	            'adresse' => 'required|string',
	            'ville' => 'required|string',
	            'codepostal' => 'required|alpha_num',
	            'sexe' => 'required|in:H,F',
	            'tel' => 'required|digits:10',
	        ]);

	        if ($validator->fails())
	        {
	            return back()->withErrors($validator)->withInput($request->except('password'));
	        }

	        try {

	        	$api = app('mangopay-api');

				$mangoUser = new \MangoPay\UserNatural();
		        $mangoUser->PersonType = "NATURAL";
		        $mangoUser->FirstName = $request->input('prenom');
		        $mangoUser->LastName = $request->input('nom');
		        $mangoUser->Birthday = Carbon::createFromFormat('d/m/Y', $request->input('birthday'))->timestamp;
		        $mangoUser->Nationality = "FR";
		        $mangoUser->CountryOfResidence = "FR";
		        $mangoUser->Email = $request->input('email');

		        Log::info(serialize($mangoUser));

		        $mangoUser = $api->Users->Create($mangoUser);

			} catch (MangoPay\Libraries\ResponseException $e) {
			    
			    MangoPay\Libraries\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
			    MangoPay\Libraries\Logs::Debug('Message', $e->GetMessage());
			    MangoPay\Libraries\Logs::Debug('Details', $e->GetErrorDetails());
			    
			} catch (MangoPay\Libraries\Exception $e) {

			    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());

			}

	        $user = new User;
	        $user->nom = $request->input('nom');
	        $user->prenom = $request->input('prenom');
	        $user->email = $request->input('email');
	        $user->password = Hash::make($request->input('password'));
	        $user->date_naissance = Carbon::createFromFormat('d/m/Y', $request->input('birthday'))->toDateString(); 
	        $user->sexe = $request->input('sexe');
	        $user->adresse = $request->input('adresse');
	        $user->ville = $request->input('ville');
	        $user->codepostal = $request->input('codepostal');
	        $user->tel = $request->input('tel');
	        if ($request->input('sexe') == 'H') {
	        	$user->photo = '/img/avatar_h.png';
	        } else {
	        	$user->photo = '/img/avatar_f.png';	
	        }
	        $user->mangopay_id = $mangoUser->Id;
	        $user->save();

	        $this->auth->attempt(['email' => $request->input('email'), 'password' => $request->input('password')]);

        	$data = ['user' => $user];

        	Mail::send('emails.creation_compte_client', $data, function($m) use ($user) {
	            $m->to($user->email, $user->prenom.' '.$user->nom)->subject('Confirmation de votre inscription !');
	        });

	        if($request->session()->has('ps')) {
	        	return redirect('/register/ps')->with('success', trans('global.notif_register'));
	        } else {
	        	return redirect('/')->with('success', trans('global.notif_register'));
	        }

	    }

    }

    public function register_ps(Request $request)
    {

    	$user = $this->auth->user();

    	if ($user->check_ps) {
    		return redirect('/')->withErrors(trans('global.notif_alreadyps'));
    	}

    	if ($request->isMethod('get')) {

    		$photos = $user->photos()->get();
    		$marques = Marque::orderBy('nom')->get();
		    return view('register_ps', compact('photos', 'marques'));

		} else {

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

			$request->merge(array_map('trim', $request->only(['pitch', 'activite', 'motivation', 'tarif_sa'])));
			$request->merge(str_replace(' ', '', $request->only(['iban', 'bic'])));

			$validator = Validator::make($request->all(),
	        [
	            'pitch' => 'required|string',
	            'marques' => 'required|check_marques',
	            'icones' => 'required|check_icones|string',
	            'photo' => 'required|image|max:3000',
	            'cv' => 'mimes:pdf,doc,docx|max:3000',
	            'activite' => 'required|string',
	            'motivation' => 'required|string',
	            'tarif_sa' => 'required|numeric',
	            'villes' => 'required|string',
	            'specialite' => 'required',
	            'iban' => 'required|iban',
	            'bic' => 'required|bic',
	            'charte' => 'required|in:1'
	        ]);

	        if (Photo::where('user_id', $user->id)->count() < 4) {
	        	$photos = ['photos' => 'Vous devez ajouter au moins trois photos à votre moodboard.'];
	        } else { $photos = []; }

	        if ($validator->fails() || Photo::where('user_id', $user->id)->count() < 4)
	        {
	            return back()->withErrors(array_merge($validator->messages()->toArray(), $photos))->withInput();
	        }

			try {

	        	$api = app('mangopay-api');

	        	$Wallet = new \MangoPay\Wallet();
				$Wallet->Owners = [$user->mangopay_id];
				$Wallet->Description = "Wallet Mayao";
				$Wallet->Currency = "EUR";

				Log::info(serialize($Wallet));

				$result_w = $api->Wallets->Create($Wallet);

			} catch (MangoPay\Libraries\ResponseException $e) {
			    
			    MangoPay\Libraries\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
			    MangoPay\Libraries\Logs::Debug('Message', $e->GetMessage());
			    MangoPay\Libraries\Logs::Debug('Details', $e->GetErrorDetails());
			    
			} catch (MangoPay\Libraries\Exception $e) {

			    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());

			}

			try {

	        	$api = app('mangopay-api');

				$BankAccount = new \MangoPay\BankAccount();
				$BankAccount->Type = "IBAN";
				$BankAccount->Details = new \MangoPay\BankAccountDetailsIBAN();
				$BankAccount->Details->IBAN = $request->input('iban');
				$BankAccount->Details->BIC = $request->input('bic');
				$BankAccount->OwnerName = $user->nom.' '.$user->prenom;
				$BankAccount->OwnerAddress = $user->adresse.', '.$user->codepostal.' '.$user->ville;

				Log::info(serialize($BankAccount));

				$result_b = $api->Users->CreateBankAccount($user->mangopay_id, $BankAccount);

			} catch (MangoPay\Libraries\ResponseException $e) {
			    
			    MangoPay\Libraries\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
			    MangoPay\Libraries\Logs::Debug('Message', $e->GetMessage());
			    MangoPay\Libraries\Logs::Debug('Details', $e->GetErrorDetails());
			    
			} catch (MangoPay\Libraries\Exception $e) {

			    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());

			}

	        if($photo = $request->file('photo')) {
	        	$photoname = $user->id.sha1(time().time()).'.'.$photo->getClientOriginalExtension();
	        	$photo->move(base_path().'/public/uploads/', $photoname);
	        }

	        if($cv = $request->file('cv')) {
	        	$filename = $user->id.sha1(time().time()).'.'.$cv->getClientOriginalExtension();
	        	$cv->move(base_path().'/public/uploads/cv/', $filename);
	        }

	        $userps = new UserPs;
	        $userps->user_id = $user->id;
	        $userps->active = 1;
	        $userps->pitch = $request->input('pitch');
	        $userps->icones = $request->input('icones');
	        $userps->tarif_sa = $request->input('tarif_sa');
	        $userps->motivation = $request->input('motivation');
	        $userps->villes = $request->input('villes');
	        $userps->activite = $request->input('activite');
	        foreach ($request->input('specialite') as $specialite) {
	            if ($specialite == 'H' || $specialite == 'F') {
	                $userps->specialite = $userps->specialite.$specialite;
	            }
	        }
	        if(isset($filename)) {
	        	$userps->cv = $filename;
	        }
	        $userps->wallet_id = $result_w->Id;
	        $userps->bank_id = $result_b->Id;
	        $userps->save();

	        foreach ($request->input('marques') as $marque) {
	        	$m = new MarquePs;
	        	$m->user_id = $user->id;
	        	$m->marque_id = $marque;
	        	$m->save();
	        }

	       	if(isset($photoname)) {
	        	$user->photo = '/uploads/'.$photoname;
	        	$user->save();
	        }

        	$data = ['user' => $user];

        	Mail::send('emails.creation_compte_ps', $data, function($m) use ($user) {
	            $m->to($user->email, $user->prenom.' '.$user->nom)->subject('Confirmation de création de votre compte personal shopper !');
	        });

	        return redirect('/espace')->with('success', trans('global.notif_register_ps'));

		}

    }

    public function login(Request $request)
    {

		$validator = Validator::make($request->all(),
        [
            'email' => 'required|email',
            'password' => 'required|between:6,38',
        ]);

       	if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput($request->except('password'));
        }

        if ($this->auth->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
        	if(strpos($request->header('referer'), 'register') !== false) {
				return redirect('/')->with('success', trans('global.notif_login'));
        	} else {
        		return back()->with('success', trans('global.notif_login'));
        	}
        } else {
            return back()->withErrors(trans('global.notif_login_error'));
        }  

    }

    public function logout()
    {
        $this->auth->logout();
        return redirect('/')->with('success', trans('global.notif_logout'));
    }

	public function update(Request $request)
	{

		$user = $this->auth->user();

		if ($request->isMethod('get')) {

			return view('update-user', compact('user'));

		} else {

			$request->merge(array_map('trim', $request->except(['password', 'photo'])));
			$request->merge(str_replace(' ', '', $request->only('tel')));

			$validator = Validator::make($request->all(),
	        [
	            'nom' => 'required|string',
	            'prenom' => 'required|string',
	            'email' => 'required|email|unique:users,email,'.$user->id,
	            'photo' => 'image|max:3000',
	            'password' => 'between:6,38|confirmed',
	            'birthday' => 'required|date_format:d/m/Y|before:'.Carbon::now()->format('d/m/Y'),
	            'adresse' => 'required|string',
	            'ville' => 'required|string',
	            'codepostal' => 'required|alpha_num',
	            'sexe' => 'required|in:H,F',
	            'tel' => 'required|digits:10',
	        ]);

	        if ($validator->fails())
	        {
	            return back()->withErrors($validator)->withInput($request->except('password'));
	        }

	        if ($user->prenom != $request->input('prenom') || 
	        	$user->nom != $request->input('nom') || 
	        	$user->date_naissance != Carbon::createFromFormat('d/m/Y', $request->input('birthday'))->toDateString() ||
	        	$user->email != $request->input('email')) 
	        {

				try {

		        	$api = app('mangopay-api');

					$mangoUser = new \MangoPay\UserNatural();
					$mangoUser->Id = $user->mangopay_id;
			        $mangoUser->PersonType = "NATURAL";
			        $mangoUser->FirstName = $request->input('prenom');
			        $mangoUser->LastName = $request->input('nom');
			        $mangoUser->Birthday = Carbon::createFromFormat('d/m/Y', $request->input('birthday'))->timestamp;
			        $mangoUser->Nationality = "FR";
			        $mangoUser->CountryOfResidence = "FR";
			        $mangoUser->Email = $request->input('email');
			        $mangoUser = $api->Users->Update($mangoUser);

		        } catch (MangoPay\Libraries\Exception $e) {

				    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
					return back()->withErrors('Il y a eu un problème lors de la validation, merci de réessayer plus tard !');

				}

	        }

	        if($photo = $request->file('photo')) {
				if (File::exists(base_path().'/public/'.$user->photo) && $user->photo != '/img/avatar_f.png' && $user->photo != '/img/avatar_h.png') {
				    File::delete(base_path().'/public/'.$user->photo);
				} 
	        	$photoname = $user->id.sha1(time().time()).'.'.$photo->getClientOriginalExtension();
	        	$photo->move(base_path().'/public/uploads/', $photoname);
	        }

	        $user->nom = $request->input('nom');
	        $user->prenom = $request->input('prenom');
	        $user->email = $request->input('email');
	        if (!empty($request->input('password'))) {
	        	$user->password = Hash::make($request->input('password'));
	        }
	        $user->date_naissance = Carbon::createFromFormat('d/m/Y', $request->input('birthday'))->toDateString(); 
	        $user->sexe = $request->input('sexe');
	        $user->adresse = $request->input('adresse');
	        $user->ville = $request->input('ville');
	        $user->codepostal = $request->input('codepostal');
	        $user->tel = $request->input('tel');
	        if (isset($photoname)) {
		        $user->photo = '/uploads/'.$photoname;
		    }
	        $user->save();

	        return redirect('/espace')->with('success', 'Vos informations ont bien été modifié !');

		}

	}

}