<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Project;
use App\User;
use App\Customer;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');ß
    }


	/**
	* Validate project data, and store in DB
	* @author sandro
	* @param request
	* 
	* handle
	* PUT REQUEST /create
	*/
    public function create (Request $request){
    	/**
		* @todo nezabudnut na name = create_with_new_customer  | checkbox button
		* @todo vypracovat taketo formulare
    	*/
    	// ak sa vytvara project s novym zakaznikom
    	if(isset($request->create_with_new_customer)){
    		$this->validate($request, [
				// project form
				'title' => 'required',
				'note' => 'required',
				// new customer form
				'customer_name' => 'required',
				'customer_ico' => 'required',
				'customer_dic' => 'required',
				'customer_address' => 'required',
				'customer_contact_person'=> 'required',
				'customer_note' => 'required'
			]);


    		// Create new customer and set the value
    		$customer = new Customer;
    		$customer -> name = $request-> customer_name;
    		$customer -> ico = $request-> customer_ico;
    		$customer -> dic = $request-> customer_dic;
    		$customer -> address = $request-> customer_address;
    		$customer -> contact_person = $request-> customer_contact_person;
    		$customer -> note = $request -> customer_note;
    		$customer -> save(); // save the customer

    		// create project associated to customer
			$project = new Project;
			$project -> title = $request->title;
			$project -> note = $request->note;

			// get record which belongsTo customer and save project!
			$customer->project()->save($project);

            return response()->json(['feedback' => 'created'], 201);


    	}
    	// s vybratim zakaznikom z ponuky existujucich zakaznikov
    	else{
			$this->validate($request, [
				'title' => 'required',
				'note' => 'required',
				'customer_id' => 'required'
			]);
			//dd("hello");
			$project = new Project;
			$project -> title = $request->title;
			$project -> note = $request->note;
			// find customer id by ICO, its unique
			$project -> customer_id = $request->customer_id;
			// save to DB!
			$project -> save();
    	}

      
        session(['message' => 'Projekt bol úspešne založený!']);
        //return redirect()->to("/project/$project->id/detail");
        return response()->json(['feedback' => 'created'], 201);

    }
    /**
    * Project detail, summary handler
    */
    public function detail ($id){
        $project = \App\Project::find($id);
        $costs = $project->costs()->get();
        $revenues = $project->revenues()->get();
        $customer = $project->customer;
        $comments = $project->comments;
        $files = $project->files;
        $revenue_all = 0.0;

        

        foreach ($revenues as $revenue) {
            $revenue_all+= $revenue->cost * $revenue->quantity;
        }

        $cost_all = 0.0;
        foreach ($costs as $cost) {
            $cost_all += $cost->cost;
        }

        //return view('project.detail', compact('project', 'costs', 'revenues', 'customer', 'comments', 'cost_all', 'revenue_all', 'files'));
        return response()->json(['costs' => $costs, 'revenues' => $revenues, 'customer' => $customer, 'comments' => $comments, 'files' => $files],200);
    }

    /**
	* Updates project
    */
    public function update (Request $request, $id){
 
		$this->validate($request, [
			// project form
			'title' => 'required',
			'note' => 'required'
		]);

		$project = Project::find($id);
		$project -> title = $request->title;
		$project -> note = $request->note;
		// save to DB!
		$project -> save();

		
        session(['message' => 'Projekt bol úspešne updatnutý!']);
        //return redirect()->to("/project/$project->id/detail");
        return response()->json(['feedback' => 'created'], 201);
    }

    /**
	* Soft deletes project, project will be put in trash, where can be recovered!
    */

    public function delete (Request $request){
    	$project = Project::find($request->id)->softDelete();
    	$project -> save();
    }


	

	/**
	* COSTS view
	*/
	public function costs ($id){
		$project = Project::find($id);
		$costs = $project->costs()->get();
		return response()->json($costs);
	}

	/**
	 * REVENUES view
	 * 
	 */
	public function revenues ($id){
		$project = Project::find($id);
		$revenues = $project->revenues()->get();
		return response()->json($revenues);
	}

	/**
	 * Handling show all projects
	 */
	public function projects (){
		$projects = Project::orderBy('created_at', 'desc')->get();
		$status = $this->finished();
		//return view('project.projects', compact('projects','status'));
        return response()->json($projects);
	}

	/**
	 * Handling files showing
	 */
	public function files ($id){
		$project = \App\Project::find($id);
		$files = $project->files()->get();

		return response()->json($files);
	}

}
