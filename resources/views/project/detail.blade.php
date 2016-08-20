@extends('layouts.app')



@section('content')

@if(session()->has('msg'))
	<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		{{session()->pull('msg')}}
	</div>
@endif

@if($project->completed)
	<div class="alert alert-success"><strong>Projekt je hotový.</strong></div>
@endif

<div class="panel panel-info">
  <div class="panel-body">
	<h3 style="margin-bottom:1em">{{$project->title}}</h3> 
	<form action="{{url("/project/$project->id/completed")}}" class="form" method="POST" id="completed-form">
		{{csrf_field()}}
		<div class="form-group" >
			<label for="completed" class="checkbox-inline">
				<input type="checkbox" id="completed" {{ $project->completed ? 'checked="true"' : '' }} value="completed" name="completed">Projekt je hotový
			</label>
		</div>
		<script>
			$('#completed').click(function(e){
				//console.log('completed');
				$('#completed-form').submit();
			});
		</script>
	</form>

  	<div class="row">
  		<div class="col-md-4 col-xs-12">
  			<ul class="list-group">
  				<li class="list-group-item"><span class="text-primary">Meno:</span> <b>{{$customer->name}}</b></li>
  				<li class="list-group-item"><span class="text-primary">Adresa:</span> {{$customer->address}}</li>
  				<li class="list-group-item"><span class="text-primary">ICO:</span> {{$customer->ico}}</li>
  				<li class="list-group-item"><span class="text-primary">DIC:</span>{{$customer->dic}}</li>

  			</ul>
  		</div>
  		<div class="col-md-4 col-xs-12">
  			<ul class="list-group">
  				<li class="list-group-item"><span class="text-primary">Kontaktná osoba: </span>{{$customer->contact_person}}</li>
  				<li class="list-group-item"><span class="text-primary">Ostatne info: </span>{{$customer->note}}</li>
  			</ul>
  		</div>
		<div class="col-md-4">
  			<ul class="list-group">
  				<li class="list-group-item"><span class="text-primary">Celkové náklady: </span>{{$cost_all}}€</li>
  				<li class="list-group-item"><span class="text-primary">Celkový príjem: </span>{{$revenue_all}}€</li>
  				<li class="list-group-item list-group-item-success"><span class="text-primary">Celkový zisk: </span>{{$revenue_all - $cost_all}}€</li>
  			</ul>
		</div>
  	</div>

			<button class="edit-btn btn btn-lg btn-primary" data-toggle="modal" data-target="#projectUpdate">edit</button>

  </div>
</div>

	


<ul class="nav nav-pills">
	<li class="active"><a href="{{ url("/project/$project->id/detail") }}">Vsetko</a></li>
  <li><a href="{{ url("/project/$project->id/revenues") }}">Prímy</a></li>
  <li><a href="{{ url("/project/$project->id/costs") }}">Náklady</a></li>
  <li><a href="{{ url("/project/$project->id/files") }}">Súbory</a></li>
  </li>
</ul>

<div class="row">
	
	<div class="col-md-4">
    <h3>PRIMY</h3>

    	@if(session()->has('revenue_creation_status'))
			{{session()->pull('revenue_creation_status')}}
    	@endif
		
				<table class="table">
					<thead>
						<th>polozka</th>
						<th>mnozstvo</th>
						<th>jedn. cena</th>
						<th>celkom</th> 
					</thead>
					<tbody>
				
				<?php $sum = 0;?>

		    	@foreach ($revenues as $revenue)
					<tr>
						<td id="item-{{$revenue->id}}">{{$revenue->item}}</td>
						<td id="quantity-{{$revenue->id}}">{{$revenue->quantity}}</td>
						<td id="cost-{{$revenue->id}}">{{$revenue->cost}}</td>
						<td>{{ ($revenue->cost * $revenue->quantity) }}</td> 
					</tr>
					<?php $sum += ($revenue->cost * $revenue->quantity); ?>
		    	@endforeach
    			
    			<tr class="info">
	    			<td><b>SPOLU</b></td>
	    			<td></td>
	    			<td></td>
	    			<td>{{$sum}}</td>
	    			<td></td>
    			</tr>
				
		    	</tbody>
			</table>
	</div>
	<div class="col-md-4">
			{{--++++++++++++++++++++++++++++++++++++--}}
			
			<h3>Náklady</h3>
			<table class="table">
				<thead>
					<th>polozka</th>
					<th>suma</th>
					<th>dodavatel</th>

				</thead>
				<tbody>
			
			<?php $sum = 0;?>

	    	@foreach ($costs as $cost)
				<tr {{--class='clickable-row' data-href='/revenue/{{$cost->id}}'--}}>
					<td id="item-{{$cost->id}}">{{$cost->item}}</td>
					<td id="cost-{{$cost->id}}">{{$cost->cost}}</td>
					<td id="supplier-{{$cost->id}}">{{$cost->supplier}}</td>
				</tr>
				<?php $sum += $cost->cost; ?>
	    	@endforeach
	   
					<tr class="info"><td><b>SPOLU</b></td><td>{{$sum}}</td><td></td></tr>
	    	</tbody>
		</table>
	</div>

	<div class="col-md-4">

		<h3>Súbory</h3>
		<ul class="list-group">
			@foreach($files as $file)

				<a class="list-group-item" download href="{{ url("/file/$file->id/download") }}"> {{$file->tag}} </a>
			
			@endforeach
		</ul>

	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
    	<h3 class="panel-title">Komentáre</h3>
	</div>
  <div class="panel-body">

  	<ul class="list-group">
  	@foreach($comments as $comment)
  	<li class="list-group-item"> <span class="text-primary">{{\App\User::find($comment->user_id)->name}}</span> komentoval/a<br/>  {{$comment->body}}</li>
  	@endforeach
  	</ul>
	<hr>

	<form action="/comment" method="POST">
		{{ csrf_field() }}
		<input type="hidden" value="{{$project->id}}" name="project_id">

		<div class="form-group">
			<label for="comment"></label>
			<textarea name="body" id="comment" class="form-control"></textarea>
		</div>
		<div class="form-group">
			<input type="submit" class="btn-primary" value="Odoslať">
		</div>

	</form>

  </div>
</div>


{{-- MODAL FOR UPDATES --}}
<div class="modal" id="projectUpdate">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Zmena údajov projektu</h4>
      </div>
      <div class="modal-body">
        
		<form action="/project/{{$project->id}}" method="POST">
			{{ csrf_field() }}
			<input type="hidden" value="PATCH" name="_method">
			

			<div class="form-group">
				<input type="text" name="title" value="{{$project->title}}" class="form-control">
				<input type="text" name="note" value="{{$project ->note}}" class="form-control">
				
			</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Späť</button>
        <input type="submit" class="btn btn-primary" value="Uložiť zmeny">
      </div>
      </form>
  		{{-- <script>
			  $('.edit-btn').click(function(event){
				var id = $(this).data('id');
				$('#editform').attr('action', '/revenue/'+id);


	    		event.preventDefault();
		    	var old_item = $("#item-"+id).html();
		    	//$("#item-"+id).html('<input type="text" class="form-control" name="uitem">');

		    	var old_cost = $("#cost-"+id).html(); 
		    	//$("#cost-"+id).html('<input type="text" class="form-control"  name="ucost" value="'+old_cost+'">');
		   	
		   		var old_quantity = $("#quantity-"+id).html();
		   		//$("#supplier-"+id).html('<input type="text" class="form-control" name="usupplier"  value="'+old_supplier+'">');

		   		$("#uitem").attr('value',(old_item));

		   		$("#ucost").attr('value',(old_cost));

		   		$('#uquantity').attr('value',(old_quantity));

			});
		</script>	 --}}
    </div>
  </div>
</div>

@endsection