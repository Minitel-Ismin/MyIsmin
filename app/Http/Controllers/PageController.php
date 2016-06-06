<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Page;
use App\Article;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$pages = Page::all();
    	return view('pageadmin.index',["pages"=>$pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articles = Article::all();
        return view('pageadmin.add',["articles"=>$articles,"type"=>"asso","page_name"=>"","article_s"=>""]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new Page();
        $article = Article::find($request->input('article_id'));
        $page->name = $request->input('name');
        $page->enabled =$request->input('enabled');
        if($request->input('enabled')=="true"){
        	$page->enabled = true;
        }else{
        	$page->enabled = false;
        }
        $page->article()->associate($article);
        
        $page->save();
        
        return redirect()->action('PageController@index');
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
        $page = Page::find($id);
        return view('pageadmin.edit',['page_name'=>$page->name, 'articles'=>$articles, 'article_s' => $page->article->id,"id"=>$page->id, 'errors' => [""]]);
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
    	$page = Page::find($id);
    	$page->name = $request->input('name');
    	if($request->input('enabled')=="true"){
    		$page->enabled = true;
    	}else{
    		$page->enabled = false;
    	}
    	
    	
    	$page->article()->associate($article);
    	
    	$page->save();
    	
    	return redirect()->action('PageController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);
		
		$page->delete();
		return redirect()->action("PageController@index");
    }
}
