<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Assos;
use App\Article;
use Illuminate\Support\Facades\App;
use App\User;

class AssoController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$assos = Assos::all ();
		return view ( 'assos_clubs.index', [ 
				"assos" => $assos,
				"type" => "asso" 
		] );
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$articles = Article::all ();
		$prezs = User::getPrez();
		return view ( 'assos_clubs.add', [ 
				"articles" => $articles,
				"type" => "asso",
				"asso_name" => "",
				"article_s" => "",
				"prez_s" => 0,
				"prezs" => $prezs,
				"lien"=>"",
				"color"=> "",
				"text_color" => "",
		] );
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$asso = new Assos ();
		$article = Article::find ( $request->input ( 'article_id' ) );
		$asso->name = $request->input ( 'name' );
		$asso->lien = $request->input ( 'lien' );
		$asso->color = $request->input ( 'color' );
		$asso->text_color = $request->input ( 'text_color' );
		
		
		$prez = User::find ( $request->input ( 'prez_id' ) );
		
		$asso->user ()->associate ( $prez );
		$asso->article ()->associate ( $article );
		
		$asso->save ();
		
		return redirect ()->action ( 'AssoController@index' );
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($asso_name, Request $request) {
		$asso = Assos::where ( 'lien', '=', $asso_name )->get ();
		$asso = $asso [0];
		$request->session ()->flash ( "origin", "asso/" );
		$request->session ()->flash ( "page", $asso_name );
		return App::call ( '\App\Http\Controllers\ArticleController@show', [ 
				"id" => $asso->article->id 
		] );
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$articles = Article::all ();
		$asso = Assos::find ( $id );
		$prez = User::getPrez ();
		
		if($asso->user){
			$prez_id = $asso->user->id;
		}else{
			$prez_id = 0;
		}
		
		return view ( 'assos_clubs.edit', [ 
				'type' => 'asso',
				'asso_name' => $asso->name,
				'articles' => $articles,
				'article_s' => $asso->article->id,
				"id" => $asso->id,
				'errors' => [ 
						"" 
				],
				"lien" => $asso->lien,
				"prezs" => $prez ,
				"prez_s" => $prez_id,
				"color"=> $asso->color,
				"text_color" => $asso->text_color,
			
		] );
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$article = Article::find ( $request->input ( 'article_id' ) );
		$asso = Assos::find ( $id );
		$asso->name = $request->input ( 'name' );
		$asso->lien = $request->input ( 'lien' );
		$asso->color = $request->input ( 'color' );
		$asso->text_color = $request->input ( 'text_color' );
		$prez = User::find ( $request->input ( 'prez_id' ) );
		
		$asso->user ()->associate ( $prez );
		$asso->article ()->associate ( $article );
		
		$asso->save ();
		
		return redirect ()->action ( 'AssoController@index' );
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$asso = Assos::find ( $id );
		
		$asso->delete ();
		return redirect ()->action ( "AssoController@index" );
	}
}
