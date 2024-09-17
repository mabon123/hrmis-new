<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Auth;
use Image;
use Storage;
use Carbon\Carbon;

use App\Http\Requests\StaffRequest;

use App\Models\AcademicYear;
use App\Models\AdminOffice;
use App\Models\AdmirationBlame;
use App\Models\AdmirationSource;
use App\Models\AdmirationType;
use App\Models\CardreType;
use App\Models\Commune;
use App\Models\DayTeaching;
use App\Models\Disability;
use App\Models\District;
use App\Models\Ethnic;
use App\Models\Grade;
use App\Models\HourTeaching;
use App\Models\Location;
use App\Models\OfficialRank;
use App\Models\Position;
use App\Models\PositionLocation;
use App\Models\Province;
use App\Models\SalaryLevel;
use App\Models\ShortCourse;
use App\Models\Staff;
use App\Models\StaffFamily;
use App\Models\StaffLanguage;
use App\Models\StaffLeave;
use App\Models\StaffSalary;
use App\Models\StaffStatus;
use App\Models\StaffTeaching;
use App\Models\Subject;
use App\Models\Village;
use App\Models\WorkHistory;
use App\Models\StaffProfessional;
use App\Models\TeachingSubject;
use App\Models\StaffQualification;
use App\Models\User;
use App\Models\TCP\ProfessionCategory;
use App\Models\TCP\ProfessionRank;
use App\Models\TCP\ProfessionRecording;
use App\Models\Timetables\TeacherSubject;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-staffs', ['only' => ['index']]);
        $this->middleware('permission:create-staffs', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-staffs', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-staffs', ['only' => ['destroy']]);

        $this->middleware('permission:view-trainee-teacher-list', ['only' => ['traineeList']]);
        $this->middleware('permission:edit-trainee-teacher-list', ['only' => ['acceptTraineeList']]);
    }

    public function index()
    {
        $payrollID = auth()->user()->payroll_id;
        $staffStatus = StaffStatus::pluck('status_kh', 'status_id')->all();
        $provinces = [];
        $positions = [];
        $locations = [];
        //$keywords  = [];
        $mobileUsers = 0;
        $mobileFUsers = 0;
        $districts = [];
        $staffs = [];
        $femaleStaffs = 0;
        //$userLocationName = '';
        $userWorkPlace = auth()->user()->work_place;
        $selectQuery = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en', 'staff_status_id', 'position_hierarchy'];

        $provinces = $this->getUserProvinces(); // Get user provinces
        $districts = $this->getUserDistricts(); // Get user districts
        $locations = $this->getUserLocations(); // Get user locations/workplaces
        $positions = $this->getUserWorkplacePositions(request()->location_code); // Get user workplace positions

        // Staff transfer filter
       if (request()->status_id == 4) {
          if (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
            // Search function
            if (request()->search) {
                // filter_by
                $filterBy = 'hrmis_staffs.'.request()->filter_by;

                if (request()->filter_by == 'fullnamekh') {
                    $filterBy = DB::raw('CONCAT(surname_kh, " ", name_kh)');
                }
                elseif (request()->filter_by == 'fullnameen') {
                    $filterBy = DB::raw('CONCAT(surname_en, " ", name_en)');
                }

                // If status not select, set default
                $statusLists = [request()->status_id];
                if (empty(request()->status_id)) { $statusLists = [4]; }

                $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                ->leftJoin('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                ->leftJoin('sys_positions as t4', 't2.position_id', '=', 't4.position_id')
                                ->whereIn('t2.status_id', $statusLists)
                                ->whereIn('hrmis_staffs.staff_status_id',[1,4,7,8,10])
                                ->where('hrmis_staffs.is_cont_staff', 0)
                                ->where('t2.pro_code', $userWorkPlace->pro_code)
                                ->when(request()->dis_code, function($query) {
                                    $query->where('t3.dis_code', request()->dis_code);
                                })
                                ->when(request()->location_code, function($query) {
                                    $query->where('t2.location_code', request()->location_code);
                                })
                                ->when(request()->position_id, function($query) {
                                    $query->where('t2.position_id', request()->position_id);
                                })
                                ->when(request()->status_id, function($query) {
                                    $query->where('t2.status_id', request()->status_id);
                                })
                                ->when(request()->keyword, function($query) use($filterBy) {
                                    $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                })
                                //->distinct()
                                ->select($selectQuery)
                                ->groupBy($selectQuery)
                                ->orderBy('position_hierarchy', 'ASC')
                                ->orderBy('hrmis_staffs.surname_kh', 'ASC')
                                ->orderBy('hrmis_staffs.name_kh', 'ASC')
                                ->paginate(10);
                
                $femaleStaffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->leftJoin('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                    ->whereIn('t2.status_id', $statusLists)
                                    ->where('hrmis_staffs.is_cont_staff', 0)
                                    ->where('t2.pro_code', $userWorkPlace->pro_code)
                                    ->when(request()->dis_code, function($query) {
                                        $query->where('t3.dis_code', request()->dis_code);
                                    })
                                    ->when(request()->location_code, function($query) {
                                        $query->where('t2.location_code', request()->location_code);
                                    })
                                    ->when(request()->position_id, function($query) {
                                        $query->where('t2.position_id', request()->position_id);
                                    })
                                    ->when(request()->status_id, function($query) {
                                        $query->where('t2.status_id', request()->status_id);
                                    })
                                    ->when(request()->keyword, function($query) use($filterBy) {
                                        $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                    })
                                    ->where('hrmis_staffs.sex', '2')
                                    ->distinct()
                                    ->count('hrmis_staffs.payroll_id');
            }
            return view('admin.staffs.index', compact(
                'provinces', 'positions', 'staffStatus', 'locations', 'staffs', 'districts', 'femaleStaffs',
                'mobileUsers', 'mobileFUsers'
            ));
        }
    }
        // If status not select, set default
        $statusLists = [request()->status_id];
        if (empty(request()->status_id)) { $statusLists = [1, 2, 7, 8, 10]; }

        // Logged in as school administrator
        if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
            $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                        ->leftJoin('sys_positions as t4', 't2.position_id', '=', 't4.position_id')
                        ->where('t2.cur_pos', 1)
                        ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                        ->where('hrmis_staffs.is_cont_staff', 0)
                        ->where('t2.location_code', $userWorkPlace->location_code)
                        ->select($selectQuery)
                        ->groupBy($selectQuery)
                        ->orderBy('position_hierarchy', 'ASC')
                        ->orderBy('hrmis_staffs.surname_kh', 'ASC')
                        ->orderBy('hrmis_staffs.name_kh', 'ASC')
                        ->paginate(10);
            
            $femaleStaffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                ->where('t2.cur_pos', 1)
                                ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                ->where('hrmis_staffs.is_cont_staff', 0)
                                ->where('t2.location_code', $userWorkPlace->location_code)
                                ->where('hrmis_staffs.sex', '2')
                                ->distinct()
                                ->count('hrmis_staffs.payroll_id');
            
            // SEARCH
            if( request()->search ) {
                // filter_by
                $filterBy = 'hrmis_staffs.'.request()->filter_by;

                if (request()->filter_by == 'fullnamekh') {
                    $filterBy = DB::raw('CONCAT(surname_kh, " ", name_kh)');
                }
                elseif (request()->filter_by == 'fullnameen') {
                    $filterBy = DB::raw('CONCAT(surname_en, " ", name_en)');
                }

                $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                            ->leftJoin('sys_positions as t4', 't2.position_id', '=', 't4.position_id')
                            ->where('t2.cur_pos', 1)
                            ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                            ->where('hrmis_staffs.is_cont_staff', 0)
                            ->where('t2.location_code', $userWorkPlace->location_code)
                            ->when(request()->position_id, function($query) {
                                $query->where('t2.position_id', request()->position_id);
                            })
                            ->when(request()->status_id, function($query) {
                                $query->where('hrmis_staffs.staff_status_id', request()->status_id);
                            })
                            ->when(request()->keyword, function($query) use($filterBy) {
                                $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                            })
                            //->distinct()
                            ->select($selectQuery)
                            ->groupBy($selectQuery)
                            ->orderBy('position_hierarchy', 'ASC')
                            ->orderBy('hrmis_staffs.surname_kh', 'ASC')
                            ->orderBy('hrmis_staffs.name_kh', 'ASC')
                            ->paginate(10);
                
                $femaleStaffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->where('t2.cur_pos', 1)
                                    ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                    ->where('hrmis_staffs.is_cont_staff', 0)
                                    ->where('t2.location_code', $userWorkPlace->location_code)
                                    ->when(request()->position_id, function($query) {
                                        $query->where('t2.position_id', request()->position_id);
                                    })
                                    ->when(request()->status_id, function($query) {
                                        $query->where('hrmis_staffs.staff_status_id', request()->status_id);
                                    })
                                    ->when(request()->keyword, function($query) use($filterBy) {
                                        $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                    })
                                    ->where('hrmis_staffs.sex', '2')
                                    ->distinct()
                                    ->count('hrmis_staffs.payroll_id');
            }
        }

        // DOE Administrator
        elseif (auth()->user()->level_id == 4) {
            // Search
            if (request()->search) {
                // filter_by
                $filterBy = 'hrmis_staffs.'.request()->filter_by;

                if (request()->filter_by == 'fullnamekh') {
                    $filterBy = DB::raw('CONCAT(surname_kh, " ", name_kh)');
                }
                elseif (request()->filter_by == 'fullnameen') {
                    $filterBy = DB::raw('CONCAT(surname_en, " ", name_en)');
                }

                // If status not select, set default
                $statusLists = [request()->status_id];
                if (empty(request()->status_id)) { $statusLists = [1, 2, 7, 8, 10]; }

                $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                            ->leftJoin('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                            ->leftJoin('sys_positions as t4', 't2.position_id', '=', 't4.position_id')
                            ->where('t2.cur_pos', 1)
                            ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                            ->where('hrmis_staffs.is_cont_staff', 0)
                            ->where('t3.dis_code', 'LIKE', $userWorkPlace->dis_code)
                            ->when(request()->dis_code, function($query) {
                                $query->where('t3.dis_code', request()->dis_code);
                            })
                            ->when(request()->location_code, function($query) {
                                $query->where('t2.location_code', request()->location_code);
                            })
                            ->when(request()->position_id, function($query) {
                                $query->where('t2.position_id', request()->position_id);
                            })
                            ->when(request()->status_id, function($query) {
                                $query->where('hrmis_staffs.staff_status_id', request()->status_id);
                            })
                            ->when(request()->keyword, function($query) use($filterBy) {
                                $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                            })
                            //->distinct()
                            ->select($selectQuery)
                            ->groupBy($selectQuery)
                            ->orderBy('position_hierarchy', 'ASC')
                            ->orderBy('hrmis_staffs.surname_kh', 'ASC')
                            ->orderBy('hrmis_staffs.name_kh', 'ASC')
                            ->paginate(10);
                
                $femaleStaffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->leftJoin('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                    ->where('t2.cur_pos', 1)
                                    ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                    ->where('hrmis_staffs.is_cont_staff', 0)
                                    ->where('t3.dis_code', 'LIKE', $userWorkPlace->dis_code)
                                    ->when(request()->dis_code, function($query) {
                                        $query->where('t3.dis_code', request()->dis_code);
                                    })
                                    ->when(request()->location_code, function($query) {
                                        $query->where('t2.location_code', request()->location_code);
                                    })
                                    ->when(request()->position_id, function($query) {
                                        $query->where('t2.position_id', request()->position_id);
                                    })
                                    ->when(request()->status_id, function($query) {
                                        $query->where('hrmis_staffs.staff_status_id', request()->status_id);
                                    })
                                    ->when(request()->keyword, function($query) use($filterBy) {
                                        $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                    })
                                    ->where('hrmis_staffs.sex', '2')
                                    ->distinct()
                                    ->count('hrmis_staffs.payroll_id');
            }
        }

        // POE Administrator
        elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
            // Search function
            if (request()->search) {
                // filter_by
                $filterBy = 'hrmis_staffs.'.request()->filter_by;

                if (request()->filter_by == 'fullnamekh') {
                    $filterBy = DB::raw('CONCAT(surname_kh, " ", name_kh)');
                }
                elseif (request()->filter_by == 'fullnameen') {
                    $filterBy = DB::raw('CONCAT(surname_en, " ", name_en)');
                }

                // If status not select, set default
                $statusLists = [request()->status_id];
                if (empty(request()->status_id)) { $statusLists = [1, 2, 7, 8, 10]; }

                $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                ->leftJoin('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                ->leftJoin('sys_positions as t4', 't2.position_id', '=', 't4.position_id')
                                ->where('t2.cur_pos', 1)
                                ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                ->where('hrmis_staffs.is_cont_staff', 0)
                                ->where('t2.pro_code', $userWorkPlace->pro_code)
                                ->when(request()->dis_code, function($query) {
                                    $query->where('t3.dis_code', request()->dis_code);
                                })
                                ->when(request()->location_code, function($query) {
                                    $query->where('t2.location_code', request()->location_code);
                                })
                                ->when(request()->position_id, function($query) {
                                    $query->where('t2.position_id', request()->position_id);
                                })
                                ->when(request()->status_id, function($query) {
                                    $query->where('hrmis_staffs.staff_status_id', request()->status_id);
                                })
                                ->when(request()->keyword, function($query) use($filterBy) {
                                    $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                })
                                //->distinct()
                                ->select($selectQuery)
                                ->groupBy($selectQuery)
                                ->orderBy('position_hierarchy', 'ASC')
                                ->orderBy('hrmis_staffs.surname_kh', 'ASC')
                                ->orderBy('hrmis_staffs.name_kh', 'ASC')
                                ->paginate(10);
                
                $femaleStaffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->leftJoin('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                    ->where('t2.cur_pos', 1)
                                    ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                    ->where('hrmis_staffs.is_cont_staff', 0)
                                    ->where('t2.pro_code', $userWorkPlace->pro_code)
                                    ->when(request()->dis_code, function($query) {
                                        $query->where('t3.dis_code', request()->dis_code);
                                    })
                                    ->when(request()->location_code, function($query) {
                                        $query->where('t2.location_code', request()->location_code);
                                    })
                                    ->when(request()->position_id, function($query) {
                                        $query->where('t2.position_id', request()->position_id);
                                    })
                                    ->when(request()->status_id, function($query) {
                                        $query->where('hrmis_staffs.staff_status_id', request()->status_id);
                                    })
                                    ->when(request()->keyword, function($query) use($filterBy) {
                                        $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                    })
                                    ->where('hrmis_staffs.sex', '2')
                                    ->distinct()
                                    ->count('hrmis_staffs.payroll_id');
            }
        }

        else {
            if( request()->search ) {
                // if province selected
                if (request()->pro_code) {
                    $districts = District::active()
                                    ->whereProCode(request()->get('pro_code'))
                                    ->pluck('name_kh', 'dis_code')
                                    ->all();
                    $districts = ['' => __('common.choose').' ...'] + $districts;
                }

                // Find location belong to province & district
                $locations = Location::when(request()->pro_code, function($query) {
                                        $query->where('pro_code', request()->pro_code);
                                     })
                                     ->when(request()->dis_code, function($query) {
                                        $query->where('dis_code', request()->dis_code);
                                     })
                                     ->pluck('location_kh', 'location_code')
                                     ->all();
                $locations = ['' => __('common.choose').' ...'] + $locations;

                // filter_by
                $filterBy = 'hrmis_staffs.'.request()->filter_by;

                if (request()->filter_by == 'fullnamekh') {
                    $filterBy = DB::raw('CONCAT(surname_kh, " ", name_kh)');
                }
                elseif (request()->filter_by == 'fullnameen') {
                    $filterBy = DB::raw('CONCAT(surname_en, " ", name_en)');
                }

                // If status not select, set default
                $statusLists = [request()->status_id];
                if (empty(request()->status_id)) { $statusLists = [1, 2, 7, 8, 10]; }

                $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                ->leftJoin('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                ->leftJoin('sys_positions as t4', 't2.position_id', '=', 't4.position_id')
                                ->where('t2.cur_pos', 1)
                                ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                ->where('hrmis_staffs.is_cont_staff', 0)
                                ->when(request()->pro_code, function($query) {
                                    $query->where('t2.pro_code', request()->pro_code);
                                })
                                ->when(request()->dis_code, function($query) {
                                    $query->where('t3.dis_code', request()->dis_code);
                                })
                                ->when(request()->location_code, function($query) {
                                    $query->where('t2.location_code', request()->location_code);
                                })
                                ->when(request()->position_id, function($query) {
                                    $query->where('t2.position_id', request()->position_id);
                                })
                                ->when(request()->status_id, function($query) {
                                    $query->where('hrmis_staffs.staff_status_id', request()->status_id);
                                })
                                ->when(request()->keyword, function($query) use($filterBy) {
                                    $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                })
                                ->select($selectQuery)
                                ->groupBy($selectQuery)
                                ->orderBy('position_hierarchy', 'ASC')
                                ->orderBy('hrmis_staffs.surname_kh', 'ASC')
                                ->orderBy('hrmis_staffs.name_kh', 'ASC')
                                ->paginate(30);

                /*$mobileUsers = 0;
                $mobileFUsers = 0;

                foreach ($staffs as $staff) {
                    $mobileUser = User::where('payroll_id', $staff->payroll_id)->whereIn('reg_type', [1, 2])->first();

                    if (!empty($mobileUser)) { 
                        $mobileUsers += 1;
                        if ($staff->sex == 1) {
                            $mobileFUsers += 1;
                        }
                    }
                }*/

                $femaleStaffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                ->leftJoin('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                ->where('t2.cur_pos', 1)
                                ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                ->where('hrmis_staffs.is_cont_staff', 0)
                                ->when(request()->pro_code, function($query) {
                                    $query->where('t2.pro_code', request()->pro_code);
                                })
                                ->when(request()->dis_code, function($query) {
                                    $query->where('t3.dis_code', request()->dis_code);
                                })
                                ->when(request()->location_code, function($query) {
                                    $query->where('t2.location_code', request()->location_code);
                                })
                                ->when(request()->position_id, function($query) {
                                    $query->where('t2.position_id', request()->position_id);
                                })
                                ->when(request()->status_id, function($query) {
                                    $query->where('hrmis_staffs.staff_status_id', request()->status_id);
                                })
                                ->when(request()->keyword, function($query) use($filterBy) {
                                    $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                })
                                ->where('hrmis_staffs.sex', '2')
                                ->distinct()
                                ->count('hrmis_staffs.payroll_id');
            }
        }
        
        return view('admin.staffs.index', compact(
                'provinces', 'positions', 'staffStatus', 'locations', 'staffs', 'districts', 'femaleStaffs',
                'mobileUsers', 'mobileFUsers'
            ));
    }


    public function create()
    {
        // Personal detail
        $staffStatus    = StaffStatus::pluck('status_kh', 'status_id')->all();
        $ethnics        = Ethnic::pluck('ethnic_kh', 'ethnic_id')->all();

        $provinces      = Province::active()->whereNotIn('pro_code', ['99'])
                                  ->pluck('name_kh', 'pro_code')
                                  ->all();

        $districts      = District::active()->pluck('name_kh');
        $salaryLevels   = SalaryLevel::pluck('salary_level_kh', 'salary_level_id')->all();
        $officialRanks  = [];
        $disabilities   = Disability::pluck('disability_kh', 'disability_id')->all();
        $locations      = $this->getUserLocations();
        $positions      = $this->getUserWorkplacePositions();
        $adminOffices   = [];

        return view('admin.staffs.create', compact(
                'staffStatus', 'ethnics', 'provinces', 'districts', 'salaryLevels', 'disabilities',
                'officialRanks', 'positions', 'adminOffices', 'locations',
            ));
    }


    public function store(StaffRequest $request)
    {
        // Check if payroll_id already taken
        $isPayrollTaken = Staff::where('payroll_id', $request->payroll_id)->first();

        if ($isPayrollTaken) {
            return back()->withInput()->withErrors(__('validation.duplicate_payroll'));
        }

        $staffData = $request->all();

        // Upload profile photo
        if( $request->hasFile('profile_photo') ) {
            $imageUpload = $request->file('profile_photo');
            //$fileName = $request->payroll_id.'.'.$imageUpload->getClientOriginalExtension();
            $fileName = $request->payroll_id.'.png';

            $profileImage = Image::make($imageUpload)->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream();

            Storage::disk('public')->put('images/staffs/'.$fileName, $profileImage);

            $staffData['photo'] = $fileName;
        }

        // Staff data info
        $staffData['surname_en']        = strtoupper($request->surname_en);
        $staffData['name_en']           = strtoupper($request->name_en);
        $staffData['bank_account']      = Str::of($request->bank_account)->replace(' ', '');
        $staffData['dob']               = date('Y-m-d', strtotime($request->dob));
        $staffData['start_date']        = $request->start_date > 0 ? 
                                            date('Y-m-d', strtotime($request->start_date)) : null;
        $staffData['appointment_date']  = $request->appointment_date > 0 ? 
                                            date('Y-m-d', strtotime($request->appointment_date)) : null;
        $staffData['maritalstatus_id']  = 1;
        $staffData['nid_card'] = substr($request->nid_card, 10, 1) == '_' ? 
                                    substr($request->nid_card, 0, 9) : $request->nid_card;
        $staffData['dtmt_school']       = $request->dtmt_school ? 1 : 0;
        $staffData['created_at']        = Carbon::now()->format('Y-m-d H:i:s');
        $staffData['created_by']        = Auth::user()->id;
        $staffData['updated_by']        = Auth::user()->id;
        
        Staff::create($staffData);


        // Work history
        $location = Location::where('location_code', $request->location_code)->first();

        // Position
        $position = Position::where('position_id', $request->position_id)->first();

        $workHistoryData['payroll_id']              = $request->payroll_id;
        $workHistoryData['pro_code']                = $location->pro_code;
        $workHistoryData['location_code']           = $location->location_code;
        $workHistoryData['sys_admin_office_id']     = $request->sys_admin_office_id > 0 ? $request->sys_admin_office_id : null;
        $workHistoryData['his_type_id']             = 1;
        $workHistoryData['country_id']              = null;
        $workHistoryData['position_id']             = $request->position_id > 0 ? $request->position_id : null;
        $workHistoryData['additional_position_id']  = $request->additional_position_id > 0 ? $request->additional_position_id : null;
        $workHistoryData['prokah']                  = $request->prokah ? $request->prokah : 0;
        $workHistoryData['prokah_num']              = $request->prokah_num;
        $workHistoryData['cur_pos']                 = 1;
        $workHistoryData['main_duty']               = $request->main_duty;
        $workHistoryData['description']             = !empty($position) ? ($position->position_kh.' តាមប្រកាសលេខ'.$request->prokah_num) : null;
        $workHistoryData['start_date']              = $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null;
        $workHistoryData['end_date']                = null;
        $workHistoryData['created_by']              = Auth::user()->id;
        $workHistoryData['updated_by']              = Auth::user()->id;

        WorkHistory::create($workHistoryData);


        // Staff salary
        $staffSalaryData['payroll_id']                  = $request->payroll_id;
        $staffSalaryData['salary_level_id']             = $request->salary_level_id;
        $staffSalaryData['official_rank_id']            = $request->official_rank_id > 0 ? $request->official_rank_id : null;
        $staffSalaryData['salary_degree']               = $request->salary_degree;
        $staffSalaryData['salary_type_prokah_num']      = $request->salary_type_prokah_num;
        $staffSalaryData['salary_type_prokah_order']    = $request->salary_type_prokah_order;
        $staffSalaryData['cardre_type_id']              = 1;
        $staffSalaryData['created_by']                  = Auth::user()->id;
        $staffSalaryData['updated_by']                  = Auth::user()->id;

        $staffSalaryData['salary_type_shift_date']      = $request->salary_type_shift_date > 0 ? date('Y-m-d', strtotime($request->salary_type_shift_date)) : null;

        $staffSalaryData['salary_special_shift_date']   = null;

        $staffSalaryData['salary_type_signdate']        = $request->salary_type_signdate > 0 ? date('Y-m-d', strtotime($request->salary_type_signdate)) : null;

        StaffSalary::create($staffSalaryData);

        return redirect()->route('staffs.edit', [app()->getLocale(), $request->payroll_id])
                         ->with('success', __('validation.add_success'));
    }


    /**
     * Show staff detail information
     *
     * @param  Staff  $staff
     */
    public function show(Staff $staff)
    {
        if (!auth()->user()->hasRole('administrator')) {
            $loginUserWorkPlace = auth()->user()->work_place;
            $staffWorkPlace = $staff->currentWorkPlace();

            if (auth()->user()->hasRole('school-admin', 'dept-admin') 
                && $loginUserWorkPlace->location_code != $staffWorkPlace->location_code) {
                return redirect()->route('page.notfound', app()->getLocale());
            }
            elseif (auth()->user()->hasRole('doe-admin') 
                && $loginUserWorkPlace->dis_code != $staffWorkPlace->dis_code) {
                return redirect()->route('page.notfound', app()->getLocale());
            }
        }

        //$headerid = $staff->payroll_id;

        $cur_WorkHistory = $staff->workHistories->where('cur_pos', 1)->first();

        $teachingInfo = $staff->teachings()->orderBy('year_id', 'desc')->first();

        $spouse = StaffFamily::where('payroll_id', $staff->payroll_id)
                             ->whereIn('relation_type_id', [1, 2])
                             ->first();

        $childrens = StaffFamily::where('payroll_id', $staff->payroll_id)
                                ->whereIn('relation_type_id', [3])
                                ->get();

        $staffSalary = StaffSalary::where('payroll_id', $staff->payroll_id)
                                ->where(function ($query){
                                    $query->where('request_cardre_check_status',5)
                                        ->orWhereNull('request_cardre_check_status');
                                })       
                                ->orderBy('salary_type_shift_date', 'desc')
                                ->first();

        // TCP Profession
        $staffTCPProfessions = ProfessionRecording::where('payroll_id', $staff->payroll_id)
                                                ->orderBy('date_received', 'desc')
                                                ->take(3)
                                                ->get();

        // Work History
        $staffWorkHistories = WorkHistory::where('payroll_id', $staff->payroll_id)
                                        ->orderBy('start_date', 'desc')
                                        ->get();

        $staffLeaves = StaffLeave::where('payroll_id', $staff->payroll_id)
                                ->orderBy('start_date', 'desc')
                                ->get();

        // Admirations
        $staffAdmirations = AdmirationBlame::where('payroll_id', $staff->payroll_id)
                                        ->orderBy('admiration_date', 'desc')
                                        ->get();

        // Qualifications
        $staffQualifications = StaffQualification::where('payroll_id', $staff->payroll_id)
                                                ->orderBy('qual_date', 'desc')
                                                ->get();

        // Profession
        $staffProfessions = StaffProfessional::where('payroll_id', $staff->payroll_id)
                                            ->orderBy('prof_date', 'desc')
                                            ->get();

        // Short Courses + Languages
        $staffShortCourses = ShortCourse::where('payroll_id', $staff->payroll_id)
                                        ->orderBy('start_date', 'desc')
                                        ->get();

        $staffLanguages = StaffLanguage::where('payroll_id', $staff->payroll_id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        // Teaching
        $curAcademicYear = AcademicYear::where('cur_year', 1)->first();
        $teachingSubjects = $staff->teachingSubjects()
                                  ->where('year_id', $curAcademicYear->year_id)
                                  ->orderBy('grade_id','asc')
                                  ->orderBy('grade_alias','asc')
                                  ->orderBy('day_id','asc')
                                  ->orderBy('hour_id','asc')
                                  ->orderBy('staff_sub_id','asc')
                                  ->get();

        //$staff->official_rank_kh = !empty($staffSalary->officialRank) ? $staffSalary->officialRank->official_rank_kh : '';
        $staff->salary_level_kh = !empty($staffSalary->salaryLevel) ? $staffSalary->salaryLevel->salary_level_kh : '';
        $staff->salary_degree_kh = !empty($staffSalary) ? $staffSalary->salary_degree : '';

        return view('admin.staffs.detail', compact(
            'staff', 'cur_WorkHistory', 'spouse', 'childrens', 'teachingInfo', 'staffTCPProfessions', 
            'staffSalary', 'staffWorkHistories', 'staffLeaves', 'staffAdmirations', 
            'staffQualifications', 'staffProfessions', 'staffShortCourses', 'staffLanguages', 
            'teachingSubjects'
        ));
    }


    /**
     * Edit staff info
     *
     * @param  Staff  $staff
     */
    public function edit(Staff $staff)
    {
        if (!auth()->user()->hasRole('administrator')) {
            $loginUserWorkPlace = auth()->user()->work_place;
            $staffWorkPlace = $staff->currentWorkPlace();
            $staffLocationCode = $staffWorkPlace ? $staffWorkPlace->location_code : '';
            $staffDisCode = $staffWorkPlace ? $staffWorkPlace->dis_code : '';
            $staffProCode = $staffWorkPlace ? $staffWorkPlace->pro_code : '';

            if (auth()->user()->hasRole('school-admin', 'dept-admin') 
                && $loginUserWorkPlace->location_code != $staffLocationCode) {
                return redirect()->route('page.notfound', app()->getLocale());
            }
            elseif (auth()->user()->hasRole('doe-admin') 
                && $loginUserWorkPlace->dis_code != $staffDisCode) {
                return redirect()->route('page.notfound', app()->getLocale());
            }
            elseif (auth()->user()->hasRole('poe-admin', 'central-admin') 
                && $loginUserWorkPlace->pro_code != $staffProCode) {
                return redirect()->route('page.notfound', app()->getLocale());
            }
        }

        $headerid   = $staff->payroll_id;
        $payroll_id = $staff->payroll_id;
        $staff->dob = $staff->dob > 0 ? date('d-m-Y', strtotime($staff->dob)) : null;
        $staff->start_date = $staff->start_date > 0 ? date('d-m-Y', strtotime($staff->start_date)) : null;
        $staff->appointment_date = $staff->appointment_date > 0 ? date('d-m-Y', strtotime($staff->appointment_date)) : null;
        
        $ethnics = Ethnic::pluck('ethnic_kh', 'ethnic_id')->all();
        $provinces = Province::active()->whereNotIn('pro_code', ['99'])
                            ->pluck('name_kh', 'pro_code')
                            ->all();
        $districts = District::active()->pluck('name_kh');
        
        // Get position_location
        $locationTypeID = !empty($staff->currentWorkPlace()) ? $staff->currentWorkPlace()->location_type_id : 0;
        $posLocations = PositionLocation::where('location_type_id', $locationTypeID)
                                        ->pluck('position_id')
                                        ->all();
        
        // Get position by location
        $positions = Position::whereIn('position_id', $posLocations)
                             ->pluck('position_kh', 'position_id')
                             ->all();

        $salaryLevels   = SalaryLevel::pluck('salary_level_kh', 'salary_level_id')->all();
        $disabilities   = Disability::pluck('disability_kh', 'disability_id')->all();
        $officialRanks  = OfficialRank::pluck('official_rank_kh', 'official_rank_id')->all();
        $adminOffices   = AdminOffice::all();
        $cardretypes    = CardreType::pluck('cardre_type_kh', 'cardre_type_id')->all();
        $locations = user_locations();

        $workHistories = WorkHistory::where('payroll_id', $staff->payroll_id)
                                    ->orderBy('start_date', 'DESC')
                                    ->take(3)
                                    ->get();

        $lastWorkHist   = WorkHistory::where('payroll_id', $staff->payroll_id)
                                     ->orderBy('start_date', 'DESC')
                                     ->first();
        $locationCode = $lastWorkHist ? $lastWorkHist->location_code : '';

        // Admin office of last workhistory
        $offices = AdminOffice::join('sys_offices', 'sys_admin_offices.office_id', '=', 'sys_offices.office_id')
                              ->where('sys_admin_offices.location_code', $locationCode)
                              ->pluck('sys_offices.office_kh', 'sys_offices.office_id')
                              ->all();

        // TCP Profession Info
        $profCategories = ProfessionCategory::pluck('tcp_prof_cat_kh', 'tcp_prof_cat_id')->all();
        $profRanks = ProfessionRank::pluck('tcp_prof_rank_kh', 'tcp_prof_rank_id')->all();
        $profRecordings = ProfessionRecording::where('payroll_id', $staff->payroll_id)
                                            ->orderBy('tcp_prof_rank_id', 'desc')
                                            ->take(3)
                                            ->get();
                                            
        //$request_cardre_check_status = StaffQualification::where('payroll_id', $staff->payroll_id)->where('request_cardre_check_status',1)->select("request_cardre_check_status")->first();                                    
        $request_cardre_check_status = StaffSalary::where('payroll_id', $payroll_id)->where('request_cardre_check_status',1)->select("request_cardre_check_status")->first();      

        return view('admin.staffs.create', compact(
                'ethnics', 'provinces', 'districts', 'salaryLevels', 'disabilities',
                'officialRanks', 'positions', 'adminOffices', 'locations', 'cardretypes',
                'staff', 'payroll_id', 'workHistories', 'lastWorkHist', 'offices', 
                'profCategories', 'profRanks', 'profRecordings',
                'request_cardre_check_status'
            ));
    }


    /**
     * Update existing staff info
     *
     * @param  Request $request
     * @param  Object  Staff  $staff
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        $staffData = $request->all();
        $payrollIDBeforeUpdate = $staff->payroll_id;

        if (auth()->user()->hasRole('administrator') && $payrollIDBeforeUpdate != $request->payroll_id) {
            // Check if payroll_id already taken
            $isPayrollTaken = Staff::where('payroll_id', $request->payroll_id)->first();

            if ($isPayrollTaken) {
                return back()->withInput()->withErrors(__('validation.duplicate_payroll'));
            }
        }

        // Only administrator can change the Payroll && DOB
        if (auth()->user()->hasRole('administrator')) {
            $staffData['payroll_id'] = $request->payroll_id;
            $staffData['dob'] = date('Y-m-d', strtotime($request->dob));
        }
        else { 
            $staffData['payroll_id'] = $staff->payroll_id;
            $staffData['dob'] = $staff->dob;
        }

        // Upload profile photo
        if( $request->hasFile('profile_photo') ) {
            // Remove old photo
            Storage::disk('public')->delete('images/staffs/'.$staff->photo);
            
            $imageUpload = $request->file('profile_photo');
            //$fileName = $staffData['payroll_id'].'.'.$imageUpload->getClientOriginalExtension();
            $fileName = $staff->payroll_id.'.png';

            $profileImage = Image::make($imageUpload)->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream();

            Storage::disk('public')->put('images/staffs/'.$fileName, $profileImage);

            $staffData['photo'] = $fileName;
        }
        else {
            $staffData['photo'] = !is_null($request->profile_photo_asset) ? $request->profile_photo_asset : null;
        }

        $staffData['bank_account']      = Str::of($request->bank_account)->replace(' ', '');
        $staffData['surname_en']        = strtoupper($request->surname_en);
        $staffData['name_en']           = strtoupper($request->name_en);
        $staffData['start_date']        = $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null;
        $staffData['appointment_date']  = $request->appointment_date > 0 ? date('Y-m-d', strtotime($request->appointment_date)) : null;
        $staffData['nid_card'] = substr($request->nid_card, 10, 1) == '_' ? substr($request->nid_card, 0, 9) : $request->nid_card;
        $staffData['sbsk'] = $request->sbsk ? 1 : 0;
        $staffData['disability_teacher'] = $request->disability_teacher ? 1 : 0;
        $staffData['disability_id'] = $request->disability_teacher ? $request->disability_id : null;
        $staffData['disability_note'] = $request->disability_teacher ? $request->disability_note : null;
        $staffData['created_by'] = Auth::user()->id;
        $staffData['updated_by'] = Auth::user()->id;
        $staffData['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
        
        // Update ref table if change payroll_id
        if (auth()->user()->hasRole('administrator') && $payrollIDBeforeUpdate != $request->payroll_id) {
            $staff->workHistories()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->admirations()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->knowledges()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->qualifications()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->shortcourses()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->languages()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->teachings()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->staffSalaries()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->families()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->teachingSubjects()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->users()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->transfers()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->profileChecks()->update(['payroll_id' => $request->payroll_id]);
            $staff->cpdEnrollmentCourses()->update(['payroll_id' => $request->payroll_id]);
            $staff->cpdProviders()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            $staff->TCPProfessions()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
             $staff->teacherSubjects()->update(['payroll_id' => $request->payroll_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }

        $staff->fill($staffData)->save();

        return redirect()->route('staffs.edit', [app()->getLocale(), $staff->payroll_id])
                         ->withSuccess(__('validation.update_success'));
    }

    /**
     * Remove existing staff info
     *
     * @param  Staff  $staff
     */
    public function destroy(Staff $staff)
    {
        // Remove staff workhistory
        $staff->workHistories()->delete();
        $staff->admirations()->delete();
        $staff->knowledges()->delete();
        $staff->qualifications()->delete();
        $staff->shortcourses()->delete();
        $staff->languages()->delete();
        $staff->teachings()->delete();
        $staff->staffSalaries()->delete();
        $staff->families()->delete();
        $staff->teachingSubjects()->delete();
        $staff->users()->delete();
        $staff->transfers()->delete();
        $staff->profileChecks()->delete();
        $staff->cpdEnrollmentCourses()->delete();
        $staff->cpdProviders()->delete();

        $staff->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }


    /**
     * Show staff profile
     */
    public function staffProfile()
    {
        $profile = Staff::where('payroll_id', Auth::user()->payroll_id)->first();

        $curPos = $profile->workHistories()->where('cur_pos', 1)->first();

        $workHistories = $profile->workHistories()
                                 ->whereNotIn('his_type_id', [5])
                                 ->orderBy('start_date', 'DESC')
                                 ->get();

        return view('admin.staffs.profile', compact('profile', 'curPos', 'workHistories'));
    }


    /**
     * Store admiration of staff/teacher
     *
     * @param payroll_id
     */
    public function storeAdmiration(Staff $staff, Request $request)
    {
        $admirationData = $request->all();

        $admirationData['payroll_id']       = $staff->payroll_id;
        $admirationData['pro_code']         = $staff->birth_pro_code;
        $admirationData['admiration_date']  = $request->admiration_date > 0 ? date('Y-m-d', strtotime($request->admiration_date)) : null;
        $admirationData['created_by']       = Auth::user()->id;
        $admirationData['updated_by']       = Auth::user()->id;

        AdmirationBlame::create($admirationData);

        return redirect()->route('staffs.create', app()->getLocale())
                         ->with('success', 'Admiration/Blame has beeen created successfully.');
    }


    /**
     * Print staff's administration certificate
     *
     * @param  Object  Staff  $staff
     */
    public function printAdministrationCertificate(Staff $staff)
    {
        $curpos = $staff->workhistories->where('cur_pos', 1)->first();

        $salary = StaffSalary::where('payroll_id', $staff->payroll_id)
                             ->orderBy('salary_type_shift_date', 'desc')
                             ->first();

        $position = !empty($curpos->position) ? $curpos->position->position_kh : '';

        $officialRank = !empty($curpos->officialRank) ? $curpos->officialRank->official_rank_kh : '';

        $office = !empty($curpos->office) ? $curpos->office->office_kh : '';

        $location = !empty($curpos->location) ? $curpos->location->location_kh : '';

        $salaryLevel = !empty($salary->salaryLevel) ? $salary->salaryLevel->salary_level_kh : '';

        return view('admin.staffs.partials.admin_certificate', compact(
                'staff', 'position', 'officialRank', 'salaryLevel', 'office', 'location'
            ));
    }

    /**
     * Filter teacher info
     *
     * @param  string  $p_filter
     */
    public function filterTeacher($p_filter)
    {
        $teachers = Staff::get()->pluck($p_filter)->all();

        return $teachers;
    }

    public function traineeList()
    {
        $staffs = Staff::select()
            ->with('currentWork')
            ->where('staff_status_id', StaffStatus::Trainee)
            ->where('is_newly_transferred', true)
            ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function ($q) {
                $q->whereHas('currentWork', function ($q) {
                    $q->where('location_code', auth()->user()->work_place->location_code);
                });
            })
            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function ($q) {
                $q->whereHas('currentWork.location', function ($q) {
                    $q->where('pro_code', auth()->user()->work_place->pro_code)
                        ->when(auth()->user()->hasRole('doe-admin'), function ($q) {
                            $q->where('dis_code', auth()->user()->work_place->dis_code);
                        });
                });
            })
            ->get();
        $processablePayrollIds = Staff::select()
            ->with('currentWork')
            ->where('staff_status_id', StaffStatus::Trainee)
            ->where('is_newly_transferred', true)
            ->whereHas('currentWork', function ($q) {
                $q->where('location_code', auth()->user()->work_place->location_code);
            })
            ->pluck('payroll_id')
            ->all();
        $locations = Location::select()
            ->when(auth()->user()->hasRole('poe-admin'), function ($q) {
                $q->where('pro_code', auth()->user()->work_place->pro_code);
            })
            ->when(auth()->user()->hasRole('doe-admin'), function ($q) {
                $q->where('dis_code', auth()->user()->work_place->dis_code);
            })
            ->when(auth()->user()->hasRole('school-admin', 'dept-admin'), function ($q) {
                $q->where('location_code', auth()->user()->work_place->location_code);
            })
            ->get()
            ->pluck('location_commune', 'location_code')
            ->all();
        return view('admin.staffs.trainee-list', compact('staffs', 'processablePayrollIds', 'locations'));
    }

    public function acceptTraineeList(Request $request)
    {
        try {
            $payrollIds = [];
            $payrollIds = explode(',', $request->payroll_ids);
            if (count($payrollIds)) {
                $processablePayrollIds = Staff::select()
                    ->with('currentWork')
                    ->where('staff_status_id', StaffStatus::Trainee)
                    ->where('is_newly_transferred', true)
                    ->whereHas('currentWork', function ($q) {
                        $q->where('location_code', auth()->user()->work_place->location_code);
                    })
                    ->pluck('payroll_id')
                    ->all();
                $accessible = count(array_intersect($payrollIds, $processablePayrollIds)) === count($payrollIds);
                if ($accessible) {
                    Staff::whereIn('payroll_id', $payrollIds)->update(['staff_status_id' => StaffStatus::Active, 'is_newly_transferred' => false]);
                }
            }

            return redirect()->route('staffs.trainee-list', [app()->getLocale()])->withSuccess(__('staff.success.accept_trainee_list'));
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function updateTraineeFutureLocation(Request $request, Staff $staff) 
    {
        try {
            $staff->currentWork()->update([
                'location_code' => $request->future_location_code,
                'pro_code' => substr($request->future_location_code, 0, 2),
            ]);
            return redirect()->route('staffs.trainee-list', [app()->getLocale()])->withSuccess(__('staff.success.update_future_location'));
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function ajaxFindStaffByPayroll(Request $request)
    {
        $staff = Staff::with('spouse')->where('payroll_id', $request->payroll)->first();
        return $staff ? $staff->toArray() : null;
    }

    /**
     * Show staff info by payroll_id
     */
    public function showStaffByPayrollID($payroll_id)
    {
        $staff = Staff::where('payroll_id', $payroll_id)
                      ->select('payroll_id', 'surname_kh', 'name_kh', 'surname_en', 'name_en', 
                            'sex', 'phone')
                      ->first();

        return $staff;
    }

    // Filter by keyword
    public function filterByKeyword($keyword)
    {
        $filterBy = 't1.'.$keyword;

        if ($keyword == 'fullnamekh') {
            $filterBy = 'CONCAT(surname_kh, " ", name_kh)';
        }
        elseif ($keyword == 'fullnameen') {
            $filterBy = 'CONCAT(surname_en, " ", name_en)';
        }

        $tempQuery = DB::table('hrmis_staffs as t1');

        if ((isset($_GET['pro_code']) && $_GET['pro_code']) 
            || (isset($_GET['dis_code']) && $_GET['dis_code']) 
            || (isset($_GET['location_code']) && $_GET['location_code']) 
            || (isset($_GET['position_id']) && $_GET['position_id']) 
            || (isset($_GET['status_id']) && $_GET['status_id'])) {
            $tempQuery->join('hrmis_work_histories as t2', 't1.payroll_id', '=', 't2.payroll_id')
                      ->where('t2.cur_pos', 1);

            if ($_GET['pro_code']) {
                $tempQuery->where('t2.pro_code', $_GET['pro_code']);
            }

            if ($_GET['dis_code']) {
                $tempQuery->where(DB::raw('LEFT(t2.location_code, 4)'), $_GET['dis_code']);
            }

            if ($_GET['location_code']) {
                $tempQuery->where('t2.location_code', $_GET['location_code']);
            }

            if ($_GET['position_id']) {
                $tempQuery->where('t2.position_id', $_GET['position_id']);
            }
            
            if ($_GET['status_id']) {
                $tempQuery->where(DB::raw('IFNULL(t2.status_id, 0)'), $_GET['status_id']);
            }
        }

        return $tempQuery->selectRaw('distinct '.$filterBy.' as keyword')->pluck('keyword')->all();
    }

    // Get user provinces
    public function getUserProvinces()
    {
        $userProCode = auth()->user()->work_place->pro_code;

        // Province
        $provinces = Province::when(!auth()->user()->hasRole('administrator'), function($query) use($userProCode) {
                                $query->where('pro_code', $userProCode);
                            })
                            ->pluck('name_kh', 'pro_code')
                            ->all();

        if (auth()->user()->hasRole('administrator')) {
            $provinces = ['' => __('common.choose').' ...'] + $provinces;
        }

        return $provinces;
    }

    // Get user districts
    public function getUserDistricts()
    {
        $userWorkPlace = auth()->user()->work_place;

        $districts = District::when((auth()->user()->level_id == 5 || auth()->user()->level_id == 4), function($query) use($userWorkPlace) {
                                $query->where('dis_code', $userWorkPlace->dis_code);
                            })
                            ->when((auth()->user()->level_id == 3 || auth()->user()->level_id == 2), function($query) use($userWorkPlace) {
                                $query->where('pro_code', $userWorkPlace->pro_code);
                            })
                            ->when(auth()->user()->hasRole('administrator'), function($query) {
                                $query->where('pro_code', 0);
                            })
                            ->pluck('name_kh', 'dis_code')
                            ->all();

        if (auth()->user()->hasRole('administrator')) {
            $districts = ['' => __('common.choose').' ...'];
        }
        elseif (auth()->user()->level_id == 3 || (auth()->user()->level_id == 2 && !auth()->user()->hasRole('dept-admin'))) {
            $districts = ['' => __('common.choose').' ...'] + $districts;
        }

        return $districts;
    }

    // Get user locations
    public function getUserLocations()
    {
        $userWorkPlace = auth()->user()->work_place;

        $locations = Location::when(auth()->user()->level_id == 5, function($query) use($userWorkPlace) {
                                $query->where('location_code', $userWorkPlace->location_code);
                            })
                            ->when(auth()->user()->hasRole('dept-admin'), function($query) use($userWorkPlace) {
                                $query->where('location_code', $userWorkPlace->location_code);
                            })
                            ->when(auth()->user()->level_id == 4, function($query) use($userWorkPlace) {
                                $query->where('dis_code', $userWorkPlace->dis_code);
                            })
                            ->when(auth()->user()->level_id == 3, function($query) use($userWorkPlace) {
                                $query->where('pro_code', $userWorkPlace->pro_code);
                            })
                            ->when(auth()->user()->level_id == 2, function($query) use($userWorkPlace) {
                                $query->where('pro_code', $userWorkPlace->pro_code);
                            })
                            ->pluck('location_kh', 'location_code')
                            ->all();

        if (auth()->user()->level_id != 5 && !auth()->user()->hasRole('dept-admin')) {
            $locations = ['' => __('common.choose').' ...'] + $locations;
        }

        return $locations;
    }

    // Get user workplace position
    public function getUserWorkplacePositions($p_location_code=null)
    {
        $userWorkPlace = auth()->user()->work_place;
        $locationTypeIDs = [];

        if (auth()->user()->hasRole('school-admin', 'dept-admin', 'leader')) {
            $locationTypeIDs = Location::where('location_code', $userWorkPlace->location_code)
                                    ->pluck('location_type_id')
                                    ->all();
        }
        elseif (auth()->user()->hasRole('doe-admin', 'poe-admin', 'central-admin')) {
            // request()->location_code
            if (!is_null($p_location_code)) {
                $locationTypeIDs = Location::where('location_code', $p_location_code)
                                           ->pluck('location_type_id')
                                           ->all();
            }
            else {
                $locationTypeIDs = Location::when(auth()->user()->hasRole('doe-admin'), function($query) use($userWorkPlace) {
                                                $query->where('dis_code', $userWorkPlace->dis_code);
                                            })
                                            ->when(auth()->user()->hasRole('poe-admin', 'central-admin'), function($query) use($userWorkPlace) {
                                                $query->where('pro_code', $userWorkPlace->pro_code);
                                            })
                                           ->pluck('location_type_id')
                                           ->all();
            }
        }

        if (auth()->user()->hasRole('administrator')) {
            $positions = Position::pluck('position_kh', 'position_id')
                                ->all();
        }
        else {
            $positions = Position::join('sys_position_location as t1', 'sys_positions.position_id', '=', 't1.position_id')
                                ->whereIn('t1.location_type_id', $locationTypeIDs)
                                ->pluck('sys_positions.position_kh', 'sys_positions.position_id')
                                ->all();
        }
        
        return $positions;
    }
}
