<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
//use Spatie\Permission\Models\Role;
//use Spatie\Permission\Models\Permission;
//use DB;

use Auth;
use App\Models\Permission;
use App\Models\Role;


class RoleController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator');
        //$this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //$this->middleware('permission:role-create', ['only' => ['create','store']]);
        //$this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //$this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }


    /**
     * Display all user roles
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('role_id','ASC')->paginate(10);

        return view('admin.roles.index',compact('roles'));

        return redirect()->route('page.notfound', app()->getLocale());
    }


    /**
     * Form create new user role
     */
    public function create()
    {
        return view('admin.roles.create');
    }


    /**
     * Store user role
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'role_kh' => 'required|unique:admin_roles,role_kh',
            'role_slug' => 'required|unique:admin_roles,role_slug',
        ]);

        $lastRole = Role::latest('role_id')->first();
        $roleData = $request->all();
        $roleData['role_id'] = !empty($lastRole) ? ($lastRole->role_id + 1) : 1;
        $roleData['active'] = $request->active ? 1 : 0;

        Role::create($roleData);
        $role = Role::latest('role_id')->first();

        // Assign permission(s) to user role
        foreach($roleData as $key => $privillege) {

            if( $privillege == 1 ) {

                $permission = Permission::where('permission_slug', $key)->first();

                if (!empty($permission)) {
                    $role->permissions()->attach($permission->permission_id, ['created_by' => Auth::user()->id]);
                }
            }
        }

        return redirect()->route('roles.index', app()->getLocale())
                         ->with('success', __('validation.add_success'));
    }


    /**
     * Edit user role info
     *
     * @param  Object  Role  $role
     */
    public function edit(Role $role)
    {
        $headerid = $role->role_id;

        return view('admin.roles.edit', compact('headerid', 'role'));
    }


    /**
     * Update user role
     *
     * @param  Object  Role  $role
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'role_kh' => 'required',
            'role_slug' => 'required',
        ]);

        $roleData = $request->all();
        $roleData['active'] = $request->active ? 1 : 0;

        $role->fill($roleData)->save();

        // Assign permission(s) to user role
        $role->permissions()->detach();
        
        foreach($roleData as $key => $privillege) {

            if( $privillege == 1 ) {

                $permission = Permission::where('permission_slug', $key)->first();

                if (!empty($permission)) {
                    $role->permissions()->attach($permission->permission_id, ['created_by' => Auth::user()->id]);
                }
            }
        }

        return redirect()->route('roles.index', app()->getLocale())
                         ->with('success', __('validation.update_success'));
    }


    /**
     * Remove user role
     *
     * @param  Object  Role  $role
     */
    public function destroy(Role $role)
    {
        // Detach permission(s) form user role
        $role->permissions()->detach();

        // Remove user role
        $role->delete();

        return $role;
    }
}