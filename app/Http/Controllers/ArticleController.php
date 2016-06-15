<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Assos;
use App\Article;
use App\User;

class ArticleController extends Controller {
	private $acceptFile = [ 
			'jpg',
			'jpeg',
			'png',
			'JPG'
	];
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$articles = Article::all();
		
		return view('article.admin.index',['articles'=>$articles]);
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$users = DB::table('users')->join('role_user', 'users.id','=','role_user.user_id')->where('role_id','=','3')->orwhere('role_id','=','1')->get();
		
		return view('article.admin.add' ,[
				'errors'=>$request->session ()->pull ( 'error', []),
				'name'=>$request->session ()->pull ( 'name', ' '),
				'content'=>$request->session ()->pull ( 'content', " "),
				'header_text'=>$request->session ()->pull ( 'header_text', ' '),
				'file'=>'',
				'banner'=>'',
				'users'=>$users,
				'owner_id'=>$request->session()->pull('owner_id', ' '),
		]);
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$article = new Article();
		$article->name = $request->input ( 'name' );
		$article->lien = str_replace(' ', '-',strtolower (urldecode($request->input ( 'name' ))));
		$article->content = $request->input ( 'contenu' );
		$article->header_text = $request->input('header');
		
		
		if ($request->hasFile ( 'header_image' )) {
			if (in_array ( $request->file ( 'header_image' )->getClientOriginalExtension(), $this->acceptFile ) && strpos($request->file('header_image')->getClientOriginalName(),"php") === false) {
				$request->file ( 'header_image' )->move ( 'assets/img/', $request->file ( 'header_image' )->getClientOriginalName () );
				$article->image = 'assets/img/' . $request->file ( 'header_image' )->getClientOriginalName ();
			} else {
				$request->session ()->flash ( 'error', ['Le fichier doit être une image'] );
				$request->session ()->flash ( 'name', $article->name );
				$request->session ()->flash ( 'content', $article->content );
				$request->session ()->flash ( 'header_text', $article->header_text );
				$request->session()->flash('owner_id', $request->input('owner_id'));
				return redirect ()->action ( 'ArticleController@create' );
			}
		}
		
		if($request->input('owner_id') != "0"){
			$owner = User::find($request->input('owner_id') );
			$article->user()->associate($owner);
		}else{
			$article->user_id = 0;
		}
		
		$article->save ();
		
		return redirect ()->action ( 'ArticleController@index');
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$article = Article::find($id);
		if($article == null){
			return view('errors.503');
		}
		if ($article->image != null) {
			$banner = $article->image;
		} else {
			$banner = null;
		}
		if ($article->header_text != "") {
			$content_header = $article->header_text;
		} else {
			$content_header = null;
		}
		if($article->user){
			$user_id = $article->user->id;
		}else{
			$user_id = 0;
		}
		
		return view ( 'article.show', [ 
				'content' => $article->content,
				'banner' => $banner,
				'content_header' => $content_header,
				'article_name' => $article->name,
				'id'=> $article->id,
				'user_id'=>$user_id,
		] );
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id) {
		$errors = [];
		$errors [] = $request->session ()->pull ( 'error', null );
		$article = Article::find($id);
		if ($article->image != null) {
			$banner = $article->image;
			$file = explode("/",$banner);
			$file = $file[count($file)-1];
		} else {
			$banner = null;
			$file = null;
		}
		
		if ($article->header_text != null) {
			$content_header = $article->header_text;
		} else {
			$content_header = null;
		}
		return view ( 'article.edit', [ 
				'content' => $article->content,
				"banner" => $banner,
				"content_header" => $content_header,
				"article_name" => $article->name,
				"file" => $file,
				"errors" => $errors,
				"id" => $article->id,
		] );
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function adminedit(Request $request, $id) {
		$errors = [];
		$errors [] = $request->session ()->pull ( 'error', null );
		$article = Article::find($id);
		$users = DB::table('users')->join('role_user', 'users.id','=','role_user.user_id')->where('role_id','=','3')->orwhere('role_id','=','1')->get();
		
		if ($article->image != null) {
			$banner = $article->image;
			$file = explode("/",$banner);
			$file = $file[count($file)-1];
		} else {
			$banner = null;
			$file = null;
		}
	
		if ($article->header_text != null) {
			$content_header = $article->header_text;
		} else {
			$content_header = null;
		}
		if($article->user){
			$owner_id = $article->user->id;
		}else{
			$owner_id = 0;
		}
		return view ( 'article.admin.edit', [
				'content' => $article->content,
				"banner" => $banner,
				"header_text" => $content_header,
				"name" => $article->name,
				"file" => $file,
				"error" => $errors,
				"id" => $article->id,
				"owner_id"=>$owner_id,
				"users"=>$users,
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
		$article = Article::find($id);
		
		$article->content = $request->input ( 'contenu' );
		$article->header_text = $request->input('header');
		if ($request->hasFile ( 'header_image' )) {
			if (in_array ( $request->file ( 'header_image' )->getClientOriginalExtension(), $this->acceptFile ) && strpos($request->file('header_image')->getClientOriginalName(),"php") === false) {
				$request->file ( 'header_image' )->move ( 'assets/img/', $request->file ( 'header_image' )->getClientOriginalName () );
				$article->image = 'assets/img/' . $request->file ( 'header_image' )->getClientOriginalName ();
			} else {
				$request->session ()->flash ( 'error', 'Le fichier doit être une image' );
				return redirect ()->action ( 'ArticleController@edit', [ 
						$id 
				] );
			}
		}
		if(!$request->input('old_file') && !$request->hasFile ( 'header_image' )){
			$article->image = "";
		}
		
		if($request->input('admin') == "true"){
			if($request->input("owner_id")!="0"){
				$owner = User::find($request->input("owner_id"));
				$article->user()->associate($owner);
			}else{
				$article->user_id = 0;
			}
			
			
			$article->save();
			return redirect()->action('ArticleController@index');
		}else{
			$article->save ();
			return redirect ()->action ( 'ArticleController@show', [
					$id
			] );
		}
		
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$article = Article::find($id);
		
		$article->delete();
		return redirect()->action("ArticleController@index");
	}
}
