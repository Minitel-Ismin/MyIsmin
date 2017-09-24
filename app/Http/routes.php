<?php

use App\Http\Controllers\ArticleController;
/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
Route::get ( '/', function () {
	return view ( 'pages.welcome', [ 
			'banner' => null,
			'content_header' => 'The website all ISMIN must use !' 
	] );
} );

Route::get ( '/formation', function () {
	return view ( 'pages.formation', [ 
			'banner' => null,
			'content_header' => 'Formation ingénieur en 3 ans' 
	] );
} );

Route::get ( '/calendrier', function () {
	return view ( 'pages.calendar', [ 
			'banner' => null,
			'content_header' => null 
	] );
} );

Route::get ( '/eco-campus', function () {
	return view ( 'pages.ecocampus', [ 
			'banner' => null,
			'content_header' => 'Campus provence, campus écolo!' 
	] );
} );

Route::auth ();

Route::group ( [ 
		'middleware' => [ 
				'roles:prez|admin' 
		] 
], function () {
	Route::resource ( 'article', 'ArticleController', [ 
			'except' => [ 
					'show',
					'create',
					'store',
					'index',
					'destroy' 
			] 
	] );
} );

Route::resource ( 'article', 'ArticleController', [ 
		'except' => [ 
				'edit',
				'update',
				'create',
				'store',
				'index',
				'destroy' 
		] 
] );

Route::group ( [ 
		'prefix' => 'admin',
		'middleware' => [ 
				'roles:admin' 
		] 
], function () {
// 	Route::resource ( 'event', 'EventController' );
	Route::resource ( 'user', 'UserController' );
	Route::resource ( 'article', 'ArticleController', [ 
			'except' => [ 
					'show',
					'edit',
					'update' 
			] 
	] );
	Route::get ( '/article/{article}/edit', 'ArticleController@adminedit' );
	// Route::put('/article/{article}','ArticleController@adminupdate');
	Route::resource ( 'asso', 'AssoController', [ 
			'except' => [ 
					'show',
			] 
	] );
	Route::resource ( 'club', 'ClubController' , [ 
			'except' => [ 
					'show',
			] 
	]);
	Route::resource ( 'page', 'PageController' );
} );

Route::group ( [ 
		'prefix' => 'admin',
		'middleware' => [ 
				'roles:admin|prez' 
		] 
], function () {
	Route::resource ( 'event', 'EventController' );
	Route::resource ( 'lieu', 'LieuController' );
} );

Route::get('/asso/{asso_name}', 'AssoController@show');
Route::get('/club/{club_name}', 'ClubController@show');
Route::get('icscalendar', 'EventController@generateics')->middleware('auth'); //il faut être authentifié pour chopper son ics
Route::get('icscalendar/{token}', 'EventController@ics')->middleware('auth');


Route::get ( '/calendar/event', 'EventController@getall' );


