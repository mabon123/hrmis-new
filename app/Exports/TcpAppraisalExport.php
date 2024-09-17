<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use App\Models\TCP\TCPAppraisal;
use App\Models\TCP\TcpStatus;
use App\Models\Province;
use App\Models\District;

class TcpAppraisalExport implements FromView
{
    public $tcp_prof_cat_id;
    public $tcp_prof_rank_id;
    public $pro_code;
    public $dis_code;
    public $location_code;
    public $status_id;
    public $year;

    //
    public function __construct($p_cat_id, $p_rank_id, $p_proCode, $p_disCode, $p_locationCode, $p_status_id, $p_year)
    {
        $this->tcp_prof_cat_id = $p_cat_id;
        $this->tcp_prof_rank_id = $p_rank_id;
        $this->pro_code = $p_proCode;
        $this->dis_code = $p_disCode;
        $this->location_code = $p_locationCode;
        $this->status_id = $p_status_id;
        $this->year = $p_year;
    }

    //
    public function view(): View
    {
        $status_field = 'status_kh';
        if (app()->getLocale() == 'en') {
            $status_field = 'status_en';
        }
        $tcpStatusList = TcpStatus::pluck($status_field, 'tcp_status_id')->all();
        $tcpStatusList =  $tcpStatusList + [
            'p_doe' => __('tcp.status_p_doe'),
            'p_poe' => __('tcp.status_p_poe'),
            'r_doe' => __('tcp.status_r_doe'),
            'r_poe' => __('tcp.status_r_poe')
        ];
        $userWorkPlace = auth()->user()->work_place;
        $selectColumns = ['tcp_appraisals.*', 'sys_provinces.name_kh as province_name', 'sys_districts.name_kh as district_name'];

        $appraisals = null;
        if (auth()->user()->hasRole('administrator')) {
            $appraisals = TCPAppraisal::join('sys_locations', 'tcp_appraisals.workplace_code', '=', 'sys_locations.location_code')
                ->join('sys_provinces', 'sys_locations.pro_code', '=', 'sys_provinces.pro_code')
                ->join('sys_districts', 'sys_locations.dis_code', '=', 'sys_districts.dis_code')
                ->when(!empty($this->tcp_prof_cat_id), function ($query) {
                    $query->where('tcp_prof_cat_id', $this->tcp_prof_cat_id);
                })
                ->when(!empty($this->tcp_prof_rank_id), function ($query) {
                    $query->where('tcp_prof_rank_id', $this->tcp_prof_rank_id);
                })
                ->when(!empty($this->pro_code), function ($query) {
                    $query->where(DB::raw("LEFT(workplace_code, 2)"), $this->pro_code);
                })
                ->when(!empty($this->dis_code), function ($query) {
                    $query->where(DB::raw("LEFT(workplace_code, 4)"), $this->dis_code);
                })
                ->when(!empty($this->location_code), function ($query) {
                    $query->where('workplace_code', $this->location_code);
                })
                ->when(!empty($this->year), function ($query) {
                    $query->where(DB::raw('YEAR(tcp_appraisal_date)'), $this->year);
                });

            if ($this->status_id == 'p_doe') {
                $appraisals = $appraisals->where('tcp_appraisals.tcp_status_id', 2)
                    ->where(DB::raw("IFNULL(doe_check_status, 4)"), 4)
                    ->where(DB::raw("IFNULL(department_check_status, 4)"), 4);
            } elseif ($this->status_id == 'p_poe') {
                $appraisals = $appraisals->where('tcp_appraisals.tcp_status_id', 2)
                    ->where(DB::raw("IFNULL(doe_check_status, 4)"), 5)
                    ->where(DB::raw("IFNULL(poe_check_status, 4)"), 4)
                    ->where(DB::raw("IFNULL(department_check_status, 4)"), 4);
            } elseif ($this->status_id == 'r_doe') {
                $appraisals = $appraisals->where('tcp_appraisals.tcp_status_id', 3)
                    ->where(DB::raw("IFNULL(doe_check_status, 4)"), 6)
                    ->where(DB::raw("IFNULL(department_check_status, 4)"), 4);
            } elseif ($this->status_id == 'r_poe') {
                $appraisals = $appraisals->where('tcp_appraisals.tcp_status_id', 3)
                    ->where(DB::raw("IFNULL(poe_check_status, 4)"), 6)
                    ->where(DB::raw("IFNULL(department_check_status, 4)"), 4);
            } else {
                $appraisals = $appraisals->where('tcp_appraisals.tcp_status_id', $this->status_id)
                    ->where(function ($query) {
                        $query->where(DB::raw("IFNULL(poe_check_status, 4)"), 5)
                            ->orWhere(DB::raw("IFNULL(department_check_status, 4)"), 5);
                    });
            }
            $appraisals = $appraisals->select($selectColumns)
                ->orderBy('workplace_code')
                ->orderBy('tcp_appraisal_date')
                ->get()->all();
        }
        //POE LEADER
        elseif (auth()->user()->level_id == 3) {
            $appraisals = TCPAppraisal::join('sys_locations', 'tcp_appraisals.workplace_code', '=', 'sys_locations.location_code')
                ->join('sys_provinces', 'sys_locations.pro_code', '=', 'sys_provinces.pro_code')
                ->join('sys_districts', 'sys_locations.dis_code', '=', 'sys_districts.dis_code')
                ->when(!empty($this->tcp_prof_cat_id), function ($query) {
                    $query->where('tcp_prof_cat_id', $this->tcp_prof_cat_id);
                })
                ->when(!empty($this->tcp_prof_rank_id), function ($query) {
                    $query->where('tcp_prof_rank_id', $this->tcp_prof_rank_id);
                })
                ->where(DB::raw("LEFT(workplace_code, 2)"),  $userWorkPlace->pro_code)
                ->when(!empty($this->dis_code), function ($query) {
                    $query->where(DB::raw("LEFT(workplace_code, 4)"), $this->dis_code);
                })
                ->when(!empty($this->location_code), function ($query) {
                    $query->where('workplace_code', $this->location_code);
                })
                ->when(!empty($this->year), function ($query) {
                    $query->where(DB::raw('YEAR(tcp_appraisal_date)'), $this->year);
                })
                ->where('tcp_appraisals.tcp_status_id', $this->status_id)
                ->when($this->status_id == 2, function ($query) {
                    $query->where(DB::raw("IFNULL(poe_check_status, 4)"), 4)
                        ->where(DB::raw("IFNULL(doe_check_status, 4)"), 5);
                })
                ->select($selectColumns)
                ->orderBy('workplace_code')
                ->orderBy('tcp_appraisal_date')
                ->get()->all();
        }
        //DOE LEADER
        else {
            $appraisals = TCPAppraisal::join('sys_locations', 'tcp_appraisals.workplace_code', '=', 'sys_locations.location_code')
                ->join('sys_provinces', 'sys_locations.pro_code', '=', 'sys_provinces.pro_code')
                ->join('sys_districts', 'sys_locations.dis_code', '=', 'sys_districts.dis_code')
                ->when(!empty($this->tcp_prof_cat_id), function ($query) {
                    $query->where('tcp_prof_cat_id', $this->tcp_prof_cat_id);
                })
                ->when(!empty($this->tcp_prof_rank_id), function ($query) {
                    $query->where('tcp_prof_rank_id', $this->tcp_prof_rank_id);
                })
                ->where(DB::raw("LEFT(workplace_code, 2)"),  $userWorkPlace->pro_code)
                ->where(DB::raw("LEFT(workplace_code, 4)"), $userWorkPlace->dis_code)
                ->when(!empty($this->location_code), function ($query) {
                    $query->where('workplace_code', $this->location_code);
                })
                ->when(!empty($this->year), function ($query) {
                    $query->where(DB::raw('YEAR(tcp_appraisal_date)'), $this->year);
                })
                ->where('tcp_appraisals.tcp_status_id', $this->status_id)
                ->when($this->status_id == 2, function ($query) {
                    $query->where(DB::raw("IFNULL(doe_check_status, 4)"), 4);
                })
                ->select($selectColumns)
                ->orderBy('workplace_code')
                ->orderBy('tcp_appraisal_date')
                ->get()->all();
        }
        $status_name = $tcpStatusList[$this->status_id];
        $status_id = $this->status_id;
        $province_name = null;
        $district_name = null;
        if (!empty($this->pro_code)) {
            $province = Province::where('pro_code', $this->pro_code)->first();
            $province_name = app()->getLocale() == 'kh' ? $province->name_kh : $province->name_en;
        }
        if (!empty($this->dis_code)) {
            $district = District::where('dis_code', $this->dis_code)->first();
            $district_name = app()->getLocale() == 'kh' ? $district->name_kh : $district->name_en;
        }
        return view('admin.cpd_tcp.tcp_appraisals.exports.appraisal_export', compact(
            'appraisals',
            'status_id',
            'status_name',
            'province_name',
            'district_name'
        ));
    }
}
