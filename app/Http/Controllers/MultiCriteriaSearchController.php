<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MultiCriteriaSearchExport;

use App\Models\AcademicYear;
use App\Models\CardreType;
use App\Models\Commune;
use App\Models\Country;
use App\Models\Disability;
use App\Models\District;
use App\Models\Ethnic;
use App\Models\Language;
use App\Models\LeaveType;
use App\Models\Location;
use App\Models\MaritalStatus;
use App\Models\Office;
use App\Models\OfficialRank;
use App\Models\Position;
use App\Models\PositionLocation;
use App\Models\ProfessionalCategory;
use App\Models\ProfessionalType;
use App\Models\Province;
use App\Models\QualificationCode;
use App\Models\ReportField;
use App\Models\ReportHeader;
use App\Models\SalaryLevel;
use App\Models\Staff;
use App\Models\StaffFamily;
use App\Models\StaffProfessional;
use App\Models\StaffQualification;
use App\Models\StaffSalary;
use App\Models\StaffStatus;
use App\Models\StaffTeaching;
use App\Models\Subject;
use App\Models\Village;
use App\Models\WorkHistory;
use App\Models\TCP\ProfessionCategory;
use App\Models\TCP\ProfessionRank;
use App\Models\TCP\ProfessionRecording;
use App\Models\TMPMultiCriteriaSearch;

class MultiCriteriaSearchController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-manage-multi-criteria-search', ['only' => ['index']]);
    }

    public function joinQuery($p_fields)
    {
        $userWorkPlace = auth()->user()->work_place;
        $statusLists = [1, 2, 7, 8, 10];

        $fields_arr = explode('.', $p_fields);
        $full_field = $p_fields;

        //$staffs = TMPMultiCriteriaSearch::where('location_code', $userWorkPlace->location_code);

        //$staffs = $staffs->where($fields_arr[1], )

        // School Level
        /*if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
            $levelStaffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                                ->where('hrmis_work_histories.cur_pos', 1)
                                ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                ->where('hrmis_work_histories.location_code', $userWorkPlace->location_code)
                                ->orderBy('hrmis_staffs.payroll_id', 'asc');
        }
        // DOE
        elseif (auth()->user()->level_id == 4) {
            $levelStaffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                                ->join('sys_locations as loc', 'hrmis_work_histories.location_code', '=', 'loc.location_code')
                                ->where('hrmis_work_histories.cur_pos', 1)
                                ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                ->where('loc.dis_code', $userWorkPlace->dis_code)
                                ->orderBy('hrmis_staffs.payroll_id', 'asc');
        }
        // POE
        elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
            $levelStaffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                                ->join('sys_locations as loc', 'hrmis_work_histories.location_code', '=', 'loc.location_code')
                                ->where('hrmis_work_histories.cur_pos', 1)
                                ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                ->where('loc.pro_code', $userWorkPlace->pro_code)
                                ->orderBy('hrmis_staffs.payroll_id', 'asc');
        }
        // Administrator
        else {
            $levelStaffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                                ->where('hrmis_work_histories.cur_pos', 1)
                                ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                ->orderBy('hrmis_staffs.payroll_id', 'asc')
                                ->distinct();
        }

        // Staff Table
        $staffs = $levelStaffs;
        
        if ($fields_arr[0] == 'sys_provinces') {
            $staffs = $levelStaffs->leftJoin('sys_provinces', 'hrmis_staffs.birth_pro_code', '=', 'sys_provinces.pro_code');
        }
        elseif ($fields_arr[0] == 'sys_locations') {
            if ($fields_arr[1] == 'pro_code') {
                $staffs = $levelStaffs->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
                                      ->join('sys_provinces', 'sys_locations.pro_code', '=', 'sys_provinces.pro_code');
                $full_field = 'sys_provinces.name_kh';
            }
            elseif ($fields_arr[1] == 'dis_code') {
                $staffs = $levelStaffs->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
                                      ->join('sys_districts', 'sys_locations.dis_code', '=', 'sys_districts.dis_code');
                $full_field = 'sys_districts.name_kh';
            }
            elseif ($fields_arr[1] == 'com_code') {
                $staffs = $levelStaffs->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
                                      ->join('sys_communes', 'sys_locations.com_code', '=', 'sys_communes.com_code');
                $full_field = 'sys_communes.name_kh';
            }
            else {
                $staffs = $levelStaffs->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code');
            }
        }
        elseif ($fields_arr[0] == 'sys_positions') {
            $staffs = $levelStaffs->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                           ->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
                           ->where('hrmis_work_histories.cur_pos', 1);
        }
        elseif ($fields_arr[0] == 'sys_maritalstatus') {
            $staffs = $levelStaffs->join('sys_maritalstatus', 'hrmis_staffs.maritalstatus_id', '=', 'sys_maritalstatus.maritalstatus_id');
        }
        elseif ($fields_arr[0] == 'salary_levels') {
            $staffs = $levelStaffs->join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
                           ->join('salary_levels', 'hrmis_staff_salaries.salary_level_id', '=', 'salary_levels.salary_level_id');
        }
        // elseif ($fields_arr[0] == 'hrmis_staff_salaries') {
        //     $staffs = Staff::join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id');
        // }
        elseif ($fields_arr[0] == 'sys_staff_status') {
            $staffs = $levelStaffs->join('sys_staff_status', 'hrmis_staffs.staff_status_id', '=', 'sys_staff_status.status_id');
        }
        elseif ($fields_arr[0] == 'sys_offices') {
            $staffs = $levelStaffs->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                           ->join('sys_offices', 'hrmis_work_histories.sys_admin_office_id', '=', 'sys_offices.office_id')
                           ->where('hrmis_work_histories.cur_pos', 1);
        }
        elseif ($fields_arr[0] == 'sys_qualification_codes') {
            $staffs = $levelStaffs->join('hrmis_staff_qualifications', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_qualifications.payroll_id')
                                  ->join('sys_qualification_codes', 'hrmis_staff_qualifications.qualification_code', '=', 'sys_qualification_codes.qualification_code')
                                  ->distinct();
            $full_field = 'sys_qualification_codes.qualification_kh';
        }
        elseif ($fields_arr[0] == 'sys_official_ranks') {
            $staffs = $levelStaffs->join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
                           ->join('sys_official_ranks', 'hrmis_staff_salaries.official_rank_id', '=', 'sys_official_ranks.official_rank_id');
        }
        elseif ($fields_arr[0] == 'sys_disabilities') {
            $staffs = $levelStaffs->join('sys_disabilities', 'hrmis_staffs.disability_id', '=', 'sys_disabilities.disability_id');
            $full_field = 'sys_disabilities.disability_kh';
        }
        elseif ($fields_arr[0] == 'sys_ethnics') {
            $staffs = $levelStaffs->join('sys_ethnics', 'hrmis_staffs.ethnic_id', '=', 'sys_ethnics.ethnic_id');
        }
        elseif ($fields_arr[0] == 'sys_leave_types') {
            $staffs = $levelStaffs->join('hrmis_staff_leaves', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_leaves.payroll_id')
                                  ->join('sys_leave_types', 'hrmis_staff_leaves.leave_type_id', '=', 'sys_leave_types.leave_type_id');
            $full_field = 'sys_leave_types.leave_type_kh';
        }

        elseif ($fields_arr[0] == 'hrmis_staffs') {
            if (($fields_arr[1] == 'birth_pro_code')) {
                $staffs = $levelStaffs->join('sys_provinces', 'hrmis_staffs.birth_pro_code', '=', 'sys_provinces.pro_code');
            }
            elseif (($fields_arr[1] == 'adr_pro_code')) {
                $staffs = $levelStaffs->join('sys_provinces', 'hrmis_staffs.adr_pro_code', '=', 'sys_provinces.pro_code');
            }
            elseif (($fields_arr[1] == 'adr_dis_code')) {
                $staffs = $levelStaffs->join('sys_districts', 'hrmis_staffs.adr_dis_code', '=', 'sys_districts.dis_code');
            }
            elseif (($fields_arr[1] == 'adr_com_code')) {
                $staffs = $levelStaffs->join('sys_communes', 'hrmis_staffs.adr_com_code', '=', 'sys_communes.com_code');
            }
            elseif (($fields_arr[1] == 'adr_vil_code')) {
                $staffs = $levelStaffs->join('sys_villages', 'hrmis_staffs.adr_vil_code', '=', 'sys_villages.vil_code');
            }
            elseif (($fields_arr[1] == 'maritalstatus_id')) {
                $staffs = $levelStaffs->join('sys_maritalstatus', 'hrmis_staffs.maritalstatus_id', '=', 'sys_maritalstatus.maritalstatus_id');
            }
        }
        elseif ($fields_arr[0] == 'hrmis_staff_teachings') {
            $curAcademicYear = AcademicYear::current()->first();

            $staffs = $levelStaffs->join('hrmis_staff_teachings', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_teachings.payroll_id')
                                  ->where('year_id', $curAcademicYear->year_id);

            if (($fields_arr[1] == 'location_code')) {
                $staffs = $staffs->join('sys_locations', 'hrmis_staff_teachings.location_code', '=', 'sys_locations.location_code');
            }
        }
        elseif ($fields_arr[0] == 'hrmis_families') {
            $staffs = $levelStaffs->join('hrmis_families', 'hrmis_staffs.payroll_id', '=', 'hrmis_families.payroll_id')
                                  ->whereIn('relation_type_id', [1, 2]);
        }
        elseif ($fields_arr[0] == 'hrmis_work_histories') {
            if ($fields_arr[1] == 'additional_position_id') {
                $staffs = $levelStaffs->join('sys_positions', 'hrmis_work_histories.additional_position_id', '=', 'sys_positions.position_id');
            }
            elseif ($fields_arr[1] == 'position_id') {
                $staffs = $levelStaffs->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id');
            }
        }
        elseif ($fields_arr[0] == 'hrmis_staff_languages') {
            $staffs = $levelStaffs->join('hrmis_staff_languages', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_languages.payroll_id')
                                  ->join('sys_languages', 'hrmis_staff_languages.language_id', '=', 'sys_languages.language_id');
        }
        elseif ($fields_arr[0] == 'hrmis_staff_professions') {
            $staffs = $levelStaffs->join('hrmis_staff_professions', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_professions.payroll_id');

            if ($fields_arr[1] == 'location_code') {
                $staffs = $staffs->join('sys_locations', 'hrmis_staff_professions.location_code', '=', 'sys_locations.location_code');
            }
            elseif ($fields_arr[1] == 'prof_type_id') {
                $staffs = $staffs->join('sys_professional_types', 'hrmis_staff_professions.prof_type_id', '=', 'sys_professional_types.prof_type_id');
            }
            elseif ($fields_arr[1] == 'subject_id1') {
                $staffs = $staffs->join('sys_subjects', 'hrmis_staff_professions.subject_id1', '=', 'sys_subjects.subject_id');
            }
            elseif ($fields_arr[1] == 'subject_id2') {
                $staffs = $staffs->join('sys_subjects', 'hrmis_staff_professions.subject_id2', '=', 'sys_subjects.subject_id');
            }
            elseif ($fields_arr[1] == 'prof_category_id') {
                $staffs = $staffs->join('sys_professional_categories', 'hrmis_staff_professions.prof_category_id', '=', 'sys_professional_categories.prof_category_id');
                $full_field = 'sys_professional_categories.prof_category_kh';
            }
        }
        elseif ($fields_arr[0] == 'hrmis_staff_salaries') {
            $staffs = $levelStaffs->join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id');

            if ($fields_arr[1] == 'cardre_type_id') {
                $staffs = $staffs->join('sys_cardre_types', 'hrmis_staff_salaries.cardre_type_id', '=', 'sys_cardre_types.cardre_type_id');
                $full_field = 'sys_cardre_types.cardre_type_kh';
            }
            elseif ($fields_arr[1] == 'salary_level_id') {
                $staffs = $staffs->join('salary_levels', 'hrmis_staff_salaries.salary_level_id', '=', 'salary_levels.salary_level_id');
                $full_field = 'salary_levels.salary_level_kh';
            }
        }
        elseif ($fields_arr[0] == 'hrmis_staff_qualifications') {
            $staffs = $levelStaffs->join('hrmis_staff_qualifications', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_qualifications.payroll_id')
                                  ->distinct();

            if ($fields_arr[1] == 'subject_id') {
                $staffs = $staffs->join('sys_subjects', 'hrmis_staff_qualifications.subject_id', '=', 'sys_subjects.subject_id');
                $full_field = 'sys_subjects.subject_kh';
            }
            elseif ($fields_arr[1] == 'country_id') {
                $staffs = $staffs->join('sys_countries', 'hrmis_staff_qualifications.country_id', '=', 'sys_countries.country_id');
                $full_field = 'sys_countries.country_kh';
            }
        }*/

        return [$staffs, $full_field];
    }

    public function joinSubQuery($p_staffs, $p_fields)
    {
        $fields_arr = explode('.', $p_fields);
        $full_field = $p_fields;

        $staffs = $p_staffs;
        
        if ($fields_arr[0] == 'sys_provinces') {
            $staffs = $p_staffs->join('sys_provinces', 'hrmis_staffs.birth_pro_code', '=', 'sys_provinces.pro_code');
        }
        elseif ($fields_arr[0] == 'sys_locations') {
            if ($fields_arr[1] == 'pro_code') {
                $staffs = $p_staffs->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
                                      ->join('sys_provinces', 'sys_locations.pro_code', '=', 'sys_provinces.pro_code');
                $full_field = 'sys_provinces.name_kh';
            }
            elseif ($fields_arr[1] == 'dis_code') {
                $staffs = $p_staffs->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
                                      ->join('sys_districts', 'sys_locations.dis_code', '=', 'sys_districts.dis_code');
                $full_field = 'sys_districts.name_kh';
            }
            elseif ($fields_arr[1] == 'com_code') {
                $staffs = $p_staffs->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
                                      ->join('sys_communes', 'sys_locations.com_code', '=', 'sys_communes.com_code');
                $full_field = 'sys_communes.name_kh';
            }
            else {
                $staffs = $p_staffs->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code');
            }
        }
        elseif ($fields_arr[0] == 'sys_positions') {
            $staffs = $p_staffs->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                             ->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
                             ->where('hrmis_work_histories.cur_pos', 1);
        }
        elseif ($fields_arr[0] == 'sys_maritalstatus') {
            $staffs = $p_staffs->join('sys_maritalstatus', 'hrmis_staffs.maritalstatus_id', '=', 'sys_maritalstatus.maritalstatus_id');
        }
        // elseif ($fields_arr[0] == 'salary_levels') {
        //     $staffs = $p_staffs->join('hrmis_staff_salaries as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
        //                        ->join('salary_levels', 't2.salary_level_id', '=', 'salary_levels.salary_level_id');
        // }
        // elseif ($fields_arr[0] == 'hrmis_staff_salaries') {
        //     $staffs = $p_staffs->join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id');
        // }
        elseif ($fields_arr[0] == 'sys_staff_status') {
            $staffs = $p_staffs->join('sys_staff_status', 'hrmis_staffs.staff_status_id', '=', 'sys_staff_status.status_id');
        }
        elseif ($fields_arr[0] == 'sys_offices') {
            $staffs = $p_staffs->join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                           ->join('sys_offices', 'hrmis_work_histories.sys_admin_office_id', '=', 'sys_offices.office_id')
                           ->where('hrmis_work_histories.cur_pos', 1);
        }
        elseif ($fields_arr[0] == 'sys_qualification_codes') {
            $staffs = $p_staffs->join('hrmis_staff_qualifications', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_qualifications.payroll_id')
                               ->join('sys_qualification_codes', 'hrmis_staff_qualifications.qualification_code', '=', 'sys_qualification_codes.qualification_code')
                               ->distinct();
            $full_field = 'sys_qualification_codes.qualification_kh';
        }
        elseif ($fields_arr[0] == 'sys_official_ranks') {
            $staffs = $p_staffs->join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id')
                               ->join('sys_official_ranks', 'hrmis_staff_salaries.official_rank_id', '=', 'sys_official_ranks.official_rank_id');
        }
        // elseif ($fields_arr[0] == 'hrmis_families') {
        //     $staffs = $p_staffs->join('hrmis_families', 'hrmis_staffs.payroll_id', '=', 'hrmis_families.payroll_id');
        // }
        elseif ($fields_arr[0] == 'sys_disabilities') {
            $staffs = $p_staffs->join('sys_disabilities', 'hrmis_staffs.disability_id', '=', 'sys_disabilities.disability_id');
            $full_field = 'sys_disabilities.disability_kh';
        }
        elseif ($fields_arr[0] == 'sys_ethnics') {
            $staffs = $p_staffs->join('sys_ethnics', 'hrmis_staffs.ethnic_id', '=', 'sys_ethnics.ethnic_id');
        }
        elseif ($fields_arr[0] == 'sys_leave_types') {
            $staffs = $p_staffs->join('hrmis_staff_leaves', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_leaves.payroll_id')
                                  ->join('sys_leave_types', 'hrmis_staff_leaves.leave_type_id', '=', 'sys_leave_types.leave_type_id');
            $full_field = 'sys_leave_types.leave_type_kh';
        }

        elseif ($fields_arr[0] == 'hrmis_staffs') {
            if (($fields_arr[1] == 'birth_pro_code')) {
                $staffs = $p_staffs->join('sys_provinces', 'hrmis_staffs.birth_pro_code', '=', 'sys_provinces.pro_code');
            }
            elseif (($fields_arr[1] == 'adr_pro_code')) {
                $staffs = $p_staffs->join('sys_provinces', 'hrmis_staffs.adr_pro_code', '=', 'sys_provinces.pro_code');
            }
            elseif (($fields_arr[1] == 'adr_dis_code')) {
                $staffs = $p_staffs->join('sys_districts', 'hrmis_staffs.adr_dis_code', '=', 'sys_districts.dis_code');
            }
            elseif (($fields_arr[1] == 'adr_com_code')) {
                $staffs = $p_staffs->join('sys_communes', 'hrmis_staffs.adr_com_code', '=', 'sys_communes.com_code');
            }
            elseif (($fields_arr[1] == 'adr_vil_code')) {
                $staffs = $p_staffs->join('sys_villages', 'hrmis_staffs.adr_vil_code', '=', 'sys_villages.vil_code');
            }
            elseif (($fields_arr[1] == 'maritalstatus_id')) {
                $staffs = $p_staffs->join('sys_maritalstatus', 'hrmis_staffs.maritalstatus_id', '=', 'sys_maritalstatus.maritalstatus_id');
            }
        }
        elseif ($fields_arr[0] == 'hrmis_staff_teachings') {
            $curAcademicYear = AcademicYear::current()->first();

            $staffs = $p_staffs->join('hrmis_staff_teachings', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_teachings.payroll_id')
                                  ->where('year_id', $curAcademicYear->year_id);

            if (($fields_arr[1] == 'location_code')) {
                $staffs = $staffs->join('sys_locations', 'hrmis_staff_teachings.location_code', '=', 'sys_locations.location_code');
            }
        }
        elseif ($fields_arr[0] == 'hrmis_families') {
            $staffs = $p_staffs->join('hrmis_families', 'hrmis_staffs.payroll_id', '=', 'hrmis_families.payroll_id')
                                  ->whereIn('relation_type_id', [1, 2]);
        }
        elseif ($fields_arr[0] == 'hrmis_work_histories') {
            if ($fields_arr[1] == 'additional_position_id') {
                $staffs = $p_staffs->join('sys_positions', 'hrmis_work_histories.additional_position_id', '=', 'sys_positions.position_id');
            }
            elseif ($fields_arr[1] == 'position_id') {
                $staffs = $p_staffs->join('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id');
            }
        }
        elseif ($fields_arr[0] == 'hrmis_staff_languages') {
            $staffs = $p_staffs->join('hrmis_staff_languages', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_languages.payroll_id')
                                  ->join('sys_languages', 'hrmis_staff_languages.language_id', '=', 'sys_languages.language_id');
        }
        elseif ($fields_arr[0] == 'hrmis_staff_professions') {
            $staffs = $p_staffs->join('hrmis_staff_professions', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_professions.payroll_id');

            if ($fields_arr[1] == 'location_code') {
                $staffs = $staffs->join('sys_locations', 'hrmis_staff_professions.location_code', '=', 'sys_locations.location_code');
            }
            elseif ($fields_arr[1] == 'prof_type_id') {
                $staffs = $staffs->join('sys_professional_types', 'hrmis_staff_professions.prof_type_id', '=', 'sys_professional_types.prof_type_id');
            }
            elseif ($fields_arr[1] == 'subject_id1') {
                $staffs = $staffs->join('sys_subjects', 'hrmis_staff_professions.subject_id1', '=', 'sys_subjects.subject_id');
            }
            elseif ($fields_arr[1] == 'subject_id2') {
                $staffs = $staffs->join('sys_subjects', 'hrmis_staff_professions.subject_id2', '=', 'sys_subjects.subject_id');
            }
            elseif ($fields_arr[1] == 'prof_category_id') {
                $staffs = $staffs->join('sys_professional_categories', 'hrmis_staff_professions.prof_category_id', '=', 'sys_professional_categories.prof_category_id');
                $full_field = 'sys_professional_categories.prof_category_kh';
            }
        }
        elseif ($fields_arr[0] == 'hrmis_staff_salaries') {
            $staffs = $p_staffs->join('hrmis_staff_salaries', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_salaries.payroll_id');

            if ($fields_arr[1] == 'cardre_type_id') {
                $staffs = $staffs->join('sys_cardre_types', 'hrmis_staff_salaries.cardre_type_id', '=', 'sys_cardre_types.cardre_type_id');
                $full_field = 'sys_cardre_types.cardre_type_kh';
            }
            elseif ($fields_arr[1] == 'salary_level_id') {
                $staffs = $staffs->join('salary_levels', 'hrmis_staff_salaries.salary_level_id', '=', 'salary_levels.salary_level_id');
                $full_field = 'salary_levels.salary_level_kh';
            }
        }
        elseif ($fields_arr[0] == 'hrmis_staff_qualifications') {
            $staffs = $p_staffs->join('hrmis_staff_qualifications', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_qualifications.payroll_id')
                                  ->distinct();

            if ($fields_arr[1] == 'subject_id') {
                $staffs = $staffs->join('sys_subjects', 'hrmis_staff_qualifications.subject_id', '=', 'sys_subjects.subject_id');
                $full_field = 'sys_subjects.subject_kh';
            }
            elseif ($fields_arr[1] == 'country_id') {
                $staffs = $staffs->join('sys_countries', 'hrmis_staff_qualifications.country_id', '=', 'sys_countries.country_id');
                $full_field = 'sys_countries.country_kh';
            }
        }

        return [$staffs, $full_field];
    }

    public function conditionQuery($p_staffs, $p_operator, $table_field, $p_value)
    {
        $table_field_exp = explode('.', $table_field);
        $field = $table_field_exp[1];

        if ($table_field == 'hrmis_staffs.surname_kh') { $field = 'last_name_kh'; }
        elseif ($table_field == 'hrmis_staffs.name_kh') { $field = 'first_name_kh'; }
        elseif ($table_field == 'hrmis_staffs.surname_en') { $field = 'last_name_en'; }
        elseif ($table_field == 'hrmis_staffs.name_en') { $field = 'first_name_en'; }
        elseif ($table_field == 'hrmis_staffs.birth_pro_code') { $field = 'birth_province'; }
        elseif ($table_field == 'hrmis_staffs.maritalstatus_id') { $field = 'maritalstatus_kh'; }
        elseif ($table_field == 'hrmis_staffs.adr_vil_code') { $field = 'adr_village'; }
        elseif ($table_field == 'hrmis_staffs.adr_com_code') { $field = 'adr_commune'; }
        elseif ($table_field == 'hrmis_staffs.adr_dis_code') { $field = 'adr_district'; }
        elseif ($table_field == 'hrmis_staffs.adr_pro_code') { $field = 'adr_province'; }
        elseif ($table_field == 'sys_locations.pro_code') { $field = 'work_province'; }
        elseif ($table_field == 'sys_locations.dis_code') { $field = 'work_district'; }
        elseif ($table_field == 'sys_locations.com_code') { $field = 'work_commune'; }
        elseif ($table_field == 'sys_locations.location_kh') { $field = 'work_location'; }
        elseif ($table_field == 'sys_offices.office_kh') { $field = 'work_office'; }
        elseif ($table_field == 'hrmis_work_histories.additional_position_id') { $field = 'additional_position_kh'; }
        elseif ($table_field == 'hrmis_work_histories.position_id') { $field = 'position_kh'; }
        elseif ($table_field == 'hrmis_work_histories.prokah_num') { $field = 'work_history_prokah_num'; }
        elseif ($table_field == 'hrmis_work_histories.start_date') { $field = 'work_history_start_date'; }
        elseif ($table_field == 'hrmis_staff_salaries.salary_level_id') { $field = 'salary_level_kh'; }
        elseif ($table_field == 'hrmis_staff_salaries.cardre_type_id') { $field = 'salary_cardre_type_kh'; }
        elseif ($table_field == 'hrmis_staff_salaries.salary_type_prokah_num') { $field = 'salary_prokah_num'; }
        elseif ($table_field == 'hrmis_staff_salaries.salary_type_prokah_order') { $field = 'salary_prokah_order'; }
        elseif ($table_field == 'sys_qualification_codes.qualification_kh') { $field = 'highest_qualification_kh'; }
        elseif ($table_field == 'hrmis_staff_qualifications.subject_id') { $field = 'qual_subject_kh'; }
        elseif ($table_field == 'hrmis_staff_qualifications.country_id') { $field = 'qual_country_kh'; }
        elseif ($table_field == 'hrmis_staff_qualifications.location_kh') { $field = 'qual_location_kh'; }
        elseif ($table_field == 'hrmis_staff_professions.prof_category_id') { $field = 'highest_profession_kh'; }
        elseif ($table_field == 'hrmis_staff_professions.subject_id1') { $field = 'profession_subject1'; }
        elseif ($table_field == 'hrmis_staff_professions.subject_id2') { $field = 'profession_subject2'; }
        elseif ($table_field == 'hrmis_staff_professions.prof_type_id') { $field = 'profession_type_kh'; }
        elseif ($table_field == 'hrmis_staff_professions.location_code') { $field = 'profession_location_kh'; }
        elseif ($table_field == 'hrmis_families.fullname_kh') { $field = 'family_fullname_kh'; }
        elseif ($table_field == 'hrmis_families.occupation') { $field = 'familty_occupation'; }
        elseif ($table_field == 'hrmis_families.allowance') { $field = 'familty_allowance'; }
        elseif ($table_field == 'hrmis_families.phone_number') { $field = 'familty_phonenumber'; }
        elseif ($table_field == 'hrmis_staff_teachings.location_code') { $field = 'teaching_cross_school_kh'; }
        elseif ($table_field == 'hrmis_staff_salaries.salary_type_shift_date') { $field = 'salary_shift_date'; }

        $staffs = $p_staffs->when($p_operator == 'equal', function($query) use($field, $p_value) {
                            $query->whereIn($field, $p_value);
                        })
                        ->when($p_operator == 'not-equal', function($query) use($field, $p_value) {
                            $query->whereNotIn($field, $p_value);
                        })
                        ->when($p_operator == 'like', function($query) use($field, $p_value) {
                            $query->where(function($sub_query) use($field, $p_value) {
                                foreach ($p_value as $favlue) {
                                    $sub_query->orWhere($field, 'like', '%'.$favlue.'%');
                                }
                            });
                        })
                        ->when($p_operator == 'like-f', function($query) use($field, $p_value) {
                            $query->where(function($sub_query) use($field, $p_value) {
                                foreach ($p_value as $favlue) {
                                    $sub_query->orWhere($field, 'like', $favlue.'%');
                                }
                            });
                        })
                        ->when($p_operator == 'like-b', function($query) use($field, $p_value) {
                            $query->where(function($sub_query) use($field, $p_value) {
                                foreach ($p_value as $favlue) {
                                    $sub_query->orWhere($field, 'like', '%'.$favlue);
                                }
                            });
                        })
                        ->when($p_operator == 'greater-than', function($query) use($field, $p_value) {
                            $query->where(function($sub_query) use($field, $p_value) {
                                foreach ($p_value as $favlue) {
                                    $sub_query->orWhere($field, '>', $favlue);
                                }
                            });
                        })
                        ->when($p_operator == 'smaller-than', function($query) use($field, $p_value) {
                            $query->where(function($sub_query) use($field, $p_value) {
                                foreach ($p_value as $favlue) {
                                    $sub_query->orWhere($field, '<', $favlue);
                                }
                            });
                        })
                        ->when($p_operator == 'in', function($query) use($field, $p_value) {
                            $query->where(function($sub_query) use($field, $p_value) {
                                foreach ($p_value as $favlue) {
                                    $sub_query->orWhereYear($field, $favlue);
                                }
                            });
                        });

        return $staffs;
    }

    public function conditionSubQuery($p_staffs, $p_operator, $p_field, $p_value)
    {
        if ($p_field == 'hrmis_staffs.birth_pro_code' || $p_field == 'hrmis_staffs.adr_pro_code') {
            $p_field = 'sys_provinces.name_kh'; 
        }
        elseif ($p_field == 'hrmis_staffs.adr_dis_code') { $p_field = 'sys_districts.name_kh'; }
        elseif ($p_field == 'hrmis_staffs.adr_com_code') { $p_field = 'sys_communes.name_kh'; }
        elseif ($p_field == 'hrmis_staffs.adr_vil_code') { $p_field = 'sys_villages.name_kh'; }
        elseif ($p_field == 'hrmis_work_histories.additional_position_id') { $p_field = 'sys_positions.position_kh'; }
        elseif ($p_field == 'hrmis_work_histories.position_id') { $p_field = 'sys_positions.position_kh'; }
        elseif ($p_field == 'hrmis_staff_teachings.location_code' || $p_field == 'hrmis_staff_professions.location_code') {
            $p_field = 'sys_locations.location_kh';
        }
        elseif ($p_field == 'hrmis_staffs.maritalstatus_id') { $p_field = 'sys_maritalstatus.maritalstatus_kh'; }
        elseif ($p_field == 'hrmis_staff_languages.language_id') { $p_field = 'sys_languages.language_kh'; }
        elseif ($p_field == 'hrmis_staff_professions.prof_type_id') { $p_field = 'sys_professional_types.prof_type_kh'; }
        elseif ($p_field == 'hrmis_staff_professions.subject_id1' || $p_field == 'hrmis_staff_professions.subject_id2') {
            $p_field = 'sys_subjects.subject_kh';
        }
        
        $staffs = $p_staffs->when($p_operator == 'equal', function($query) use($p_field, $p_value) {
                            $query->when(request()->first_and, function($sub_query) use($p_field, $p_value) {
                                $sub_query->whereIn($p_field, $p_value);
                            }, function($sub_query) use($p_field, $p_value) {
                                $sub_query->orWhereIn($p_field, $p_value);
                            });
                        })
                        ->when($p_operator == 'not-equal', function($query) use($p_field, $p_value) {
                            $query->when(request()->first_and, function($sub_query) use($p_field, $p_value) {
                                $query->whereNotIn($p_field, $p_value);
                            }, function($sub_query) use($p_field, $p_value) {
                                $query->orWhereNotIn($p_field, $p_value);
                            });
                        })
                        ->when($p_operator == 'like', function($query) use($p_field, $p_value) {
                            $query->when(request()->first_and, function($sub_query) use($p_field, $p_value) {
                                $sub_query->where(function($sub_query2) use($p_field, $p_value) {
                                    foreach ($p_value as $favlue) {
                                        $sub_query2->orWhere($p_field, 'like', $favlue);
                                    }
                                });
                            }, function($sub_query) use($p_field, $p_value) {
                                $sub_query->orWhere(function($sub_query2) use($p_field, $p_value) {
                                    foreach ($p_value as $favlue) {
                                        $sub_query2->orWhere($p_field, 'like', $favlue);
                                    }
                                });
                            });
                        })
                        ->when($p_operator == 'like-f', function($query) use($p_field, $p_value) {
                            $query->when(request()->first_and, function($sub_query) use($p_field, $p_value) {
                                $sub_query->where(function($sub_query2) use($p_field, $p_value) {
                                    foreach ($p_value as $favlue) {
                                        $sub_query2->orWhere($p_field, 'like', $favlue.'%');
                                    }
                                });
                            }, function($sub_query) use($p_field, $p_value) {
                                $sub_query->orWhere(function($sub_query2) use($p_field, $p_value) {
                                    foreach ($p_value as $favlue) {
                                        $sub_query2->orWhere($p_field, 'like', $favlue.'%');
                                    }
                                });
                            });
                        })
                        ->when($p_operator == 'like-b', function($query) use($p_field, $p_value) {
                            $query->when(request()->first_and, function($sub_query) use($p_field, $p_value) {
                                $sub_query->where(function($sub_query2) use($p_field, $p_value) {
                                    foreach ($p_value as $favlue) {
                                        $sub_query2->orWhere($p_field, 'like', '%'.$favlue);
                                    }
                                });
                            }, function($sub_query) use($p_field, $p_value) {
                                $sub_query->orWhere(function($sub_query2) use($p_field, $p_value) {
                                    foreach ($p_value as $favlue) {
                                        $sub_query2->orWhere($p_field, 'like', '%'.$favlue);
                                    }
                                });
                            });
                        })
                        ->when($p_operator == 'greater-than', function($query) use($p_field, $p_value) {
                            $query->when(request()->first_and, function($sub_query) use($p_field, $p_value) {
                                $sub_query->where(function($sub_query2) use($p_field, $p_value) {
                                    foreach ($p_value as $favlue) {
                                        $sub_query2->orWhere($p_field, '>', $favlue);
                                    }
                                });
                            }, function($sub_query) use($p_field, $p_value) {
                                $sub_query->orWhere(function($sub_query2) use($p_field, $p_value) {
                                    foreach ($p_value as $favlue) {
                                        $sub_query2->orWhere($p_field, '>', $favlue);
                                    }
                                });
                            });
                        })
                        ->when($p_operator == 'smaller-than', function($query) use($p_field, $p_value) {
                            $query->when(request()->first_and, function($sub_query) use($p_field, $p_value) {
                                $sub_query->where(function($sub_query2) use($p_field, $p_value) {
                                    foreach ($p_value as $favlue) {
                                        $sub_query2->orWhere($p_field, '<', $favlue);
                                    }
                                });
                            }, function($sub_query) use($p_field, $p_value) {
                                $sub_query->orWhere(function($sub_query2) use($p_field, $p_value) {
                                    foreach ($p_value as $favlue) {
                                        $sub_query2->orWhere($p_field, '<', $favlue);
                                    }
                                });
                            });
                        });

        return $staffs;
    }

    // Convert value
    public function convertedValue($p_field, $p_value)
    {
        $filterValue = $p_value;

        if ($p_field == 'hrmis_staffs.sex') {
            $staffGender = [];
            foreach ($p_value as $gender) {
                $staffGender[] = $gender == 'ប្រុស' ? 1 : 2;
            }
            $filterValue = $staffGender;
        }
        elseif ($p_field == 'hrmis_staff_teachings.teach_cross_school' 
            || $p_field == 'hrmis_staff_teachings.chief_technical'
            || $p_field == 'hrmis_staff_teachings.class_incharge' 
            || $p_field == 'hrmis_staff_teachings.bi_language' 
            || $p_field == 'hrmis_staff_teachings.double_shift' 
            || $p_field == 'hrmis_staff_teachings.triple_grade'
            || $p_field == 'hrmis_staff_teachings.multi_grade'
            || $p_field == 'hrmis_staff_teachings.teach_english'
            || $p_field == 'hrmis_staff_teachings.add_teaching'
            || $p_field == 'hrmis_families.allowance' ) {
            $fieldValues = [];
            foreach ($p_value as $gender) {
                $fieldValues[] = $gender == 'Yes' ? 1 : 0;
            }
            $filterValue = $fieldValues;
        }

        return $filterValue;
    }

    // Multi-Criteria Search
    public function index()
    {
        // Report header by user
        $fieldIDs = ReportHeader::where('user_id', auth()->user()->id)->pluck('field_id')->all();

        // All report fields
        $reportFields = ReportField::active()
                                ->select('id', 'table_name', 'field_name', 'title_kh', 'is_date_field', 'title_order')
                                ->orderBy('title_order', 'asc')
                                ->get();

        // All report fields exclude selected fields
        $tableFields = ReportField::active()->whereNotIn('id', $fieldIDs)
                                ->select('id', 'table_name', 'field_name', 'title_kh', 'is_date_field', 'title_order')
                                ->orderBy('title_order', 'asc')
                                ->get();

        $reportHeaders = ReportHeader::join('sys_report_fields', 'sys_report_headers.field_id', '=', 'sys_report_fields.id')
                                ->where('sys_report_headers.user_id', auth()->user()->id)
                                ->select('sys_report_fields.*')
                                ->orderBy('sys_report_headers.header_id', 'asc')
                                ->get();
        
        //return $reportFields;

        $staffs = [];

        if (request()->search) {
            // Export to Excel
            if (request()->get('btn-action') == 'export') {
                return Excel::download(
                        new MultiCriteriaSearchExport(request()->all()), 
                        'staff_retport_multi_criteria_search_'.time().'.xlsx'
                    );
            }

            
            //$selectQuery = ReportField::orderBy('id', 'asc')->get()->whereIn('id', $fieldIDs)->pluck('table_field')->all();

            //$test = Staff::with('birthProvince')->select('hrmis_staffs.payroll_id', 'hrmis_staffs.name_kh', 'birth_pro_code')->where('birth_pro_code', '02')->paginate(100);

            //return $selectQuery;

            $userWorkPlace = auth()->user()->work_place;
            $statusLists = ['សកម្ម', 'ទំនេរគ្មានបៀវត្ស', 'ទំនេរគ្មានបៀវត្សបន្ត', 'ក្រៅក្របខ័ណ្ឌដើម', 'បន្តការសិក្សា'];

            // School Level
            if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
                $staffs = TMPMultiCriteriaSearch::where('location_code', $userWorkPlace->location_code);
            }

            // DOE
            elseif (auth()->user()->level_id == 4) {
                $staffs = TMPMultiCriteriaSearch::where('dis_code', $userWorkPlace->dis_code);
            }

            // POE
            elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
                $staffs = TMPMultiCriteriaSearch::where('pro_code', $userWorkPlace->pro_code);
            }

            // Administrator
            else {
                $staffs = TMPMultiCriteriaSearch::whereIn('status_kh', $statusLists);
            }
            
            // 1st
            $firstValue = $this->convertedValue(request()->first_field, request()->first_value);
            //list($staffs, $first_field) = $this->joinQuery(request()->first_field);
            $staffs = $this->conditionQuery($staffs, request()->first_operator, request()->first_field, $firstValue);

            //return request()->first_field;
            
            //return request()->second_field;

            // 2nd
            if (request()->second_field && request()->second_value) {
                $secondValue = $this->convertedValue(request()->second_field, request()->second_value);
                //list($staffs, $second_field) = $this->joinSubQuery($staffs, request()->second_field);
                //$staffs = $this->conditionSubQuery($staffs, request()->second_operator, $second_field, $secondValue);
                $staffs = $this->conditionQuery($staffs, request()->second_operator, request()->second_field, $secondValue);
            }

            //return $staffs->select('hrmis_staffs.*')->paginate(100);

            // 3rd
            if (request()->third_field && request()->third_value[0]) {
                $thirdValue = $this->convertedValue(request()->third_field, request()->third_value);
                //list($staffs, $third_field) = $this->joinSubQuery($staffs, request()->third_field);
                //$staffs = $this->conditionSubQuery($staffs, request()->third_operator, $third_field, $thirdValue);
                $staffs = $this->conditionQuery($staffs, request()->third_operator, request()->third_field, $thirdValue);
            }

            //return $staffs->select('hrmis_staffs.*')->paginate(100);

            // 4th
            if (request()->fourth_field && request()->fourth_value) {
                $fourthValue = $this->convertedValue(request()->fourth_field, request()->fourth_value);
                //list($staffs, $fourth_field) = $this->joinSubQuery($staffs, request()->fourth_field);
                //$staffs = $this->conditionSubQuery($staffs, request()->fourth_operator, $fourth_field, $fourthValue);
                $staffs = $this->conditionQuery($staffs, request()->fourth_operator, request()->fourth_field, $fourthValue);
            }

            // 5th
            if (request()->fifth_field && request()->fifth_value) {
                $fifthValue = $this->convertedValue(request()->fifth_field, request()->fifth_value);
                //list($staffs, $fifth_field) = $this->joinSubQuery($staffs, request()->fifth_field);
                //$staffs = $this->conditionSubQuery($staffs, request()->fifth_operator, $fifth_field, $fifthValue);
                $staffs = $this->conditionQuery($staffs, request()->fifth_operator, request()->fifth_field, $fifthValue);
            }

            //return $staffs->paginate(10);

            $staffs = $staffs->paginate(20);
        }

        //return $staffs;
        
        return view('admin.multi_criteria.index', compact('staffs', 'reportFields', 'reportHeaders', 'tableFields'));
    }

    public function staffAddress($p_field, $p_table) 
    {
        $userWorkPlace = auth()->user()->work_place;

        // School Level
        if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
            $staffAdrCodes = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                ->where('t2.cur_pos', 1)
                                ->where('t2.location_code', $userWorkPlace->location_code)
                                ->select($p_field)
                                ->distinct()
                                ->pluck($p_field)
                                ->all();
        }
        // DOE
        elseif (auth()->user()->level_id == 4) {
            $staffAdrCodes = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                ->where('t2.cur_pos', 1)
                                ->where('t3.dis_code', $userWorkPlace->dis_code)
                                ->select($p_field)
                                ->distinct()
                                ->pluck($p_field)
                                ->all();
        }
        // POE
        elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
            $staffAdrCodes = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                ->where('t2.cur_pos', 1)
                                ->where('t3.pro_code', $userWorkPlace->pro_code)
                                ->select($p_field)
                                ->distinct()
                                ->pluck($p_field)
                                ->all();
        }

        // Province
        if ($p_table == 'Province') {
            $addresses = Province::whereIn('pro_code', $staffAdrCodes)
                                ->distinct()->select('name_kh')
                                ->orderBy('name_kh', 'ASC')
                                ->pluck('name_kh')->all();
        }
        // District
        elseif ($p_table == 'District') {
            $addresses = District::whereIn('dis_code', $staffAdrCodes)
                                ->distinct()->select('name_kh')
                                ->orderBy('name_kh', 'ASC')
                                ->pluck('name_kh')->all();
        }
        // Commune
        elseif ($p_table == 'Commune') {
            $addresses = Commune::whereIn('com_code', $staffAdrCodes)
                                ->distinct()->select('name_kh')
                                ->orderBy('name_kh', 'ASC')
                                ->pluck('name_kh')->all();
        }
        // Village
        else {
            $addresses = Village::whereIn('vil_code', $staffAdrCodes)
                                ->distinct()->select('name_kh')
                                ->orderBy('name_kh', 'ASC')
                                ->pluck('name_kh')->all();
        }

        return $addresses;
    }

    public function staffLocation($p_table)
    {
        $userWorkPlace = auth()->user()->work_place;

        // School Level
        if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
            $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                            ->where('t2.cur_pos', 1)
                            ->where('t2.location_code', $userWorkPlace->location_code)
                            ->select('hrmis_staffs.payroll_id')
                            ->distinct()
                            ->pluck('hrmis_staffs.payroll_id')
                            ->all();
        }
        // DOE
        elseif (auth()->user()->level_id == 4) {
            $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                            ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                            ->where('t2.cur_pos', 1)
                            ->where('t3.dis_code', $userWorkPlace->dis_code)
                            ->select('hrmis_staffs.payroll_id')
                            ->distinct()
                            ->pluck('hrmis_staffs.payroll_id')
                            ->all();
        }
        // POE 
        elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
            $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                            ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                            ->where('t2.cur_pos', 1)
                            ->where('t3.pro_code', $userWorkPlace->pro_code)
                            ->select('hrmis_staffs.payroll_id')
                            ->distinct()
                            ->pluck('hrmis_staffs.payroll_id')
                            ->all();
        }

        $locationCodes = [];

        if ($p_table == 'StaffTeaching') {
            $locationCodes = StaffTeaching::whereIn('payroll_id', $staffs)->distinct()->pluck('location_code')->all();
        }

        $fields = Location::whereIn('location_code', $locationCodes)->pluck('location_kh')->all();

        return $fields;
    }

    // Ajax get value from table field
    public function ajaxGetFieldValue($table_field)
    {
        $statusLists = [1, 2, 7, 8, 10];
        $userWorkPlace = auth()->user()->work_place;

        $table_field_exp = explode('.', $table_field);

        if ($table_field_exp[0] == 'hrmis_staffs') {
            if ($table_field_exp[1] == 'sex') {
                $fieldValues = ['ប្រុស', 'ស្រី'];
            }
            // Birth Provinces
            elseif ($table_field_exp[1] == 'birth_pro_code' || $table_field_exp[1] == 'adr_pro_code') {
                $fieldValues = Province::active()->pluck('name_kh')->all();
            }

            // Birth Districts
            elseif ($table_field_exp[1] == 'birth_district' || $table_field_exp[1] == 'adr_dis_code') {
                $fieldValues = District::active()->pluck('name_kh')->all();
            }

            // Birth Communes
            elseif ($table_field_exp[1] == 'birth_commune' || $table_field_exp[1] == 'adr_com_code') {
                $fieldValues = Commune::active()->pluck('name_kh')->all();
            }

            // Birth Villages
            elseif ($table_field_exp[1] == 'birth_village' || $table_field_exp[1] == 'adr_vil_code') {
                $fieldValues = Village::pluck('name_kh')->all();
            }
            elseif ($table_field_exp[1] == 'dtmt_school') {
                $fieldValues = ['Yes', 'No'];
            }
            elseif ($table_field_exp[1] == 'maritalstatus_id') {
                $fieldValues = MaritalStatus::distinct()->select('maritalstatus_kh')->pluck('maritalstatus_kh')->all();
            }
            /*elseif ($table_field_exp[1] == 'adr_vil_code') {
                $fieldValues = $this->staffAddress('hrmis_staffs.adr_vil_code', 'Village');
            }
            elseif ($table_field_exp[1] == 'adr_com_code') {
                $fieldValues = $this->staffAddress('hrmis_staffs.adr_com_code', 'Commune');
            }
            elseif ($table_field_exp[1] == 'adr_dis_code') {
                $fieldValues = $this->staffAddress('hrmis_staffs.adr_dis_code', 'District');
            }
            elseif ($table_field_exp[1] == 'adr_pro_code') {
                $fieldValues = $this->staffAddress('hrmis_staffs.adr_pro_code', 'Province');
            }*/
            else {
                // School Level
                if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
                    $fieldValues = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                        ->where('t2.cur_pos', 1)
                                        //->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                        ->where('t2.location_code', $userWorkPlace->location_code)
                                        ->select($table_field)
                                        ->distinct()
                                        ->pluck($table_field)
                                        ->all();
                }
                // DOE
                elseif (auth()->user()->level_id == 4) {
                    $fieldValues = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                        ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                        ->where('t2.cur_pos', 1)
                                        ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                        ->where('t3.dis_code', $userWorkPlace->dis_code)
                                        ->select($table_field)
                                        ->distinct()
                                        ->pluck($table_field)
                                        ->all();
                }
                // POE
                elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
                    $fieldValues = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                        ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                        ->where('t2.cur_pos', 1)
                                        ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                        ->where('t3.pro_code', $userWorkPlace->pro_code)
                                        ->select($table_field)
                                        ->distinct()
                                        ->pluck($table_field)
                                        ->all();
                }
                else {
                    $fieldValues = Staff::select($table_field)->orderBy($table_field, 'ASC')
                                        ->distinct()->pluck($table_field)->all();
                }
            }
        }
        elseif ($table_field_exp[0] == 'sys_provinces') {
            $fieldValues = Province::select($table_field)->distinct()->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'sys_locations') {
            if ($table_field_exp[1] == 'pro_code') {
                if (auth()->user()->hasRole('administrator')) {
                    $fieldValues = Province::select('name_kh')->pluck('name_kh')->all();
                } else {
                    $fieldValues = Province::where('pro_code', $userWorkPlace->pro_code)
                                            ->select('name_kh')->pluck('name_kh')->all();
                }
            } elseif ($table_field_exp[1] == 'dis_code') {
                if (auth()->user()->hasRole('administrator')) {
                    $fieldValues = District::select('name_kh')->pluck('name_kh')->all();
                }
                // POE
                elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
                    $fieldValues = District::where('pro_code', $userWorkPlace->pro_code)
                                            ->select('name_kh')->pluck('name_kh')->all();
                }
                else {
                    $fieldValues = District::where('dis_code', $userWorkPlace->dis_code)
                                            ->select('name_kh')->pluck('name_kh')->all();
                }
            } elseif ($table_field_exp[1] == 'com_code') {
                if (auth()->user()->hasRole('administrator')) {
                    $fieldValues = Commune::select('name_kh')->pluck('name_kh')->all();
                }
                // POE
                elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
                    $disCodes = District::where('pro_code', $userWorkPlace->pro_code)->pluck('dis_code')->all();
                    $fieldValues = Commune::whereIn('dis_code', $disCodes)->select('name_kh')->pluck('name_kh')->all();
                }
                // DOE
                elseif (auth()->user()->level_id == 4) {
                    $fieldValues = Commune::whereIn('dis_code', $userWorkPlace->dis_code)
                                            ->select('name_kh')->pluck('name_kh')->all();
                }
                else {
                    $fieldValues = Commune::where('com_code', $userWorkPlace->com_code)
                                            ->select('name_kh')->pluck('name_kh')->all();
                }
            } else {
                // School Level
                if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
                    $fieldValues = Location::where('location_code', $userWorkPlace->location_code)
                                           ->pluck($table_field)
                                           ->all();
                }
                // DOE
                elseif (auth()->user()->level_id == 4) {
                    $fieldValues = Location::where('dis_code', $userWorkPlace->dis_code)->pluck('location_kh')->all();
                }
                // POE
                elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
                    $fieldValues = Location::where('pro_code', $userWorkPlace->pro_code)->pluck('location_kh')->all();
                }
                else {
                    $fieldValues = Location::distinct()->select($table_field)->pluck($table_field)->all();
                }
            }
        }
        elseif ($table_field_exp[0] == 'sys_positions') {
            // School Level
            if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
                $location = Location::where('location_code', $userWorkPlace->location_code)
                                    ->select('location_type_id')
                                    ->first();

                $positionsOfLocation = PositionLocation::where('location_type_id', $location->location_type_id)
                                                       ->pluck('position_id')
                                                       ->all();

                $fieldValues = Position::whereIn('position_id', $positionsOfLocation)
                                       ->select($table_field)
                                       ->pluck($table_field)
                                       ->all();
            } else {
                $fieldValues = Position::distinct()->select($table_field)->pluck($table_field)->all();
            }
        }
        
        elseif ($table_field_exp[0] == 'hrmis_staff_salaries') {
            if ($table_field_exp[1] == 'salary_degree') {
                $fieldValues = ['១', '២', '៣', '៤', '៥', '៦'];
            }
            elseif ($table_field_exp[1] == 'cardre_type_id') {
                $fieldValues = CardreType::pluck('cardre_type_kh')->all();
            }
            elseif ($table_field_exp[1] == 'salary_level_id') {
                $fieldValues = SalaryLevel::distinct()->pluck('salary_level_kh')->all();
            }
            else {
                // School Level
                if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->where('t2.cur_pos', 1)
                                    ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                    ->where('t2.location_code', $userWorkPlace->location_code)
                                    ->select('hrmis_staffs.payroll_id')
                                    ->distinct()
                                    ->pluck('hrmis_staffs.payroll_id')
                                    ->all();
                }
                // DOE
                elseif (auth()->user()->level_id == 4) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                    ->where('t2.cur_pos', 1)
                                    ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                    ->where('t3.dis_code', $userWorkPlace->dis_code)
                                    ->select('hrmis_staffs.payroll_id')
                                    ->distinct()
                                    ->pluck('hrmis_staffs.payroll_id')
                                    ->all();
                }
                // POE
                elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                    ->where('t2.cur_pos', 1)
                                    ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                    ->where('t3.pro_code', $userWorkPlace->pro_code)
                                    ->select('hrmis_staffs.payroll_id')
                                    ->distinct()
                                    ->pluck('hrmis_staffs.payroll_id')
                                    ->all();
                }

                $fieldValues = StaffSalary::whereIn('payroll_id', $staffs)
                                          ->distinct()->select($table_field)
                                          ->orderBy($table_field, 'ASC')
                                          ->pluck($table_field)->all();
            }
        }
        elseif ($table_field_exp[0] == 'hrmis_work_histories') {
            if ($table_field_exp[1] == 'position_id' || $table_field_exp[1] == 'additional_position_id') {
                // School Level
                if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
                    $location = Location::where('location_code', $userWorkPlace->location_code)
                                        ->select('location_type_id')
                                        ->first();

                    $positionsOfLocation = PositionLocation::where('location_type_id', $location->location_type_id)
                                                           ->pluck('position_id')
                                                           ->all();

                    $fieldValues = Position::whereIn('position_id', $positionsOfLocation)
                                           ->select('position_kh')
                                           ->pluck('position_kh')
                                           ->all();
                }
                else {
                    $fieldValues = Position::pluck('position_kh')->all();
                }
            }
            else {
                $fieldValues = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                                    ->where('hrmis_work_histories.cur_pos', 1)
                                    ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                    ->where('hrmis_work_histories.location_code', $userWorkPlace->location_code)
                                    ->select($table_field)
                                    ->distinct()
                                    ->pluck($table_field)
                                    ->all();
            }
        }
        elseif ($table_field_exp[0] == 'hrmis_families') {
            if ($table_field_exp[1] == 'occupation') {
                $fieldValues = ['មន្រ្តីរាជការ', 'ក្រុមហ៊ុនឯកជន', 'មេផ្ទះ', 'អាជីវករ', 'កសិករ'];
            }
            if ($table_field_exp[1] == 'allowance') {
                return ['Yes', 'No'];
            }
            else {
                // School Level
                if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->where('t2.cur_pos', 1)
                                    ->where('t2.location_code', $userWorkPlace->location_code)
                                    ->select('hrmis_staffs.payroll_id')
                                    ->distinct()
                                    ->pluck('hrmis_staffs.payroll_id')
                                    ->all();
                }
                // DOE
                elseif (auth()->user()->level_id == 4) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                    ->where('t2.cur_pos', 1)
                                    ->where('t3.dis_code', $userWorkPlace->dis_code)
                                    ->select('hrmis_staffs.payroll_id')
                                    ->distinct()
                                    ->pluck('hrmis_staffs.payroll_id')
                                    ->all();
                }
                // POE
                elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                    ->where('t2.cur_pos', 1)
                                    ->where('t3.pro_code', $userWorkPlace->pro_code)
                                    ->select('hrmis_staffs.payroll_id')
                                    ->distinct()
                                    ->pluck('hrmis_staffs.payroll_id')
                                    ->all();
                }

                $fieldValues = StaffFamily::whereIn('payroll_id', $staffs)
                                          ->distinct()->select($table_field)
                                          ->orderBy($table_field, 'ASC')
                                          ->pluck($table_field)->all();
            }
        }
        elseif ($table_field_exp[0] == 'hrmis_staff_teachings') {
            if ($table_field_exp[1] == 'location_code') {
                $fieldValues = $this->staffLocation('StaffTeaching');
            }
            else {
                $fieldValues = ['Yes', 'No'];
            }

            //$fieldValues = ['ជួយបង្រៀន', 'បង្រៀនភាសាអង់គ្លេស', 'ថ្នាក់គួប', 'ថ្នាក់គួបបីកម្រិត', 'ពីរថ្នាក់ពីរពេល', 'ពីរភាសា', 'ទទួលបន្ទុកថ្នាក់', 'ប្រធានក្រុមបច្ចេកទេស', 'បង្រៀនឆ្លងសាលា'];
        }
        elseif ($table_field_exp[0] == 'hrmis_staff_qualifications') {
            if ($table_field_exp[1] == 'subject_id') {
                $fieldValues = Subject::orderBy('subject_hierachy', 'ASC')->pluck('subject_kh')->all();
            }
            elseif ($table_field_exp[1] == 'country_id') {
                $fieldValues = Country::active()->orderBy('country_en', 'ASC')->pluck('country_kh')->all();
            }
            else {
                // School Level
                if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                        ->where('t2.cur_pos', 1)
                                        ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                        ->where('t2.location_code', $userWorkPlace->location_code)
                                        ->select('hrmis_staffs.payroll_id')
                                        ->distinct()
                                        ->pluck('hrmis_staffs.payroll_id')
                                        ->all();
                }
                // DOE
                elseif (auth()->user()->level_id == 4) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                    ->where('t2.cur_pos', 1)
                                    ->where('t3.dis_code', $userWorkPlace->dis_code)
                                    ->select('hrmis_staffs.payroll_id')
                                    ->distinct()
                                    ->pluck('hrmis_staffs.payroll_id')
                                    ->all();
                }
                // POE
                elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                    ->where('t2.cur_pos', 1)
                                    ->where('t3.pro_code', $userWorkPlace->pro_code)
                                    ->select('hrmis_staffs.payroll_id')
                                    ->distinct()
                                    ->pluck('hrmis_staffs.payroll_id')
                                    ->all();
                }

                $fieldValues = StaffQualification::whereIn('payroll_id', $staffs)
                                                 ->distinct()->select($table_field)
                                                 ->orderBy($table_field, 'ASC')
                                                 ->pluck($table_field)->all();
            }
        }
        elseif ($table_field_exp[0] == 'hrmis_staff_professions') {
            if ($table_field_exp[1] == 'location_code') {
                // School Level
                if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                        ->where('t2.cur_pos', 1)
                                        ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                        ->where('t2.location_code', $userWorkPlace->location_code)
                                        ->select('hrmis_staffs.payroll_id')
                                        ->distinct()
                                        ->pluck('hrmis_staffs.payroll_id')
                                        ->all();
                }
                // DOE
                elseif (auth()->user()->level_id == 4) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                    ->where('t2.cur_pos', 1)
                                    ->where('t3.dis_code', $userWorkPlace->dis_code)
                                    ->select('hrmis_staffs.payroll_id')
                                    ->distinct()
                                    ->pluck('hrmis_staffs.payroll_id')
                                    ->all();
                }
                // POE
                elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
                    $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                    ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                    ->where('t2.cur_pos', 1)
                                    ->where('t3.pro_code', $userWorkPlace->pro_code)
                                    ->select('hrmis_staffs.payroll_id')
                                    ->distinct()
                                    ->pluck('hrmis_staffs.payroll_id')
                                    ->all();
                }

                $professionLocations = StaffProfessional::whereIn('payroll_id', $staffs)
                                                        ->pluck('location_code')
                                                        ->all();

                $fieldValues = Location::whereIn('location_code', $professionLocations)->pluck('location_kh')->all();
            }
            elseif ($table_field_exp[1] == 'prof_type_id') {
                $fieldValues = ProfessionalType::distinct()->pluck('prof_type_kh')->all();
            }
            elseif ($table_field_exp[1] == 'subject_id1' || $table_field_exp[1] == 'subject_id2') {
                $fieldValues = Subject::distinct()->pluck('subject_kh')->all();
            }
            elseif ($table_field_exp[1] == 'prof_category_id') {
                $fieldValues = ProfessionalCategory::orderBy('prof_hierachy', 'ASC')->pluck('prof_category_kh')->all();
            }
        }
        elseif ($table_field_exp[0] == 'hrmis_staff_languages') {
            $fieldValues = Language::distinct()->select('language_kh')->pluck('language_kh')->all();
        }

        elseif ($table_field_exp[0] == 'sys_districts') {
            $fieldValues = District::select($table_field)->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'sys_communes') {
            $fieldValues = Commune::select($table_field)->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'sys_staff_status') {
            $fieldValues = StaffStatus::select($table_field)->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'sys_offices') {
            if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
                $fieldValues = [];
            } else {
                $fieldValues = Office::select($table_field)->pluck($table_field)->all();
            }
        }
        elseif ($table_field_exp[0] == 'sys_qualification_codes') {
            $fieldValues = QualificationCode::select($table_field)->orderBy('qualification_hierachy', 'asc')
                                            ->pluck($table_field)
                                            ->all();
        }
        elseif ($table_field_exp[0] == 'sys_official_ranks') {
            $fieldValues = OfficialRank::select($table_field)->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'sys_disabilities') {
            $fieldValues = Disability::select($table_field)->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'sys_ethnics') {
            $fieldValues = Ethnic::select($table_field)->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'sys_leave_types') {
            $fieldValues = LeaveType::distinct()->select($table_field)->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'sys_countries') {
            $fieldValues = Country::distinct()->select($table_field)->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'sys_professional_categories') {
            $fieldValues = ProfessionalCategory::distinct()->select($table_field)->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'sys_grades') {
            $fieldValues = ['Yes', 'No'];
        }

        elseif ($table_field_exp[0] == 'tcp_prof_categories') {
            $fieldValues = ProfessionCategory::select($table_field)->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'tcp_prof_ranks') {
            $fieldValues = ProfessionRank::select($table_field)->pluck($table_field)->all();
        }
        elseif ($table_field_exp[0] == 'tcp_prof_recordings') {
            // School Level
            if (auth()->user()->level_id == 5 || auth()->user()->hasRole('dept-admin')) {
                $staffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                                ->where('hrmis_work_histories.cur_pos', 1)
                                ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                                ->where('hrmis_work_histories.location_code', $userWorkPlace->location_code)
                                ->select('hrmis_staffs.payroll_id')
                                ->distinct()
                                ->pluck('hrmis_staffs.payroll_id')
                                ->all();
            }
            // DOE
            elseif (auth()->user()->level_id == 4) {
                $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                ->where('t2.cur_pos', 1)
                                ->where('t3.dis_code', $userWorkPlace->dis_code)
                                ->select('hrmis_staffs.payroll_id')
                                ->distinct()
                                ->pluck('hrmis_staffs.payroll_id')
                                ->all();
            }
            // POE
            elseif (auth()->user()->level_id == 3 || auth()->user()->level_id == 2) {
                $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                ->join('sys_locations as t3', 't2.location_code', '=', 't3.location_code')
                                ->where('t2.cur_pos', 1)
                                ->where('t3.pro_code', $userWorkPlace->pro_code)
                                ->select('hrmis_staffs.payroll_id')
                                ->distinct()
                                ->pluck('hrmis_staffs.payroll_id')
                                ->all();
            }

            $fieldValues = ProfessionRecording::whereIn('payroll_id', $staffs)
                                              ->select($table_field)->pluck($table_field)->all();
        }
        else {
            $fieldValues = [];
        }

        return array_values(array_filter($fieldValues));
    }

    // Store Report Headers
    public function ajaxStoreReportHeader(Request $request)
    {
        $oldReportHeaders = ReportHeader::where('user_id', auth()->user()->id)->delete();

        foreach ($request->report_fields as $report_field) {
            ReportHeader::create([
                'user_id' => auth()->user()->id,
                'field_id' => $report_field,
            ]);
        }

        return 'success';
    }

    // Ajax get report fields
    public function ajaxGetReportField()
    {
        $reportFields = ReportField::active()
                                ->select('id', 'table_name', 'field_name', 'title_kh', 'is_date_field', 'title_order')
                                ->orderBy('title_order', 'asc')
                                ->get();

        return $reportFields;
    }
}
