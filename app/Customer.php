<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * Get the project record associated with the customer.
     */
    public function project()
    {
        return $this->hasOne('App\Project');
    }

    /**
     *  
     */
    public function allProjects (){
    	return $this->hasMany('App\Project', 'customer_id');
    	
    }

    
}
