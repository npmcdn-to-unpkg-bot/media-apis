@extends('layouts.app')


@section('content')

<ul class="nav nav-pills">
	<li ><a href="{{ url("/project/$project->id/detail") }}">Zhrnutie</a></li>
  <li class="active"><a href="{{ url("/project/$project->id/revenues") }}">Prímy</a></li>
  <li><a href="{{ url("/project/$project->id/costs") }}">Náklady</a></li>
  <li><a href="{{ url("/project/$project->id/files") }}">Súbory</a></li>
  </li>
</ul>


<div class="panel panel-info" style="margin-top:25px">
  <div class="panel-heading">
    <h3 class="panel-title">Primy</h3>
  </div>
  <div class="panel-body">
    @if(session()->has('revenue_update_status'))
		<div class="alert alert-dismissible alert-success">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>{{session()->pull('revenue_update_status')}}</strong>
		</div>
    @endif
				<table class="table">
					<thead>
						<th>polozka</th>
						<th>mnozstvo</th>
						<th>jedn. cena</th>
						<th>celkom</th> 
						<th>eddit</th>
					</thead>
					<tbody>
				
				<?php $sum = 0;?>

		    	@foreach ($revenues as $revenue)
					<tr>
						<td id="item-{{$revenue->id}}">{{$revenue->item}}</td>
						<td id="quantity-{{$revenue->id}}">{{$revenue->quantity}}</td>
						<td id="cost-{{$revenue->id}}">{{$revenue->cost}}</td>
						<td>{{ ($revenue->cost * $revenue->quantity) }}</td> 
						<td><button class="edit-btn btn btn-xs btn-info" data-id="{{$revenue->id}}" data-toggle="modal" data-target="#revenueUpdate">edit</button></td>
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
				
			
		    	<tr>
		    		<form action="{{url("/revenue")}}" method="POST">
		    		<input type="hidden" name="project_id" value="{{$project->id}}">
					{{ csrf_field() }}
		    		<td><input type="text" name="item" placeholder="Polozka" class="form-control"></td>
		    		<td><input type="text" name="cost" placeholder="Suma" class="form-control"></td>
		    		<td><input type="text" name="quantity" placeholder="dodavatel" class="form-control"></td>
		    		<td><input type="submit" value="pridat" class="btn btn-primary btn-md"></td>
		    		<td></td>
		    		
		    		</form>
		    	</tr>

		    	</tbody>
			</table>

  </div>
</div>

<div class="modal" id="revenueUpdate">
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
				<input type="text" id="uquantity" name="uquantity" class="form-control">
				<input type="text" id="ucost" name="ucost" class="form-control">
				
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
				$('#editform').attr('action', '{{ url('/revenue/') }}'+id);


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
		</script>	
    </div>
  </div>
</div>
	
@endsection