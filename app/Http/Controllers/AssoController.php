<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Assos;
use App\Article;

class AssoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$assos = Assos::all();
    	return view('assos_clubs.index',["assos"=>$assos, "type"=>"asso"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articles = Article::all();
        return view('assos_clubs.add',["articles"=>$articles,"type"=>"asso","asso_name"=>"","article_s"=>""]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asso = new Assos();
        $article = Article::find($request->input('article_id'));
        $asso->name = $request->input('name');
        
        $asso->article()->associate($article);
        
        $asso->save();
        
        return redirect()->action('AssoController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        $asso = Assos::find($id);
        return view('assos_clubs.edit',['type' => 'asso','asso_name'=>$asso->name, 'articles'=>$articles, 'article_s' => $asso->article->id,"id"=>$asso->id, 'errors' => [""]]);
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
    	$asso = Assos::find($id);
    	$asso->name = $request->input('name');
    	
    	$asso->article()->associate($article);
    	
    	$asso->save();
    	
    	return redirect()->action('AssoController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asso = Assos::find($id);
		
		$asso->delete();
		return redirect()->action("AssoController@index");
    }
}
