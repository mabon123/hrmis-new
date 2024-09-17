<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\StaffsInWorkplaceExport;
use App\Exports\StaffOnePageOneWorkplaceExport;
use App\Exports\StaffByPositionExport;
use App\Exports\StaffShortLeaveExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\AcademicYear;
use App\Models\District;
use App\Models\Language;
use App\Models\Location;
use App\Models\Position;
use App\Models\PositionLocation;
use App\Models\Province;
use App\Models\Staff;

class ReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-report-and-chart', ['only' => ['index']]);
    }

    // Reports page
    public function index()
    {
        $userWorkPlace = auth()->user()->work_place;

        $provinces = user_provinces();
        $districts = user_districts();
        $locations = auth()->user()->hasRole('administrator') ? ['' => __('common.choose') . ' ...'] : user_locations();

        $userLocation = Location::where('location_code', $userWorkPlace->location_code)
            ->select('location_type_id')->first();

        // Position of school-admin
        if (auth()->user()->hasRole('school-admin')) {
            $posLocations = PositionLocation::where('location_type_id', $userLocation->location_type_id)
                ->pluck('position_id')
                ->all();
            $positions = Position::whereIn('position_id', $posLocations)
                ->orderBy('position_hierarchy', 'ASC')
                ->pluck('position_kh', 'position_id')
                ->all();
        } else {
            $positions = Position::orderBy('position_hierarchy', 'ASC')
                ->pluck('position_kh', 'position_id')
                ->all();
        }

        // Languages info
        $languages = Language::pluck('language_kh', 'language_id')->all();

        return view('admin.reports.index', compact(
            'provinces',
            'districts',
            'locations',
            'positions',
            'languages'
        ));
    }

    /**
     * Show off duty staffs info
     */
    public function offDutyStaff()
    {
        $selectQuery = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en', 'staff_status_id'];

        $next3Month = Carbon::now()->addMonths(3);

        $staffs = Staff::with('currentWork')
            ->where('staff_status_id', 8)
            ->whereHas('currentWork', function ($query) use ($next3Month) {
                $query->whereDate('end_date', '<=', $next3Month);
                $query->orWhereNull('end_date');
            })
            ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function ($query) {
                $query->whereHas('currentWork', function ($query) {
                    $query->where('location_code', auth()->user()->work_place->location_code);
                });
            })
            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function ($query) {
                $query->whereHas('currentWork.location', function ($query) {
                    $query->where('pro_code', auth()->user()->work_place->pro_code)
                        ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                            $query->where('dis_code', auth()->user()->work_place->dis_code);
                        });
                });
            })
            ->select($selectQuery)
            ->paginate(10);

        $femaleStaffs = Staff::with('currentWork')
            ->where('hrmis_staffs.staff_status_id', 8)
            ->where('hrmis_staffs.sex', '2')
            ->whereHas('currentWork', function ($query) use ($next3Month) {
                $query->whereDate('end_date', '<=', $next3Month);
                $query->orWhereNull('end_date');
            })
            ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function ($query) {
                $query->whereHas('currentWork', function ($query) {
                    $query->where('location_code', auth()->user()->work_place->location_code);
                });
            })
            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function ($query) {
                $query->whereHas('currentWork.location', function ($query) {
                    $query->where('pro_code', auth()->user()->work_place->pro_code)
                        ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                            $query->where('dis_code', auth()->user()->work_place->dis_code);
                        });
                });
            })
            ->select($selectQuery)
            ->count('hrmis_staffs.payroll_id');

        return view('admin.reports.off_duty_staff', compact('staffs', 'femaleStaffs'));
    }

    /**
     * Leave without pay staff info
     */
    public function leaveWithoutPayStaff()
    {
        $selectQuery = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en', 'staff_status_id'];

        $next3Month = Carbon::now()->addMonths(3);

        $staffs = Staff::with('currentWork')
            ->where('hrmis_staffs.staff_status_id', 2)
            ->whereHas('currentWork', function ($query) use ($next3Month) {
                $query->whereDate('end_date', '<=', $next3Month);
                $query->orWhereNull('prokah_num');
            })
            ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function ($query) {
                $query->whereHas('currentWork', function ($query) {
                    $query->where('location_code', auth()->user()->work_place->location_code);
                });
            })
            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function ($query) {
                $query->whereHas('currentWork.location', function ($query) {
                    $query->where('pro_code', auth()->user()->work_place->pro_code)
                        ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                            $query->where('dis_code', auth()->user()->work_place->dis_code);
                        });
                });
            })
            ->select($selectQuery)
            ->paginate(10);

        $femaleStaffs = Staff::with('currentWork')
            ->where('hrmis_staffs.staff_status_id', 2)
            ->where('hrmis_staffs.sex', '2')
            ->whereHas('currentWork', function ($query) use ($next3Month) {
                $query->whereDate('end_date', '<=', $next3Month);
                $query->orWhereNull('prokah_num');
            })
            ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function ($query) {
                $query->whereHas('currentWork', function ($query) {
                    $query->where('location_code', auth()->user()->work_place->location_code);
                });
            })
            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function ($query) {
                $query->whereHas('currentWork.location', function ($query) {
                    $query->where('pro_code', auth()->user()->work_place->pro_code)
                        ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                            $query->where('dis_code', auth()->user()->work_place->dis_code);
                        });
                });
            })
            ->select($selectQuery)
            ->count('hrmis_staffs.payroll_id');

        return view('admin.reports.leave_without_pay_staff', compact('staffs', 'femaleStaffs'));
    }

    /**
     * Continue study staff info
     */
    public function continueStudyStaff()
    {
        $selectQuery = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en', 'staff_status_id'];

        $nextMonth = Carbon::now()->addMonth();

        $staffs = Staff::with('currentWork')
            ->where('hrmis_staffs.staff_status_id', 10)
            ->whereHas('currentWork', function ($query) use ($nextMonth) {
                $query->whereDate('end_date', '<=', $nextMonth);
            })
            ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function ($query) {
                $query->whereHas('currentWork', function ($query) {
                    $query->where('location_code', auth()->user()->work_place->location_code);
                });
            })
            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function ($query) {
                $query->whereHas('currentWork.location', function ($query) {
                    $query->where('pro_code', auth()->user()->work_place->pro_code)
                        ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                            $query->where('dis_code', auth()->user()->work_place->dis_code);
                        });
                });
            })
            ->select($selectQuery)
            ->paginate(10);

        $femaleStaffs = Staff::with('currentWork')
            ->where('hrmis_staffs.staff_status_id', 10)
            ->where('hrmis_staffs.sex', '2')
            ->whereHas('currentWork', function ($query) use ($nextMonth) {
                $query->whereDate('end_date', '<=', $nextMonth);
            })
            ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function ($query) {
                $query->whereHas('currentWork', function ($query) {
                    $query->where('location_code', auth()->user()->work_place->location_code);
                });
            })
            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function ($query) {
                $query->whereHas('currentWork.location', function ($query) {
                    $query->where('pro_code', auth()->user()->work_place->pro_code)
                        ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                            $query->where('dis_code', auth()->user()->work_place->dis_code);
                        });
                });
            })
            ->select($selectQuery)
            ->count('hrmis_staffs.payroll_id');

        return view('admin.reports.continue_study_staff', compact('staffs', 'femaleStaffs'));
    }

    // Show all staffs in status (1, 2, 7, 8, 10, 14)
    public function generateAllStaff(Request $request)
    {
        $request->validate(['pro_code' => 'required']);
        /*return $request->all();
        $academicYears = AcademicYear::orderBy('year_id', 'desc')->pluck('year_kh', 'year_id')->all();

        if (request()->academic_year) {
            $lastAcademicYearID = request()->academic_year;
        } else {
            $lastAcademicYear = AcademicYear::orderBy('year_id', 'desc')->select('year_id')->first();
            $lastAcademicYearID = $lastAcademicYear->year_id;
        }

        $locationCode = !empty(auth()->user()->work_place) ? auth()->user()->work_place->location_code : 0;

        // Find location info
        $lSelectQuery = ['location_code', 'location_kh', 'pro_code', 'dis_code', 'com_code'];
        $workplace = Location::where('location_code', $locationCode)->select($lSelectQuery)->first();*/

        $pro_code = $request->pro_code ? $request->pro_code : '99'; //Must have one
        $location_code = $request->location_code ? $request->location_code : '';
        $dis_code = $request->dis_code ? $request->dis_code : ($location_code ? substr($location_code, 0, 4) : '');

        return redirect()->route('reports.showAllStaff', [app()->getLocale(), $pro_code, $dis_code, $location_code]);
    }
    public function showAllStaff($pro_code, $dis_code = '', $location_code = '')
    {
        $staffs = DB::select("CALL sp_rptstafflist_workplaces('" . $pro_code . "',  '" . $dis_code . "', '" . $location_code . "')");

        return view('admin.reports.all_staff', compact('staffs', 'pro_code', 'dis_code', 'location_code'));
    }
    public function exportAllStaffExcel($pro_code, $dis_code = '', $location_code = '')
    {
        return Excel::download(new StaffsInWorkplaceExport($pro_code, $dis_code, $location_code), 'all_staffs.xlsx');
    }
    public function exportAllStaffPDF($pro_code, $dis_code = '', $location_code = '')
    {
        $staffs = DB::select("CALL sp_rptstafflist_workplaces('" . $pro_code . "',  '" . $dis_code . "', '" . $location_code . "')");

        return view('admin.reports.exports.pdf.all_staff', compact('staffs'));
    }

    // Show staff report - one page one workplace


    //Short Leave
    private function dataShortLeave($pro_code, $dis_code, $location_code, $start_date, $end_date)
    {
        $staffs = Staff::join('hrmis_work_histories as wh', 'hrmis_staffs.payroll_id', '=', 'wh.payroll_id')
            ->join('hrmis_staff_leaves as leave', 'hrmis_staffs.payroll_id', '=', 'leave.payroll_id')
            ->select(
                'hrmis_staffs.payroll_id',
                'surname_kh',
                'name_kh',
                'is_cont_staff',
                'sex',
                'dob',
                DB::raw("DATEDIFF(leave.end_date, leave.start_date)+1 AS days"),
                'leave.start_date',
                'leave.end_date',
                'leave.description'
            )
            ->where('cur_pos', 1)
            ->where('leave.leave_type_id', 2)
            ->whereNotIn(DB::raw("IFNULL(leave.check_status_id, 0)"), [4, 6])
            ->where('wh.pro_code', $pro_code)
            ->when($dis_code != '0', function ($query) use ($dis_code) {
                $query->where(DB::raw("LEFT(wh.location_code, 4)"), $dis_code);
            })
            ->when($location_code != '0', function ($query) use ($location_code) {
                $query->where('wh.location_code', $location_code);
            })
            ->whereBetween('leave.start_date', [$start_date, $end_date])
            ->whereBetween('leave.end_date', [$start_date, $end_date])
            ->orderBy('leave.start_date')
            ->get()->all();
        return $staffs;
    }

    public function generateShortLeave(Request $request)
    {
        $request->validate([
            'pro_code' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $pro_code = $request->pro_code ? $request->pro_code : '99'; //Must have one
        $dis_code = $request->dis_code ? $request->dis_code : '0';
        $location_code = $request->location_code ? $request->location_code : '0';
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));

        $staffs = $this->dataShortLeave($pro_code, $dis_code, $location_code, $start_date, $end_date);

        return view('admin.reports.staff_short_leave', compact(
            'staffs',
            'pro_code',
            'dis_code',
            'location_code',
            'start_date',
            'end_date'
        ));
    }
    public function exportShortLeavePDF($pro_code, $dis_code, $location_code, $start_date, $end_date)
    {
        $userWorkplace = Location::where('location_code', auth()->user()->work_place->location_code)
            ->select('location_code', 'location_kh')
            ->first();
        $staffs = $this->dataShortLeave($pro_code, $dis_code, $location_code, $start_date, $end_date);

        return view('admin.reports.exports.pdf.pdf_short_leave', compact(
            'staffs',
            'userWorkplace'
        ));
    }
    public function exportShortLeaveExcel($pro_code, $dis_code, $location_code, $start_date, $end_date)
    {
        $d_from = date('d-m-Y', strtotime($start_date));
        $d_to = date('d-m-Y', strtotime($end_date));

        return Excel::download(
            new StaffShortLeaveExport($pro_code, $dis_code, $location_code, $start_date, $end_date),
            'staff_short_leave_' . $d_from . '_to_' . $d_to . '.xlsx'
        );
    }
    //End Short Leave

    // Staff by position report
    public function generateStaffbyPosition(Request $request)
    {
        $request->validate([
            'pro_code' => 'required',
            'position_from' => 'required',
            'position_to' => 'required',
        ], [
            'position_from.required' => __('validation.required'),
            'position_to.required' => __('validation.required'),
        ]);

        $pro_code = $request->pro_code ? $request->pro_code : '99'; //Must have one
        $location_code = $request->location_code ? $request->location_code : '';
        $dis_code = $request->dis_code ? $request->dis_code : ($location_code ? substr($location_code, 0, 4) : '');
        $position_from = $request->position_from ? $request->position_from : 0;
        $position_to = $request->position_to ? $request->position_to : 0;

        return redirect()->route('reports.showStaffbyPosition', [
            app()->getLocale(),
            $pro_code, $position_from, $position_to, $dis_code, $location_code
        ]);
    }
    public function showStaffbyPosition($pro_code, $position_from, $position_to, $dis_code = '', $location_code = '')
    {
        $staffs = DB::select("CALL sp_rptstafflist_positions(
                        '" . $pro_code . "',  '" . $dis_code . "', '" . $location_code . "', " . $position_from . ", " . $position_to . "
                    )");

        return view('admin.reports.staff_by_position', compact(
            'staffs',
            'pro_code',
            'dis_code',
            'location_code',
            'position_from',
            'position_to'
        ));
    }
    public function exportStaffbyPositionExcel($pro_code, $position_from, $position_to, $dis_code = '', $location_code = '')
    {
        return Excel::download(
            new StaffByPositionExport($pro_code, $dis_code, $location_code, $position_from, $position_to),
            'staff_by_position.xlsx'
        );
    }
    public function exportStaffbyPositionPDF($pro_code, $position_from, $position_to, $dis_code = '', $location_code = '')
    {
        $staffs = DB::select("CALL sp_rptstafflist_positions(
                                    '" . $pro_code . "',  
                                    '" . $dis_code . "', 
                                    '" . $location_code . "', 
                                    " . $position_from . ", 
                                    " . $position_to . "
                                )");

        return view('admin.reports.exports.pdf.staff_by_position', compact('staffs'));
    }

    // On Leave Staff Report
    public function showStaffOnLeave()
    {
        $selectQuery = [
            'hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en',
            'hrmis_staff_leaves.description', 'hrmis_staff_leaves.start_date', 'hrmis_staff_leaves.end_date'
        ];

        $staffs = Staff::join('hrmis_staff_leaves', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_leaves.payroll_id')
            ->whereDate('hrmis_staff_leaves.start_date', '<=', Carbon::now()->format('Y-m-d'))
            ->whereDate('hrmis_staff_leaves.end_date', '>=', Carbon::now()->format('Y-m-d'))
            ->when(auth()->user()->hasRole('school-admin', 'dept-admin'), function ($query) {
                $query->whereHas('currentWork', function ($query) {
                    $query->where('location_code', auth()->user()->work_place->location_code);
                });
            })
            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function ($query) {
                $query->whereHas('currentWork.location', function ($query) {
                    $query->where('pro_code', auth()->user()->work_place->pro_code)
                        ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                            $query->where('dis_code', auth()->user()->work_place->dis_code);
                        });
                });
            })
            ->select($selectQuery)
            ->paginate(10);

        $femaleStaffs = Staff::join('hrmis_staff_leaves', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_leaves.payroll_id')
            ->whereDate('hrmis_staff_leaves.start_date', '<=', Carbon::now()->format('Y-m-d'))
            ->whereDate('hrmis_staff_leaves.end_date', '>=', Carbon::now()->format('Y-m-d'))
            ->where('hrmis_staffs.sex', '2')
            ->when(auth()->user()->hasRole('school-admin', 'dept-admin'), function ($query) {
                $query->whereHas('currentWork', function ($query) {
                    $query->where('location_code', auth()->user()->work_place->location_code);
                });
            })
            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function ($query) {
                $query->whereHas('currentWork.location', function ($query) {
                    $query->where('pro_code', auth()->user()->work_place->pro_code)
                        ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                            $query->where('dis_code', auth()->user()->work_place->dis_code);
                        });
                });
            })
            ->select($selectQuery)
            ->count('hrmis_staffs.payroll_id');

        return view('admin.reports.staff_on_leave', compact('staffs', 'femaleStaffs'));
    }
}
