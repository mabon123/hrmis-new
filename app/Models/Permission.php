<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'admin_permissions';

    protected $primaryKey = 'permission_id';

    protected $fillable = ['permission_id', 'permission_kh', 'permission_en', 'permission_slug', 'active'];

    public $timestamps = false;


    // Relationship between permission and user
    public function users()
    {
    	return $this->belongsToMany('App\Models\User', 'admin_user_permission', 'permission_id', 'user_id');
    }


    // Relationship between permission and role
    public function roles()
    {
    	return $this->belongsToMany('App\Models\Role', 'admin_role_permission', 'permission_id', 'role_id');
    }
}
