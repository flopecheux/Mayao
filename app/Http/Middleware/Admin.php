<?php namespace App\Http\Middleware;

use Closure;

class Admin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($request->session()->has('admin') && $request->session()->get('admin') == 'm@y@0') {

			return $next($request);

		} else {

			return view('admin.login');

		}

	}

}
