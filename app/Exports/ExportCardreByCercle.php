<?php

namespace App\Exports;

use App\Models\Staff;
use App\Models\District;
use App\Models\Location;
use App\Models\Province;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportCardreByCercle implements FromView
{
    public $pro_code;
    public $dis_code;
    public $location_code;
    private $arab_number = [];
    private $unicode_number = [];
    private $select_query = [];
    private $status_request_cartdre = [];

    public function __construct($pro_code, $dis_code, $location_code)
    {
        $this->pro_code         = $pro_code;
        $this->dis_code         = $dis_code;
        $this->location_code    = $location_code;
        $this->arab_number        = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        $this->unicode_number     = ["០", "១", "២", "៣", "៤", "៥", "៦", "៧", "៨", "៩"];
        //$this->select_query = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en', 'phone', 'hrmis_staffs.start_date as hire_date', 'hrmis_work_histories.pro_code'];  
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

        $this->status_request_cartdre = [1,2,7,8,10];

    }

    public function view(): View
    {
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
            
        $pro_code       = $this->pro_code ? $this->pro_code : '00'; 
        $location_code  = $this->location_code ? $this->location_code : '';
        $location_kh    = $this->location_code ? Location::where('location_code', $this->location_code)->select('location_kh')->first()->location_kh : '';
        $dis_code       = $this->dis_code ? $this->dis_code : ($location_code ? substr($location_code, 0, 4) : '');
        $dis_kh         = $this->dis_code ? District::where('dis_code', $this->dis_code)->select('name_kh')->first()->name_kh : '';

        $province_codes = Province::select('pro_code', 'name_kh')->get();
        
      

        // if($pro_code > 0) {
        //     $queries =  Staff::when(auth()->user()->hasRole('school-admin', 'dept-admin'), function ($query) {
        //         $query->whereHas('currentWork.location', function ($query) {
        //             $query->where('pro_code', auth()->user()->work_place->pro_code)
        //                 ->where('dis_code', auth()->user()->work_place->dis_code)
        //                 ->where('location_code', auth()->user()->work_place->location_code); 
        //         });
        //     })
        //     ->when(auth()->user()->hasRole('doe-admin'), function ($query) {
        //         $query->whereHas('currentWork.location', function ($query) {
        //             $query->where('pro_code', auth()->user()->work_place->pro_code)
        //                 ->where('dis_code', auth()->user()->work_place->dis_code);
        //         });
        //     })
        //     ->when(auth()->user()->hasRole('poe-admin', 'central-admin'), function ($query) {
        //         $query->whereHas('currentWork.location', function ($query) {
        //             $query->where('pro_code', auth()->user()->work_place->pro_code);
        //         });
        //     })  
        //     ->join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
        //     ->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
        //     ->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
        //     ->where('hrmis_staffs.is_cont_staff', 0)
        //     ->whereIn('hrmis_staffs.staff_status_id', $this->status_request_cartdre)
        //     ->where('hrmis_work_histories.cur_pos', 1)
        //     ->where('hrmis_staff_salaries.cardre_type_id', 1)
        //     ->where('request_cardre_check_status', 1)
        //     ->orderBy('sys_positions.position_hierarchy', 'ASC')
        //     ->orderBy('hrmis_staff_salaries.salary_level_id', 'ASC')
        //     ->orderBy('hrmis_staff_salaries.salary_degree', 'ASC')
        //     ->orderBy('hrmis_staff_salaries.payroll_id', 'ASC')
        //     ->orderBy('hrmis_staff_salaries.salary_type_prokah_order', 'ASC')
        //     ->groupBy('hrmis_staffs.payroll_id')
        //     ->when($location_code <> '', function($query) use($location_code){
        //         $query->whereHas('currentWork.location', function ($query) use($location_code){
        //             $query->where('location_code', $location_code);                                    
        //         });
        //     })
        //     ->when($dis_code <> '', function($query) use($dis_code){
        //         $query->whereHas('currentWork.location', function ($query) use($dis_code){
        //             $query->where('dis_code', $dis_code);                                  
        //         });
        //     })
        //     ->when($pro_code <> '', function($query) use($pro_code){
        //         $query->whereHas('currentWork.location', function ($query) use($pro_code) {
        //             $query->where('pro_code', $pro_code);                            
        //         });
        //     })
        //     ->select($this->select_query)
        //     ;
        // }else{
        //     $queries =  Staff::
        //     join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
        //     ->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
        //     // ->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
        //     ->where('hrmis_staffs.is_cont_staff', 0)
        //     ->whereIn('hrmis_staffs.staff_status_id', $this->status_request_cartdre)
        //     ->where('hrmis_work_histories.cur_pos', 1)
        //     ->where('hrmis_staff_salaries.cardre_type_id', 1)
        //     ->where('request_cardre_check_status', 1)
        //     // ->orderBy('sys_positions.position_hierarchy', 'ASC')
        //     ->orderBy('hrmis_work_histories.pro_code', 'ASC')
        //     ->orderBy('hrmis_staff_salaries.salary_level_id', 'ASC')
        //     ->orderBy('hrmis_staff_salaries.salary_degree', 'ASC')
        //     ->orderBy('hrmis_staff_salaries.payroll_id', 'ASC')
        //     ->orderBy('hrmis_staff_salaries.salary_type_prokah_order', 'ASC')
        //     ->groupBy('hrmis_staffs.payroll_id')
        //     ->select($this->select_query)
        //     ;
        // }

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

        return view('admin.reports.excel_request_cardre_bycercle', 
            compact('pro_code','location_kh','dis_kh', 'y', 
            'brokah_domleungtnaks','brokah_thanorns','ahnukret_domleungtnaks','ahnukret_thanorns','reachkret_domleungtnaks','reachkret_thanorns',
            'staffs_count','staffs_f_count',
            'province_codes'
        ));   
    }


}
