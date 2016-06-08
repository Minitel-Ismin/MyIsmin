<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Contracts\Auth\Guard;
use App\Article;
use Illuminate\Support\Facades\Auth;

class RolesMiddleware {

	
	protected $auth;

	/**
	 * Creates a new instance of the middleware.
	 *
	 * @param Guard $auth
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  Closure $next
	 * @param  $permissions
	 * @return mixed
	 */
	public function handle($request, Closure $next, $roles)
	{
		if ($this->auth->guest() || !$request->user()->hasRole(explode('|', $roles))) {
			abort(403,'Unauthorized action.');
		}else{
			if($request->route()->parameterNames()){
				if($request->route()->parameterNames()[0] == "article"){
					$article = Article::find($request->route()->parameters()["article"]);
					if($article->user){ //gestion des articles sans propriétaire
						if(($article->user->id != Auth::user()->id) && !$request->user()->hasRole('admin')){
							abort(403, 'Unauthorized action.');
						}
					}else if($request->user()->hasRole('prez')){ //on évite qu'un prez puisse modifier un article sans propriétaire
						abort(403, 'Unauthorized action.');
					}
				}
			}
			
		}


		return $next($request);
	}
}