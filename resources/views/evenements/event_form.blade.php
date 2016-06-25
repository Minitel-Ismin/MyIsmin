@if(count($errors))
				<div class="row">
				<div class="alert alert-danger col-md-12 go-right" role="alert">
					@foreach($errors as $error) <span
						class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="sr-only">Error:</span> {{$error}} 
					</br>
					@endforeach
				</div>
				</div>

				@endif
				</br>
				<div class="form-group">
					<label for="title">Nom de l'évènement</label> <input name="title"
						type="text" class="form-control" value="{{$title}}" required>

				</div>
				<div class="form-group">
					<label for="lieu">Organisateur</label> <select class="form-control"
						id="lieu" name="orga">
						@foreach($organisateurs as $organisateur)
							@if(($organisateur->user && Entrust::hasRole('prez') && Auth::user()->id == $organisateur->user->id)||Entrust::hasRole('admin'))
								<option value={{$organisateur->id}} @if($organisateur_s == $organisateur->id) selected @endif > {{$organisateur->name}}</option>
							@endif
						@endforeach
						<option value="0" @if($organisateur_s==0) selected @endif>Autre</option>
					</select>
				</div>
				<div class="form-group">

					<label for="description">Description</label>
					<textarea name="description" class="form-control" required>{{$desc}}</textarea>
				</div>
				<div class="form-group">

					<label for="lieu">Lieu</label> <select class="form-control"
						id="lieu" name="lieu">
						@foreach($lieus as $lieu)
							<option value={{$lieu->id}} @if($lieu_s == $lieu->id) selected @endif >{{$lieu->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">

					<div class="row">
						<div class='col-sm-12'>
							<label for="start">Debut</label> <input name="start"
								class="form-control" id='datetimepicker' value={{$start}} type="text" required>
						</div>
					</div>
				</div>
				<div class="form-group">

					<div class="row">
						<div class='col-sm-12'>
							<label for="end">Fin</label> <input name="end" class="form-control"
								id='datetimepicker1' value={{$end}} type="text" required>
						</div>
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Enregistrer</button>
				</div>
