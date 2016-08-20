<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use \App\Customer;

class CustomerController extends Controller
{
    //

    public function  customers (){
    	$customers = Customer::all();
    	//$projects = Customer::find(1)->allProjects()->get();
 
    	return response()->json($customers);
    }

    public function update (Request $request){
        $this->validate($request, [
            'customer_name' => 'required',
            'customer_ico' => 'required',
            'customer_dic' => 'required',
            'customer_address' => 'required',
            'customer_contact_person'=> 'required',
            'customer_id' => 'required',
            'customer_note' => 'required'
        ]);

        $customer = Customer::find($request->customer_id);
        $customer ->name= $request->customer_name;
        $customer ->ico = $request->customer_ico;
        $customer ->dic = $request->customer_dic;
        $customer ->address = $request->customer_address;
        $customer ->contact_person = $request->customer_contact_person;
        $customer ->note = $request->customer_note;
        $customer->save();

        session(['update_status' => 'Informácie úspešne aktualizované!']);

        return response()->json(['feedback' => 'updated'], 201);
        
    }
}
