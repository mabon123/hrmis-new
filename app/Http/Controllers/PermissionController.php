<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Permission;

class PermissionController extends Controller
{
	//
	public function __construct()
	{
        $this->middleware('auth');
		$this->middleware('role:administrator');
	}


    // Display all permissions
    public function index()
    {
        $permissions = Permission::latest('permission_id')->paginate(10);

    	return view('admin.permissions.index', compact('permissions'));
    }


    // Create new permission
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'permission_slug' => 'required|max:50',
    	]);

    	// Get last permission info
    	$lastPermission = Permission::latest('permission_id')->first();

    	$permissionData = $request->all();
    	$permissionData['permission_id'] = !empty($lastPermission) ? ($lastPermission->permission_id + 1) : 1;
    	$permissionData['active'] = isset($request->active) ? $request->active : 0;
    	
    	Permission::create($permissionData);

    	return redirect()->route('permissions.index', app()->getLocale())->with('success', 'Permission has been created successfully.');
    }


    /**
     * Edit existing permission info
     *
     * @param  Permission  $permission
     */
    public function edit(Permission $permission)
    {
    	return $permission;
    }


    /**
     * Update existing permission info
     *
     * @param  Permission  $permission
     */
    public function update(Permission $permission, Request $request)
    {
    	$permissionData = $request->all();
    	$permissionData['active'] = isset($request->active) ? $request->active : 0;

    	$permission->fill($permissionData)->save();

    	return redirect()->route('permissions.index', app()->getLocale())->with('success', 'Permission has been updated successfully.');
    }


    /**
     * Remove existing permission info
     *
     * @param  Permission  $permission
     */
    public function destroy(Permission $permission)
    {
    	$permission->delete();

    	return $permission;
    }
}
