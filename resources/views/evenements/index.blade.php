@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{URL::asset('assets/js/jquery.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/datatables.min.js')}}"></script>
<link href="{{URL::asset('assets/css/datatables.min.css')}}"
	rel='stylesheet' type='text/css'>
<link href="{{URL::asset('assets/css/font-awesome.min.css')}}"
	rel='stylesheet' type='text/css'>
<link href="{{URL::asset('assets/css/event.css')}}" rel='stylesheet'
	type='text/css'>

<div class="container">
	<div class="row">


	
		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default panel-table">
				<div class="panel-heading">
					<div class="row">
						<div class="col col-xs-6">
							<h3 class="panel-title">Evenements à venir</h3>
						</div>
						<div class="col col-xs-6 text-right">
							<a href={{URL::to('admin/event/create')}}><button type="button" class="btn btn-sm btn-primary btn-create"> Créer un évènement</button></a>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-list" id="event_list">
						<thead>
							<tr>
								<th><em class="fa fa-cog"></em></th>
								<th class="hidden-xs">ID</th>
								<th>Titre</th>
								<th>Asso</th>
								<th>Description</th>
								<th>Lieu</th>
								<th>Début</th>
								<th>Fin</th>
								<th>Créé par:</th>
							</tr>
						</thead>
						<tbody>
							@foreach($events as $event)
								<tr>
									<td>
										<div class="row">
											<div class="col-md-10">
												<div class="col-md-5">
													<a href="{{URL::to('/admin/event/'.$event->id.'/edit')}}" class="btn btn-default"><em class="fa fa-pencil"></em></a> 
												</div>
												<div class="col-md-5 col-md-offset-1">
													<form method="post" class="" action="{{URL::to('/admin/event/'.$event->id)}}" >
														<div class="">
														<input type="hidden" name="_method" value="DELETE">
														{!! csrf_field() !!}
														<button type="submit" class="btn btn-danger fa fa-trash" style="min-height:34px; min-width:38px"></button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</td>
									<td class="hidden-xs">{{$event->id}}</td>
									
									<td>{{$event->title}}</td>
									@if($event->assos)
										<td>{{$event->assos->name}}</td>
									@else
										<td>Autre</td>
									@endif
									<td>{{$event->description}}</td>
									<td>{{$event->lieu->name}}</td>
									<td>{{$event->start}}</td>
									<td>{{$event->end}}</td>
									<td>{{$event->user->username}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
<!-- 				<div class="panel-footer"> -->
<!-- 					<div class="row"> -->
<!-- 						<div class="col col-xs-4">Page 1 of 5</div> -->
<!-- 						<div class="col col-xs-8"> -->
<!-- 							<ul class="pagination hidden-xs pull-right"> -->
<!-- 								<li><a href="#">1</a></li> -->
<!-- 								<li><a href="#">2</a></li> -->
<!-- 								<li><a href="#">3</a></li> -->
<!-- 								<li><a href="#">4</a></li> -->
<!-- 								<li><a href="#">5</a></li> -->
<!-- 							</ul> -->
<!-- 							<ul class="pagination visible-xs pull-right"> -->
<!-- 								<li><a href="#">«</a></li> -->
<!-- 								<li><a href="#">»</a></li> -->
<!-- 							</ul> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 				</div> -->
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
	
	$(document).ready( function () {
	    $('#event_list').DataTable({
		    "language":{
		    	"sProcessing":     "Traitement en cours...",
		    	"sSearch":         "Rechercher&nbsp;:",
		        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
		    	"sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
		    	"sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
		    	"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
		    	"sInfoPostFix":    "",
		    	"sLoadingRecords": "Chargement en cours...",
		        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
		    	"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
		    	"oPaginate": {
		    		"sFirst":      "Premier",
		    		"sPrevious":   "Pr&eacute;c&eacute;dent",
		    		"sNext":       "Suivant",
		    		"sLast":       "Dernier"
		    	},
		    	"oAria": {
		    		"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
		    		"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
		    	}}}
			    );
	} );
</script>

@endsection

