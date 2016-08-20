@extends('layouts.app')

@section('content')

{{--<div class="panel panel-info">
	<div class="panel-heading">Projekt <i>#{{ $project->id }}</i></div>
	<div class="panel-body">
		<div class="list-group">
			<li class="list-group-item">{{ $project->title }}</li>	
			<li class="list-group-item">{{ $project->note }}</li>	
			<li class="list-group-item">{{ $project->customer_id }}</li>
		</div>
	</div>
</div>--}}

<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Projekt {{ $project->title }} - <i>#{{ $project->id }}</i></h3>
  </div>
  <div class="panel-body">

  	<div class="panel panel-default">
	  	<div class="panel-heading">Poznamka</div>
	    <div class="panel-body">{{$project->note}}</div>
    </div>
  	<div class="panel panel-default">
	  	<div class="panel-heading">Pre zakaznika </div>
	    <div class="panel-body">
	    	<ul class="list-group">
    		
				<li class="list-group-item">Meno: {{$customer->name}}</li>
				<li class="list-group-item">ICO: {{$customer->ico}}</li>
				<li class="list-group-item">DIC: {{$customer->dic}}</li>
				<li class="list-group-item">Kontaktna osoba: {{$customer->contact_person}}</li>
				<li class="list-group-item">Projekt: {{$project->title}}</li>

	    	</ul>

	    </div>
    </div>
  	<div class="panel panel-default">
	  	<div class="panel-heading">Naklady </div>
	    <div class="panel-body">
	    	<table class="table table-striped">
    			<thead>
    				<th>polozka</th>
    				<th>suma</th>
    				<th>dodavatel</th>
    				<th>projekt id</th>
    			</thead>
	    	@foreach ($costs as $cost)
    			<tr>
    				<td>{{$cost->item}}</td>
    				<td>{{$cost->cost}}</td>
    				<td>{{$cost->supplier}}</td>
    				<td>{{$cost->project_id}}</td>
    			</tr>
	    	@endforeach
	    	</table>
	    </div>
    </div>
	
  	<div class="panel panel-default">
	  	<div class="panel-heading">Primy </div>
	    <div class="panel-body">
	    	<table class="table table-striped">
    			<thead>
    				<th>polozka</th>
    				<th>mnozstvo</th>
    				<th>jedn. cena</th>
    				<th>projekt id</th>
    			</thead>
	    	@foreach ($revenues as $revenue)
    			<tr>
    				<td>{{$revenue->item}}</td>
    				<td>{{$revenue->quantity}}</td>
    				<td>{{$revenue->cost}}</td>
    				<td>{{$revenue->project_id}}</td>
    			</tr>
	    	@endforeach
	    	</table>
	    </div>
    </div>

  </div>
</div>

@endsection

