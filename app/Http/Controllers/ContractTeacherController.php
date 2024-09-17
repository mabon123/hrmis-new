<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Auth;
use DB;
use Image;
use Storage;
use Carbon\Carbon;
use App\Http\Requests\ContStaffRequest;

use App\Models\Province;
use App\Models\District;
use App\Models\Commune;
use App\Models\Village;
use App\Models\Ethnic;
use App\Models\ContractStaffPosition;
use App\Models\ContractTeacher;
use App\Models\ContractTeacherHistory;
use App\Models\ContractTeacherTeaching;
use App\Models\ContractTeacherTeachingSubject;
use App\Models\ContractType;
use App\Models\Location;
use App\Models\Position;
use App\Models\ProfessionalCategory;
use App\Models\QualificationCode;
use App\Models\Staff;
use App\Models\StaffProfessional;
use App\Models\StaffQualification;
use App\Models\StaffStatus;
use App\Models\StaffTeaching;
use App\Models\TeachingSubject;
use App\Models\Subject;
use App\Models\WorkHistory;

class ContractTeacherController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-cont-staffs', ['only' => ['index']]);
        $this->middleware('permission:create-cont-staffs', ['only' => ['create', 'store']]);
    	$this->middleware('permission:edit-cont-staffs', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-cont-staffs', ['only' => ['destroy']]);
    }


    /**
     * Contract Teacher Listing
     */
    public function index()
    {
        $userWorkPlace = auth()->user()->work_place;
        $provinces = user_provinces();
        $districts = user_districts();
        $locations = !auth()->user()->hasRole('administrator') ? user_locations() : [];

        $contTypes = ContractType::pluck('contract_type_kh', 'contract_type_id')->all();
        $contPositions = ContractStaffPosition::where('contract_type_id', request()->get('contract_type_id', null))
                                              ->pluck('cont_pos_kh', 'cont_pos_id')
                                              ->all();
        
        $contTeachers = [];
        $selectQuery = [
                'hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'surname_en', 'name_en', 'sex', 'dob', 
                't2.location_kh', 'hrmis_staffs.staff_status_id'
            ];

        // Search - Filter By
        if (request()->search) {
            $filterBy = request()->filter_by;

            if (request()->filter_by == 'fullnamekh') {
                $filterBy = DB::raw('CONCAT(surname_kh, " ", name_kh)');
            }
            elseif (request()->filter_by == 'fullnameen') {
                $filterBy = DB::raw('CONCAT(surname_en, " ", name_en)');
            }
        }

        // School Administrator || Department Administrator
        if (auth()->user()->level_id == 5) {
            $contTeachers = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                 ->where('t2.cur_pos', 1)
                                 ->where('hrmis_staffs.is_cont_staff', 1)
                                 ->whereNotIn('t2.contract_type_id',[4])
                                 ->where('t2.location_code', $userWorkPlace->location_code)
                                 ->select($selectQuery)
                                 ->paginate(10);

            if( request()->search ) {
                $contTeachers = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                     ->where('t2.cur_pos', 1)
                                     ->where('hrmis_staffs.is_cont_staff', 1)
                                     ->where('t2.location_code', $userWorkPlace->location_code)
                                     ->when(empty(request()->contract_type_id),function($query){
                                        $query->whereNotIn('t2.contract_type_id',[4]);
                                     })                                    
                                     ->when(request()->contract_type_id, function($query) {
                                        $query->where('t2.contract_type_id', request()->contract_type_id);
                                     })
                                     ->when(request()->cont_pos_id, function($query) {
                                        $query->where('t2.cont_pos_id', request()->cont_pos_id);
                                     })
                                     ->when(request()->keyword, function($query) use($filterBy) {
                                        $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                     })
                                     ->select($selectQuery)
                                     ->paginate(10);
            }
        }

        // DOE Administrator
        elseif (auth()->user()->level_id == 4) {
            $locations = ['' => __('common.choose').' ...'] + $locations;

            if( request()->search ) {
                $contTeachers = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                     ->leftJoin('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                     ->where('t2.cur_pos', 1)
                                     ->where('hrmis_staffs.is_cont_staff', 1)
                                     ->where('t3.dis_code', 'LIKE', $userWorkPlace->dis_code)
                                     ->when(empty(request()->contract_type_id),function($query){
                                        $query->whereNotIn('t2.contract_type_id',[4]);
                                     }) 
                                     ->when(request()->contract_type_id, function($query) {
                                        $query->where('contract_type_id', request()->contract_type_id);
                                     })
                                     ->when(request()->cont_pos_id, function($query) {
                                        $query->where('t2.cont_pos_id', request()->cont_pos_id);
                                     })
                                     ->when(request()->location_code, function($query) {
                                        $query->where('t2.location_code', request()->location_code);
                                     })
                                     ->when(request()->keyword, function($query) use($filterBy) {
                                        $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                     })
                                     ->select($selectQuery)
                                     ->paginate(10);
            }
        }

        // POE Administrator
        elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
            if (auth()->user()->hasRole('poe-admin')) {
                $districts = ['' => __('common.choose').' ...'] + $districts;
            }
            
            $locations = ['' => __('common.choose').' ...'] + $locations;

            if( request()->search ) {
                $contTeachers = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                     ->where('t2.cur_pos', 1)
                                     ->where('hrmis_staffs.is_cont_staff', 1)
                                     ->where('t2.pro_code', $userWorkPlace->pro_code)
                                     ->when(request()->dis_code, function($query) {
                                        $query->where('t2.dis_code', request()->dis_code);
                                     })
                                     ->when(empty(request()->contract_type_id),function($query){
                                        $query->whereNotIn('t2.contract_type_id',[4]);
                                     }) 
                                     ->when(request()->contract_type_id, function($query) {
                                        $query->where('contract_type_id', request()->contract_type_id);
                                     })
                                     ->when(request()->cont_pos_id, function($query) {
                                        $query->where('t2.cont_pos_id', request()->cont_pos_id);
                                     })
                                     ->when(request()->location_code, function($query) {
                                        $query->where('t2.location_code', request()->location_code);
                                     })
                                     ->when(request()->keyword, function($query) use($filterBy) {
                                        $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                     })
                                     ->select($selectQuery)
                                     ->paginate(10);
            }
        }

        // System Administrator
        else {
            $provinces = ['' => __('common.choose').' ...'] + $provinces;
            $districts = ['' => __('common.choose').' ...'] + $districts;
            $locations = ['' => __('common.choose').' ...'] + $locations;

            if( request()->search ) {
                $contTeachers = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                     ->where('t2.cur_pos', 1)
                                     ->where('hrmis_staffs.is_cont_staff', 1)
                                     ->when(request()->pro_code, function($query) {
                                        $query->where('t2.pro_code', request()->pro_code);
                                     })
                                     ->when(request()->dis_code, function($query) {
                                        $query->where('t2.dis_code', request()->dis_code);
                                     })
                                      ->when(empty(request()->contract_type_id),function($query){
                                        $query->whereNotIn('t2.contract_type_id',[4]);
                                     }) 
                                     ->when(request()->contract_type_id, function($query) {
                                        $query->where('t2.contract_type_id', request()->contract_type_id);
                                     })
                                     ->when(request()->cont_pos_id, function($query) {
                                        $query->where('t2.cont_pos_id', request()->cont_pos_id);
                                     })
                                     ->when(request()->location_code, function($query) {
                                        $query->where('t2.location_code', request()->location_code);
                                     })
                                     ->when(request()->keyword, function($query) use($filterBy) {
                                        $query->where($filterBy, 'like', '%'.request()->keyword.'%');
                                     })
                                     ->select($selectQuery)
                                     ->paginate(10);
            }
        }

    	return view('admin.contract_teachers.index', compact(
    			'provinces', 'locations', 'contTeachers', 'contTypes', 'districts', 'contPositions'
    		));
    }

    // 

    // Search
    public function searchContStaff()
    {
        return 0;
    }


    /**
     * Create New Contract Teacher
     */
    public function create()
    {
        //return 'System Maintenance...!';
    	$provinces = Province::active()->whereNotIn('pro_code', ['99'])->pluck('name_kh', 'pro_code')->all();
        $districts = District::active()->pluck('name_kh');
        $locations = user_locations();
        $ethnics = Ethnic::pluck('ethnic_kh', 'ethnic_id')->all();
        $contractTypes = ContractType::pluck('contract_type_kh', 'contract_type_id')->all();

    	$qualificationCodes = QualificationCode::orderBy('qualification_hierachy', 'ASC')
                                               ->pluck('qualification_kh', 'qualification_code')
                                               ->all();
        
        $subjects = Subject::orderBy('subject_hierachy', 'ASC')
                           ->pluck('subject_kh', 'subject_id')
                           ->all();

    	return view('admin.contract_teachers.create', compact(
    			'contractTypes', 'provinces', 'locations', 'qualificationCodes', 'districts',
                'ethnics', 'subjects'
    		));
    }


    /**
     * Store contract teacher info
     */
    public function store(ContStaffRequest $request)
    {
    	// Upload profile photo
        $payrollID = '9'.$request->nid_card;
        $fileName = '';

        if( $request->hasFile('profile_photo') ) {
            $imageUpload = $request->file('profile_photo');
            $fileName = $payrollID.'.'.$imageUpload->getClientOriginalExtension();

            $profileImage = Image::make($imageUpload)->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream();

            Storage::disk('public')->put('images/cont_staffs/'.$fileName, $profileImage);
        }

        $phoneWithoutMinus = str_replace('-', '', $request->phone);
        $phoneWithoutSpace = str_replace('_', '', $phoneWithoutMinus);
        
        // Store contract teacher
        Staff::create([
            'payroll_id' => $payrollID,
            'nid_card' => $request->nid_card, 
            'bank_account' => str_replace(' ', '', $request->bank_account),
            'surname_kh' => $request->surname_kh, 
            'name_kh' => $request->name_kh, 
            'surname_en' => strtoupper($request->surname_en), 
            'name_en' => strtoupper($request->name_en), 
            'sex' => $request->sex, 
            'dob' => $request->dob > 0 ? date('Y-m-d', strtotime($request->dob)) : null,
            'ethnic_id' => $request->ethnic_id,
            'photo' => $fileName,
            'birth_pro_code' => $request->birth_pro_code,
            'birth_district' => $request->birth_district,
            'birth_commune' => $request->birth_commune,
            'birth_village' => $request->birth_village,
            'start_date' => $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null,
            'appointment_date' => $request->end_date > 0 ? date('Y-m-d', strtotime($request->end_date)) : null,
            'staff_status_id' => 1,
            'is_newly_transferred' => 0,
            'is_cont_staff' => 1,
            //'qualification_code' => $request->qualification_code ? $request->qualification_code : null,
            //'professional_level' => $request->professional_level ? $request->professional_level : null,
            'experience' => $request->experience,
            'former_staff' => $request->former_staff ? 1 : 0,
            'maritalstatus_id' => 0,
            'adr_pro_code' => $request->adr_pro_code,
            'adr_dis_code' => $request->adr_dis_code,
            'adr_com_code' => $request->adr_com_code,
            'adr_vil_code' => $request->adr_vil_code,
            'house_num' => $request->house_num,
            'street_num' => $request->street_num,
            'group_num' => $request->group_num,
            'address' => null,
            'phone' => $phoneWithoutSpace,
            'email' => null,
            'dtmt_school' => 0,
            'sbsk' => 0,
            'sbsk_num' => null,
            'disability_teacher' => 0,
            'disability_id' => null,
            'disability_note' => null,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
    	// Get location info
        $location = Location::where('location_code', $request->location_code)
    						->select('location_code', 'location_kh', 'pro_code', 'dis_code', 'com_code', 'vil_code')
    						->first();

        // Refill year num
        if ($request->cont_pos_id == 1) { $year_refilled_num = $request->refilled_literacy_teacher_year; }
        elseif ($request->cont_pos_id == 2 || $request->cont_pos_id == 3) {
            $year_refilled_num = $request->refilled_equivalent_year;
        }
        elseif ($request->cont_pos_id == 4) { $year_refilled_num = $request->refilled_back_school_year; }
        elseif ($request->cont_pos_id == 5) { $year_refilled_num = $request->refilled_edu_specialist_year; }
        else { $year_refilled_num = ''; }

    	// Store contract teacher history
        WorkHistory::create([
            'location_pro_code' => $request->location_pro_code,
            'location_dis_code' => $request->location_dis_code,
            'location_com_code' => $request->location_com_code,
            'location_vil_code' => $request->location_vil_code,
            'pro_code' => $location->pro_code,
            'location_code' => $location->location_code,
            'location_kh' => $location->location_kh,
            'sys_admin_office_id' => null,
            'payroll_id' => $payrollID,
            'his_type_id' => 1,
            'country_id' => null,
            'position_id' => null,
            'additional_position_id' => null,
            'status_id' => 1,
            'prokah' => 0,
            'prokah_num' => null,
            'cur_pos' => 1,
            'main_duty' => $request->duty,
            'annual_eval' => $request->annual_eval,
            'has_refilled_training' => $request->has_refilled_training ? 1 : 0,
            'year_refilled_num' => $year_refilled_num ? $year_refilled_num : null,
            'contract_type_id' => $request->contract_type_id,
            'cont_pos_id' => $request->cont_pos_id,
            'description' => $request->description,
            'start_date' => $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null,
            'end_date' => $request->end_date > 0 ? date('Y-m-d', strtotime($request->end_date)) : null,
            'official_rank_id' => null,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'dis_code'=>$location->dis_code
        ]);

        // Qualification
        StaffQualification::create([
            'payroll_id' => $payrollID,
            'qualification_code' => $request->qualification_code ? $request->qualification_code : null,
            'pro_code' => $location->pro_code,
            'subject_id' => $request->subject_id ? $request->subject_id : null,
            'qual_date' => null,
            'country_id' => null,
            'location_kh' => null,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

    	return redirect()->route('contract-teachers.edit', [app()->getLocale(), $payrollID])
    					 ->with('success', __('validation.add_success'));
    }


    /**
     * Show contract techer profile
     *
     * @param  Object  ContractTeacher $contract_teacher
     */
    public function show(Staff $contract_teacher)
    {
        $lastWorkHist = $contract_teacher->workhistories()->orderBy('start_date', 'desc')->first();

        $teachingInfo = $contract_teacher->teachings()->orderBy('year_id', 'desc')->first();
        
        return view('admin.contract_teachers.profile', compact(
                'contract_teacher', 'lastWorkHist', 'teachingInfo'
            ));
    }


    /**
     * Edit contract teacher info
     *
     * @param  Object  ContractTeacher $contract_teacher
     */
    public function edit(Staff $contract_teacher)
    {
    	$headerid = $contract_teacher->payroll_id;
        $userWorkPlace = auth()->user()->work_place;
        $locations = user_locations();
        // Get last work history
        $lastWorkHist = $contract_teacher->workhistories()->orderBy('start_date', 'desc')->first();
        
        $districtCodes = [];
        $communeCodes = [];
        $villageCodes = [];

        if ($lastWorkHist->contract_type_id == 3) {
            $districtCodes = District::where('pro_code', $lastWorkHist->location_pro_code)->pluck('name_kh', 'dis_code')->all();
            $communeCodes = Commune::where('dis_code', $lastWorkHist->location_dis_code)->pluck('name_kh', 'com_code')->all();
            $villageCodes = Village::where('com_code', $lastWorkHist->location_com_code)->pluck('name_kh', 'vil_code')->all();
        }

        // Convert dob to another format
        $contract_teacher->dob = date('d-m-Y', strtotime($contract_teacher->dob));
        $contract_teacher->former_staff = $contract_teacher->former_staff == 1 ? 'true' : '';
        $contract_teacher->qualification_code = !empty($contract_teacher->highestQualification) ? 
                                                    $contract_teacher->highestQualification->qualification_code : null;
        $contract_teacher->subject_id = !empty($contract_teacher->highestQualification) ? 
                                                $contract_teacher->highestQualification->subject_id : null;

        
    	$provinces = Province::active()->whereNotIn('pro_code', ['99'])->pluck('name_kh', 'pro_code')->all();
        $districts = District::active()->pluck('name_kh');

        $ethnics = Ethnic::pluck('ethnic_kh', 'ethnic_id')->all();

        $contractTypes = ContractType::pluck('contract_type_kh', 'contract_type_id')->all();

        $addr_dists = District::active()
                              ->whereProCode($contract_teacher->adr_pro_code)
                              ->pluck('name_kh', 'dis_code')
                              ->all();

        $addr_comms = Commune::whereDisCode($contract_teacher->adr_dis_code)
                             ->pluck('name_kh', 'com_code')
                             ->all();

        $addr_vills = Village::whereComCode($contract_teacher->adr_com_code)
                             ->pluck('name_kh', 'vil_code')
                             ->all();

    	$qualificationCodes = QualificationCode::orderBy('qualification_hierachy', 'ASC')
                                               ->pluck('qualification_kh', 'qualification_code')
                                               ->all();

        $subjects = Subject::orderBy('subject_hierachy', 'ASC')
                           ->pluck('subject_kh', 'subject_id')
                           ->all();

    	return view('admin.contract_teachers.create', compact(
    			'contractTypes', 'provinces', 'locations', 'qualificationCodes', 'subjects', 
    			'contract_teacher', 'districts', 'lastWorkHist', 'ethnics',
                'addr_dists', 'addr_comms', 'addr_vills',
                'districtCodes', 'communeCodes', 'villageCodes',
    		));
    }


    /**
     * Update contract teacher info
     */
    public function update(Staff $contract_teacher, ContStaffRequest $request)
    {
        $payrollID = '9'.$request->nid_card;

    	// Upload profile photo
        if( $request->hasFile('profile_photo') ) {
            $imageUpload = $request->file('profile_photo');
            $fileName = $payrollID.'.'.$imageUpload->getClientOriginalExtension();

            $profileImage = Image::make($imageUpload)->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream();

            Storage::disk('public')->put('images/cont_staffs/'.$fileName, $profileImage);

            $contTeacherData['photo'] = $fileName;
        }

        $phoneWithoutMinus = str_replace('-', '', $request->phone);
        $phoneWithoutSpace = str_replace('_', '', $phoneWithoutMinus);

    	// Update contract teacher
        $contract_teacher->fill([
            'payroll_id' => $payrollID,
            'nid_card' => $request->nid_card, 
            'bank_account' => str_replace(' ', '', $request->bank_account),
            'surname_kh' => $request->surname_kh, 
            'name_kh' => $request->name_kh, 
            'surname_en' => strtoupper($request->surname_en), 
            'name_en' => strtoupper($request->name_en), 
            'sex' => $request->sex, 
            'dob' => $request->dob > 0 ? date('Y-m-d', strtotime($request->dob)) : null,
            'ethnic_id' => $request->ethnic_id,
            'photo' => $request->hasFile('profile_photo') ? $fileName : $contract_teacher->photo,
            'birth_pro_code' => $request->birth_pro_code,
            'birth_district' => $request->birth_district,
            'birth_commune' => $request->birth_commune,
            'birth_village' => $request->birth_village,
            'start_date' => $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null,
            'appointment_date' => $request->end_date > 0 ? date('Y-m-d', strtotime($request->end_date)) : null,
            'staff_status_id' => 1,
            'is_newly_transferred' => 0,
            'is_cont_staff' => 1,
            //'qualification_code' => $request->qualification_code ? $request->qualification_code : null,
            //'professional_level' => $request->professional_level ? $request->professional_level : null,
            'experience' => $request->experience,
            'former_staff' => $request->former_staff ? 1 : 0,
            'maritalstatus_id' => 0,
            'adr_pro_code' => $request->adr_pro_code,
            'adr_dis_code' => $request->adr_dis_code,
            'adr_com_code' => $request->adr_com_code,
            'adr_vil_code' => $request->adr_vil_code,
            'house_num' => $request->house_num,
            'street_num' => $request->street_num,
            'group_num' => $request->group_num,
            'address' => null,
            'phone' => $phoneWithoutSpace,
            'email' => null,
            'dtmt_school' => 0,
            'sbsk' => 0,
            'sbsk_num' => null,
            'disability_teacher' => 0,
            'disability_id' => null,
            'disability_note' => null,
            'updated_by' => auth()->user()->id,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ])->save();

        // Qualification
        $staffQualification = StaffQualification::where('payroll_id', $payrollID)->first();
            
        if($staffQualification != "") { 
            $staffQualification->fill([
                'qualification_code' => $request->qualification_code ? $request->qualification_code : null,
                'subject_id' => $request->subject_id ? $request->subject_id : null,
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ])->save();
         }
         else {
            // Get location info
            $location = Location::where('location_code', $request->location_code)
            ->select('location_code', 'location_kh', 'pro_code', 'dis_code', 'com_code', 'vil_code')
            ->first();

            // Qualification
            StaffQualification::create([
                'payroll_id' => $payrollID,
                'qualification_code' => $request->qualification_code ? $request->qualification_code : null,
                'pro_code' => ($location && $location->pro_code) ? $location->pro_code : null,
                'subject_id' => $request->subject_id ? $request->subject_id : null,
                'qual_date' => null,
                'country_id' => null,
                'location_kh' => null,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
         }

       

    	return redirect()->route('contract-teachers.edit', [app()->getLocale(), $payrollID])
    					 ->with('success', __('validation.update_success'));
    }


    /**
     * Filter contract teacher info
     *
     * @param  string  $p_filter
     */
    public function filterContractTeacher($p_filter)
    {
        $contTeachers = Staff::get()->pluck($p_filter)->all();

        return $contTeachers;
    }


    // Generate
    public function contStaffGenerateToStaff()
    {
        $contTeachers = ContractTeacher::orderBy('contstaff_id', 'ASC')->get();

        foreach ($contTeachers as $contTeacher) {
            
            $nid_card = substr($contTeacher->nid_card, 0, 9);
            $staff = Staff::where('nid_card', $nid_card)->first();

            //return $nid_card;

            if (empty($staff)) {
                $payrollID = $contTeacher->payroll_id ? $contTeacher->payroll_id : '9'.$nid_card;
                
                //return $payrollID;

                $phoneWithoutMinus = str_replace('-', '', $contTeacher->phone);
                $phoneWithoutSpace = str_replace('_', '', $phoneWithoutMinus);
                
                // Store contract teacher
                Staff::create([
                    'payroll_id' => $payrollID,
                    'nid_card' => $nid_card, 
                    'bank_account' => str_replace(' ', '', $contTeacher->bank_account),
                    'surname_kh' => $contTeacher->surname_kh, 
                    'name_kh' => $contTeacher->name_kh, 
                    'surname_en' => strtoupper($contTeacher->surname_en), 
                    'name_en' => strtoupper($contTeacher->name_en), 
                    'sex' => $contTeacher->sex, 
                    'dob' => $contTeacher->dob > 0 ? date('Y-m-d', strtotime($contTeacher->dob)) : null,
                    'ethnic_id' => $contTeacher->ethnic_id,
                    'photo' => null,
                    'birth_pro_code' => $contTeacher->birth_pro_code,
                    'birth_district' => $contTeacher->birth_district,
                    'birth_commune' => $contTeacher->birth_commune,
                    'birth_village' => $contTeacher->birth_village,
                    'start_date' => null,
                    'appointment_date' => null,
                    'staff_status_id' => 1,
                    'is_newly_transferred' => 0,
                    'is_cont_staff' => 1,
                    'experience' => $contTeacher->experience,
                    'former_staff' => $contTeacher->former_staff ? 1 : 0,
                    'maritalstatus_id' => 0,
                    'adr_pro_code' => $contTeacher->adr_pro_code,
                    'adr_dis_code' => $contTeacher->adr_dis_code,
                    'adr_com_code' => $contTeacher->adr_com_code,
                    'adr_vil_code' => $contTeacher->adr_vil_code,
                    'house_num' => $contTeacher->house_num,
                    'street_num' => $contTeacher->street_num,
                    'group_num' => $contTeacher->group_num,
                    'address' => null,
                    'phone' => $phoneWithoutSpace,
                    'email' => null,
                    'dtmt_school' => 0,
                    'sbsk' => 0,
                    'sbsk_num' => null,
                    'disability_teacher' => 0,
                    'disability_id' => null,
                    'disability_note' => null,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
                

                // Store contract teacher history
                $histories = ContractTeacherHistory::where('contstaff_id', $contTeacher->contstaff_id)->orderBy('start_date', 'ASC')->get();
                if (count($histories) > 0) {
                    foreach ($histories as $history) {
                        WorkHistory::create([
                            'location_pro_code' => $history->pro_code,
                            'location_dis_code' => $history->dis_code,
                            'location_com_code' => $history->com_code,
                            'location_vil_code' => $history->vil_code,
                            'pro_code' => $history->pro_code,
                            'location_code' => $history->location_code,
                            'location_kh' => $history->location_kh,
                            'sys_admin_office_id' => null,
                            'payroll_id' => $payrollID,
                            'his_type_id' => 1,
                            'country_id' => null,
                            'position_id' => null,
                            'additional_position_id' => null,
                            'status_id' => 1,
                            'prokah' => 0,
                            'prokah_num' => null,
                            'cur_pos' => 1,
                            'main_duty' => $history->duty,
                            'annual_eval' => $history->annual_eval,
                            'has_refilled_training' => $history->has_refilled_training,
                            'year_refilled_num' => $history->year_refilled_num,
                            'contract_type_id' => $history->contract_type_id,
                            'cont_pos_id' => $history->cont_pos_id,
                            'description' => $history->description,
                            'start_date' => $history->start_date,
                            'end_date' => $history->end_date,
                            'official_rank_id' => null,
                            'created_by' => auth()->user()->id,
                            'updated_by' => auth()->user()->id,
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);
                    }
                }

                // Qualification
                StaffQualification::create([
                    'payroll_id' => $payrollID,
                    'qualification_code' => $contTeacher->qualification_code ? $contTeacher->qualification_code : 0,
                    'pro_code' => !empty($histories[0]) ? $histories[0]->pro_code : '99',
                    'subject_id' => null,
                    'qual_date' => null,
                    'country_id' => null,
                    'location_kh' => null,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
                
                // Teaching
                $teachings = ContractTeacherTeaching::where('contstaff_id', $contTeacher->contstaff_id)->orderBy('year_id', 'ASC')->get();
                if (count($teachings) > 0) {
                    foreach ($teachings as $teaching) {
                        StaffTeaching::create([
                            'payroll_id' => $payrollID,
                            'add_teaching' => 0,
                            'class_incharge' => 0,
                            'chief_technical' => 0,
                            'multi_grade' => $teaching->multi_grade ? 1 : 0,
                            'double_shift' => $teaching->double_shift ? 1 : 0,
                            'bi_language' => $teaching->bi_language ? 1 : 0,
                            'year_id' => $teaching->year_id ? $teaching->year_id : 0,
                            'overtime' => null,
                            'teach_english' => $teaching->teach_english ? 1 : 0,
                            'triple_grade' => 0,
                            'teach_cross_school' => 0,
                            'location_code' => null,
                            'created_by' => auth()->user()->id,
                            'modif_by' => auth()->user()->id,
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        $subjects = ContractTeacherTeachingSubject::where('contstaff_id', $contTeacher->contstaff_id)->orderBy('year_id', 'ASC')->get();
                        foreach ($subjects as $subject) {
                            TeachingSubject::create([
                                'payroll_id' => $payrollID,
                                'subject_id' => $subject->subject_id ? $subject->subject_id : 0,
                                'grade_id' => $subject->grade_id ? $subject->grade_id : 0,
                                'grade_alias' => null,
                                'day_id' => $subject->day_id ? $subject->day_id : 0,
                                'hour_id' => $subject->hour_id ? $subject->hour_id : 0,
                                'year_id' => $subject->year_id ? $subject->year_id : 0,
                                'created_by' => auth()->user()->id,
                                'updated_by' => auth()->user()->id,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
                        }
                    }
                }
            }
        }

        return 'Successfully generated - on date: ' . Carbon::now();
    }
}
