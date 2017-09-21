<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\Lieu;

class LieuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lieus = Lieu::all();

        return view('lieu.index', [
            "lieus" => $lieus
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $lieus = Lieu::all ();
        
        return view ( 'lieu.add', [ 
                'lieus' => $lieus,
                "name" => $request->session ()->pull ( 'name', ''),
                "errors" => $request->session ()->pull ( 'error', []),
                
        ] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lieu = new Lieu();
        $lieu->name = $request->input('name');

        if($lieu->save()){
            return redirect()->action('LieuController@index');
        }
        $request->session ()->flash ( 'name', $request->input("name"));
        return redirect()->action('LieuController@create');
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
        $lieu = Lieu::find($id);

        return view('lieu.edit', [
            'lieu'=>$lieu
        ]);
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
        $lieu = Lieu::find($id);
        $lieu->name = $request->input('name');
        $lieu->save();
        return redirect()->action('LieuController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lieu = Lieu::find($id);
        $lieu->delete();
        return redirect()->action('LieuController@index');
    
    }
}
