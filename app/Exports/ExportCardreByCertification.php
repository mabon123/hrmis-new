<?php

namespace App\Exports;

use App\Models\Staff;
use App\Models\District;
use App\Models\Location;
use App\Models\Province;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportCardreByCertification implements FromView
{

    public $pro_code;
    public $dis_code;
    public $location_code;
    private $arab_number = [];
    private $unicode_number = [];
    private $select_query = [];

    public function __construct($pro_code, $dis_code, $location_code)
    {
        $this->pro_code         = $pro_code;
        $this->dis_code         = $dis_code;
        $this->location_code    = $location_code;
        $this->arab_number        = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        $this->unicode_number     = ["០", "១", "២", "៣", "៤", "៥", "៦", "៧", "៨", "៩"];
        $this->select_query = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en', 'phone', 'hrmis_staffs.start_date'];  
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
                    ->where('hrmis_staffs.staff_status_id', 1)
                    ->where('hrmis_work_histories.cur_pos', 1)
                    ->where('hrmis_staff_salaries.cardre_type_id', 2)
                    ->where('request_cardre_check_status', 1)
                    ->orderBy('sys_positions.position_hierarchy', 'ASC')
                    ->orderBy('hrmis_staff_salaries.salary_level_id', 'ASC')
                    ->orderBy('hrmis_staff_salaries.salary_degree', 'ASC')
                    ->orderBy('hrmis_staff_salaries.payroll_id', 'ASC')
                    ->orderBy('hrmis_staff_salaries.salary_type_prokah_order', 'ASC')
                    ->groupBy('hrmis_staffs.payroll_id')
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
            $queries        =  Staff::
            join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
            ->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
            // ->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
            ->where('hrmis_staffs.is_cont_staff', 0)
            ->where('hrmis_staffs.staff_status_id', 1)
            ->where('hrmis_work_histories.cur_pos', 1)
            ->where('hrmis_staff_salaries.cardre_type_id', 2)
            ->where('request_cardre_check_status', 1)
            // ->orderBy('sys_positions.position_hierarchy', 'ASC')
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

        // $brokah_domleungtnaks = with(clone $queries)->whereIn(DB::Raw('CONCAT(hrmis_staff_salaries.salary_level_id, hrmis_staff_salaries.salary_degree)'), 
        //                         [  
        //                             '3១','3២','3៣','3៤',
        //                             '4១','4២','4៣','4៤','4៥',
        //                             '5១','5២','5៣',
        //                             '6១','6២','6៣','6៤',
        //                             '7១','7២','7៣','7៤','7៥','7៦','7៧','7៨','7៩','7១០',
        //                             '8១','8២','8៣','8៤','8៥','8៦','8៧','8៨','8៩','8១០',
        //                             '9១','9២','9៣','9៤','9៥','9៦','9៧','9៨','9៩','9១០'
        //                         ]) 
        //                         ->select($this->select_query)->get();
        // $brokah_domleungtnaks_count = isset($brokah_domleungtnaks) ? count($brokah_domleungtnaks) : 0 ;

        // $brokah_thanorns = with(clone $queries)->whereIn(DB::Raw('CONCAT(hrmis_staff_salaries.salary_level_id, hrmis_staff_salaries.salary_degree)'), 
        //                         [  
        //                             '4៦',
        //                             '5៤',
        //                         ]) 
        //                         ->select($this->select_query)->get();
        // $brokah_thanorns_count = isset($brokah_thanorns) ? count($brokah_thanorns) : 0 ;            

        // $ahnukret_domleungtnaks = with(clone $queries)->whereIn(DB::Raw('CONCAT(hrmis_staff_salaries.salary_level_id, hrmis_staff_salaries.salary_degree)'), 
        //                         [  
        //                             '2១','2២','2៣'
        //                         ]) 
        //                         ->select($this->select_query)->get();
        // $ahnukret_domleungtnaks_count = isset($ahnukret_domleungtnaks) ? count($ahnukret_domleungtnaks) : 0 ;      

        // $ahnukret_thanorns = with(clone $queries)->whereIn(DB::Raw('CONCAT(hrmis_staff_salaries.salary_level_id, hrmis_staff_salaries.salary_degree)'), 
        //                         [  
        //                             '2៤',
        //                         ]) 
        //                         ->select($this->select_query)->get();
        // $ahnukret_thanorns_count = isset($ahnukret_thanorns) ? count($ahnukret_thanorns) : 0 ;
        
        // $reachkret_domleungtnaks = with(clone $queries)->whereIn(DB::Raw('CONCAT(hrmis_staff_salaries.salary_level_id, hrmis_staff_salaries.salary_degree)'), 
        //                         [  
        //                             '1១','1២','1៣','1៤','1៥',
        //                         ]) 
        //                         ->select($this->select_query)->get();
        // $reachkret_domleungtnaks_count = isset($reachkret_domleungtnaks) ? count($reachkret_domleungtnaks) : 0 ;

        
        // $reachkret_thanorns = with(clone $queries)->whereIn(DB::Raw('CONCAT(hrmis_staff_salaries.salary_level_id, hrmis_staff_salaries.salary_degree)'), 
        //                         [  
        //                             '1៦',
        //                         ]) 
        //                         ->select($this->select_query)->get();
        // $reachkret_thanorns_count = isset($reachkret_thanorns) ? count($reachkret_thanorns) : 0 ;                                

        $y= str_replace($this->arab_number, $this->unicode_number, (string)((int)date('Y')));
        
        $staffs_count =  str_replace($this->arab_number, $this->unicode_number, count(with(clone $queries)->get()));
        $staffs_f_count =  str_replace($this->arab_number, $this->unicode_number, count(with(clone $queries)->where('hrmis_staffs.sex',2)->get()));
        

        return view('admin.reports.excel_request_cardre_bycertification', 
            compact('pro_code','location_kh','dis_kh', 'y', 
            'brokah_domleungtnaks','brokah_thanorns','ahnukret_domleungtnaks','ahnukret_thanorns','reachkret_domleungtnaks','reachkret_thanorns',
            'staffs_count','staffs_f_count',
            'province_codes'
        ));  
    }

}
