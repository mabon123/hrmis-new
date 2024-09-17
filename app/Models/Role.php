<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'admin_roles';

    protected $primaryKey = 'role_id';

    protected $fillable = ['role_id', 'role_kh', 'role_en', 'role_slug', 'active'];

    public $timestamps = false;


    // Active role only
    public function scopeActiveRole($query)
    {
    	return $query->where('active', 1);
    }


	// Relationship between role and user
	public function users() 
	{
	  	return $this->belongsToMany('App\Models\User', 'admin_user_role', 'role_id', 'user_id');
	}


	// Relationship between role and permission
	public function permissions()
	{
		return $this->belongsToMany('App\Models\Permission', 'admin_role_permission', 'role_id', 'permission_id');
	}


	public function can($key)
	{
		foreach($this->permissions as $permission) {

	    	if( $permission->permission_slug === $key ) {

	    		return true;
	    	}
    	}

    	return false;
	}
}
