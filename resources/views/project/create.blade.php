@extends('layouts.app')

@section('content')


<h3>Nový projekt</h3>

<form action="{{url('/project')}}" method="POST" class="form">
	{{ csrf_field() }}

	<div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
		<label class="control-label" for="title">Názov projektu</label>
		<input type="text" id="title" value="{{old('title')}}" class="form-control" name="title">
	</div>

	<div class="form-group {{ $errors->has('note') ? ' has-error' : '' }}" id="dynamic">
		<label class="control-label" for="note">Poznámka</label>
		<textarea name="note" id="note" value="{{old('note')}}"  class="form-control"></textarea>
	</div>
	
	<div class="form-group">
		<label for="customer">Zákazník</label>
			<select class="form-control" id="customer" name="customer_id">
			@foreach ($customers as $customer)
			  <option value="{{$customer->id}}">{{$customer->name}}</option>
		  	@endforeach
			</select>

	</div>
	

	<div class="form-group" >
		<label for="new_customer" class="checkbox-inline">
			<input type="checkbox" {{old('create_with_new_customer') ? 'checked' : ''}} id="new_customer" value="new_customer" name="create_with_new_customer">Nový zákazník
		</label>
	</div>
	


	<div id="new-customer-form" style="display:none">
		<fieldset>
			<legend>Nový zákazník</legend>
			<div class="form-group {{ $errors->has('customer_name') ? ' has-error' : '' }}">
				<label class="control-label" for="customer_name">Meno</label>
				<input type="text" value="{{old('customer_name')}}" id="customer_name" class="form-control" name="customer_name">
			</div>
			
			<div class="form-group {{ $errors->has('customer_ico') ? ' has-error' : '' }}">
				<label class="control-label" for="customer_ico">IČO</label>
				<input type="text" value="{{old('customer_ico')}}" id="customer_ico" class="form-control" name="customer_ico">
			</div>

			<div class="form-group {{ $errors->has('customer_dic') ? ' has-error' : '' }}">
				<label class="control-label" for="customer_dic">DIČ</label>
				<input type="text" value="{{old('customer_dic')}}" id="customer_dic" class="form-control" name="customer_dic">
			</div>

			<div class="form-group {{ $errors->has('note') ? ' has-error' : '' }}">
				<label class="control-label" for="customer_address">Adresa</label>
				<input type="text" value="{{old('customer_address')}}" id="customer_address" class="form-control" name="customer_address">
			</div>

			<div class="form-group {{ $errors->has('customer_contact_person') ? ' has-error' : '' }}">
				<label class="control-label" for="customer_contact_person">Kontaktná osoba</label>
				<input type="text" value="{{old('customer_contact_person')}}" id="customer_contact_person" class="form-control" name="customer_contact_person">
			</div>
				
			<div class="form-group {{ $errors->has('customer_note') ? ' has-error' : '' }}">
				<label class="control-label" for="customer_note">Poznámka</label>
				<textarea value="{{old('customer_note')}}" id="customer_note" class="form-control" name="customer_note"></textarea>
			</div>
		</fieldset>
	</div>

		<div class="form-group">
			<input type="submit" value="Uložiť" class="btn btn-primary">
		</div>
</form>

	<script type="text/javascript">

		//var new_customer = document.getElementById("new_customer");
		var new_customer = document.querySelector('#new_customer');
		console.log(new_customer.checked);

		if(new_customer.checked){
			document.getElementById('new-customer-form').style.display = '';
		}

		new_customer.addEventListener('click', function(e){
			if(e.target.checked){
				document.getElementById('new-customer-form').style.display = '';
			}else{
				document.getElementById('new-customer-form').style.display = 'none';
			}
		});
		
	</script>

@endsection