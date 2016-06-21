<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;
use App\Clubs;
use Illuminate\Support\Facades\App;


class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$clubs = Clubs::all();
    	return view('assos_clubs.index',["assos"=>$clubs, "type"=>"club"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articles = Article::all();
        return view('assos_clubs.add',["articles"=>$articles,"type"=>"club","asso_name"=>"","article_s"=>""]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $club = new Clubs();
        $article = Article::find($request->input('article_id'));
        $club->name = $request->input('name');
        $asso->lien = $request->input('lien');
        
        $club->article()->associate($article);
        
        $club->save();
        
        return redirect()->action('AssoController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($club_name, Request $request)
    {
    	$club = Clubs::where('lien','=',$club_name)->get();
    	$club = $club[0];
    	$request->session()->flash("origin","club/");
    	$request->session()->flash("page",$club_name);
    	return App::call('\App\Http\Controllers\ArticleController@show',["id"=>$club->article->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articles = Article::all();
        $club = Clubs::find($id);
        return view('assos_clubs.edit',['type' => 'club','asso_name'=>$club->name, 'articles'=>$articles, 'article_s' => $club->article->id,"id"=>$club->id, 'errors' => [""], "lien"=>$club->lien]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$article = Article::find($request->input('article_id'));
    	$club = Clubs::find($id);
    	$club->name = $request->input('name');
    	$club->lien = $request->input('lien');
    	 
    	$club->article()->associate($article);
    	 
    	$club->save();
    	 
    	return redirect()->action('ClubController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$club = Clubs::find($id);
    	
    	$club->delete();
    	return redirect()->action("ClubController@index");
    }
}
