@extends('layouts.app')


@section('content')
	
<ul class="nav nav-pills">
	<li ><a href="{{ url("/project/$project->id/detail") }}">Všetko</a></li>
	<li><a href="{{ url("/project/$project->id/revenues") }}">Prímy</a></li>
	<li class="active"><a href="{{ url("/project/$project->id/costs") }}">Náklady</a></li>
	<li><a href="{{ url("/project/$project->id/files") }}">Súbory</a></li>
	</li>
</ul>


<div class="panel panel-info" style="margin-top:25px">
  <div class="panel-heading">
    <h3 class="panel-title">Naklady</h3>
  </div>
  <div class="panel-body">
    
				<table class="table">
					<thead>
						<th>polozka</th>
						<th>suma</th>
						<th>dodavatel</th>
						<th></th>
					</thead>
					<tbody>
				
				<?php $sum = 0;?>

		    	@foreach ($costs as $cost)
					<tr {{--class='clickable-row' data-href='/revenue/{{$cost->id}}'--}}>
						<td id="item-{{$cost->id}}">{{$cost->item}}</td>
						<td id="cost-{{$cost->id}}">{{$cost->cost}}</td>
						<td id="supplier-{{$cost->id}}">{{$cost->supplier}}</td>
						{{-- <td id="project_id-{{$cost->id}}">{{$cost->project_id}}</td> --}}
						<td><button class="edit-btn btn btn-xs btn-info" data-id="{{$cost->id}}" data-toggle="modal" data-target="#myModal">edit</button></td>
					</tr>
					<?php $sum += $cost->cost; ?>
		    	@endforeach
		   
				<tr class="info"><td><b>SPOLU</b></td><td>{{$sum}}</td><td></td><td></td></tr>
			
		    	<tr>
		    		<form action="/cost" method="POST">
					{{ csrf_field() }}
		    		<td><input type="text" name="item" placeholder="Polozka" class="form-control"></td>
		    		<td><input type="text" name="cost" placeholder="Suma" class="form-control"></td>
		    		<td><input type="text" name="supplier" placeholder="dodavatel" class="form-control"></td>
		    		<td><input type="submit" value="pridat" class="btn btn-primary btn-md"></td>
		    		<input type="hidden" name="project_id" value="{{$project->id}}">
		    		</form>
		    	</tr>

	    			
		    	</tbody>
			</table>

  </div>
</div>

<!-- Button trigger modal -->

<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        
		<form id="editform" method="POST">
			{{ csrf_field() }}
			<input type="hidden" value="PATCH" name="_method">
			

			<div class="form-group">
				<input type="text" id="uitem" name="uitem" class="form-control">
				<input type="text" id="ucost" name="ucost" class="form-control">
				<input type="text" id="usupplier" name="usupplier" class="form-control">
				
			</div>
			<div class="form-group">
				
			</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Spat</button>
        <input type="submit" class="btn btn-primary" value="Ulozit zmeny">
      </div>
      </form>
  		<script>
			  $('.edit-btn').click(function(event){
				var id = $(this).data('id');
				$('#editform').attr('action', '{{url('/cost/')}}'+id);


	    		event.preventDefault();
		    	var old_item = $("#item-"+id).html();
		    	//$("#item-"+id).html('<input type="text" class="form-control" name="uitem">');

		    	var old_cost = $("#cost-"+id).html(); 
		    	//$("#cost-"+id).html('<input type="text" class="form-control"  name="ucost" value="'+old_cost+'">');
		   	
		   		var old_supplier = $("#supplier-"+id).html();
		   		//$("#supplier-"+id).html('<input type="text" class="form-control" name="usupplier"  value="'+old_supplier+'">');

		   		$("#uitem").attr('value',(old_item));

		   		$("#ucost").attr('value',(old_cost));

		   		$('#usupplier').attr('value',(old_supplier));

			});
		</script>	
    </div>
  </div>
</div>

@endsection