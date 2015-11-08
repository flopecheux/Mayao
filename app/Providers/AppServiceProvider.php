<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MangoPay\MangoPayApi;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);

		$this->app->singleton('mangopay-api', function($app) {

			$api = new MangoPayApi;
			$api->Config->ClientId = env('MP_CLIENTID', '');
			$api->Config->ClientPassword = env('MP_PASSWORD', '');
			$api->Config->TemporaryFolder = base_path().'/tmp';
			$api->Config->BaseUrl = env('MP_URL', '');

			return $api;
			
		});
	}

}