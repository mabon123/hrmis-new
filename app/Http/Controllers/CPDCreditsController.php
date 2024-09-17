<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\CPD\Provider;
use App\Models\CPD\ScheduleCourse;
use App\Models\CPD\Course;
use App\Models\CPD\EnrollmentCourse;
use App\Models\Province;
use App\Models\District;
use App\Models\Location;
use App\Models\Staff;

use Illuminate\Http\Request;

class CPDCreditsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('cpd_provider')) {
            $offerings = ScheduleCourse::join('cpd_enrollment_courses as t2', 'cpd_schedule_courses.schedule_course_id', '=', 't2.schedule_course_id')
                ->join('cpd_courses as t3', 'cpd_schedule_courses.cpd_course_id', '=', 't3.cpd_course_id')
                ->select(
                    'cpd_schedule_courses.schedule_course_id',
                    't3.cpd_course_kh',
                    't3.credits',
                    'participant_num',
                    DB::raw('count(t2.payroll_id) as user_count'),
                    DB::raw('SUM(CASE t2.is_verified WHEN 1 THEN 0 ELSE 1 END) as user_pending'),
                    'cpd_schedule_courses.start_date',
                    'cpd_schedule_courses.end_date',
                    DB::raw('MAX(t2.completed_date) as completed_date'),
                    'remark'
                )
                ->where('t2.provider_id', auth()->user()->provider_id)
                ->where('t2.enroll_status_id', 6) //Completed
                ->groupBy(
                    'cpd_schedule_courses.schedule_course_id',
                    't3.cpd_course_kh',
                    't3.credits',
                    'participant_num',
                    'cpd_schedule_courses.start_date',
                    'cpd_schedule_courses.end_date',
                    'remark'
                )
                ->orderBy('cpd_schedule_courses.end_date', 'DESC')
                ->paginate(10);
            return view('admin.cpd_tcp.cpd_credits.index', compact('offerings'));
        } else {
            return redirect()->back();
        }
    }

    //Get staff to use in CPD credits recording
    public function staffListbyLocation($location_code, $schedule_course_id)
    {
        $statusLists = [1, 2, 7, 8, 10, 14];
        $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
            ->leftJoin('sys_positions as pos', 'pos.position_id', '=', 't2.position_id')
            ->leftJoin('sys_contract_types as cont_type', 'cont_type.contract_type_id', '=', 't2.contract_type_id')
            ->where('t2.cur_pos', 1)
            ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
            ->where('t2.location_code', $location_code)
            ->whereNotIn('hrmis_staffs.payroll_id', function ($query) use ($schedule_course_id) {
                $query->where('schedule_course_id', $schedule_course_id)
                    ->select('payroll_id')
                    ->from('cpd_enrollment_courses');
            })
            ->orderBy('surname_kh')
            ->orderBy('name_kh')
            ->distinct()
            ->select(
                'hrmis_staffs.payroll_id',
                'surname_kh',
                'name_kh',
                'surname_en',
                'name_en',
                'sex',
                DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                'position_hierarchy',
                DB::raw("(CASE hrmis_staffs.is_cont_staff WHEN 1 THEN cont_type.contract_type_kh ELSE position_kh END) As position_kh")
            )
            ->get()->all();
        return $staffs;
    }
    // Get staff to use in CPD credits recording || staff un registered via mobile app
    public function staffListbyPayrollName($payroll_name, $schedule_course_id)
    {
        $statusLists = [1, 2, 7, 8, 10, 14];
        $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
            ->leftJoin('sys_positions as pos', 'pos.position_id', '=', 't2.position_id')
            ->leftJoin('sys_contract_types as cont_type', 'cont_type.contract_type_id', '=', 't2.contract_type_id')
            ->where('t2.cur_pos', 1)
            ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
            ->when(request()->pro_code, function ($query) {
                $query->where('t2.pro_code', request()->pro_code);
            })
            ->when(request()->dis_code, function ($query) {
                $query->where(DB::raw("LEFT(t2.location_code, 4)"), request()->dis_code);
            })
            ->when(request()->location_code, function ($query) {
                $query->where('t2.location_code', request()->location_code);
            })
            ->where(function ($query) use ($payroll_name) {
                $query->where('t2.payroll_id', $payroll_name)
                    ->orWhere(DB::raw('CONCAT(surname_kh, " ", name_kh)'), 'like', '%' . $payroll_name . '%')
                    ->orWhere(DB::raw('CONCAT(surname_en, " ", name_en)'), 'like', '%' . $payroll_name . '%');
            })
            ->whereNotIn('hrmis_staffs.payroll_id', function ($query) use ($schedule_course_id) {
                $query->where('schedule_course_id', $schedule_course_id)
                    ->select('payroll_id')
                    ->from('cpd_enrollment_courses');
            })
            ->orderBy('surname_kh')
            ->orderBy('name_kh')
            ->distinct()
            ->select(
                'hrmis_staffs.payroll_id',
                'surname_kh',
                'name_kh',
                'surname_en',
                'name_en',
                'sex',
                DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                'position_hierarchy',
                DB::raw("(CASE hrmis_staffs.is_cont_staff WHEN 1 THEN cont_type.contract_type_kh ELSE position_kh END) As position_kh")
            )
            ->get()->all();
        return $staffs;
    }

    //Get staff registered via mobile app
    public function staffListRegistrations($schedule_course_id)
    {
        $statusLists = [1, 2, 7, 8, 10, 14];
        $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
            ->join('cpd_enrollment_courses as enroll', 'hrmis_staffs.payroll_id', '=', 'enroll.payroll_id')
            ->leftJoin('sys_positions as pos', 'pos.position_id', '=', 't2.position_id')
            ->leftJoin('sys_contract_types as cont_type', 'cont_type.contract_type_id', '=', 't2.contract_type_id')
            ->where('t2.cur_pos', 1)
            ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
            ->where('enroll.schedule_course_id', $schedule_course_id)
            ->where('enroll.enroll_status_id', 3) //In progress
            ->orderBy('surname_kh')
            ->orderBy('name_kh')
            ->distinct()
            ->select(
                'hrmis_staffs.payroll_id',
                'surname_kh',
                'name_kh',
                'surname_en',
                'name_en',
                'sex',
                DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                'position_hierarchy',
                DB::raw("(CASE hrmis_staffs.is_cont_staff WHEN 1 THEN cont_type.contract_type_kh ELSE position_kh END) As position_kh")
            )
            ->get()->all();
        return $staffs;
    }

    //Retrieve CPD offerings List by mobile or not
    public function getCPDOfferings($chkMobile)
    {       
        $offerings = Course::join('cpd_schedule_courses', 'cpd_courses.cpd_course_id', '=', 'cpd_schedule_courses.cpd_course_id')
            ->where('provider_id', auth()->user()->provider_id)
            ->where('is_mobile', $chkMobile);
        if ($chkMobile == 1) {
            $offerings = $offerings
                ->whereIn('schedule_course_id', function ($query) {
                    $query->select('schedule_course_id')
                        ->where('enroll_status_id', 3) //In progress
                        ->from('cpd_enrollment_courses');
                });
        } else {
            $offerings = $offerings
                ->whereNotIn('schedule_course_id', function ($query) {
                    $query->select('schedule_course_id')->from('cpd_enrollment_courses');
                });
        }
        $offerings = $offerings
            ->distinct()
            ->get()
            ->pluck('full_course', 'schedule_course_id')->all();
        return $offerings;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->hasRole('cpd_provider')) {
            $offerings = Course::join('cpd_schedule_courses', 'cpd_courses.cpd_course_id', '=', 'cpd_schedule_courses.cpd_course_id')
                ->where('provider_id', auth()->user()->provider_id)
                ->where('is_mobile', true)
                ->whereIn('schedule_course_id', function ($query) {
                    $query->select('schedule_course_id')
                        ->where('enroll_status_id', 3) //In progress
                        ->from('cpd_enrollment_courses');
                })
                ->distinct()
                ->get()
                ->pluck('full_course', 'schedule_course_id')->all();

            $provinces = ['' => __('common.choose') . ' ...'] + Province::active()->pluck('name_kh', 'pro_code')->all();
            $districts = ['' => __('common.choose') . ' ...'];
            $locations = ['' => __('common.choose') . ' ...'];

            return view('admin.cpd_tcp.cpd_credits.create', compact(
                'offerings',
                'provinces',
                'districts',
                'locations'
            ));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /////

    // To fix exising records.
    ////
    public function store(Request $request)
    {
        if (auth()->user()->hasRole('cpd_provider')) {
            $request->validate([
                'schedule_course_id' => 'required',
                'completed_date' => 'required',
                'payroll_numbers'  => 'required'
            ]);
            if ($request->is_mobile) { //Update existing records
                $update_approves = array();
                $update_approves['enroll_status_id']    = 6;
                $update_approves['provider_id']         = auth()->user()->provider_id;
                $update_approves['provider_status']     = 5; // approved by provider
                $update_approves['provider_check_date'] = now();
                $update_approves['confirm_completed']   = 1;
                $update_approves['completed_date']      = date('Y-m-d', strtotime($request->completed_date));
                $update_approves['is_verified']         = 0;
                EnrollmentCourse::whereIn('payroll_id', $request->payroll_numbers)
                    ->where('schedule_course_id', $request->schedule_course_id)
                    ->update($update_approves);
            } else {
                foreach ($request->payroll_numbers as $payroll_id) {
                    EnrollmentCourse::create([
                        'schedule_course_id'    => $request->schedule_course_id,
                        'payroll_id'            => $payroll_id,
                        'enroll_option'         => 3, //1:Organization, 2: Personal Budget, 3: Provider
                        'enroll_status_id'      => 6, //6: automatically completed
                        'staff_check_status'    => 5, //5: auto approved
                        'staff_check_date'      => date('Y-m-d', strtotime($request->completed_date)),
                        'enroll_date'           => date('Y-m-d', strtotime($request->completed_date)),
                        'supervisor_payroll'    => null,
                        'supervisor_status'     => null,
                        'supervisor_check_date' => null,
                        'provider_id'           => auth()->user()->provider_id,
                        'provider_status'       => 5, // Approved
                        'provider_check_date'   => now(),
                        'confirm_completed'     => 1,
                        'completed_date'        => date('Y-m-d', strtotime($request->completed_date)),
                        'is_verified'           => 0
                    ]);
                }
            }
            return redirect()->route('cpd-credits.index', app()->getLocale())
                ->withSuccess(__('validation.add_success'));
        } else {
            return redirect()->back();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($schedule_course_id, $completed_date)
    {
        if (auth()->user()->hasRole('cpd_provider')) {
            $offerings = Course::join('cpd_schedule_courses', 'cpd_courses.cpd_course_id', '=', 'cpd_schedule_courses.cpd_course_id')
                ->where('provider_id', auth()->user()->provider_id)
                ->where('schedule_course_id', $schedule_course_id)
                ->distinct()
                ->get()
                ->pluck('full_course', 'schedule_course_id')->all();

            $provinces = ['' => __('common.choose') . ' ...'] + Province::active()->pluck('name_kh', 'pro_code')->all();
            $districts = ['' => __('common.choose') . ' ...'];
            $locations = ['' => __('common.choose') . ' ...'];

            $search_provinces = $provinces;
            $search_districts = $districts;
            $search_locations = $locations;
            if (request()->search) {
                if (request()->search_pro_code) {
                    $search_districts = District::active()
                        ->whereProCode(request()->get('search_pro_code'))
                        ->pluck('name_kh', 'dis_code')
                        ->all();
                    $search_districts = ['' => __('common.choose') . ' ...'] + $search_districts;
                }
                if (request()->search_dis_code) {
                    $search_locations = Location::when(request()->search_dis_code, function ($query) {
                        $query->where('dis_code', request()->search_dis_code);
                    })
                        ->pluck('location_kh', 'location_code')
                        ->all();
                    $search_locations = ['' => __('common.choose') . ' ...'] + $search_locations;
                }
            }

            $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                ->join('cpd_enrollment_courses as enroll', 'hrmis_staffs.payroll_id', '=', 'enroll.payroll_id')
                ->join('sys_locations as l', 'l.location_code', '=', 't2.location_code')
                ->leftJoin('sys_positions as pos', 'pos.position_id', '=', 't2.position_id')
                ->leftJoin('sys_contract_types as cont_type', 'cont_type.contract_type_id', '=', 't2.contract_type_id')
                ->where('t2.cur_pos', 1)
                ->where('enroll.schedule_course_id', $schedule_course_id)
                ->where('enroll.enroll_status_id', 6) //Completed
                ->when(request()->search_pro_code, function ($query) {
                    $query->where('t2.pro_code', request()->search_pro_code);
                })
                ->when(request()->search_dis_code, function ($query) {
                    $query->where(DB::raw("LEFT(t2.location_code, 4)"), request()->search_dis_code);
                })
                ->when(request()->search_location_code, function ($query) {
                    $query->where('t2.location_code', request()->search_location_code);
                })
                ->when(request()->search_payroll_name_bottom, function ($query) {
                    $query->where(function ($query) {
                        $query->where('enroll.payroll_id', request()->search_payroll_name_bottom)
                            ->orWhere(DB::raw('CONCAT(surname_kh, " ", name_kh)'), 'like', '%' . request()->search_payroll_name_bottom . '%')
                            ->orWhere(DB::raw('CONCAT(surname_en, " ", name_en)'), 'like', '%' . request()->search_payroll_name_bottom . '%');
                    });
                })
                ->orderBy('l.location_kh')
                ->orderBy('surname_kh')
                ->orderBy('name_kh')
                ->distinct()
                ->select(
                    'enroll.id',
                    'hrmis_staffs.payroll_id',
                    'surname_kh',
                    'name_kh',
                    'surname_en',
                    'name_en',
                    'sex',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                    'enroll.is_verified',
                    'position_hierarchy',
                    'l.location_kh',
                    DB::raw("(CASE hrmis_staffs.is_cont_staff WHEN 1 THEN cont_type.contract_type_kh ELSE position_kh END) As position_kh")
                )
                ->paginate(10);

            $registrations = [];
            $cpd_schedule_course = ScheduleCourse::find($schedule_course_id);
            if ($cpd_schedule_course->is_mobile == 1) {
                $registrations = $this->staffListRegistrations($schedule_course_id);
            }

            return view('admin.cpd_tcp.cpd_credits.create', compact(
                'cpd_schedule_course',
                'completed_date',
                'offerings',
                'provinces',
                'districts',
                'locations',
                'search_provinces',
                'search_districts',
                'search_locations',
                'staffs',
                'registrations'
            ));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $schedule_course_id)
    {
        if (auth()->user()->hasRole('cpd_provider')) {
            $request->validate([
                'completed_date' => 'required'
            ]);
            //Update existing records with new completed_date
            $update_row = array();
            $update_row['staff_check_date'] = date('Y-m-d', strtotime($request->completed_date));
            $update_row['enroll_date'] = date('Y-m-d', strtotime($request->completed_date));
            $update_row['completed_date'] = date('Y-m-d', strtotime($request->completed_date));
            $update_row['provider_check_date'] = now();

            EnrollmentCourse::where('schedule_course_id', $schedule_course_id)->update($update_row);

            if ($request->payroll_numbers) {
                if ($request->has_is_mobile == '1') { //Update existing payroll numbers
                    $update_approves = array();
                    $update_approves['enroll_status_id']    = 6;
                    $update_approves['provider_id']         = auth()->user()->provider_id;
                    $update_approves['provider_status']     = 5; // approved by provider
                    $update_approves['provider_check_date'] = now();
                    $update_approves['confirm_completed']   = 1;
                    $update_approves['completed_date']      = date('Y-m-d', strtotime($request->completed_date));
                    $update_approves['is_verified']         = 0;
                    EnrollmentCourse::whereIn('payroll_id', $request->payroll_numbers)
                        ->where('schedule_course_id', $schedule_course_id)
                        ->update($update_approves);
                } else {
                    // Insert new records
                    foreach ($request->payroll_numbers as $payroll_id) {
                        EnrollmentCourse::create([
                            'schedule_course_id'    => $schedule_course_id,
                            'payroll_id'            => $payroll_id,
                            'enroll_option'         => 3, //1:Organization, 2: Personal Budget, 3: Provider
                            'enroll_status_id'      => 6, //6: automatically completed
                            'staff_check_status'    => 5, //5: auto approved
                            'staff_check_date'      => date('Y-m-d', strtotime($request->completed_date)),
                            'enroll_date'           => date('Y-m-d', strtotime($request->completed_date)),
                            'supervisor_payroll'    => null,
                            'supervisor_status'     => null,
                            'supervisor_check_date' => null,
                            'provider_id'           => auth()->user()->provider_id,
                            'provider_status'       => 5, // Approved
                            'provider_check_date'   => now(),
                            'confirm_completed'     => 1,
                            'completed_date'        => date('Y-m-d', strtotime($request->completed_date)),
                            'is_verified'           => 0
                        ]);
                    }
                }
            }

            //return redirect()->route('cpd-credits.index', app()->getLocale())
            //->withSuccess(__('validation.add_success'));
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function pendingActivities()
    {

        if (auth()->user()->hasRole('administrator')) {
            $offerings = ScheduleCourse::join('cpd_enrollment_courses as t2', 'cpd_schedule_courses.schedule_course_id', '=', 't2.schedule_course_id')
                ->join('cpd_courses as t3', 'cpd_schedule_courses.cpd_course_id', '=', 't3.cpd_course_id')
                ->join('cpd_providers as t4', 'cpd_schedule_courses.provider_id', '=', 't4.provider_id')
                ->select(
                    'cpd_schedule_courses.schedule_course_id',
                    't4.provider_kh',
                    't3.cpd_course_kh',
                    't3.credits',
                    'participant_num',
                    DB::raw('count(t2.payroll_id) as user_count'),
                    'cpd_schedule_courses.start_date',
                    'cpd_schedule_courses.end_date'
                )
                ->where('t2.is_verified', false)
                ->where('t2.enroll_status_id', 6) //Completed
                ->groupBy(
                    'cpd_schedule_courses.schedule_course_id',
                    't4.provider_kh',
                    't3.cpd_course_kh',
                    't3.credits',
                    'participant_num',
                    'cpd_schedule_courses.start_date',
                    'cpd_schedule_courses.end_date'
                )
                ->orderBy('cpd_schedule_courses.end_date', 'DESC')
                ->paginate(10);
            return view('admin.cpd_tcp.cpd_credits.pending_list', compact('offerings'));
        } else {
            return redirect()->back();
        }
    }

    public function viewPendingCPD($schedule_course_id)
    {
        if (auth()->user()->hasRole('administrator')) {
            $provinces = ['' => __('common.choose') . ' ...'] + Province::active()->pluck('name_kh', 'pro_code')->all();
            $districts = ['' => __('common.choose') . ' ...'];
            $locations = ['' => __('common.choose') . ' ...'];
            if (request()->search) {
                if (request()->pro_code) {
                    $districts = District::active()
                        ->whereProCode(request()->get('pro_code'))
                        ->pluck('name_kh', 'dis_code')
                        ->all();
                    $districts = ['' => __('common.choose') . ' ...'] + $districts;
                }
                if (request()->dis_code) {
                    $locations = Location::when(request()->dis_code, function ($query) {
                        $query->where('dis_code', request()->dis_code);
                    })
                        ->pluck('location_kh', 'location_code')
                        ->all();
                    $locations = ['' => __('common.choose') . ' ...'] + $locations;
                }
            }

            $schedule_course = ScheduleCourse::find($schedule_course_id);
            $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                ->join('cpd_enrollment_courses as enroll', 'hrmis_staffs.payroll_id', '=', 'enroll.payroll_id')
                ->join('sys_locations as l', 'l.location_code', '=', 't2.location_code')
                ->leftJoin('sys_positions as pos', 'pos.position_id', '=', 't2.position_id')
                ->leftJoin('sys_contract_types as cont_type', 'cont_type.contract_type_id', '=', 't2.contract_type_id')
                ->where('t2.cur_pos', 1)
                ->where('enroll.schedule_course_id', $schedule_course_id)
                ->where('enroll.enroll_status_id', 6) //Completed
                ->where('enroll.is_verified', false) //Pending Records
                ->when(request()->pro_code, function ($query) {
                    $query->where('t2.pro_code', request()->pro_code);
                })
                ->when(request()->dis_code, function ($query) {
                    $query->where(DB::raw("LEFT(t2.location_code, 4)"), request()->dis_code);
                })
                ->when(request()->location_code, function ($query) {
                    $query->where('t2.location_code', request()->location_code);
                })
                ->when(request()->payroll_name, function ($query) {
                    $query->where(function ($query) {
                        $query->where('enroll.payroll_id', request()->payroll_name)
                            ->orWhere(DB::raw('CONCAT(surname_kh, " ", name_kh)'), 'like', '%' . request()->payroll_name . '%')
                            ->orWhere(DB::raw('CONCAT(surname_en, " ", name_en)'), 'like', '%' . request()->payroll_name . '%');
                    });
                })
                ->orderBy('l.location_kh')
                ->orderBy('surname_kh')
                ->orderBy('name_kh')
                ->distinct()
                ->select(
                    'enroll.id',
                    'hrmis_staffs.payroll_id',
                    'surname_kh',
                    'name_kh',
                    'surname_en',
                    'name_en',
                    'sex',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                    DB::raw("(CASE hrmis_staffs.is_cont_staff WHEN 1 THEN cont_type.contract_type_kh ELSE position_kh END) As position_kh"),
                    'position_hierarchy',
                    DB::raw("DATE_FORMAT(enroll.completed_date, '%d-%m-%Y') as completed_date"),
                    'l.location_kh'
                )
                ->get()->all();

            return view('admin.cpd_tcp.cpd_credits.view_pending_cpd', compact(
                'schedule_course',
                'staffs',
                'provinces',
                'districts',
                'locations'
            ));
        } else {
            return redirect()->back();
        }
    }

    public function verifyCPD(Request $request, $schedule_course_id)
    {
        if (auth()->user()->hasRole('administrator')) {
            $request->validate([
                'payroll_numbers'  => 'required'
            ]);

            $errors = [];

            if ($errors) {
                return back()->withInput()->withErrors($errors);
            }
            $schedule_course = ScheduleCourse::find($schedule_course_id);
            $schedule_course->fill([
                'remark'   => $request->remark ? $request->remark : '',
                'updated_by' => auth()->user()->id
            ])->save();

            if (count($request->payroll_numbers) > 0) {
                $update_row = array();
                $update_row['is_verified'] = 1;
                $update_row['verified_by'] = auth()->user()->payroll_id;
                $update_row['verified_date'] = now();

                EnrollmentCourse::where('schedule_course_id', $schedule_course_id)
                    ->whereIn('payroll_id', $request->payroll_numbers)
                    ->update($update_row);
            }
            //return redirect()->route('cpd-credits.cpd-pending-list', app()->getLocale())
            return redirect()->back()
                ->withSuccess(__('validation.add_success'));
        } else {
            return redirect()->back();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $enroll = EnrollmentCourse::find($id);
        $enroll->delete();
        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
