<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the whole application
     *
     * @return \Illuminate\Http\Response
     */
    public function material (){
        return view('material');
    }
    // public function yearOverview ($year){

    //     $numberOfProjects = \App\Project::whereBetween('created_at',["$year-01-01", "$year-12-31"])->count();
    //     $projects = \App\Project::whereBetween('created_at',["$year-01-01", "$year-12-31"])->get();
    //     $numberOfCustomers = \App\Customer::whereBetween('created_at',["$year-01-01", "$year-12-31"])->count();
    //     $customers = \App\Customer::whereBetween('created_at',["$year-01-01", "$year-12-31"])->get();

    //     $totalRevenue = 0.0;

    //     foreach ($projects as $project) {
    //         foreach ($project->revenues as $revenue) {
    //             $totalRevenue+=$revenue->cost * $revenue->quantity;
    //         }
    //     }

    //     $totalCost = 0.0;

    //     foreach ($projects as $project) {
    //         foreach ($project->costs as $cost) {
    //             $totalCost+=$cost->cost;
    //         }
    //     }

    //     return view('overview', compact('numberOfCustomers', 'numberOfProjects', 'projects', 'customers', 'totalCost','totalRevenue','hello','year'));

    // }


}
