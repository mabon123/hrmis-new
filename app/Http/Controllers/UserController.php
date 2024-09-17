<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Commune;
use App\Models\District;
use App\Models\Level;
use App\Models\Province;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator');

        //   $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //   $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //   $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //   $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    // public function restrictAccess(){
    //     return view('users.restrict');
    // }
    

    /**
     * Display all user(s)
     */
    public function index()
    {
        $roles = Role::activeRole()->pluck('role_kh', 'role_id')->all();
        $levels = Level::active()->pluck('level_kh', 'level_id')->all();

        $users = User::when(request()->role, function($query) {
                        $query->join('admin_user_role', 'admin_users.id', '=', 'admin_user_role.user_id');
                        $query->where('admin_user_role.role_id', request()->role);
                    })
                    ->when(request()->level, function($query) {
                        $query->where('level_id', request()->level);
                    })
                    ->when(request()->reg_type, function($query) {
                        $query->where('reg_type', request()->reg_type);
                    })
                    ->when(request()->keyword, function($query) {
                        $query->where('username', 'like', '%'.request()->keyword.'%');
                        $query->orWhere('payroll_id', 'like', '%'.request()->keyword.'%');
                    })
                    ->select('admin_users.*')
                    ->latest('id')
                    ->paginate(10);

        return view('admin.users.index', compact('users', 'roles', 'levels'));
    }


    public function getRoles()
    {
        $roles = Role::all();
        return $roles;
    }
    

    /**
     * Form create new user
     */
    public function create()
    {
        $roles = Role::whereNotIn('role_id', [2, 3, 8, 9])->pluck('role_kh', 'role_id')->all();
        $levels = Level::whereNotIn('level_id', [6])->pluck('level_kh', 'level_id')->all();

        return view('admin.users.create', compact('roles', 'levels'));
    }

    private function validateUser(Request $request)
    {
        $request->validate([
            'fullname' => ['required', 'string', 'max:50'],
            'police_id' => ['required'],//'integer'],
            'username' => ['required', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'max:30'],
          
            ],
            [
            'fullname.required' => 'សូមបញ្ចូលឈ្មោះពេញ!',
            'police_id.required' => 'សូមបញ្ចូលអត្តលេខនគរបាលជាតិ!',
            //'police_id.integer' => 'ត្រូវបញ្ចូលអត្តលេខនគរបាលជាតិ​ ជាលេខឡាតាំង!​​ 0-9',
            'username.required' => 'សូមបញ្ចូលឈ្មោះប្រើប្រាស់ប្រព័ន្ធ!',
            'password.required' => 'សូមបញ្ចូលលេខសម្ងាត់!',
            'password.min' => 'ត្រូវបញ្ចូលលេខសម្ងាត់ចាប់ពី​៨តួអក្សរ​ឡើងទៅ',
            'password.max' => 'ត្រូវបញ្ចូលលេខសម្ងាត់ចាប់ពី​៨តួអក្សរ​ឡើងទៅ ៣០​តួអក្សរយ៉ាងច្រើន!',
          
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|min:6|max:30|unique:admin_users',
            'password' => 'required',
            'payroll_id' => 'required|max:20|unique:admin_users',
            'level_id' => 'required',
            'role_id' => 'required',
        ], [
            'payroll_id.unique' => __('validation.unique_payroll'),
            'username.unique' => __('validation.unique_username'),
        ]);

        $userData = $request->all();
        $userData['password'] = Hash::make($request['password']);
        $userData['status'] = config('constants.CONST_APPROVED');
        $userData['approver_id'] = auth()->user()->id;
        $userData['approved_date'] = Carbon::now();
        $userData['reg_type'] = 1;
        $userData['user_type'] = 1;
        $userData['nid_card'] = NULL;
        $userData['provider_id'] = NULL;
        $userData['created_by'] = 1;
        $userData['updated_by'] = 1;
        $userData['gen_dept_id'] = 0;
        $userData['department_id'] = 0;
        
        $user = User::create($userData); // Create new user

        // Assign role to user
        $user->roles()->attach($request->role_id, ['created_by' => auth()->user()->id]);


        return redirect()->route('users.index', app()->getLocale())
                         ->with('success', __('validation.add_success'));
        
    }


    public function show($id)
    {
        //
    }


    /**
     * Edit user info
     * 
     * @param  Object  User  $user
     */
    public function edit(User $user)
    {
        $headerid = $user->id;
        $roles = Role::whereNotIn('role_id', [2, 3, 9])->pluck('role_kh', 'role_id');
        $levels = Level::whereNotIn('level_id', [6])->pluck('level_kh', 'level_id');

        return view('admin.users.edit',compact('headerid', 'user', 'roles', 'levels'));
    }


    /**
     * Udate user info
     * 
     * @param  User    $user
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'username' => 'required',
            'level_id' => 'required',
            'role_id' => 'required',
        ]);

        // Do not validate payroll_id, if CPD Provider
        if ($request->role_id != 3) {
            $request->validate(['payroll_id' => 'required']);
        }

        $userData = $request->all();
        $userData['updated_by'] = Auth::user()->id;
        $userData['level_id'] = $request->level_id;
        $userData['active'] = $request->active ? 1 : 0;
        $userData['reg_type'] = $request->reg_type;
        
        $user->fill($userData)->save();

        // Assign role(s) to user
        $user->roles()->detach();
        $user->roles()->attach($request->role_id, ['created_by' => Auth::user()->id]);

        // Assign permission(s) to user
        $user->permissions()->detach();
        
        foreach($userData as $key => $privillege) {

            if( $privillege == 1 ) {

                $permission = Permission::where('permission_slug', $key)->first();

                if (!empty($permission)) {
                    $user->permissions()->attach($permission->permission_id, ['created_by' => Auth::user()->id]);
                }
            }
        }

        return redirect()->route('users.index', app()->getLocale())
                        ->with('success', __('validation.update_success'));
    }

    /*public function destroy($id)
    {
        $user = User::find($id);
        //$user->delete();
        if ($user->active) {
            $user->active = false;
        } else {
            $user->active = true;
        }
        $user->modifby = Auth::user()->id;
        $user->save();

        return redirect('users')->with('success', 'ទិន្នន័យត្រូវបានកែប្រែរួច!');
    }*/

    /**
     * Disable user account info
     *
     * @param  User $user
     */
    public function disableUser(User $user)
    {
        $active = $user->active ? 0 : 1;

        $user->fill(['active' => $active])->save();

        return redirect()->route('users.index', app()->getLocale())
                         ->withSuccess(__('validation.disable_success'));
    }
}
