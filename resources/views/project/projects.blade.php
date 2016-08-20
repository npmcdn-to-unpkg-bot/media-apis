@extends('layouts.app')

@section('content')
	
	<h3><a href="{{ url('/projects')}}">Projekty</a></h3>

	<form action="{{url('/project/find')}}" method="GET" class="form-inline">
		<div class="form-group ">
			<input type="text" name="find" placeholder="Názov projektu" class="form-control">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-md btn-primary">Hľadať</button>
		</div>
	</form>

	<div style="margin-top:2em;" class="progress" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$status == 100 ? 'Všetky projekty sú hotové!' : ((int)$status)."% projektov je hotových"}}">
  		<div class="progress-bar {{$status == 100 ? 'progress-bar-success' : ''}} {{$status < 50 ? 'progress-bar-warning' : ''}}" style="width:{{$status}}%"></div>
	</div>

	<ul class="list-group">
	@foreach($projects as $project)		
			<a href="{{ url("/project/$project->id/detail") }}" class="{{$project->completed ? 'list-group-item-success' : ''}} list-group-item lead">
				<span class="text-primary">{{$project->title}}</span> pre <span class="text-info">{{ $project->customer()->get()->first()->name }}</span>
			</a>	
	@endforeach
	</ul>

	{{ $projects->links() }}
@endsection