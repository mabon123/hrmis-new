<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'nationality';
	public function residencemembers()
    {
		return $this->hasMany('App\Models\Residencemember');
       
    }
}
