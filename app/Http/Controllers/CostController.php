<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Cost;

class CostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
	/**
	* Cost handler, create or update
	* (náklady)
	*/
  //   public function create (Request $request){
  //   	$this->validate($request, [
  //   		"item" => 'required',
  //   		"cost" => 'required',
  //   		"supplier" => 'required',
  //   		"project_id" => "required"
		// ]);

  //   	//$cost = Cost::find($id);
 
		// $newCost = new Cost;
  //   	$newCost ->item = $request->item;
  //   	$newCost ->cost = $request->cost;
  //   	$newCost ->supplier = $request ->supplier;
  //   	// hidden input!
  //   	$newCost ->project_id = $request ->project_id;
  //   	$newCost ->save();

  //       return response()-json(['feedback' => 'created'], 201);

  //   }

  //   public function update (Request $request, $id){

  //   	$this->validate($request, [
  //   		"uitem" => 'required',
  //   		"ucost" => 'required',
  //   		"usupplier" => 'required'
		// ]);

  //   	$cost = Cost::find($id);

  //   	if($cost == null){
  //   		return back();
  //   	}

  //   	$cost ->item = $request->uitem;
  //   	$cost ->cost = $request->ucost;
  //   	$cost ->supplier = $request ->usupplier;
  //   	$cost ->save();

  //       return response()->json(['feedback' => 'updated'], 201);
  //   }

    public function createOrUpdate (Request $request){

      $this->validate($request,[
        "rows.*.id" => 'required',
        "rows.*.item" => 'required',
        "rows.*.supplier" => 'required',
        "rows.*.cost" => 'required',
        "rows.*.project_id" => 'required'
      ]);

        $count = count($request->rows());
        $feedback = 0;
      foreach ($request->rows as $row) {
        $cost = Cost::where('id', $row->id)->first();
        if($cost !== null){
            //update
            $cost->update($row);
        }else{
            //create
            Cost::create($row);
            $feedback++;
        }
      }
        return response()->json(['feedback' => "$count / $feedback succesfuly created or updated"]);
    }
}
