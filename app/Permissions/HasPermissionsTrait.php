<?php

namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait {

    /**
     * Assign permission to user
     * 
     * @param  array $permissions
     */
    public function givePermissionsTo(... $permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        dd($permissions);

        if ($permissions === null) {
          return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }


    /**
     * Withdraw permission from user
     * 
     * @param  array $permissions
     */
    public function withdrawPermissionsTo( ... $permissions )
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);

        return $this;
    }

    
    /**
     * Reassign user permission
     * 
     * @param  array $permissions
     */
    public function refreshPermissions( ... $permissions )
    {
        $this->permissions()->detach();

        return $this->givePermissionsTo($permissions);
    }


    /**
     * Check if user has permission
     * 
     * @param  string  $permission
     * @return boolean
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }


    /**
     * Check if this user role has permission
     * 
     * @param  string  $permission
     * @return boolean
     */
    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {

            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }


    /**
     * Check if user has this role assigned
     * 
     * @param  array  $roles (role_slug)
     * @return boolean
     */
    public function hasRole( ... $roles )
    {
        foreach ($roles as $role) {

            if ($this->roles->contains('role_slug', $role)) {
                return true;
            }
        }

        return false;
    }


    // Relationship between user and role
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'admin_user_role', 'user_id', 'role_id');
    }


    // Relationship between user and permission
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'admin_user_permission', 'user_id', 'permission_id');
    }

    
    /**
     * Check if user has permission
     * 
     * @param  string  $permission (permission_slug)
     */
    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('permission_slug', $permission->permission_slug)->count();
    }

    
    /**
     * Get all permissions
     * 
     * @param  array  $permissions
     */
    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('permission_slug', $permissions)->get();
    }

}
