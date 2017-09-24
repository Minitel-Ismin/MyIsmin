<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Evenement;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Lieu;
use App\Assos;
use App\ICS;
use App\User;

class EventController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$events = Evenement::where ( 'start', '>', (new \DateTime ('yesterday')) )->get ();
		// dd($events[0]->);
		return view ( 'evenements.index', [ 
				'events' => $events 
		] );
	}
	public function getall() {
		if(Auth::user()){
			$events = Evenement::with ( 'lieu','assos' )->where ( 'start', '>', (new \DateTime ('first day of')) )->get ();
			
		}else{
			$salle_reu_id = Lieu::where('name', "=", "Salle de réu")->get()[0]->id;
			$events = Evenement::with ( 'lieu','assos' )->where ( 'start', '>', (new \DateTime ('first day of')) )->where('lieu_id','=',$salle_reu_id)->get ();
			
		}
		return $events->toJson ();
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$lieus = Lieu::all ();
// 		dd($request->session ()->pull ( 'error', ''));
		return view ( 'evenements.add', [ 
				'lieus' => $lieus,
				"title" => $request->session ()->pull ( 'title', ' '),
				"lieu_s" => $request->session ()->pull ( 'lieu_s', ' '),
				"start" => "",
				"end" => "",
				"desc" => $request->session ()->pull ( 'desc', ''),
				"errors" => $request->session ()->pull ( 'error', []),
				"organisateurs" => Assos::all(),
				"organisateur_s" =>$request->session ()->pull ( 'orga_s', ' '),
		] );
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$errors =[];

		$user = Auth::user ();
		$eventStart = \DateTime::createFromFormat ( 'd/m/Y H:i', $request->input ( 'start' ) );
		$eventEnd = \DateTime::createFromFormat ( 'd/m/Y H:i', $request->input ( 'end' ) );
		
		$periodicite = $request->input('periodicite');

		$lieu = Lieu::find ( $request->input ( 'lieu' ) );
		if($lieu == null){
			$lieu = new Lieu();
			$lieu->name = $request->input('lieu');
			$lieu->save();
		}
		
		$orga_id = $request->input( 'orga' );
		if($orga_id != 0){
			$orga = Assos::find($orga_id);
		}
		
		
		if ($eventStart > $eventEnd) {

// 			$request->session ()->flash ( 'error', 'La date de début doit être avant la date de fin' );
			$errors[] = 'La date de début doit être avant la date de fin';
		}


		//verification periodicite
		if($periodicite!='none'){
			$endPeriodicite = \DateTime::createFromFormat ( 'd/m/Y H:i', $request->input ( 'end-periodicite' ) );
			if($endPeriodicite < $eventEnd){
				$errors[] = 'La date de fin de periodicité doit être après la fin du premier evenement';
			}else{
				$diff = $endPeriodicite->diff(new \DateTime('now'));
				if(intval($diff->format("%m")) + intval($diff->format("%y")*12)> 9){
					$errors[] = 'La date de fin de periodicité est trop lointaine';		
				}
			}
			//construction de la table des évènements :
			if($periodicite == 'mensuelle'){
				$interval = new \DateInterval('P4W');
			}else if($periodicite=="bimensuelle"){
				$interval = new \DateInterval('P2W');
			}else if ($periodicite=="hebdomadaire"){
				$interval = new \DateInterval('P1W');
			}
		}

		

		$curDate = $eventStart;
		do{
			$event = new Evenement ();
			$event->title = $request->input ( 'title' );
			
			$event->start = $curDate;
			$event->end = $eventEnd;
			$event->description = $request->input ( 'description' );

			if(DB::table('evenements')
					->where([['start', '<=', $event->start],['end', '>=', $event->start],['lieu_id','=',$lieu->id]])
					->orwhere([['start', '<=', $event->end],['end', '>=', $event->end],['lieu_id','=',$lieu->id]])
					->first() != null) {		

		// 			$request->session ()->flash ( 'error',"Un évènement est déjà prévu à la ".$lieu->name." sur ce créneau" );
				$errors[] = "Un évènement est déjà prévu à la ".$lieu->name." sur ce créneau" ;
			}


			if (count ( $errors )) {
				$request->session ()->flash ( 'title',$event->title);
					
				$request->session ()->flash ( 'lieu_s',$request->input ( 'lieu' ));
				$request->session()->flash('organisateur_s', $request->input('orga'));
				$request->session ()->flash ( 'desc',$event->description);
				$request->session ()->flash ( 'error', $errors);
				return redirect()->action('EventController@create');
			} 
	
			$event->lieu ()->associate ( $lieu );
			if($orga_id != 0){
				$event->assos()->associate($orga);
			}else{
				$event->assos_id = 0;
			}
			$user->events ()->save ( $event );
			if($periodicite!='none'){
				$curDate->add($interval);
				$eventEnd->add($interval);
			}
			

		}while($periodicite!='none' && $endPeriodicite>$curDate);

		return redirect ()->action ( 'EventController@index' );
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request ,$id) {
		$event = Evenement::find ( $id );
		$lieus = Lieu::all ();
		$orgas = Assos::all();
		$errors = $request->session ()->pull ( 'error', []);
		if($event->assos){
			$orga_id = $event->assos->id;
		}else{
			$orga_id = 0;
		}
		if($errors != []){
			return view( 'evenements.edit', [
					"id" => $event->id,
					"title" => $event->title,
					"lieus" => $lieus,
					"lieu_s" => $event->lieu->id,
					"organisateurs"=>$orgas,
					"organisateur_s"=>$orga_id,
					"start" => (new \DateTime ( $event->start ))->format ( "d/m/Y H:i" ),
					"end" => (new \DateTime ( $event->end ))->format ( "d/m/Y H:i" ),
					"desc" => $event->description,
					"errors" => $errors
				]
			);
		}
		
		return view ( 'evenements.edit', [ 
				"id" => $event->id,
				"title" => $event->title,
				"lieus" => $lieus,
				"lieu_s" => $event->lieu->id,
				"organisateurs"=>$orgas,
				"organisateur_s"=>$orga_id,
				"start" => (new \DateTime ( $event->start ))->format ( "d/m/Y H:i" ),
				"end" => (new \DateTime ( $event->end ))->format ( "d/m/Y H:i" ),
				"desc" => $event->description,
				"errors" => []
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
		
		$errors = [];
		$event = Evenement::find ( $id );
		$event->title = $request->input ( 'title' );
		$event->start = \DateTime::createFromFormat ( 'd/m/Y H:i', $request->input ( 'start' ) );
		$event->end = \DateTime::createFromFormat ( 'd/m/Y H:i', $request->input ( 'end' ) );
		$event->description = $request->input ( 'description' );
		$lieu = Lieu::find ( $request->input ( 'lieu' ) );

		if($lieu == null){
			$lieu = new Lieu();
			$lieu->name = $request->input('lieu');
			$lieu->save();
		}


		$orga_id = $request->input('orga');
		if($orga_id !=0){
			$orga = Assos::find($orga_id);
		}
		
		if ($event->start > $event->end) {
			$errors [] = "La date de début doit être avant la date de fin";
		}
		
		if(DB::table('evenements')
			->where([['start', '<', $event->start],['end', '>', $event->start],['lieu_id','=',$lieu->id]])
			->orwhere([['start', '<', $event->end],['end', '>', $event->end],['lieu_id','=',$lieu->id]])
			->first() != null) {
	
				// 			$request->session ()->flash ( 'error',"Un évènement est déjà prévu à la ".$lieu->name." sur ce créneau" );
				$errors[] = "Un évènement est déjà prévu à la ".$lieu->name." sur ce créneau" ;
			}
	
		if (count ( $errors )) {
			$request->session ()->flash ( 'title',$event->title);
				
			$request->session ()->flash ( 'lieu_s',$request->input ( 'lieu' ));

			$request->session()->flash('organisateur_s', $request->input('orga'));
			$request->session ()->flash ( 'desc',$event->description);
			$request->session ()->flash ( 'error', $errors);
			return redirect()->action('EventController@edit', ["id"=>$id]);
		}
		
		
		if($orga_id != 0){
			$event->assos()->associate($orga);
		}else{
			$event->assos_id = 0;
		}
			
		$event->lieu ()->associate ( $lieu );
		$event->save ();
		return redirect ( '/admin/event' );
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$event = Evenement::find ( $id );
		$event->delete ();
		return redirect ( '/admin/event' );
	}

	public function ics($token){
		$user = User::where('ics_token','=', $token)->get();
		if(count($user)==0){
			abort(500);
		}

		$events = Evenement::where ( 'start', '>', (new \DateTime ('first day of')) )->with(['lieu', 'assos'])->get ();
		// $events = $events->toArray();
		$icsArray = [];

		foreach($events as $event){
			$icsArray[] = [
				"location"=> $event->lieu->name,
				"description"=> $event->description,
				"dtstart"=>$event->start,
				"dtend"=>$event->end,
				"summary"=>$event->assos->name,
			];
		}
		$ics = new ICS($icsArray);

		return response($ics->to_string())
			->header('Content-Type', 'text/calendar; charset=utf-8')
			->header('Content-Disposition', 'attachement; filename=invite.ics');
	}

	public function generateIcs(){
		$user = Auth::user();
		if($user->ics_token==""){
			$token = str_random(30);
			$user->ics_token = $token;
			$user->save();
		}

		
		$url = action('EventController@ics', ["token"=>$user->ics_token]);
		return response($url);
	}


	
}
