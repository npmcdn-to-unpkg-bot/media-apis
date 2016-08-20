<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/**
 * WHOLE JS APPLICATION INTERFACE
 */

Route::get('/material', 'HomeController@material');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::auth();

/**
 * ----------------------------------------------
 * 
 * APIS 
 *
 * ----------------------------------------------
 */



/**
* Customer management
*/

Route::get('/customers', 'CustomerController@customers');

Route::patch('/customer', 'CustomerController@update');
/**
 *
 * /project entry Routes
 *
*/

Route::post('/project', 'ProjectController@create');

Route::patch('/project/{id}', 'ProjectController@update');

Route::delete('/project', 'ProjectController@delete');

//TUTO BUDES NAJVIAC POUZIVAT, VRATI VSETKY INFO K PROJEKTU !,
Route::get('/project/{id}/detail', 'ProjectController@detail');

// RETURNS ALL PROJECTS
Route::get('/projects', 'ProjectController@projects');

/**
*
* Revenues
* table
* Every project has revenue, it is simply there, it can be createdOrUpdated
* if entity exists, it will be updated, if not, it will be created!
*/

// called from detail view
Route::patch('/revenue/{id}', 'RevenueController@update');
Route::post('/revenue', 'RevenueController@create');

/**
*
* Costs
* table
* Every project can have costs, it can be createdOrUpdated
*/

//called from detail view
Route::patch('/cost/{id}', 'CostController@update');
Route::post('/cost', 'CostController@create');

/**
*
* Files
* table
* Every project can have files attached, it can be created(uploaded) | updated
*/

// NIE som si isty ci je to cele dorobene !!!
Route::post('/file', 'FileController@create');

Route::patch('/file', 'FileController@update');

Route::delete('/file', 'FileController@delete');

Route::get('/file/{id}/download', 'FileController@download');

/**
*
* Comments
* table
* Every project can have comments from users.
*/

Route::post('/comment', 'CommentController@create');

//TODO
Route::patch('/comment', 'CommentController@update');
//TODO
Route::delete('/comment', 'CommentController@delete');
