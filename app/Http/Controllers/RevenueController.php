<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Revenue;

class RevenueController extends Controller
{	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
  	/**
  	* Revenue handler, create or update
  	* (primy)
  	*/

    public function create(Request $request){
    	$this->validate($request, [
    		"item" => 'required',
    		"cost" => 'required',
    		"quantity" => 'required',
    		"project_id" => "required"
		]);

    	// if entity does not exists, create it
		$newRevenue = new Revenue;
    	$newRevenue ->item = $request->item;
    	$newRevenue ->cost = $request->cost;
    	$newRevenue ->quantity = $request ->quantity;
    	// hidden input!
    	$newRevenue ->project_id = $request ->project_id;
    	$newRevenue ->save();

      //\Session::put('revenue_creation_status', 'Položka úspešne vložená.');

      return response()->json(['feedback' => 'created'], 201);
    }

   	public function update (Request $request, $id){
   		//validate request
    	$this->validate($request, [
    		"uitem" => 'required',
    		"ucost" => 'required',
    		"uquantity" => 'required',
		]);

   		$revenue = Revenue::find($id);

   		if($revenue == null){
   			return back();
   		}

    	$revenue ->item = $request->uitem;
    	$revenue ->cost = $request->ucost;
    	$revenue ->quantity = $request ->uquantity;
    	$revenue ->save();

      //\Session::put('revenue_update_status', 'Položka úspešne zmenená.');

      return response()->json(['feedback' => 'created'], 201);
   	}
}
