<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use Carbon\Carbon;
use App\Models\Location;
use App\Models\Staff;
//use App\Models\StaffLeave;
use App\Models\StaffStatus;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->active == 0) {
            Auth::logout();
            return redirect()->route('login', 'en');
        }
        
        $userWorkPlace = auth()->user()->work_place;

        if (auth()->user()->hasRole('cpd_provider')) {
            return redirect()->route('cpd-schedule-courses.index', app()->getLocale());
        }

        $userWorkPlaceName = Location::where('location_code', $userWorkPlace->location_code)
                                    ->select('location_kh')
                                    ->first()
                                    ->location_kh;

        $nextMonth = Carbon::now()->addMonth();
        $next3Month = Carbon::now()->addMonths(3);

        // Newly trained teacher
        $newlyTrainedTeacher = Staff::select()
                                ->with('currentWork')
                                ->where('staff_status_id', StaffStatus::Trainee)
                                ->where('is_newly_transferred', true)
                                ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function ($q) {
                                    $q->whereHas('currentWork', function($q) {
                                        $q->where('location_code', auth()->user()->work_place->location_code);
                                    });
                                })
                                ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function($q) {
                                    $q->whereHas('currentWork.location', function($q) {
                                        $q->where('pro_code', auth()->user()->work_place->pro_code)
                                            ->when(auth()->user()->hasRole('doe-admin'), function ($q) {
                                                $q->where('dis_code', auth()->user()->work_place->dis_code);
                                            });
                                    });
                                })
                                ->count('payroll_id');

        // Off duty staff
        $offDutyStaff = Staff::with('currentWork')
                            ->where('staff_status_id', 8)
                            ->whereHas('currentWork', function($query) use($next3Month) {
                                $query->whereDate('end_date', '<=', $next3Month);
                                $query->orWhereNull('end_date');
                            })
                            ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function($query) {
                                $query->whereHas('currentWork', function($query) {
                                    $query->where('location_code', auth()->user()->work_place->location_code);
                                });
                            })
                            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function($query) {
                                $query->whereHas('currentWork.location', function($query) {
                                    $query->where('pro_code', auth()->user()->work_place->pro_code)
                                        ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                                            $query->where('dis_code', auth()->user()->work_place->dis_code);
                                        });
                                });
                            })
                            ->count('payroll_id');

        // Leave without pay staff
        $leaveWithoutPayStaff = Staff::with('currentWork')
                                    ->where('staff_status_id', 2)
                                    ->whereHas('currentWork', function($query) use($next3Month) {
                                        $query->whereDate('end_date', '<=', $next3Month);
                                        $query->orWhereNull('prokah_num');
                                    })
                                    ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function($query) {
                                        $query->whereHas('currentWork', function($query) {
                                            $query->where('location_code', auth()->user()->work_place->location_code);
                                        });
                                    })
                                    ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function($query) {
                                        $query->whereHas('currentWork.location', function($query) {
                                            $query->where('pro_code', auth()->user()->work_place->pro_code)
                                                ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                                                    $query->where('dis_code', auth()->user()->work_place->dis_code);
                                                });
                                        });
                                    })
                                    ->count('payroll_id');

        // Continue study staff
        $continueStudyStaff = Staff::with('currentWork')
                                    ->where('staff_status_id', 10)
                                    ->whereHas('currentWork', function($query) use($nextMonth) {
                                        $query->whereDate('end_date', '<=', $nextMonth);
                                    })
                                    ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function($query) {
                                        $query->whereHas('currentWork', function($query) {
                                            $query->where('location_code', auth()->user()->work_place->location_code);
                                        });
                                    })
                                    ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function($query) {
                                        $query->whereHas('currentWork.location', function($query) {
                                            $query->where('pro_code', auth()->user()->work_place->pro_code)
                                                ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                                                    $query->where('dis_code', auth()->user()->work_place->dis_code);
                                                });
                                        });
                                    })
                                    ->count('payroll_id');

        // Staff move-in
        $movedInStaff = Staff::join('hrmis_staff_movements', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_movements.payroll_id')
                            ->when(auth()->user()->hasRole('school-admin', 'dept-admin'), function($query) use($userWorkPlace) {
                                $query->where('hrmis_staff_movements.new_location_code', $userWorkPlace->location_code);
                            })
                            ->when(auth()->user()->hasRole('doe-admin'), function($query) use($userWorkPlace) {
                                $query->where('hrmis_staff_movements.new_dis_code', $userWorkPlace->dis_code);
                            })
                            ->when(auth()->user()->hasRole('poe-admin', 'central-admin'), function($query) use($userWorkPlace) {
                                $query->where('hrmis_staff_movements.new_pro_code', $userWorkPlace->pro_code);
                            })
                            ->where('hrmis_staff_movements.transfer_status', 0)
                            ->count('hrmis_staffs.payroll_id');

        $staffOnLeave = Staff::join('hrmis_staff_leaves', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_leaves.payroll_id')
                            ->whereDate('hrmis_staff_leaves.start_date', '<=', Carbon::now()->format('Y-m-d'))
                            ->whereDate('hrmis_staff_leaves.end_date', '>=', Carbon::now()->format('Y-m-d'))
                            ->when(auth()->user()->hasRole('school-admin', 'dept-admin'), function($query) {
                                $query->whereHas('currentWork', function($query) {
                                    $query->where('location_code', auth()->user()->work_place->location_code);
                                });
                            })
                            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function($query) {
                                $query->whereHas('currentWork.location', function($query) {
                                    $query->where('pro_code', auth()->user()->work_place->pro_code)
                                        ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                                            $query->where('dis_code', auth()->user()->work_place->dis_code);
                                        });
                                });
                            })
                            ->count('hrmis_staffs.payroll_id');
        
        // Request Cardre Certification
        $cardreCertification = Staff::with('currentWork')
                            ->join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
                            ->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                            ->when(auth()->user()->hasRole('school-admin', 'dept-admin'), function($query) {
                                $query->whereHas('currentWork.location', function($query) {
                                    $query->where('location_code', auth()->user()->work_place->location_code);
                                });
                            })
                            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin', 'central-admin'), function($query) {
                                $query->whereHas('currentWork.location', function($query) {
                                    $query->where('pro_code', auth()->user()->work_place->pro_code)
                                        ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                                            $query->where('dis_code', auth()->user()->work_place->dis_code);
                                        });
                                });
                            })
                            ->where('hrmis_staffs.is_cont_staff', 0)
                            ->where('hrmis_staffs.staff_status_id', 1)
                            ->where('hrmis_work_histories.cur_pos', 1)
                            ->where('hrmis_staff_salaries.cardre_type_id', 2)
                            ->where('request_cardre_check_status', 1)
                            ->count('hrmis_staffs.payroll_id');

        // Request Cardre Cercle
        // $cardreCercle = Staff::with(['currentWork'])
        //                     ->join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
        //                     ->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
        //                     ->when(auth()->user()->hasRole('school-admin', 'dept-admin'), function($query) {
        //                         $query->whereHas('currentWork.location', function($query) {
        //                             $query->where('location_code', auth()->user()->work_place->location_code);
        //                         });
        //                     })
        //                     ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function($query) {
        //                         $query->whereHas('currentWork.location', function($query) {
        //                             $query->where('pro_code', auth()->user()->work_place->pro_code)
        //                                 ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
        //                                     $query->where('dis_code', auth()->user()->work_place->dis_code);
        //                                 });
        //                         });
        //                     })
        //                     ->where('hrmis_staffs.is_cont_staff', 0)
        //                     ->where('hrmis_staffs.staff_status_id', 1)
        //                     ->where('hrmis_work_histories.cur_pos', 1)
        //                     ->where('hrmis_staff_salaries.cardre_type_id', 1)
        //                     ->where('request_cardre_check_status', 1)
        //                     ->count('hrmis_staffs.payroll_id'); 
        $cardreCercle =  count(Staff::when(auth()->user()->hasRole('school-admin', 'dept-admin'), function ($query) {
                                    $query->whereHas('currentWork.location', function ($query) {
                                        $query->where('pro_code', auth()->user()->work_place->pro_code)
                                            ->where('dis_code', auth()->user()->work_place->dis_code)
                                            ->where('location_code', auth()->user()->work_place->location_code); 
                                    });
                                })
                                ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
                                    $query->whereHas('currentWork.location', function ($query) {
                                        $query->where('pro_code', auth()->user()->work_place->pro_code)
                                            ->where('dis_code', auth()->user()->work_place->dis_code);
                                    });
                                })
                                ->when(auth()->user()->hasRole('poe-admin', 'central-admin'), function ($query) {
                                    $query->whereHas('currentWork.location', function ($query) {
                                        $query->where('pro_code', auth()->user()->work_place->pro_code);
                                    });
                                })  
                                ->join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
                                ->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                                ->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
                                ->where('hrmis_staffs.is_cont_staff', 0)
                                ->where('hrmis_staffs.staff_status_id', 1)
                                ->where('hrmis_work_histories.cur_pos', 1)
                                ->whereIn('hrmis_staff_salaries.cardre_type_id',  [1,2,7,8,10])
                                ->where('request_cardre_check_status', 1)
                                ->orderBy('hrmis_staff_salaries.salary_level_id', 'ASC')
                                ->orderBy('hrmis_staff_salaries.salary_degree', 'ASC')
                                ->orderBy('hrmis_staff_salaries.payroll_id', 'ASC')
                                ->orderBy('hrmis_staff_salaries.salary_type_prokah_order', 'ASC')
                                ->groupBy('hrmis_staffs.payroll_id')
                                ->select('hrmis_staffs.payroll_id')->get());     

        return view('admin.home', compact(
                'userWorkPlaceName', 'newlyTrainedTeacher', 'offDutyStaff', 'leaveWithoutPayStaff',
                'continueStudyStaff', 'movedInStaff', 'staffOnLeave','cardreCertification','cardreCercle'
            ));
    }







    /**
     * Page not found
     */
    public function pageNotFound()
    {
    	return view('errors.404');
    }


    /**
     * Show other tools for administrator
     */
    public function otherTools()
    {
        $icon = 'far fa-arrow-alt-circle-right';
        $col  = 'col-sm-3';

        return view('admin.tools', compact('icon', 'col'));
    }
}
