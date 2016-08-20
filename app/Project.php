<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{	

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the customer record associated with the project.
 	*/	
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    /**
     * Return all revenues for project
     */
    public function totalRevenue (){
        $totalRevenue = 0.0;
        foreach ($this->revenues as $revenue) {
            $totalRevenue+= $revenue->cost * $revenue->quantity;
        }
        return $totalRevenue;
    }
    /**
     * return all costs for project
     */
    public function totalCost(){
        $totalCost = 0.0;
        foreach ($this->costs as $cost) {
            $totalCost+= $cost->cost;
        }
        return $totalCost;
    }

    /**
     * Is completed, return if project was finished
     */
    public function isCompleted (){
        if($this->completed){
            return 'true';
        }else{
            return 'false';
        }
        
    }

    /**
     * Get the comments for the blog post.
     */
    public function costs()
    {
        return $this->hasMany('App\Cost', 'project_id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function files()
    {
        return $this->hasMany('App\File');
    }
    /**
     * Get the comments for the blog post.
     */
    public function revenues()
    {
        return $this->hasMany('App\Revenue');
    }

    /**
     * Get the comments for the blog post.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
