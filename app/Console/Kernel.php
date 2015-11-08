<?php namespace App\Console;

use Carbon, Mail;
use App\Models\Commande;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	protected $commands = [];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */

	// * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1

	protected function schedule(Schedule $schedule)
	{

		$schedule->call(function () {
           
			$commandes = Commande::where('statut', 1)->where('date', '<=', Carbon::now()->subDays(3)->toDateString())->get();

			$api = app('mangopay-api');

			foreach ($commandes as $commande) {

				$PayOut = new \MangoPay\PayOut();
				$PayOut->AuthorId = $commande->userps->mangopay_id;
				$PayOut->DebitedWalletId = $commande->userps->ps->wallet_id;
				$PayOut->DebitedFunds = new \MangoPay\Money();
				$PayOut->DebitedFunds->Currency = "EUR";
				$PayOut->DebitedFunds->Amount = str_replace('.', '', number_format(($commande->tarif), 2));
				$PayOut->Fees = new \MangoPay\Money();
				$PayOut->Fees->Currency = "EUR";
				$PayOut->Fees->Amount = str_replace('.', '', number_format((0.1*$commande->tarif), 2));
				$PayOut->PaymentType = "BANK_WIRE";
				$PayOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
				$PayOut->MeanOfPaymentDetails->BankAccountId = $commande->userps->ps->bank_id;
				$result = $api->PayOuts->Create($PayOut);

				$commande->statut = 3;
				$commande->save();

			}

        })->dailyAt('4:00');

		$schedule->call(function () {
           
			$commandes = Commande::where('statut', 1)->where('date', '=', Carbon::now()->addDays(2)->toDateString())->get();

			foreach ($commandes as $commande) {
				$data = ['commande' => $commande];
				Mail::send('emails.rappel_prestation_j2', $data, function($m) use ($commande) {
	            	$m->to($commande->user->email, $commande->user->prenom.' '.$commande->user->nom)->subject('Rappel de votre réservation !');
	        	});
			}

        })->dailyAt('8:00');

		$schedule->call(function () {
           
			$commandes = Commande::where('statut', 1)->where('date', '=', Carbon::now()->subDays(1)->toDateString())->get();

			foreach ($commandes as $commande) {
				$data = ['commande' => $commande];
				Mail::send('emails.evaluation_ps', $data, function($m) use ($commande) {
	            	$m->to($commande->user->email, $commande->user->prenom.' '.$commande->user->nom)->subject('Laissez votre avis pour votre séance !');
	        	});
			}

        })->dailyAt('9:00');

		$schedule->call(function () {
           
			$commandes = Commande::where('statut', 0)->where('created_at', '<', Carbon::now()->subMinutes(16)->toDateTimeString())->update(['statut' => 2]);

        })->everyFiveMinutes();

	}

}
