<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'religions';
	
	public function residencemembers()
    {
		return $this->hasMany('App\Models\Residencemember');
       
    }
}
