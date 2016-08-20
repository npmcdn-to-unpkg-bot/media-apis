<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Comment;

class CommentController extends Controller
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
    
    public function create (Request $request){
    	$this->validate($request, [
    		"body" => 'required',
		]);

    	$comment = new Comment;
    	$comment -> body = $request -> body;
    	$comment -> user_id = \Auth::user()->id;
    	$comment -> project_id = $request-> project_id;
    	$comment -> save();
    	return response()->json(['feedback' => 'created'], 201);
    }
}
