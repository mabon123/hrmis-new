<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Level;
use App\Models\Role;
use App\Models\Staff;
use App\Models\User;

class UserApprovalController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-manage-user-registration', ['only' => ['userNeedApproval']]);
    }

    /**
     * List of all users that need approval from School Director, DoE, PoE
     * or System Administration to access HRMIS system via web & mobile app
     *
     * @return $users
     */
    public function userNeedApproval()
    {
        $roles = Role::activeRole()->pluck('role_kh', 'role_id')->all();
        $levels = Level::active()->pluck('level_kh', 'level_id')->all();

        $curLoginStaff = auth()->user()->staff;
        $userLocationCode = (!empty($curLoginStaff) && !empty($curLoginStaff->currentWorkPlace())) ?
            $curLoginStaff->currentWorkPlace()->location_code : '0';
        $staffs = [];

        $staffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
            ->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
            ->where('hrmis_work_histories.cur_pos', 1)
            ->where('hrmis_work_histories.location_code', $userLocationCode)
            ->select('hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en')
            ->distinct()
            ->pluck('payroll_id');

        $userApprovals = User::leftJoin('admin_user_role as t1', 'admin_users.id', '=', 't1.user_id')
                            ->leftJoin('hrmis_staffs as t2', 'admin_users.payroll_id', '=', 't2.payroll_id')                                              
                            ->when(request()->keyword, function($query) {
                                $query->where('username', 'like', '%'.request()->keyword.'%');
                                $query->orWhere('admin_users.payroll_id', 'like', '%'.request()->keyword.'%');
                            })
                            ->when(request()->name_kh, function($query) {
                                $query->where(DB::raw('CONCAT(surname_kh, " ", name_kh)'), 'like', '%'.request()->name_kh.'%');
                            })
                            ->when(request()->role, function($query) {
                                $query->where('t1.role_id', request()->role);
                            })
                            ->when(request()->level, function($query) {
                                $query->where('admin_users.level_id', request()->level);
                            })
                            ->whereIn('admin_users.payroll_id', $staffs)          
                            ->whereNotIn('admin_users.level_id', [1, 6]) //CPDMO and CPD Provider
                            ->select('admin_users.*')
                            ->distinct()
                            ->orderBy('admin_users.status', 'desc')
                            ->paginate(100);

        return view('admin.users.approval.pending', compact('userApprovals', 'roles', 'levels'));
    }


    public function userNeedApprovalPOE()
    {
        $roles = Role::activeRole()->pluck('role_kh', 'role_id')->all();
        $levels = Level::active()->pluck('level_kh', 'level_id')->all();
        $pro_code = auth()->user()->staff->currentWorkPlace()->pro_code;
        
        $staffs = [];

        $staffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
            ->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
            ->where('hrmis_work_histories.cur_pos', 1)
            ->where('hrmis_work_histories.pro_code', $pro_code)
            ->select('hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en')
            ->distinct()
            ->pluck('payroll_id');

        $userApprovals = User::leftJoin('admin_user_role as t1', 'admin_users.id', '=', 't1.user_id')
                            ->leftJoin('hrmis_staffs as t2', 'admin_users.payroll_id', '=', 't2.payroll_id')                            
                            ->when(request()->keyword, function($query) {
                                $query->where('username', 'like', '%'.request()->keyword.'%')
                                            ->orWhere('admin_users.payroll_id', 'like', '%'.request()->keyword.'%');
                            })
                            ->when(request()->name_kh, function($query) {
                                $query->where(DB::raw('CONCAT(surname_kh, " ", name_kh)'), 'like', '%'.request()->name_kh.'%');
                            })
                            ->when(request()->role, function($query) {
                                $query->where('t1.role_id', request()->role);
                            })
                            ->when(request()->level, function($query) {
                                $query->where('admin_users.level_id', request()->level);
                            })
                            ->whereIn('admin_users.payroll_id', $staffs)
                            ->whereNotIn('admin_users.level_id', [1, 6]) //CPDMO and CPD Provider
                            ->select('admin_users.*')
                            ->distinct()
                            ->orderBy('admin_users.status', 'desc')
                            ->paginate(100);

        return view('admin.users.approval.pending_poe', compact('userApprovals', 'roles', 'levels'));
    }
    /**
     * Function approve user registration account
     *
     * @param  User $user
     */
    public function userApproval(User $user)
    {
        $user->fill([
            'status' => config('constants.CONST_APPROVED'),
            'approver_id' => auth()->user()->id,
            'approved_date' => Carbon::now(),
        ])->save();

        return back()->withSuccess(__('validations.user_approved'));
    }

    /**
     * User reset password form
     *
     * @param  User $user
     */
    public function resetPasswordForm(User $user)
    {
        $headerid = $user->id;

        return view('admin.users.password_reset', compact('headerid', 'user'));
    }
    public function resetPasswordFormPoE (User $user)
    {
        $headerid = $user->id;

        return view('admin.users.password_reset_poe', compact('headerid', 'user'));
    }

    /**
     * Reset user password function
     *
     * @param  User $user
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ], [
            'password.required' => 'សូមបំពេញលេខកូដសម្ងាត់អោយបានត្រឹមត្រូវ',
            'password.confirmed' => 'សូមបំពេញការបញ្ជាក់លេខសម្ងាត់អោយបានត្រឹមត្រូវ',
        ]);

        $user->fill(['password' => bcrypt($request->password)])->save();

        // If system_admin, redirect to user page
        if (auth()->user()->hasRole('administrator')) {
            return redirect()->route('users.index', app()->getLocale())
                ->withSuccess(__('validation.update_success'));
        }

       return redirect()->route('user.need.approval', app()->getLocale())->withSuccess(__('validation.update_success'));
    }

    public function resetPasswordPoe(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ], [
            'password.required' => 'សូមបំពេញលេខកូដសម្ងាត់អោយបានត្រឹមត្រូវ',
            'password.confirmed' => 'សូមបំពេញការបញ្ជាក់លេខសម្ងាត់អោយបានត្រឹមត្រូវ',
        ]);

        $user->fill(['password' => bcrypt($request->password)])->save();

        // If system_admin, redirect to user page
        if (auth()->user()->hasRole('administrator')) {
            return redirect()->route('users.index', app()->getLocale())
                ->withSuccess(__('validation.update_success'));
        }

        return redirect()->route('user.need.approvalpoe', app()->getLocale())->withSuccess(__('validation.update_success'));

    }
}