<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

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

class MultiCriteriaSearchExport implements FromView
{
    public $criterias;

    //
    public function __construct($p_criterias)
    {
        $this->criterias = $p_criterias;
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
    
    //
    public function view(): View
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
        $staffs = $this->conditionQuery($staffs, request()->first_operator, request()->first_field, $firstValue);

        // 2nd
        if (request()->second_field && request()->second_value[0]) {
            $secondValue = $this->convertedValue(request()->second_field, request()->second_value);
            $staffs = $this->conditionQuery($staffs, request()->second_operator, request()->second_field, $secondValue);
        }

        // 3rd
        if (request()->third_field && request()->third_value[0]) {
            $thirdValue = $this->convertedValue(request()->third_field, request()->third_value);
            $staffs = $this->conditionQuery($staffs, request()->third_operator, request()->third_field, $thirdValue);
        }

        // 4th
        if (request()->fourth_field && request()->fourth_value[0]) {
            $fourthValue = $this->convertedValue(request()->fourth_field, request()->fourth_value);
            $staffs = $this->conditionQuery($staffs, request()->fourth_operator, request()->fourth_field, $fourthValue);
        }

        // 5th
        if (request()->fifth_field && request()->fifth_value[0]) {
            $fifthValue = $this->convertedValue(request()->fifth_field, request()->fifth_value);
            $staffs = $this->conditionQuery($staffs, request()->fifth_operator, request()->fifth_field, $fifthValue);
        }

        $staffs = $staffs->get();

        return view('admin.multi_criteria.excel', compact('reportHeaders', 'staffs'));
    }
}
