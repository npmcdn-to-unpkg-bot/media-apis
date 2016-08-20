<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\File;
class FileController extends Controller
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
    
    public function create (Request $request){
    	$this->validate($request, [
			'path' => 'required',
			'tag' => 'required',
			'project_id' =>'required'
		]);


    	//$file = new File;
    	//\App\Project::all()->last()->id; last id of current file
    	$incomingFile = $request->file('path');
    	if ($incomingFile->isValid()) {
   			$hash = md5_file($request->file('path'), false);

   			//chceck if files exists
	    	if(File::where('path',$hash.'.'.$incomingFile->getClientOriginalExtension())->exists()){
    			return back()->withErrors(['er'=>'Subor uz je priradený']);
    		}
    		
    		$incomingFile->move('../resources/uploads', $hash.'.'.$incomingFile->getClientOriginalExtension());



    		$store = new File;
    		$store -> tag = $request->tag;
    		$store -> path = $hash.'.'.$incomingFile->getClientOriginalExtension();
    		$store -> project_id = $request->project_id;
    		$store -> save();
    		return response()->json(['feedback' => 'created'], 201);

		}

    }

    public function download ($id){
		//PDF file is stored under project/public/download/info.pdf

	    //get tag of downloading file
	    $f = File::find($id);

	    $file= '../resources/uploads/'.$f->path;

	    $content_type = mime_content_type($file);

	    $ext = pathinfo($f->path, PATHINFO_EXTENSION);

	    $headers = array(
	              "Content-Type: $content_type",
	            );

	    return \Response::download($file, $f->tag.'.'.$ext , $headers);
    }
}
