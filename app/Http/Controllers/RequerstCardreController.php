<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Staff;
use App\Models\District;
use App\Models\Location;
use App\Models\Province;
use App\Models\StaffSalary;
use Illuminate\Http\Request;
use App\Models\StaffQualification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportCardreByCercle;
use Illuminate\Support\Facades\Redirect;
use App\Exports\ExportCardreByCertification;

class RequerstCardreController extends Controller
{
    private $cardre = [];
    private $cardre_1 = [];
    private $arab_number = [];
    private $unicode_number = [];
    private $select_query = [];
    private $none_request_cartdre = [];
    private $status_request_cartdre = [];
    private $thanorn_1_1 =[];
    private $thanorn_1_2 =[];
    private $thanorn_2_1 =[];
    private $thanorn_2_2 =[];
    private $thanorn_3_1 =[];
    private $thanorn_3_2 =[];
    private $page;
    private $year_request_cardre;
    
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('permission:create-staffs', ['only' => ['index', 'edit']]);
        $this->cardre = [
                "1.១","1.២","1.៣","1.៤","1.៥","1.៦",
                "2.១","2.២","2.៣","2.៤",
                "3.១","3.២","3.៣","3.៤",
                "4.១","4.២","4.៣","4.៤","4.៥","4.៦",
                "5.១","5.២","5.៣","5.៤",
                "6.១","6.២","6.៣","6.៤",
                "7.១","7.២","7.៣","7.៤","7.៥","7.៦","7.៧","7.៨","7.៩","7.១០",
                "8.១","8.២","8.៣","8.៤","8.៥","8.៦","8.៧","8.៨","8.៩","8.១០",
                "9.១","9.២","9.៣","9.៤","9.៥","9.៦","9.៧","9.៨","9.៩","9.១០"
            ];  
        $this->cardre_1 =[
                "1.1","1.2","1.3","1.4","1.5","1.6",
                "2.1","2.2","2.3","2.4",
                "3.1","3.2","3.3","3.4",
                "4.1","4.2","4.3","4.4","4.5","4.6",
                "5.1","5.2","5.3","5.4",
                "6.1","6.2","6.3","6.4",
                "7.1","7.2","7.3","7.4","7.5","7.6","7.7","7.8","7.9","7.10",
                "8.1","8.2","8.3","8.4","8.5","8.6","8.7","8.8","8.9","8.10",
                "9.1","9.2","9.3","9.4","9.5","9.6","9.7","9.8","9.9","9.10"
            ];
        $this->arab_number        = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        $this->unicode_number     = ["០", "១", "២", "៣", "៤", "៥", "៦", "៧", "៨", "៩"];
        $this->select_query = [ 'hrmis_staffs.payroll_id', 
                                'surname_kh', 'name_kh', 
                                'sex', 
                                'dob', 
                                'surname_en', 
                                'name_en', 
                                'phone', 
                                'hrmis_staffs.start_date',                                          
                                'hrmis_staff_salaries.salary_type_shift_date',         
                                'hrmis_staff_salaries.cardre_type_id',
                                'hrmis_staff_salaries.request_cardre_check_status',        
                            ];  
        $this->none_request_cartdre = ['1១','4១','7១','8១','9១'];
        $this->status_request_cartdre = [1,2,7,8,10];
        $this->page = 200;
        $this->thanorn_1_1 = [  
                '3១','3២','3៣','3៤',
                '4១','4២','4៣','4៤','4៥',
                '5១','5២','5៣',
                '6១','6២','6៣','6៤',
                '7១','7២','7៣','7៤','7៥','7៦','7៧','7៨','7៩','7១០',
                '8១','8២','8៣','8៤','8៥','8៦','8៧','8៨','8៩','8១០',
                '9១','9២','9៣','9៤','9៥','9៦','9៧','9៨','9៩','9១០'
            ];
        $this->thanorn_1_2 = [  
                '4៦',
                '5៤',
            ];
        $this->thanorn_2_1 = [  
                '2១','2២','2៣'
            ];     
        $this->thanorn_2_2 = [  
                '2៤',
            ];
        $this->thanorn_3_1 = [  
                '1១','1២','1៣','1៤','1៥',
            ];
        $this->thanorn_3_2 = [  
                '1៦',
            ];
        $this->year_request_cardre = (int)date('Y')+1;
    }

    public function requestCardreByCertification($payroll_id, $qual_id){    

        $staff = staff::where('payroll_id', $payroll_id)->first();    
        $request_cardre = $staff->lastCardre->salary_level_id.'.'.$staff->lastCardre->salary_degree; 
    	$salaryData['payroll_id']                   = $payroll_id;    	    
        $salaryData['official_rank_id']             = isset($staff->lastCardreSalary->official_rank_id) ? $staff->lastCardreSalary->official_rank_id : null;	
    	$salaryData['salary_level_id']              = (!isset($staff->lastCardre->salaryLevel->salary_level_kh) || !isset($staff->lastCardre->salary_degree)) ? null : (int)substr($this->cardre[array_search($request_cardre, $this->cardre)-1],0,1);
    	$salaryData['salary_degree']                = (!isset($staff->lastCardre->salaryLevel->salary_level_kh) || !isset($staff->lastCardre->salary_degree)) ? null : str_replace($this->arab_number, $this->unicode_number, (string)substr($this->cardre_1[array_search($request_cardre, $this->cardre)-1],2,1));
    	$salaryData['salary_type_shift_date']       = (Carbon::parse((Carbon::parse($staff->lastCardre->salary_type_shift_date)->addYear(1))->format('Y')."-10-01")->format('Y-m-d'));
        $salaryData['salary_type_prokah_order']     = isset($staff->lastCardreSalary->salary_type_prokah_order) ? $staff->lastCardreSalary->salary_type_prokah_order : null;
    	$salaryData['cardre_type_id']               = 2;
    	$salaryData['pro_code']                     = Auth::user()->work_place->pro_code;
        $salaryData['request_qual_id']              = $qual_id;
        $salaryData['request_cardre_check_status']  = 1;    //1	បានរក្សារទុក	Saved
        $salaryData['request_cardre_check_date']    = Carbon::now()->format('Y-m-d H:i:s');
        $salaryData['location_check_approver']      = Auth::user()->payroll_id;
        $salaryData['location_check_status']        = 2;    //2	បានបញ្ជូន	Submitted
        $salaryData['location_check_date']          = Carbon::now()->format('Y-m-d H:i:s');        
        $salaryData['created_by'] = Auth::user()->id;
        $salaryData['updated_by'] = Auth::user()->id;
        $salaryData['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');        
        
        if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_1_1)){
            $salaryData['salary_thanorn'] = (double)(1.1);
        }else if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_1_2)){
            $salaryData['salary_thanorn'] = (double)(1.2);
        }else if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_2_1)){
            $salaryData['salary_thanorn'] = (double)(2.1);
        }else if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_2_2)){
            $salaryData['salary_thanorn'] = (double)(2.2);
        }else if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_3_1)){
            $salaryData['salary_thanorn'] = (double)(3.1);
        }else if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_3_2)){
            $salaryData['salary_thanorn'] = (double)(3.2);
        }
    
        $qualification = StaffQualification::where('payroll_id', $payroll_id)->where('qual_id', $qual_id)->first();
        
        if(!empty($qualification->qual_doc)){
            try {
                StaffSalary::create($salaryData);
                $qualification->update(['request_cardre_check_status' => 1, 'request_cardre_check_date' => Carbon::now()->format('Y-m-d H:i:s')]); 
                return redirect()->route('general-knowledge.index', [app()->getLocale(), $payroll_id])->withSuccess('សញ្ញាបត្ររបស់លោកអ្នកត្រូវបានដាក់ស្នើរួចរាល់ហើយ។ សូមអរគុណ។');
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors(__('validation.error_message'));
            }
        }else{
            return redirect()->back()->withErrors('សូមបំពេញឯកសារយោង ហើយព្យាយាមម្តងទៀត។ សូមអរគុណ!');
        }
        
    }

    public function reportRequestCardreByCertification(Request $request){
        $queries                        = [];
        $brokah_domleungtnaks           = [];
        $brokah_thanorns                = [];
        $ahnukret_domleungtnaks         = [];
        $ahnukret_thanorns              = [];
        $reachkret_domleungtnaks        = [];
        $reachkret_thanorns             = [];
        $y                              = [];
        $staffs_count                   = [];
        $staffs_f_count                 = [];        
            
        $pro_code       = request()->pro_code ? request()->pro_code : '00'; 
        $location_code  = request()->location_code ? request()->location_code : '';
        $location_kh    = request()->location_code ? Location::where('location_code', request()->location_code)->select('location_kh')->first()->location_kh : '';
        $dis_code       = request()->dis_code ? request()->dis_code : ($location_code ? substr($location_code, 0, 4) : '');
        $dis_kh         = request()->dis_code ? District::where('dis_code', request()->dis_code)->select('name_kh')->first()->name_kh : '';

        $province_codes = Province::select('pro_code', 'name_kh')->get();

        if($pro_code > 0) {
            $queries        =  Staff::when(auth()->user()->hasRole('school-admin', 'dept-admin'), function ($query) {
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
                ->whereIn('hrmis_staffs.staff_status_id', $this->status_request_cartdre)
                ->where('hrmis_work_histories.cur_pos', 1)
                ->where('hrmis_staff_salaries.cardre_type_id', 2)
                ->where('request_cardre_check_status', 1)
                ////->orderBy('sys_positions.position_hierarchy', 'ASC')
                ->orderBy('hrmis_staff_salaries.salary_level_id', 'ASC')
                ->orderBy('hrmis_staff_salaries.salary_degree', 'ASC')
                ->orderBy('hrmis_staff_salaries.payroll_id', 'ASC')
                ->orderBy('hrmis_staff_salaries.salary_type_prokah_order', 'ASC')
                ->groupBy('hrmis_staffs.payroll_id')
                ->select($this->select_query)
                ->when($location_code <> '', function($query) use($location_code){
                    $query->whereHas('currentWork.location', function ($query) use($location_code){
                        $query->where('location_code', $location_code);                                    
                    });
                })
                ->when($dis_code <> '', function($query) use($dis_code){
                    $query->whereHas('currentWork.location', function ($query) use($dis_code){
                        $query->where('dis_code', $dis_code);                                  
                    });
                })
                ->when($pro_code <> '', function($query) use($pro_code){
                    $query->whereHas('currentWork.location', function ($query) use($pro_code) {
                        $query->where('pro_code', $pro_code);                            
                    });
                })->select($this->select_query);
        }else{
            $queries        =  Staff::
                join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
                ->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
                ->where('hrmis_staffs.is_cont_staff', 0)
                ->whereIn('hrmis_staffs.staff_status_id', $this->status_request_cartdre)
                ->where('hrmis_work_histories.cur_pos', 1)
                ->where('hrmis_staff_salaries.cardre_type_id', 2)
                ->where('request_cardre_check_status', 1)
//                ->orderBy('sys_positions.position_hierarchy', 'ASC')
                ->orderBy('hrmis_work_histories.pro_code', 'ASC')
                ->orderBy('hrmis_staff_salaries.salary_level_id', 'ASC')
                ->orderBy('hrmis_staff_salaries.salary_degree', 'ASC')
                ->orderBy('hrmis_staff_salaries.payroll_id', 'ASC')
                ->orderBy('hrmis_staff_salaries.salary_type_prokah_order', 'ASC')
                ->groupBy('hrmis_staffs.payroll_id')
                ->select($this->select_query);
        }
        
        $brokah_domleungtnaks       = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 1.1)->get();         
        $brokah_thanorns            = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 1.2)->get();     
        $ahnukret_domleungtnaks     = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 2.1)->get();  
        $ahnukret_thanorns          = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 2.2)->get();     
        $reachkret_domleungtnaks    = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 3.1)->get();  
        $reachkret_thanorns         = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 3.2)->get();     

        $y= str_replace($this->arab_number, $this->unicode_number, (string)($this->year_request_cardre));
        
        $staffs_count =  str_replace($this->arab_number, $this->unicode_number, count(with(clone $queries)->get()));
        $staffs_f_count =  str_replace($this->arab_number, $this->unicode_number, count(with(clone $queries)->where('hrmis_staffs.sex',2)->get()));
        

        return view('admin.reports.report_request_cardre_bycertification', 
            compact('pro_code','location_kh','dis_kh', 'y', 
            'brokah_domleungtnaks','brokah_thanorns','ahnukret_domleungtnaks','ahnukret_thanorns','reachkret_domleungtnaks','reachkret_thanorns',
            'staffs_count','staffs_f_count',
            'province_codes'
        ));  
    }

    public function exportCardreByCertification(){  
        return Excel::download(new ExportCardreByCertification(request()->pro_code, request()->dis_code, request()->location_code), 'បញ្ជីរាយនាមមន្រ្តីរាជការស្នើសុំដំឡើងថ្នាក់តាមវេន  '. auth()->user()->work_place->location_kh . str_replace($this->arab_number, $this->unicode_number, (string)((int)date('Y')) .'.xlsx'));
    }

    public function exportCardreByCercle(){  
        return Excel::download(new ExportCardreByCercle(request()->pro_code, request()->dis_code, request()->location_code), 'បញ្ជីរាយនាមមន្រ្តីរាជការស្នើសុំដំឡើងថ្នាក់តាមវេន  '. auth()->user()->work_place->location_kh . str_replace($this->arab_number, $this->unicode_number, (string)((int)date('Y')+1) .'.xlsx'));
    }

    public function reportRequestCardreByCercle(Request $request){       

        $queries                        = [];
        $brokah_domleungtnaks           = [];
        $brokah_thanorns                = [];
        $ahnukret_domleungtnaks         = [];
        $ahnukret_thanorns              = [];
        $reachkret_domleungtnaks        = [];
        $reachkret_thanorns             = [];
        $y                              = [];
        $staffs_count                   = [];
        $staffs_f_count                 = [];        
            
        $pro_code       = request()->pro_code ? request()->pro_code : '00'; 
        $location_code  = request()->location_code ? request()->location_code : '';
        $location_kh    = request()->location_code ? Location::where('location_code', request()->location_code)->select('location_kh')->first()->location_kh : '';
        $dis_code       = request()->dis_code ? request()->dis_code : ($location_code ? substr($location_code, 0, 4) : '');
        $dis_kh         = request()->dis_code ? District::where('dis_code', request()->dis_code)->select('name_kh')->first()->name_kh : '';

        $province_codes = Province::select('pro_code', 'name_kh')->get();       

        if($pro_code > 0) {
            $queries =  Staff::when(auth()->user()->hasRole('school-admin', 'dept-admin'), function ($query) {
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
            ->whereIn('hrmis_staffs.staff_status_id', $this->status_request_cartdre)
            ->where('hrmis_work_histories.cur_pos', 1)
            ->where('hrmis_staff_salaries.cardre_type_id', 1)
            ->where('request_cardre_check_status', 1)
            //->orderBy('sys_positions.position_hierarchy', 'ASC')
            ->orderBy('hrmis_staff_salaries.salary_level_id', 'ASC')
            ->orderBy('hrmis_staff_salaries.salary_degree', 'ASC')
            ->orderBy('hrmis_staff_salaries.payroll_id', 'ASC')
            ->orderBy('hrmis_staff_salaries.salary_type_prokah_order', 'ASC')
            ->groupBy('hrmis_staffs.payroll_id')
            ->select($this->select_query)
            ->when($location_code <> '', function($query) use($location_code){
                $query->whereHas('currentWork.location', function ($query) use($location_code){
                    $query->where('location_code', $location_code);                                    
                });
            })
            ->when($dis_code <> '', function($query) use($dis_code){
                $query->whereHas('currentWork.location', function ($query) use($dis_code){
                    $query->where('dis_code', $dis_code);                                  
                });
            })
            ->when($pro_code <> '', function($query) use($pro_code){
                $query->whereHas('currentWork.location', function ($query) use($pro_code) {
                    $query->where('pro_code', $pro_code);                            
                });
            });
        }else{
            $queries =  Staff::
            join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
            ->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
            ->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
            ->where('hrmis_staffs.is_cont_staff', 0)
            ->whereIn('hrmis_staffs.staff_status_id', $this->status_request_cartdre)
            ->where('hrmis_work_histories.cur_pos', 1)
            ->where('hrmis_staff_salaries.cardre_type_id', 1)
            ->where('request_cardre_check_status', 1)
            //->orderBy('sys_positions.position_hierarchy', 'ASC')
            ->orderBy('hrmis_work_histories.pro_code', 'ASC')
            ->orderBy('hrmis_staff_salaries.salary_level_id', 'ASC')
            ->orderBy('hrmis_staff_salaries.salary_degree', 'ASC')
            ->orderBy('hrmis_staff_salaries.payroll_id', 'ASC')
            ->orderBy('hrmis_staff_salaries.salary_type_prokah_order', 'ASC')
            ->groupBy('hrmis_staffs.payroll_id')
            ->select($this->select_query)
            ;
        }           
            
        $brokah_domleungtnaks       = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 1.1)->get();         
        $brokah_thanorns            = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 1.2)->get();     
        $ahnukret_domleungtnaks     = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 2.1)->get();  
        $ahnukret_thanorns          = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 2.2)->get();     
        $reachkret_domleungtnaks    = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 3.1)->get();  
        $reachkret_thanorns         = with(clone $queries)->where('hrmis_staff_salaries.salary_thanorn', 3.2)->get();                               

        $y= str_replace($this->arab_number, $this->unicode_number, (string)((int)date('Y')+1));
            
        $staffs_count =  str_replace($this->arab_number, $this->unicode_number, count(with(clone $queries)->get()));
        $staffs_f_count =  str_replace($this->arab_number, $this->unicode_number, count(with(clone $queries)->where('hrmis_staffs.sex',2)->get()));

         return view('admin.reports.report_request_cardre_bycercle', 
            compact('pro_code','location_kh','dis_kh', 'y', 
            'brokah_domleungtnaks','brokah_thanorns','ahnukret_domleungtnaks','ahnukret_thanorns','reachkret_domleungtnaks','reachkret_thanorns',
            'staffs_count','staffs_f_count',
            'province_codes'
        ));        
    }

    public function requestCardreByCertificationUndo($payroll_id, $qual_id){           
        try {
            StaffSalary::where('payroll_id', $payroll_id)->where('request_qual_id', $qual_id)->delete();
            
            $qualification = StaffQualification::where('payroll_id', $payroll_id)->where('qual_id', $qual_id)->first();
            $qualification->update(['request_cardre_check_status' => null, 'request_cardre_check_date' => Carbon::now()->format('Y-m-d H:i:s')]); 
            
            $StaffSalary = staff::where('payroll_id', $payroll_id)->first();
            $request_cardre = $StaffSalary->lastCardreSalary->salary_level_id.'.'.$StaffSalary->lastCardreSalary->salary_degree; 
            $salaryData['salary_level_id']              = (!isset($StaffSalary->lastCardreSalary->salary_level_id) || !isset($StaffSalary->lastCardreSalary->salary_degree)) ? null : (int)substr($this->cardre[array_search($request_cardre, $this->cardre)-1],0,1);
            $salaryData['salary_degree']                = (!isset($StaffSalary->lastCardreSalary->salary_level_id) || !isset($StaffSalary->lastCardreSalary->salary_degree)) ? null : str_replace($this->arab_number, $this->unicode_number, (string)substr($this->cardre_1[array_search($request_cardre, $this->cardre)-1],2,1));
            $exist_StaffSalary_request_cercle = StaffSalary::where('payroll_id', $payroll_id)->where("cardre_type_id", 1)->where("request_cardre_check_status", 1)->first(); 
            $exist_StaffSalary_request_cercle ? $exist_StaffSalary_request_cercle->update($salaryData) : null; 

            return redirect()->route('general-knowledge.index', [app()->getLocale(), $payroll_id])->withSuccess(__('validation.add_success'));
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(__('validation.error_message'));
        }
    }

    public function indexRequestCardreByCertification()
    { 
        $staffs = [];
        $staff_contact = [];
        $staff_HROContact = [];
        $femaleStaffs = 0;
        $provinces = user_provinces();
        $districts = user_districts();
        $locations = auth()->user()->hasRole('administrator') ? ['' => __('common.choose') . ' ...'] : user_locations();        
        $pro_code       = request()->pro_code ? request()->pro_code : '00'; 
        $location_code  = request()->location_code ? request()->location_code : '';
        $dis_code       = request()->dis_code ? request()->dis_code : ($location_code ? substr($location_code, 0, 4) : '');
        $selectQuery = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en'];       
         
        if(!empty(request()->all())){
        
            $staffs =   with(clone $this->queryRequestCardreByCertification())
                                ->when($location_code <> '', function($query) use($location_code){
                                    $query->whereHas('currentWork.location', function ($query) use($location_code){
                                        $query->where('location_code', $location_code);                                    
                                    });
                                })
                                ->when($dis_code <> '', function($query) use($dis_code){
                                    $query->whereHas('currentWork.location', function ($query) use($dis_code){
                                        $query->where('dis_code', $dis_code);                                  
                                    });
                                })
                                ->when($pro_code <> '', function($query) use($pro_code){
                                    $query->whereHas('currentWork.location', function ($query) use($pro_code) {
                                        $query->where('pro_code', $pro_code);                            
                                    });
                                })->paginate($this->page);  
            
            $femaleStaffs = count(with(clone $this->queryRequestCardreByCertification())
                                ->when($location_code <> '', function($query) use($location_code){
                                    $query->whereHas('currentWork.location', function ($query) use($location_code){
                                        $query->where('location_code', $location_code);                                    
                                    });
                                })
                                ->when($dis_code <> '', function($query) use($dis_code){
                                    $query->whereHas('currentWork.location', function ($query) use($dis_code){
                                        $query->where('dis_code', $dis_code);                                  
                                    });
                                })
                                ->when($pro_code <> '', function($query) use($pro_code){
                                    $query->whereHas('currentWork.location', function ($query) use($pro_code) {
                                        $query->where('pro_code', $pro_code);                            
                                    });
                                })
                                ->where('hrmis_staffs.sex', 2)            
                                ->get()
                            );      

            $exist_staff_contact = staff::when($location_code <> '', function($query) use($location_code){
                                    $query->whereHas('currentWork.location', function ($query) use($location_code){
                                        $query->where('location_code', $location_code);                                    
                                    });
                                })->first();
            
            if(isset($exist_staff_contact)){                    
                $staff_contact = with(clone $this->queryStaffContact())
                                    ->when($location_code <> '', function($query) use($location_code){
                                        $query->whereHas('currentWork.location', function ($query) use($location_code){
                                            $query->where('location_code', $location_code);                                    
                                        });
                                    })
                                    ->when($dis_code <> '', function($query) use($dis_code){
                                        $query->whereHas('currentWork.location', function ($query) use($dis_code){
                                            $query->where('dis_code', $dis_code);                                  
                                        });
                                    })
                                    ->when($pro_code <> '', function($query) use($pro_code){
                                        $query->whereHas('currentWork.location', function ($query) use($pro_code) {
                                            $query->where('pro_code', $pro_code);                            
                                        });
                                    })->first();     
            }           
            $staff_HROContact = with(clone $this->queryStaffHROContact())->first();
        }

        return view('admin.reports.staff_request_cardre_bycertification', compact('staffs', 'femaleStaffs',  'provinces', 'districts', 'locations', 'staff_contact', 'staff_HROContact'));        
    }
    
    public function indexRequestCardreByCercle(Request $request){     
        $staffs                 = [];
        $requestCardreStaffs    = [];
        $staff_contact          = [];
        $staff_HROContact       = [];
        $y                      = [];
        $femaleStaffs           = 0;
        $provinces              = user_provinces();
        $districts              = user_districts();
        $locations              = auth()->user()->hasRole('administrator') ? ['' => __('common.choose') . ' ...'] : user_locations();        
        $pro_code               = request()->pro_code ? request()->pro_code : '00'; 
        $location_code          = request()->location_code ? request()->location_code : '';
        $dis_code               = request()->dis_code ? request()->dis_code : ($location_code ? substr($location_code, 0, 4) : '');
        
        if(!empty(request()->all())){            
            $staffs =    with(clone $this->queryRequestCardreByCercle())
                                ->when($location_code <> '', function($query) use($location_code){
                                    $query->whereHas('currentWork.location', function ($query) use($location_code){
                                        $query->where('location_code', $location_code);                                    
                                    });
                                })
                                ->when($dis_code <> '', function($query) use($dis_code){
                                    $query->whereHas('currentWork.location', function ($query) use($dis_code){
                                        $query->where('dis_code', $dis_code);                                  
                                    });
                                })
                                ->when($pro_code <> '', function($query) use($pro_code){
                                    $query->whereHas('currentWork.location', function ($query) use($pro_code) {
                                        $query->where('pro_code', $pro_code);                            
                                    });
                                })->select($this->select_query)->paginate($this->page);  

            $femaleStaffs = count(with(clone $this->queryRequestCardreByCercle())
                                ->when($location_code <> '', function($query) use($location_code){
                                    $query->whereHas('currentWork.location', function ($query) use($location_code){
                                        $query->where('location_code', $location_code);                                    
                                    });
                                })
                                ->when($dis_code <> '', function($query) use($dis_code){
                                    $query->whereHas('currentWork.location', function ($query) use($dis_code){
                                        $query->where('dis_code', $dis_code);                                  
                                    });
                                })
                                ->when($pro_code <> '', function($query) use($pro_code){
                                    $query->whereHas('currentWork.location', function ($query) use($pro_code) {
                                        $query->where('pro_code', $pro_code);                            
                                    });
                                })
                                ->where('hrmis_staffs.sex', 2)            
                                ->get()
                            );
                            
            $requestCardreStaffs = count(with(clone $this->queryRequestedCardreByCercle())->where('hrmis_staff_salaries.cardre_type_id', 1)->where('request_cardre_check_status', 1)
                                ->when($location_code <> '', function($query) use($location_code){
                                    $query->whereHas('currentWork.location', function ($query) use($location_code){
                                        $query->where('location_code', $location_code);                                    
                                    });
                                })
                                ->when($dis_code <> '', function($query) use($dis_code){
                                    $query->whereHas('currentWork.location', function ($query) use($dis_code){
                                        $query->where('dis_code', $dis_code);                                  
                                    });
                                })
                                ->when($pro_code <> '', function($query) use($pro_code){
                                    $query->whereHas('currentWork.location', function ($query) use($pro_code) {
                                        $query->where('pro_code', $pro_code);                            
                                    });
                                })        
                                ->get()
                            );
                                 
            $exist_staff_contact = staff::when($location_code <> '', function($query) use($location_code){
                                        $query->whereHas('currentWork.location', function ($query) use($location_code){
                                            $query->where('location_code', $location_code);                                    
                                        });
                                    })->first();

            if(isset($exist_staff_contact)){
                $staff_contact = with(clone $this->queryStaffContact())
                                        ->when($location_code <> '', function($query) use($location_code){
                                            $query->whereHas('currentWork.location', function ($query) use($location_code){
                                                $query->where('location_code', $location_code);                                    
                                            });
                                        })
                                        ->when($dis_code <> '', function($query) use($dis_code){
                                            $query->whereHas('currentWork.location', function ($query) use($dis_code){
                                                $query->where('dis_code', $dis_code);                                  
                                            });
                                        })
                                        ->when($pro_code <> '', function($query) use($pro_code){
                                            $query->whereHas('currentWork.location', function ($query) use($pro_code) {
                                                $query->where('pro_code', $pro_code);                            
                                            });
                                        })->first();
            }
            $staff_HROContact = with(clone $this->queryStaffHROContact())->first();
            $y= str_replace($this->arab_number, $this->unicode_number, (string)((int)date('Y')+1));

        } 
        return view('admin.reports.staff_request_cardre_bycercle', compact('y', 'staffs', 'femaleStaffs', 'requestCardreStaffs', 'provinces', 'districts', 'locations', 'staff_contact', 'staff_HROContact'));
    }
    
    public function showRequestCardreByCertification(Request $request){   
        $staffs = [];
        $staff_contact = [];
        $staff_HROContact = [];
        $femaleStaffs = 0;  
        $y = [];
        $provinces = user_provinces();
        $districts = user_districts();
        $locations = auth()->user()->hasRole('administrator') ? ['' => __('common.choose') . ' ...'] : user_locations();    
        if (auth()->user()->hasRole('school-admin', 'dept-admin')) {                           
            $staffs = with(clone $this->queryRequestCardreByCertification())->select($this->select_query)->paginate($this->page);             
            $femaleStaffs = count(with(clone $this->queryRequestCardreByCertification())->where('hrmis_staffs.sex', '2')->get());            
            $staff_contact = with(clone $this->queryStaffContact())->first();               
            $staff_HROContact = with(clone $this->queryStaffHROContact())->first();       
        }    
        $y= str_replace($this->arab_number, $this->unicode_number, (string)($this->year_request_cardre));
        
        return view('admin.reports.staff_request_cardre_bycertification', compact('y', 'staffs', 'femaleStaffs', 'provinces', 'districts', 'locations', 'staff_contact', 'staff_HROContact'));
    }

    private function queryRequestCardreByCertification(){
        return Staff::when(auth()->user()->hasRole('school-admin', 'dept-admin'), function ($query) {
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
                ->whereIn('hrmis_staffs.staff_status_id', $this->status_request_cartdre)
                ->where('hrmis_work_histories.cur_pos', 1)
                ->where('hrmis_staff_salaries.cardre_type_id', 2)
                ->where('request_cardre_check_status', 1)
                //->orderBy('sys_positions.position_hierarchy', 'ASC')
                ->orderBy('hrmis_staff_salaries.salary_level_id', 'ASC')
                ->orderBy('hrmis_staff_salaries.salary_degree', 'ASC')
                ->orderBy('hrmis_staff_salaries.payroll_id', 'ASC')
                ->orderBy('hrmis_staff_salaries.salary_type_prokah_order', 'ASC')            
                ->groupBy('hrmis_staffs.payroll_id')
                ->select($this->select_query);
    }

    private function queryRequestedCardreByCercle(){
        return  Staff::when(auth()->user()->hasRole('school-admin', 'dept-admin'), function ($query) {
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
        ->whereIn('hrmis_staffs.staff_status_id', $this->status_request_cartdre)
        ->where('hrmis_work_histories.cur_pos', 1)
        ->where('hrmis_staff_salaries.cardre_type_id', 1)
        ->where('request_cardre_check_status', 1)
        ////->orderBy('sys_positions.position_hierarchy', 'ASC')
        ->orderBy('hrmis_staff_salaries.salary_level_id', 'ASC')
        ->orderBy('hrmis_staff_salaries.salary_degree', 'ASC')
        ->orderBy('hrmis_staff_salaries.payroll_id', 'ASC')
        ->orderBy('hrmis_staff_salaries.salary_type_prokah_order', 'ASC')
        ->groupBy('hrmis_staffs.payroll_id')
        ->select($this->select_query);
    }

    private function queryRequestCardreByCercle(){
        return Staff::
                    when(auth()->user()->hasRole('school-admin', 'dept-admin'), function ($query) {
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
                    ->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                    //->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
                    ->join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
                    ->join(
                            DB::raw('
                                (SELECT `payroll_id`, MAX(`salary_type_shift_date`) AS `salary_type_shift_date` 
                                    FROM `hrmis_staff_salaries` 
                                    WHERE (`request_cardre_check_status` IS NULL
                                    OR `request_cardre_check_status` = 5)
                                    AND cardre_type_id = 1
                                    GROUP BY `payroll_id`
                                )lastCardreSalary
                            '),function($join){
                                $join->on('lastCardreSalary.payroll_id', '=', 'hrmis_staff_salaries.payroll_id');
                                $join->on('lastCardreSalary.salary_type_shift_date', '=', 'hrmis_staff_salaries.salary_type_shift_date');
                        }
                    )                                        
                    ->where('hrmis_staffs.is_cont_staff', 0)
                    ->whereIn('hrmis_staffs.staff_status_id', $this->status_request_cartdre)
                    ->where('hrmis_work_histories.cur_pos', 1)
                    // ->where(DB::Raw('DATEDIFF(curdate(), hrmis_staff_salaries.salary_type_shift_date)'), '>=', 730) 
                    ->where(DB::Raw('DATEDIFF(DATE_ADD(CURDATE() , INTERVAL 365 DAY), hrmis_staff_salaries.salary_type_shift_date)'), '>=', 730) 
                    ->whereNotIn(DB::Raw('CONCAT(hrmis_staff_salaries.salary_level_id, hrmis_staff_salaries.salary_degree)'), $this->none_request_cartdre) 
                    ////->orderBy('sys_positions.position_hierarchy', 'ASC')
                    ->orderBy('hrmis_staff_salaries.salary_type_shift_date', 'DESC')
                    ->orderBy('hrmis_staff_salaries.salary_level_id', 'ASC')
                    ->orderBy('hrmis_staff_salaries.salary_degree', 'ASC')
                    ->orderBy('hrmis_staff_salaries.payroll_id', 'ASC')
                    ->orderBy('hrmis_staff_salaries.salary_type_prokah_order', 'ASC')
                    ->groupBy('hrmis_staffs.payroll_id');      
                         
    }

    private function queryStaffContact(){
        return Staff::when(auth()->user()->hasRole('school-admin', 'dept-admin'), function ($query) {
                        $query->whereHas('currentWork.location', function ($query) {
                            $query->where('pro_code', auth()->user()->work_place->pro_code)
                                ->where('dis_code', auth()->user()->work_place->dis_code)
                                ->where('location_code', auth()->user()->work_place->location_code); 
                        });
                    })
                    ->join("hrmis_work_histories", "hrmis_work_histories.payroll_id", "=", "hrmis_staffs.payroll_id")
                    ->join("sys_positions", "sys_positions.position_id", "=", "hrmis_work_histories.position_id")
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
                    ->orderby("sys_positions.position_hierarchy", "ASC")
                    ->where('hrmis_staffs.is_cont_staff', 0)
                    ->whereIn('hrmis_staffs.staff_status_id', $this->status_request_cartdre)
                    ->where('hrmis_work_histories.cur_pos', 1);
    }
    
    private function queryStaffHROContact(){
        return  Staff::join("hrmis_work_histories", "hrmis_work_histories.payroll_id", "=", "hrmis_staffs.payroll_id")
                ->join("sys_positions", "sys_positions.position_id", "=", "hrmis_work_histories.position_id")
                ->where('hrmis_work_histories.pro_code', auth()->user()->work_place->pro_code)
                ->where('hrmis_staffs.is_cont_staff', 0)
                ->whereIn('hrmis_staffs.staff_status_id', $this->status_request_cartdre)
                ->where('hrmis_work_histories.cur_pos', 1)
                ->where('hrmis_work_histories.position_id', 24)
                ->whereIn('hrmis_work_histories.sys_admin_office_id', ["2","17","213","217","219","229","338","368","398","407","428"]);
    }

    public function showRequestCardreByCercle(Request $request){            
        $staffs                 = [];
        $staff_contact          = [];
        $requestCardreStaffs    = [];
        $staff_HROContact       = [];
        $y                      = [];
        $femaleStaffs = 0;
        $provinces = user_provinces();
        $districts = user_districts();
        $locations = auth()->user()->hasRole('administrator') ? ['' => __('common.choose') . ' ...'] : user_locations();       
        if (auth()->user()->hasRole('school-admin', 'dept-admin')) {            
            $staffs = with(clone $this->queryRequestCardreByCercle())->select($this->select_query)->paginate($this->page);            
            $requestCardreStaffs = count(with(clone $this->queryRequestedCardreByCercle())->where('hrmis_staff_salaries.cardre_type_id', 1)->where('hrmis_staff_salaries.request_cardre_check_status', 1)->get());             
            $femaleStaffs = count(with(clone $this->queryRequestCardreByCercle())->where('hrmis_staffs.sex', '2')->get());       
            $staff_contact = with(clone $this->queryStaffContact())->first();    
            $staff_HROContact = with(clone $this->queryStaffHROContact())->first();    
        }    
        $y= str_replace($this->arab_number, $this->unicode_number, (string)($this->year_request_cardre));
        return view('admin.reports.staff_request_cardre_bycercle', compact('y', 'staffs', 'femaleStaffs', 'requestCardreStaffs', 'provinces', 'districts', 'locations', 'staff_contact', 'staff_HROContact'));
    }

    public function verifyCardreByCercle(Request $request)
    {       

        foreach($request->payroll_numbers as $i => $value) {$data_request[$value] = (isset($request->payroll_id_checked[$value])) ? 1 : 0;}
        StaffSalary::whereIn('payroll_id', $request->payroll_numbers)->where("cardre_type_id", 1)->where("request_cardre_check_status", 1)->delete();         
        
        if(isset($request->payroll_numbers)){
            if (count($request->payroll_numbers) > 0) {
                foreach($request->payroll_numbers as $i => $value){
                    if(isset($request->payroll_id_checked[$value])){
                        $payroll_id = $request->payroll_numbers[$i];

                        $StaffSalary = staff::where('payroll_id', $request->payroll_numbers[$i])->first();

                        $request_cardre = $StaffSalary->lastCardreSalary->salary_level_id.'.'.$StaffSalary->lastCardreSalary->salary_degree; 
                        $salaryData_0['salary_level_id']              = (!isset($StaffSalary->lastCardreSalary->salary_level_id) || !isset($StaffSalary->lastCardreSalary->salary_degree)) ? null : (int)substr($this->cardre[array_search($request_cardre, $this->cardre)-1],0,1);
                        $salaryData_0['salary_degree']                = (!isset($StaffSalary->lastCardreSalary->salary_level_id) || !isset($StaffSalary->lastCardreSalary->salary_degree)) ? null : str_replace($this->arab_number, $this->unicode_number, (string)substr($this->cardre_1[array_search($request_cardre, $this->cardre)-1],2,1));
                        $exist_StaffSalary_request_certification = StaffSalary::where('payroll_id', $payroll_id)->where("cardre_type_id", 2)->where("request_cardre_check_status", 1)->first(); 
                        $exist_StaffSalary_request_certification ? $exist_StaffSalary_request_certification->update($salaryData_0) : null; 

                        $request_cardre = $StaffSalary->lastCardre->salary_level_id.'.'.$StaffSalary->lastCardre->salary_degree; 

                        $salaryData['payroll_id']                   = $payroll_id;    	    
                        $salaryData['official_rank_id']             = null;	
                        $salaryData['salary_level_id']              = (!isset($StaffSalary->lastCardre->salary_level_id) || !isset($StaffSalary->lastCardre->salary_degree)) ? null : (int)substr($this->cardre[array_search($request_cardre, $this->cardre)-1],0,1);
                        $salaryData['salary_degree']                = (!isset($StaffSalary->lastCardre->salary_level_id) || !isset($StaffSalary->lastCardre->salary_degree)) ? null : str_replace($this->arab_number, $this->unicode_number, (string)substr($this->cardre_1[array_search($request_cardre, $this->cardre)-1],2,1));
                        $salaryData['salary_type_shift_date']       = (Carbon::parse($StaffSalary->lastCardreSalary->salary_type_shift_date)->addYear(2))->format('Y-m-d');
                        $salaryData['salary_type_prokah_order']     = isset($StaffSalary->lastCardreSalary->salary_type_prokah_order) ? $StaffSalary->lastCardreSalary->salary_type_prokah_order : null;
                        $salaryData['cardre_type_id']               = 1;
                        $salaryData['pro_code']                     = auth()->user()->work_place->pro_code;
                        $salaryData['request_qual_id']              = null;
                        $salaryData['request_cardre_check_status']  = 1;    //1	បានរក្សារទុក	Saved
                        $salaryData['request_cardre_check_date']    = Carbon::now()->format('Y-m-d H:i:s');
                        $salaryData['location_check_approver']      = Auth::user()->payroll_id;
                        $salaryData['location_check_status']        = 2;    //2	បានបញ្ជូន	Submitted
                        $salaryData['location_check_date']          = Carbon::now()->format('Y-m-d H:i:s');        
                        $salaryData['created_by']                   = Auth::user()->id;
                        $salaryData['updated_by']                   = Auth::user()->id;
                        $salaryData['updated_at']                   = Carbon::now()->format('Y-m-d H:i:s');  

                        if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_1_1)){
                            $salaryData['salary_thanorn'] = (double)(1.1);
                        }else if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_1_2)){
                            $salaryData['salary_thanorn'] = (double)(1.2);
                        }else if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_2_1)){
                            $salaryData['salary_thanorn'] = (double)(2.1);
                        }else if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_2_2)){
                            $salaryData['salary_thanorn'] = (double)(2.2);
                        }else if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_3_1)){
                            $salaryData['salary_thanorn'] = (double)(3.1);
                        }else if(in_array($salaryData['salary_level_id'].$salaryData['salary_degree'], $this->thanorn_3_2)){
                            $salaryData['salary_thanorn'] = (double)(3.2);
                        }

                        StaffSalary::create($salaryData);
                    }                    
                }
            }
        }        
          
        return redirect()->back()->withSuccess("ទិន្ន័យរបស់លោកអ្នកត្រូវបានដាក់ស្នើរួចរាល់ហើយ សូមអរគុណ។ ");
                
     }


    

}


