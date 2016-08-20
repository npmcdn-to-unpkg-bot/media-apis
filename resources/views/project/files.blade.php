@extends('layouts.app')


@section('content')
<ul class="nav nav-pills">
	<li><a href="{{ url("/project/$project->id/detail") }}">Vsetko</a></li>
	<li><a href="{{ url("/project/$project->id/revenues") }}">Prímy</a></li>
	<li><a href="{{ url("/project/$project->id/costs") }}">Náklady</a></li>
	<li class="active"><a href="{{ url("/project/$project->id/files") }}">Súbory</a></li>
</ul>
<div class="panel panel-info" style="margin-top:25px">	
	<div class="panel-heading">
		<h3 class="panel-title">Súbory</h3>
	</div>
	<div class="panel-body">	
		<ul class="list-group">
			@foreach($files as $file)

			<a class="list-group-item" download href="{{ url("/file/$file->id/download") }}"> {{$file->tag}} </a>
			
			@endforeach
		</ul>

		<form action="{{url('/file')}}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="path">Subor</label>
				<input type="file" id="path" name="path" class="form-control">

			</div>

			<div class="form-group">
				<label for="tag">Tag</label>
				<input type="text" id="tag" name="tag" class="form-control">
			</div>

			<input type="hidden" name="project_id" value="{{$project->id}}">

			<div class="form-group">
				<input type="submit" value="Ulozit" class="btn btn-primary">
			</div>
		</form>

		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>
@endsection