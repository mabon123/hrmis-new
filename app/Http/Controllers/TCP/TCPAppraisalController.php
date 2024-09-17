<?php

namespace App\Http\Controllers\TCP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Staff;
use App\Models\WorkHistory;
use App\Models\Position;
use App\Models\District;
use App\Models\Location;
use App\Models\TCP\TCPAppraisal;
use App\Models\TCP\TCPAppraiser;
use App\Models\TCP\ProfessionCategory;
use App\Models\TCP\ProfessionRank;
use App\Models\TCP\ProfessionRecording;
use App\Models\TCP\TcpStatus;
use App\Exports\TcpAppraisalExport;

class TCPAppraisalController extends Controller
{
    private static $doc_max_size_kb = 2048; //2 MB
    private static $doc_max_size_mb = 2;
    private static $appraisal_doc_max_size_kb = 5120;
    private static $appraisal_doc_max_size_mb = 5;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-tcp-appraisal-requests', ['only' => ['viewTCPAppraisals', 'show']]);
        $this->middleware('permission:view-tcp-appraisal', ['only' => ['index']]);
        $this->middleware('permission:create-tcp-appraisal', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-tcp-appraisal', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-tcp-appraisal', ['only' => ['destroy']]);
    }

    public function index()
    {
        $userWorkPlace = auth()->user()->work_place;
        $appraisals = TCPAppraisal::where('workplace_code', $userWorkPlace->location_code)
            ->orderBy('tcp_prof_cat_id')
            ->orderBy('tcp_appraisal_date')
            ->paginate(10);
        return view('admin.cpd_tcp.tcp_appraisals.index', compact(
            'appraisals'
        ));
    }

    public function showDetails($tcp_appraisal_id)
    {
        $tcp_appraisal = TCPAppraisal::where('tcp_appraisal_id', $tcp_appraisal_id)->first();
        $profCategories = ProfessionCategory::where('tcp_prof_cat_id', $tcp_appraisal->tcp_prof_cat_id)
            ->pluck('tcp_prof_cat_kh', 'tcp_prof_cat_id')->all();

        $profRanks = ProfessionRank::where('tcp_prof_rank_id', $tcp_appraisal->tcp_prof_rank_id)
            ->pluck('tcp_prof_rank_kh', 'tcp_prof_rank_id')->all();

        $appraisers = TCPAppraiser::where('tcp_appraisal_id', $tcp_appraisal->tcp_appraisal_id)
            ->pluck('appraiser_payroll')
            ->all();

        $staffs = Staff::join('tcp_appraisers', 'hrmis_staffs.payroll_id', '=', 'tcp_appraisers.appraiser_payroll')
            ->where('tcp_appraisal_id', $tcp_appraisal->tcp_appraisal_id)
            ->get()
            ->pluck('fullname_kh', 'payroll_id')
            ->all();

        $appraisal_staffs = Staff::where('payroll_id', $tcp_appraisal->staff_payroll)
            ->get()
            ->pluck('fullname_kh', 'payroll_id')->all();

        $position = $this->getStaffPosition($tcp_appraisal->staff_payroll);
        $view_data = true;

        return view('admin.cpd_tcp.tcp_appraisals.create', compact(
            'profCategories',
            'profRanks',
            'staffs',
            'appraisal_staffs',
            'tcp_appraisal',
            'appraisers',
            'position',
            'view_data'
        ));
    }

    public function viewTCPAppraisals()
    {
        $provinces = user_provinces();
        $districts = user_districts();
        $locations = !auth()->user()->hasRole('administrator') ? user_locations() : ['' => __('common.choose') . ' ...'];
        $years = TCPAppraisal::select(DB::raw('YEAR(tcp_appraisal_date) as year'))->distinct()->pluck('year', 'year')->all();
        $years = ['' => __('common.choose') . ' ...'] + $years;

        $status_field = app()->getLocale() == 'kh' ? 'status_kh' : 'status_en';
        $tcpStatusList = [];

        $profCategories = ProfessionCategory::when((auth()->user()->level_id == 5), function ($query) {
            $query->where('tcp_prof_cat_id', 1);
        })
            ->pluck('tcp_prof_cat_kh', 'tcp_prof_cat_id')->all();
        $profRanks = ['' => __('common.choose') . ' ...'];

        $userWorkPlace = auth()->user()->work_place;

        if (request()->search) {
            if (request()->pro_code) {
                $districts = District::active()
                    ->whereProCode(request()->get('pro_code'))
                    ->pluck('name_kh', 'dis_code')
                    ->all();
                $districts = ['' => __('common.choose') . ' ...'] + $districts;

                // Find location belong to province & district
                $locations = Location::when(request()->pro_code, function ($query) {
                    $query->where('pro_code', request()->pro_code);
                })
                    ->when(request()->dis_code, function ($query) {
                        $query->where('dis_code', request()->dis_code);
                    })
                    ->pluck('location_kh', 'location_code')
                    ->all();
                $locations = ['' => __('common.choose') . ' ...'] + $locations;
            }
            if (request()->tcp_prof_cat_id) {
                $profRanks = ProfessionRank::where('tcp_prof_cat_id', request()->tcp_prof_cat_id)
                    ->pluck('tcp_prof_rank_kh', 'tcp_prof_rank_id')->all();
                $profRanks = ['' => __('common.choose') . ' ...'] + $profRanks;
            }
        }
        $status_id = request()->tcp_status_id ? request()->tcp_status_id : 2; //Default show in-progress
        $appraisals = null;
        if (auth()->user()->hasRole('administrator')) {
            $tcpStatusList = TcpStatus::whereNotIn('tcp_status_id', [1, 3])
                ->pluck($status_field, 'tcp_status_id')->all();
            $tcpStatusList =  $tcpStatusList + [
                'p_doe' => __('tcp.status_p_doe'),
                'p_poe' => __('tcp.status_p_poe'),
                'r_doe' => __('tcp.status_r_doe'),
                'r_poe' => __('tcp.status_r_poe')
            ];

            $appraisals = TCPAppraisal::when(request()->tcp_prof_cat_id, function ($query) {
                $query->where('tcp_prof_cat_id', request()->tcp_prof_cat_id);
            })
                ->when(request()->tcp_prof_rank_id, function ($query) {
                    $query->where('tcp_prof_rank_id', request()->tcp_prof_rank_id);
                })
                ->when(request()->pro_code, function ($query) {
                    $query->where(DB::raw("LEFT(workplace_code, 2)"), request()->pro_code);
                })
                ->when(request()->dis_code, function ($query) {
                    $query->where(DB::raw("LEFT(workplace_code, 4)"), request()->dis_code);
                })
                ->when(request()->location_code, function ($query) {
                    $query->where('workplace_code', request()->location_code);
                })
                ->when(request()->year, function ($query) {
                    $query->where(DB::raw('YEAR(tcp_appraisal_date)'), request()->year);
                });

            if ($status_id == 'p_doe') {
                $appraisals = $appraisals->where('tcp_appraisals.tcp_status_id', 2)
                    ->where(DB::raw("IFNULL(doe_check_status, 4)"), 4)
                    ->where(DB::raw("IFNULL(poe_check_status, 4)"), 4)
                    ->where(DB::raw("IFNULL(department_check_status, 4)"), 4);
            } elseif ($status_id == 'p_poe') {
                $appraisals = $appraisals->where('tcp_appraisals.tcp_status_id', 2)
                    ->where(DB::raw("IFNULL(doe_check_status, 4)"), 5)
                    ->where(DB::raw("IFNULL(poe_check_status, 4)"), 4)
                    ->where(DB::raw("IFNULL(department_check_status, 4)"), 4);
            } elseif ($status_id == 'r_doe') {
                $appraisals = $appraisals->where('tcp_appraisals.tcp_status_id', 3)
                    ->where(DB::raw("IFNULL(doe_check_status, 4)"), 6)
                    ->where(DB::raw("IFNULL(department_check_status, 4)"), 4);
            } elseif ($status_id == 'r_poe') {
                $appraisals = $appraisals->where('tcp_appraisals.tcp_status_id', 3)
                    ->where(DB::raw("IFNULL(poe_check_status, 4)"), 6)
                    ->where(DB::raw("IFNULL(department_check_status, 4)"), 4);
            } else {
                $appraisals = $appraisals->where('tcp_appraisals.tcp_status_id', $status_id)
                    ->where(function ($query) {
                        $query->where(DB::raw("IFNULL(poe_check_status, 4)"), 5)
                            ->orWhere(DB::raw("IFNULL(department_check_status, 4)"), 5);
                    });
            }
            $appraisals = $appraisals->orderBy('tcp_appraisal_date')->get()->all();
        }
        //POE LEADER
        elseif (auth()->user()->level_id == 3) {
            $tcpStatusList = TcpStatus::where('tcp_status_id', '!=', 1)
                ->pluck($status_field, 'tcp_status_id')->all();

            $appraisals = TCPAppraisal::when(request()->tcp_prof_cat_id, function ($query) {
                $query->where('tcp_prof_cat_id', request()->tcp_prof_cat_id);
            })
                ->when(request()->tcp_prof_rank_id, function ($query) {
                    $query->where('tcp_prof_rank_id', request()->tcp_prof_rank_id);
                })
                ->where(DB::raw("LEFT(workplace_code, 2)"),  $userWorkPlace->pro_code)
                ->when(request()->dis_code, function ($query) {
                    $query->where(DB::raw("LEFT(workplace_code, 4)"), request()->dis_code);
                })
                ->when(request()->location_code, function ($query) {
                    $query->where('workplace_code', request()->location_code);
                })
                ->when(request()->year, function ($query) {
                    $query->where(DB::raw('YEAR(tcp_appraisal_date)'), request()->year);
                })
                ->where('tcp_appraisals.tcp_status_id', $status_id)
                ->when($status_id == 2, function ($query) {
                    $query->where(DB::raw("IFNULL(poe_check_status, 4)"), 4)
                        ->where(DB::raw("IFNULL(doe_check_status, 4)"), 5);
                })
                ->orderBy('tcp_appraisal_date')->get()->all();
        }
        //DOE LEADER
        else {
            $tcpStatusList = TcpStatus::where('tcp_status_id', '!=', 1)
                ->pluck($status_field, 'tcp_status_id')->all();

            $appraisals = TCPAppraisal::when(request()->tcp_prof_cat_id, function ($query) {
                $query->where('tcp_prof_cat_id', request()->tcp_prof_cat_id);
            })
                ->when(request()->tcp_prof_rank_id, function ($query) {
                    $query->where('tcp_prof_rank_id', request()->tcp_prof_rank_id);
                })
                ->where(DB::raw("LEFT(workplace_code, 2)"),  $userWorkPlace->pro_code)
                ->where(DB::raw("LEFT(workplace_code, 4)"), $userWorkPlace->dis_code)
                ->when(request()->location_code, function ($query) {
                    $query->where('workplace_code', request()->location_code);
                })
                ->when(request()->year, function ($query) {
                    $query->where(DB::raw('YEAR(tcp_appraisal_date)'), request()->year);
                })
                ->where('tcp_appraisals.tcp_status_id', $status_id)
                ->when($status_id == 2, function ($query) {
                    $query->where(DB::raw("IFNULL(doe_check_status, 4)"), 4);
                })
                ->orderBy('tcp_appraisal_date')->get()->all();
        }
        $status_name = $tcpStatusList[$status_id];
        return view('admin.cpd_tcp.tcp_appraisals.appraisal_list', compact(
            'provinces',
            'districts',
            'locations',
            'tcpStatusList',
            'profCategories',
            'profRanks',
            'appraisals',
            'status_id',
            'status_name',
            'years'
        ));
    }
    private function getRank($category_id, $rank_id)
    {
        $profRank = ProfessionRank::where('tcp_prof_cat_id', $category_id)
            ->where('tcp_prof_rank_id', $rank_id)->first();

        return $profRank;
    }

    private function createNewRank($category_id, $payroll_id)
    {
        $appraisal = TCPAppraisal::where('staff_payroll', $payroll_id)
            ->where('tcp_status_id', 5) //Check with succeed status
            ->orderBy('tcp_prof_rank_id', 'DESC')
            ->first();
        $rank_id = 0;
        if ($appraisal) {
            $rank_id = $appraisal->tcp_prof_rank_id + 1;
        } else {
            //Check from manual recordings
            $prof_recording = ProfessionRecording::where('payroll_id', $payroll_id)
                ->orderBy('tcp_prof_rank_id', 'DESC')
                ->first();
            if ($prof_recording) {
                $rank_id = $prof_recording->tcp_prof_rank_id + 1;
            } else {
                if ($category_id == 1) {
                    $rank_id = 1;
                } elseif ($category_id == 2) {
                    $rank_id = 4;
                } else {
                    $rank_id = 7;
                }
            }
        }
        return $this->getRank($category_id, $rank_id);
    }
    private function getStaffPosition($payroll_id)
    {
        $position = Position::join('hrmis_work_histories', 'sys_positions.position_id', '=', 'hrmis_work_histories.position_id')
            ->where('hrmis_work_histories.payroll_id', $payroll_id)
            ->where('cur_pos', 1)
            ->select('sys_positions.position_kh', 'sys_positions.position_en')
            ->first();
        return $position;
    }
    public function getPositionRank(Request $request)
    {
        $category_id = $request->category_id;
        $payroll_id = $request->payroll_id;
        return [
            'position'  => $this->getStaffPosition($payroll_id),
            'profRank'  => !empty($category_id) ? $this->createNewRank($category_id, $payroll_id) : null
        ];
    }
    private function getStaffList()
    {
        $userWorkPlace = auth()->user()->work_place;
        $staffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
            ->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
            //School or Department leader
            ->when((auth()->user()->level_id == 2 || auth()->user()->level_id == 5), function ($query) use ($userWorkPlace) {
                $query->where('hrmis_work_histories.location_code', $userWorkPlace->location_code);
            })
            //DOE leader. Take all staff in DOE + all school principals
            ->when(auth()->user()->level_id == 4, function ($query) use ($userWorkPlace) {
                $query->where('hrmis_work_histories.location_code', $userWorkPlace->location_code)
                    ->orWhere(function ($query2) use ($userWorkPlace) {
                        $query2->where(DB::raw("LEFT(hrmis_work_histories.location_code, 4)"), $userWorkPlace->dis_code)
                            ->where('position_kh', 'LIKE', '%នាយក%'); //Principal & Vice-principal
                    });
            })
            //POE leader. Take all staff in POE + all DOE directors
            ->when(auth()->user()->level_id == 3, function ($query) use ($userWorkPlace) {
                $query->where('hrmis_work_histories.location_code', $userWorkPlace->location_code)
                    ->orWhere(function ($query2) use ($userWorkPlace) {
                        $query2->where('hrmis_work_histories.pro_code', $userWorkPlace->pro_code)
                            ->whereIn('hrmis_work_histories.position_id', [26, 27, 46, 48]);
                    });
            })
            ->where('cur_pos', 1)
            ->select(DB::raw('CONCAT(surname_kh, \' \', name_kh) AS fullname'), 'hrmis_staffs.payroll_id')
            ->orderBy('fullname')
            ->pluck('fullname', 'payroll_id')
            ->all();
        return $staffs;
    }

    private function getAppraisalStaffs()
    {
        $userWorkPlace = auth()->user()->work_place;
        $staffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
            ->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
            //School leader
            ->when(auth()->user()->level_id == 5, function ($query) use ($userWorkPlace) {
                $query->where('hrmis_work_histories.location_code', $userWorkPlace->location_code)
                    ->where('position_kh', 'NOT LIKE', '%នាយក%'); //Principal & Vice-principal
            })
            //DOE leader. Take all staff in DOE + all school principals
            ->when(auth()->user()->level_id == 4, function ($query) use ($userWorkPlace) {
                $query->where('hrmis_work_histories.location_code', $userWorkPlace->location_code)
                    ->whereNotIn('hrmis_work_histories.position_id', [26, 27]) //DOE director & Deputy director
                    ->orWhere(function ($query2) use ($userWorkPlace) {
                        $query2->where(DB::raw("LEFT(hrmis_work_histories.location_code, 4)"), $userWorkPlace->dis_code)
                            ->where('position_kh', 'LIKE', '%នាយក%'); //Principal & Vice-principal
                    });
            })
            //POE leader. Take all staff in POE + all DOE directors
            ->when(auth()->user()->level_id == 3, function ($query) use ($userWorkPlace) {
                $query->where('hrmis_work_histories.location_code', $userWorkPlace->location_code)
                    ->whereNotIn('hrmis_work_histories.position_id', [15, 22]) //POE director & Deputy director
                    ->orWhere(function ($query2) use ($userWorkPlace) {
                        $query2->where('hrmis_work_histories.pro_code', $userWorkPlace->pro_code)
                            ->whereIn('hrmis_work_histories.position_id', [26, 27, 46, 48]); //DOE & PTTC directors & deputy
                    });
            })
            //Department leader
            ->when(auth()->user()->level_id == 2, function ($query) use ($userWorkPlace) {
                $query->where('hrmis_work_histories.location_code', $userWorkPlace->location_code)
                    ->where('position_en', 'NOT LIKE', '%director%');
            })
            ->where('cur_pos', 1)
            ->select(DB::raw('CONCAT(surname_kh, \' \', name_kh) AS fullname'), 'hrmis_staffs.payroll_id')
            ->orderBy('fullname')
            ->pluck('fullname', 'payroll_id')
            ->all();
        return $staffs;
    }
    // Create
    public function create()
    {
        $profCategories = ProfessionCategory::when((auth()->user()->level_id == 2 || auth()->user()->level_id == 3), function ($query) {
            $query->where('tcp_prof_cat_id', 3); //Edu. Specialist for central department or POE
        })
            ->when((auth()->user()->level_id == 4), function ($query) {
                $query->whereIn('tcp_prof_cat_id', [2, 3]); // Leader & Edu. for DOE
            })
            ->when((auth()->user()->level_id == 5), function ($query) {
                $query->whereIn('tcp_prof_cat_id', [1, 2]); // Teaching & Leader. for School
            })
            ->pluck('tcp_prof_cat_kh', 'tcp_prof_cat_id')->all();
        $profRanks = ['' => __('common.choose') . ' ...']; //ProfessionRank::pluck('tcp_prof_rank_kh', 'tcp_prof_rank_id')->all();
        $staffs = $this->getStaffList();
        $appraisal_staffs = $this->getAppraisalStaffs();
        return view('admin.cpd_tcp.tcp_appraisals.create', compact(
            'profCategories',
            'profRanks',
            'staffs',
            'appraisal_staffs'
        ));
    }
    private function getCurrentWorkplace($payroll_id)
    {
        $workplace = WorkHistory::where('payroll_id', $payroll_id)
            ->where('cur_pos', 1)->first();
        return $workplace ? $workplace->location_code : '00000000000'; //0x11 to avoid error
    }
    private function checkDuplicate($staff_payroll)
    {
        $appraisal =  TCPAppraisal::where('staff_payroll', $staff_payroll)
            ->where('tcp_status_id', 2)->first();
        return !empty($appraisal) ? true : false;
    }
    // Store
    public function store(Request $request)
    {
        $request->validate(
            [
                'tcp_prof_cat_id'       => 'required',
                'tcp_appraisal_date'    => 'required',
                'appraisers'            => 'required',
                'staff_payroll'         => 'required',
                'tcp_prof_rank_id'      => 'required',
                'cat1_score'            => 'required',
                'cat1_ref_doc'          => 'required|max:' . self::$doc_max_size_kb,
                'cat2_score'            => 'required',
                'cat2_ref_doc'          => 'required|max:' . self::$doc_max_size_kb,
                'cat3_score'            => 'required',
                'cat3_ref_doc'          => 'required|max:' . self::$doc_max_size_kb,
                'cat5_score'            => 'required',
                'cat5_ref_doc'          => 'required|max:' . self::$doc_max_size_kb,
                'appraisal_ref_doc'     => 'required|max:' . self::$appraisal_doc_max_size_kb
            ],
            [
                'cat1_ref_doc.max'      => __('validation.tcp_doc', ['attribute' => __('tcp.ref_doc') . ' - ' . __('tcp.credits_qualification'), 'max' => self::$doc_max_size_mb]),
                'cat2_ref_doc.max'      => __('validation.tcp_doc', ['attribute' => __('tcp.ref_doc') . ' - ' . __('tcp.credits_experience'), 'max' => self::$doc_max_size_mb]),
                'cat3_ref_doc.max'      => __('validation.tcp_doc', ['attribute' => __('tcp.ref_doc') . ' - ' . __('tcp.credits_achievement'), 'max' => self::$doc_max_size_mb]),
                'cat5_ref_doc.max'      => __('validation.tcp_doc', ['attribute' => __('tcp.ref_doc') . ' - ' . __('tcp.credits_prof_competence'), 'max' => self::$doc_max_size_mb]),
                'appraisal_ref_doc.max'      => __('validation.tcp_doc', ['attribute' => __('tcp.appraisal_ref_doc'), 'max' => self::$appraisal_doc_max_size_mb])
            ]
        );
        if ($this->checkDuplicate($request->staff_payroll)) {
            return back()->withInput()->withErrors(__('tcp.duplicate_message'));
        }

        $common_file_name = $request->staff_payroll . '_tcptrack' . $request->tcp_prof_cat_id . '_rank' . $request->tcp_prof_rank_id . '_' . Carbon::now()->format('Y-m-d.H:i:s');

        $cat1Image = $request->file('cat1_ref_doc');
        $cat1File = 'category1_' . $common_file_name . '.' . $cat1Image->getClientOriginalExtension();
        $request->file('cat1_ref_doc')->storeAs('images/tcp_docs/', $cat1File, 'public');

        $cat2Image = $request->file('cat2_ref_doc');
        $cat2File = 'category2_' . $common_file_name . '.' . $cat2Image->getClientOriginalExtension();
        $request->file('cat2_ref_doc')->storeAs('images/tcp_docs/', $cat2File, 'public');

        $cat3Image = $request->file('cat3_ref_doc');
        $cat3File = 'category3_' . $common_file_name . '.' . $cat3Image->getClientOriginalExtension();
        $request->file('cat3_ref_doc')->storeAs('images/tcp_docs/', $cat3File, 'public');

        $cat4File = null;
        if ($request->tcp_prof_cat_id != 3) {
            $request->validate([
                'cat4_score'        => 'required',
                'cat4_ref_doc'      => 'required|max:' . self::$doc_max_size_kb
            ], [
                'cat4_ref_doc.max'      => __('validation.max.file', ['attribute' => __('tcp.ref_doc') . ' - ' . __('tcp.credits_job_outcome'), 'max' => self::$doc_max_size_mb]),
            ]);
            $cat4Image = $request->file('cat4_ref_doc');
            $cat4File = 'category4_' . $common_file_name . '.' . $cat4Image->getClientOriginalExtension();
            $request->file('cat4_ref_doc')->storeAs('images/tcp_docs/', $cat4File, 'public');
        }
        $cat5Image = $request->file('cat5_ref_doc');
        $cat5File = 'category5_' . $common_file_name . '.' . $cat5Image->getClientOriginalExtension();
        $request->file('cat5_ref_doc')->storeAs('images/tcp_docs/', $cat5File, 'public');

        $apprImage = $request->file('appraisal_ref_doc');
        $apprFile = 'appr_' . $common_file_name . '.' . $apprImage->getClientOriginalExtension();
        $request->file('appraisal_ref_doc')->storeAs('images/tcp_docs/', $apprFile, 'public');
        $data = [
            'tcp_status_id' => 2, //In progress
            'tcp_prof_cat_id' => $request->tcp_prof_cat_id,
            'tcp_appraisal_date' => date('Y-m-d', strtotime($request->tcp_appraisal_date)),
            'staff_payroll' => $request->staff_payroll,
            'tcp_prof_rank_id' => $request->tcp_prof_rank_id,
            'workplace_code' => $this->getCurrentWorkplace($request->staff_payroll),
            'cat1_score' => $request->cat1_score,
            'cat1_ref_doc' => $cat1File,
            'cat1_note' => $request->cat1_note,
            'cat2_score' => $request->cat2_score,
            'cat2_ref_doc' => $cat2File,
            'cat2_note' => $request->cat2_note,
            'cat3_score' => $request->cat3_score,
            'cat3_ref_doc' => $cat3File,
            'cat3_note' => $request->cat3_note,
            'cat4_score' => $request->tcp_prof_cat_id == 3 ? 0 : $request->cat4_score,
            'cat4_ref_doc' => $cat4File ? $cat4File : null,
            'cat4_note' => $request->tcp_prof_cat_id == 3 ? null : $request->cat4_note,
            'cat5_score' => $request->cat5_score,
            'cat5_ref_doc' => $cat5File,
            'cat5_note' => $request->cat5_note,
            'appraisal_ref_doc' => $apprFile,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_by' => auth()->user()->id,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->id
        ];
        //Central Department
        if (auth()->user()->level_id == 1 || auth()->user()->level_id == 2) {
            $data['department_approver'] = auth()->user()->payroll_id;
            $data['department_check_status'] = 5; //auto-approve
            $data['department_check_date'] = Carbon::now()->format('Y-m-d H:i:s');
        }
        //POE
        elseif (auth()->user()->level_id == 3) {
            $data['poe_approver'] = auth()->user()->payroll_id;
            $data['poe_check_status'] = 5; //auto-approve
            $data['poe_check_date'] = Carbon::now()->format('Y-m-d H:i:s');
        }
        //DOE
        elseif (auth()->user()->level_id == 4) {
            $data['doe_approver'] = auth()->user()->payroll_id;
            $data['doe_check_status'] = 5; //auto-approve
            $data['doe_check_date'] = Carbon::now()->format('Y-m-d H:i:s');
        }
        //School
        else {
            $data['school_approver'] = auth()->user()->payroll_id;
            $data['school_check_status'] = 5; //auto-approve
            $data['school_check_date'] = Carbon::now()->format('Y-m-d H:i:s');
        }
        $appraisal = TCPAppraisal::create($data);

        if ($appraisal) {
            foreach ($request->appraisers as $appraiser) {
                TCPAppraiser::create([
                    'tcp_appraisal_id' => $appraisal->tcp_appraisal_id,
                    'appraiser_payroll' => $appraiser
                ]);
            }
            return redirect()->route('tcp-appraisals.index', app()->getLocale())
                ->withSuccess(__('validation.add_success'));
        }
        return back()->withInput()->withErrors(__('tcp.system_issue_message'));
    }

    // Edit
    public function edit(TCPAppraisal $tcp_appraisal)
    {
        $profCategories = ProfessionCategory::when((auth()->user()->level_id == 2 || auth()->user()->level_id == 3), function ($query) {
            $query->where('tcp_prof_cat_id', 3); //Edu. Specialist for central department or POE
        })
            ->when((auth()->user()->level_id == 4), function ($query) {
                $query->whereIn('tcp_prof_cat_id', [2, 3]); // Leader & Edu. for DOE
            })
            ->when((auth()->user()->level_id == 5), function ($query) {
                $query->whereIn('tcp_prof_cat_id', [1, 2]); // Teaching & Leader. for School
            })
            ->pluck('tcp_prof_cat_kh', 'tcp_prof_cat_id')->all();
        $profRanks = ProfessionRank::where('tcp_prof_rank_id', $tcp_appraisal->tcp_prof_rank_id)
            ->pluck('tcp_prof_rank_kh', 'tcp_prof_rank_id')->all();
        $appraisers = TCPAppraiser::where('tcp_appraisal_id', $tcp_appraisal->tcp_appraisal_id)
            ->pluck('appraiser_payroll')
            ->all();

        $staffs = $this->getStaffList();
        $appraisal_staffs = $this->getAppraisalStaffs();
        $position = $this->getStaffPosition($tcp_appraisal->staff_payroll);

        return view('admin.cpd_tcp.tcp_appraisals.create', compact(
            'profCategories',
            'profRanks',
            'staffs',
            'appraisal_staffs',
            'tcp_appraisal',
            'appraisers',
            'position'
        ));
    }

    // Update
    public function update(TCPAppraisal $tcp_appraisal, Request $request)
    {
        $request->validate([
            'tcp_prof_cat_id'       => 'required',
            'tcp_appraisal_date'    => 'required',
            'appraisers'            => 'required',
            'staff_payroll'         => 'required',
            'tcp_prof_rank_id'      => 'required',
            'cat1_score'            => 'required',
            'cat2_score'            => 'required',
            'cat3_score'            => 'required',
            'cat5_score'            => 'required'
        ]);
        if ($request->tcp_prof_cat_id != 3) {
            $request->validate([
                'cat4_score'        => 'required'
            ]);
        }

        if ($tcp_appraisal->staff_payroll != $request->staff_payroll && $this->checkDuplicate($request->staff_payroll)) {
            return back()->withInput()->withErrors(__('tcp.duplicate_message'));
        }

        $data = [
            'tcp_prof_cat_id' => $request->tcp_prof_cat_id,
            'tcp_appraisal_date' => date('Y-m-d', strtotime($request->tcp_appraisal_date)),
            'staff_payroll' => $request->staff_payroll,
            'tcp_prof_rank_id' => $request->tcp_prof_rank_id,
            'cat1_score' => $request->cat1_score,
            'cat1_note' => $request->cat1_note,
            'cat2_score' => $request->cat2_score,
            'cat2_note' => $request->cat2_note,
            'cat3_score' => $request->cat3_score,
            'cat3_note' => $request->cat3_note,
            'cat4_score' => $request->tcp_prof_cat_id == 3 ? 0 : $request->cat4_score,
            'cat4_note' => $request->tcp_prof_cat_id == 3 ? null : $request->cat4_note,
            'cat5_score' => $request->cat5_score,
            'cat5_note' => $request->cat5_note,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->id,
        ];
        //Central Department
        if (auth()->user()->level_id == 1 || auth()->user()->level_id == 2) {
            $data['department_approver'] = auth()->user()->payroll_id;
            $data['department_check_status'] = 5; //auto-approve
            $data['department_check_date'] = Carbon::now()->format('Y-m-d H:i:s');
        }
        //POE
        elseif (auth()->user()->level_id == 3) {
            $data['poe_approver'] = auth()->user()->payroll_id;
            $data['poe_check_status'] = 5; //auto-approve
            $data['poe_check_date'] = Carbon::now()->format('Y-m-d H:i:s');
        }
        //DOE
        elseif (auth()->user()->level_id == 4) {
            $data['doe_approver'] = auth()->user()->payroll_id;
            $data['doe_check_status'] = 5; //auto-approve
            $data['doe_check_date'] = Carbon::now()->format('Y-m-d H:i:s');
        }
        //School
        else {
            $data['school_approver'] = auth()->user()->payroll_id;
            $data['school_check_status'] = 5; //auto-approve
            $data['school_check_date'] = Carbon::now()->format('Y-m-d H:i:s');
        }


        $common_file_name = $request->staff_payroll . '_tcptrack' . $request->tcp_prof_cat_id . '_rank' . $request->tcp_prof_rank_id . '_' . Carbon::now()->format('Y-m-d.H:i:s');
        if ($request->hasFile('cat1_ref_doc')) {
            $request->validate(
                ['cat1_ref_doc'          => 'required|max:' . self::$doc_max_size_kb],
                ['cat1_ref_doc.max'      => __('validation.tcp_doc', ['attribute' => __('tcp.ref_doc') . ' - ' . __('tcp.credits_qualification'), 'max' => self::$doc_max_size_mb])]
            );
            if (Storage::disk('public')->exists('images/tcp_docs/' . $tcp_appraisal->cat1_ref_doc)) {
                Storage::disk('public')->delete('images/tcp_docs/' . $tcp_appraisal->cat1_ref_doc);
            }
            $imageUpload = $request->file('cat1_ref_doc');
            $fileName = 'category1_' . $common_file_name . '.' . $imageUpload->getClientOriginalExtension();
            $request->file('cat1_ref_doc')->storeAs('images/tcp_docs/', $fileName, 'public');
            $data['cat1_ref_doc'] = $fileName;
        }
        if ($request->hasFile('cat2_ref_doc')) {
            $request->validate(
                ['cat2_ref_doc'          => 'required|max:' . self::$doc_max_size_kb],
                ['cat2_ref_doc.max'      => __('validation.tcp_doc', ['attribute' => __('tcp.ref_doc') . ' - ' . __('tcp.credits_experience'), 'max' => self::$doc_max_size_mb])]
            );
            if (Storage::disk('public')->exists('images/tcp_docs/' . $tcp_appraisal->cat2_ref_doc)) {
                Storage::disk('public')->delete('images/tcp_docs/' . $tcp_appraisal->cat2_ref_doc);
            }
            $imageUpload = $request->file('cat2_ref_doc');
            $fileName = 'category2_' . $common_file_name . '.' . $imageUpload->getClientOriginalExtension();
            $request->file('cat2_ref_doc')->storeAs('images/tcp_docs/', $fileName, 'public');
            $data['cat2_ref_doc'] = $fileName;
        }
        if ($request->hasFile('cat3_ref_doc')) {
            $request->validate(
                ['cat3_ref_doc'          => 'required|max:' . self::$doc_max_size_kb],
                ['cat3_ref_doc.max'      => __('validation.tcp_doc', ['attribute' => __('tcp.ref_doc') . ' - ' . __('tcp.credits_achievement'), 'max' => self::$doc_max_size_mb])]
            );
            if (Storage::disk('public')->exists('images/tcp_docs/' . $tcp_appraisal->cat3_ref_doc)) {
                Storage::disk('public')->delete('images/tcp_docs/' . $tcp_appraisal->cat3_ref_doc);
            }
            $imageUpload = $request->file('cat3_ref_doc');
            $fileName = 'category3_' . $common_file_name . '.' . $imageUpload->getClientOriginalExtension();
            $request->file('cat3_ref_doc')->storeAs('images/tcp_docs/', $fileName, 'public');
            $data['cat3_ref_doc'] = $fileName;
        }
        if ($request->hasFile('cat4_ref_doc')) {
            $request->validate(
                ['cat4_ref_doc'          => 'required|max:' . self::$doc_max_size_kb],
                ['cat4_ref_doc.max'      => __('validation.tcp_doc', ['attribute' => __('tcp.ref_doc') . ' - ' . __('tcp.credits_job_outcome'), 'max' => self::$doc_max_size_mb])]
            );
            if (Storage::disk('public')->exists('images/tcp_docs/' . $tcp_appraisal->cat4_ref_doc)) {
                Storage::disk('public')->delete('images/tcp_docs/' . $tcp_appraisal->cat4_ref_doc);
            }
            $imageUpload = $request->file('cat4_ref_doc');
            $fileName = 'category4_' . $common_file_name . '.' . $imageUpload->getClientOriginalExtension();
            $request->file('cat4_ref_doc')->storeAs('images/tcp_docs/', $fileName, 'public');
            $data['cat4_ref_doc'] = $fileName;
        }
        if ($request->hasFile('cat5_ref_doc')) {
            $request->validate(
                ['cat5_ref_doc'          => 'required|max:' . self::$doc_max_size_kb],
                ['cat5_ref_doc.max'      => __('validation.tcp_doc', ['attribute' => __('tcp.ref_doc') . ' - ' . __('tcp.credits_prof_competence'), 'max' => self::$doc_max_size_mb])]
            );
            if (Storage::disk('public')->exists('images/tcp_docs/' . $tcp_appraisal->cat5_ref_doc)) {
                Storage::disk('public')->delete('images/tcp_docs/' . $tcp_appraisal->cat5_ref_doc);
            }
            $imageUpload = $request->file('cat5_ref_doc');
            $fileName = 'category5_' . $common_file_name . '.' . $imageUpload->getClientOriginalExtension();
            $request->file('cat5_ref_doc')->storeAs('images/tcp_docs/', $fileName, 'public');
            $data['cat5_ref_doc'] = $fileName;
        }
        if ($request->hasFile('appraisal_ref_doc')) {
            $request->validate(
                ['appraisal_ref_doc'          => 'required|max:' . self::$appraisal_doc_max_size_kb],
                ['appraisal_ref_doc.max'      => __('validation.tcp_doc', ['attribute' => __('tcp.appraisal_ref_doc'), 'max' => self::$appraisal_doc_max_size_mb])]
            );
            if (Storage::disk('public')->exists('images/tcp_docs/' . $tcp_appraisal->appraisal_ref_doc)) {
                Storage::disk('public')->delete('images/tcp_docs/' . $tcp_appraisal->appraisal_ref_doc);
            }
            $imageUpload = $request->file('appraisal_ref_doc');
            $fileName = 'appr_' . $common_file_name . '.' . $imageUpload->getClientOriginalExtension();
            $request->file('appraisal_ref_doc')->storeAs('images/tcp_docs/', $fileName, 'public');
            $data['appraisal_ref_doc'] = $fileName;
        }

        $tcp_appraisal->fill($data)->save();

        return redirect()->route('tcp-appraisals.index', app()->getLocale())
            ->withSuccess(__('validation.update_success'));
    }

    public function verifyList(Request $request)
    {
        $approve_ids = $request->approve_ids;
        $approve_notes = $request->approve_notes;
        $reject_ids = $request->reject_ids;
        $reject_notes = $request->reject_notes;
        $approver_field = null;
        $check_status_field = null;
        $check_date_field = null;
        $note_field = null;

        if (auth()->user()->hasRole('administrator')) {
            $approver_field = 'admin_approver';
            $check_status_field = 'admin_check_status';
            $check_date_field = 'admin_check_date';
            $note_field = 'admin_note';
        }
        //POE leader 
        elseif (auth()->user()->level_id == 3) {
            $approver_field = 'poe_approver';
            $check_status_field = 'poe_check_status';
            $check_date_field = 'poe_check_date';
            $note_field = 'poe_note';
        }
        //DOE leader
        else {
            $approver_field = 'doe_approver';
            $check_status_field = 'doe_check_status';
            $check_date_field = 'doe_check_date';
            $note_field = 'doe_note';
        }

        if (!empty($approve_ids) && count($approve_ids) > 0) {
            for ($i = 0; $i < count($approve_ids); $i++) {
                $update_row = array(
                    $approver_field         => auth()->user()->payroll_id,
                    $check_status_field     => 5, //approved
                    $check_date_field       => Carbon::now()->format('Y-m-d H:i:s'),
                    $note_field             => $approve_notes[$i]
                );
                if (auth()->user()->hasRole('administrator')) {
                    $update_row['tcp_status_id'] = 5; //Passed 
                }
                DB::table('tcp_appraisals')->where('tcp_appraisal_id', $approve_ids[$i])->update($update_row);
            }
        }
        if (!empty($reject_ids) && count($reject_ids) > 0) {
            for ($i = 0; $i < count($reject_ids); $i++) {
                $update_row = array(
                    $approver_field         => auth()->user()->payroll_id,
                    $check_status_field     => 6, //rejected
                    $check_date_field       => Carbon::now()->format('Y-m-d H:i:s'),
                    $note_field             => $reject_notes[$i],
                    'tcp_status_id'         => auth()->user()->hasRole('administrator') ? 4 : 3 //If admin then failed, else just rejected.
                );
                DB::table('tcp_appraisals')->where('tcp_appraisal_id', $reject_ids[$i])->update($update_row);
            }
        }
        $userWorkPlace = auth()->user()->work_place;
        $appraisals = null;
        if (auth()->user()->hasRole('administrator')) {
            $appraisals = TCPAppraisal::join('tcp_prof_categories', 'tcp_appraisals.tcp_prof_cat_id', '=', 'tcp_prof_categories.tcp_prof_cat_id')
                ->join('tcp_prof_ranks', 'tcp_appraisals.tcp_prof_rank_id', '=', 'tcp_prof_ranks.tcp_prof_rank_id')
                ->join('sys_locations', 'tcp_appraisals.workplace_code', '=', 'sys_locations.location_code')
                ->join('tcp_check_status', 'tcp_appraisals.tcp_status_id', '=', 'tcp_check_status.tcp_status_id')
                ->join('hrmis_staffs', 'tcp_appraisals.staff_payroll', '=', 'hrmis_staffs.payroll_id')
                ->when(request()->tcp_prof_cat_id, function ($query) {
                    $query->where('tcp_appraisals.tcp_prof_cat_id', request()->tcp_prof_cat_id);
                })
                ->when(request()->tcp_prof_rank_id, function ($query) {
                    $query->where('tcp_appraisals.tcp_prof_rank_id', request()->tcp_prof_rank_id);
                })
                ->when(request()->pro_code, function ($query) {
                    $query->where(DB::raw("LEFT(workplace_code, 2)"), request()->pro_code);
                })
                ->when(request()->dis_code, function ($query) {
                    $query->where(DB::raw("LEFT(workplace_code, 4)"), request()->dis_code);
                })
                ->when(request()->location_code, function ($query) {
                    $query->where('workplace_code', request()->location_code);
                })
                ->when(request()->year, function ($query) {
                    $query->where(DB::raw('YEAR(tcp_appraisal_date)'), request()->year);
                })
                ->where('tcp_appraisals.tcp_status_id', 2) // In progress
                ->where(function ($query) {
                    $query->where(DB::raw("IFNULL(poe_check_status, 4)"), 5)
                        ->orWhere(DB::raw("IFNULL(department_check_status, 4)"), 5);
                })
                ->select(
                    'tcp_appraisal_id',
                    'tcp_prof_cat_kh',
                    'tcp_prof_rank_kh',
                    'surname_kh',
                    'name_kh',
                    'tcp_appraisal_date',
                    DB::raw("DATE_FORMAT(tcp_appraisal_date, '%d-%m-%Y') as tcp_appraisal_date2"),
                    DB::raw("(cat1_score+cat2_score+cat3_score+cat4_score+cat5_score) as total_score"),
                    'location_kh',
                    'tcp_check_status.status_kh',
                    'tcp_check_status.status_en',
                    'admin_note as feedback',
                    'poe_note',
                    'doe_note',
                    'tcp_appraisals.tcp_status_id'
                )
                ->groupBy(
                    'tcp_appraisal_id',
                    'tcp_prof_cat_kh',
                    'tcp_prof_rank_kh',
                    'surname_kh',
                    'name_kh',
                    'tcp_appraisal_date',
                    DB::raw("DATE_FORMAT(tcp_appraisal_date, '%d-%m-%Y')"),
                    'location_kh',
                    'tcp_check_status.status_kh',
                    'tcp_check_status.status_en',
                    'admin_note',
                    'poe_note',
                    'doe_note',
                    'tcp_appraisals.tcp_status_id'
                )
                ->orderBy('tcp_appraisal_date')->get()->all();
        }
        //POE LEADER
        elseif (auth()->user()->level_id == 3) {
            $appraisals = TCPAppraisal::join('tcp_prof_categories', 'tcp_appraisals.tcp_prof_cat_id', '=', 'tcp_prof_categories.tcp_prof_cat_id')
                ->join('tcp_prof_ranks', 'tcp_appraisals.tcp_prof_rank_id', '=', 'tcp_prof_ranks.tcp_prof_rank_id')
                ->join('sys_locations', 'tcp_appraisals.workplace_code', '=', 'sys_locations.location_code')
                ->join('tcp_check_status', 'tcp_appraisals.tcp_status_id', '=', 'tcp_check_status.tcp_status_id')
                ->join('hrmis_staffs', 'tcp_appraisals.staff_payroll', '=', 'hrmis_staffs.payroll_id')
                ->when(request()->tcp_prof_cat_id, function ($query) {
                    $query->where('tcp_appraisals.tcp_prof_cat_id', request()->tcp_prof_cat_id);
                })
                ->when(request()->tcp_prof_rank_id, function ($query) {
                    $query->where('tcp_appraisals.tcp_prof_rank_id', request()->tcp_prof_rank_id);
                })
                ->where(DB::raw("LEFT(workplace_code, 2)"),  $userWorkPlace->pro_code)
                ->when(request()->dis_code, function ($query) {
                    $query->where(DB::raw("LEFT(workplace_code, 4)"), request()->dis_code);
                })
                ->when(request()->location_code, function ($query) {
                    $query->where('workplace_code', request()->location_code);
                })
                ->when(request()->year, function ($query) {
                    $query->where(DB::raw('YEAR(tcp_appraisal_date)'), request()->year);
                })
                ->where('tcp_appraisals.tcp_status_id', 2)
                ->where(DB::raw("IFNULL(poe_check_status, 4)"), 4)
                ->where(DB::raw("IFNULL(doe_check_status, 4)"), 5)
                ->select(
                    'tcp_appraisal_id',
                    'tcp_prof_cat_kh',
                    'tcp_prof_rank_kh',
                    'surname_kh',
                    'name_kh',
                    'tcp_appraisal_date',
                    DB::raw("DATE_FORMAT(tcp_appraisal_date, '%d-%m-%Y') as tcp_appraisal_date2"),
                    DB::raw("(cat1_score+cat2_score+cat3_score+cat4_score+cat5_score) as total_score"),
                    'location_kh',
                    'tcp_check_status.status_kh',
                    'tcp_check_status.status_en',
                    'poe_note as feedback',
                    'doe_note',
                    'tcp_appraisals.tcp_status_id'
                )
                ->groupBy(
                    'tcp_appraisal_id',
                    'tcp_prof_cat_kh',
                    'tcp_prof_rank_kh',
                    'surname_kh',
                    'name_kh',
                    'tcp_appraisal_date',
                    DB::raw("DATE_FORMAT(tcp_appraisal_date, '%d-%m-%Y')"),
                    'location_kh',
                    'tcp_check_status.status_kh',
                    'tcp_check_status.status_en',
                    'poe_note',
                    'doe_note',
                    'tcp_appraisals.tcp_status_id'
                )
                ->orderBy('tcp_appraisal_date')->get()->all();
        }
        //DOE LEADER
        else {
            $appraisals = TCPAppraisal::join('tcp_prof_categories', 'tcp_appraisals.tcp_prof_cat_id', '=', 'tcp_prof_categories.tcp_prof_cat_id')
                ->join('tcp_prof_ranks', 'tcp_appraisals.tcp_prof_rank_id', '=', 'tcp_prof_ranks.tcp_prof_rank_id')
                ->join('sys_locations', 'tcp_appraisals.workplace_code', '=', 'sys_locations.location_code')
                ->join('tcp_check_status', 'tcp_appraisals.tcp_status_id', '=', 'tcp_check_status.tcp_status_id')
                ->join('hrmis_staffs', 'tcp_appraisals.staff_payroll', '=', 'hrmis_staffs.payroll_id')
                ->when(request()->tcp_prof_cat_id, function ($query) {
                    $query->where('tcp_appraisals.tcp_prof_cat_id', request()->tcp_prof_cat_id);
                })
                ->when(request()->tcp_prof_rank_id, function ($query) {
                    $query->where('tcp_appraisals.tcp_prof_rank_id', request()->tcp_prof_rank_id);
                })
                ->where(DB::raw("LEFT(workplace_code, 2)"),  $userWorkPlace->pro_code)
                ->where(DB::raw("LEFT(workplace_code, 4)"), $userWorkPlace->dis_code)
                ->when(request()->location_code, function ($query) {
                    $query->where('workplace_code', request()->location_code);
                })
                ->when(request()->year, function ($query) {
                    $query->where(DB::raw('YEAR(tcp_appraisal_date)'), request()->year);
                })
                ->where('tcp_appraisals.tcp_status_id', 2)
                ->where(DB::raw("IFNULL(doe_check_status, 4)"), 4)
                ->select(
                    'tcp_appraisal_id',
                    'tcp_prof_cat_kh',
                    'tcp_prof_rank_kh',
                    'surname_kh',
                    'name_kh',
                    'tcp_appraisal_date',
                    DB::raw("DATE_FORMAT(tcp_appraisal_date, '%d-%m-%Y') as tcp_appraisal_date2"),
                    DB::raw("(cat1_score+cat2_score+cat3_score+cat4_score+cat5_score) as total_score"),
                    'location_kh',
                    'tcp_check_status.status_kh',
                    'tcp_check_status.status_en',
                    'doe_note as feedback',
                    'tcp_appraisals.tcp_status_id'
                )
                ->groupBy(
                    'tcp_appraisal_id',
                    'tcp_prof_cat_kh',
                    'tcp_prof_rank_kh',
                    'surname_kh',
                    'name_kh',
                    'tcp_appraisal_date',
                    DB::raw("DATE_FORMAT(tcp_appraisal_date, '%d-%m-%Y')"),
                    'location_kh',
                    'tcp_check_status.status_kh',
                    'tcp_check_status.status_en',
                    'doe_note',
                    'tcp_appraisals.tcp_status_id'
                )
                ->orderBy('tcp_appraisal_date')->get()->all();
        }

        return response($appraisals, 200);
    }
    //Export data
    public function exportAppraisalsExcel(Request $request)
    {
        $tcp_prof_cat_id = $request->tcp_prof_cat_id;
        $tcp_prof_rank_id = $request->tcp_prof_rank_id;
        $pro_code = $request->pro_code;
        $dis_code = $request->dis_code;
        $location_code = $request->location_code;
        $tcp_status_id = $request->tcp_status_id;
        $year = $request->year;
        return Excel::download(
            new TcpAppraisalExport($tcp_prof_cat_id, $tcp_prof_rank_id, $pro_code, $dis_code, $location_code, $tcp_status_id, $year),
            'TCP Appraisals List.xlsx'
        );
    }
    // Destroy
    public function destroy(TCPAppraisal $tcp_appraisal)
    {
        if (Storage::disk("public")->exists("/images/tcp_docs/" . $tcp_appraisal->cat1_ref_doc)) {
            Storage::delete("public/images/tcp_docs/" . $tcp_appraisal->cat1_ref_doc);
        }
        if (Storage::disk("public")->exists("/images/tcp_docs/" . $tcp_appraisal->cat2_ref_doc)) {
            Storage::delete("public/images/tcp_docs/" . $tcp_appraisal->cat2_ref_doc);
        }
        if (Storage::disk("public")->exists("/images/tcp_docs/" . $tcp_appraisal->cat3_ref_doc)) {
            Storage::delete("public/images/tcp_docs/" . $tcp_appraisal->cat3_ref_doc);
        }
        if (Storage::disk("public")->exists("/images/tcp_docs/" . $tcp_appraisal->cat4_ref_doc)) {
            Storage::delete("public/images/tcp_docs/" . $tcp_appraisal->cat4_ref_doc);
        }
        if (Storage::disk("public")->exists("/images/tcp_docs/" . $tcp_appraisal->cat5_ref_doc)) {
            Storage::delete("public/images/tcp_docs/" . $tcp_appraisal->cat5_ref_doc);
        }
        if (Storage::disk("public")->exists("/images/tcp_docs/" . $tcp_appraisal->appraisal_ref_doc)) {
            Storage::delete("public/images/tcp_docs/" . $tcp_appraisal->appraisal_ref_doc);
        }

        TCPAppraiser::where('tcp_appraisal_id', $tcp_appraisal->tcp_appraisal_id)->delete();
        $tcp_appraisal->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
