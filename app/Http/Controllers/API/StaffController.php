<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\WorkHistory;
use App\Models\StaffTeaching;
use App\Models\StaffFamily;
use App\Models\AdmirationBlame;
use App\Models\StaffQualification;
use App\Models\StaffProfessional;
use App\Models\ShortCourse;
use App\Models\StaffLanguage;
use App\Models\TeachingSubject;
use App\Models\Profile\ProfileCheck;
use App\Models\TCP\ProfessionRecording;
use App\Models\StaffLeave;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function staffProfile(Request $request)
    {
        $lang = $request->lang;
        $staff = DB::table('hrmis_staffs')
            ->leftJoin('sys_provinces as pro0', 'hrmis_staffs.birth_pro_code', '=', 'pro0.pro_code')
            ->leftJoin('sys_provinces as pro', 'hrmis_staffs.adr_pro_code', '=', 'pro.pro_code')
            ->leftJoin('sys_districts as dis', 'hrmis_staffs.adr_dis_code', '=', 'dis.dis_code')
            ->leftJoin('sys_communes as com', 'hrmis_staffs.adr_com_code', '=', 'com.com_code')
            ->leftJoin('sys_villages as vil', 'hrmis_staffs.adr_vil_code', '=', 'vil.vil_code')
            ->leftJoin('sys_ethnics as eth', 'hrmis_staffs.ethnic_id', '=', 'eth.ethnic_id')
            ->leftJoin('sys_disabilities as tbl_disability', 'hrmis_staffs.disability_id', '=', 'tbl_disability.disability_id')
            ->leftJoin('sys_maritalstatus as marital', 'hrmis_staffs.maritalstatus_id', '=', 'marital.maritalstatus_id')
            ->select(
                'hrmis_staffs.payroll_id',
                'nid_card',
                'bank_account',
                'surname_kh',
                'hrmis_staffs.name_kh',
                'surname_en',
                'hrmis_staffs.name_en',
                'sex',
                DB::raw("DATE_FORMAT(hrmis_staffs.dob, '%d-%m-%Y') as dob"),
                'eth.ethnic_kh as ethnic',
                'photo',
                'pro0.name_kh as birth_province',
                'birth_district',
                'birth_commune',
                'birth_village',
                DB::raw("DATE_FORMAT(start_date, '%d-%m-%Y') as start_date"),
                DB::raw("DATE_FORMAT(appointment_date, '%d-%m-%Y') as appointment_date"),
                'marital.maritalstatus_kh as marital_status',
                'pro.pro_code',
                'pro.name_kh as province',
                'dis.dis_code',
                'dis.name_kh as district',
                'com.com_code',
                'com.name_kh as commune',
                'vil.vil_code',
                'vil.name_kh as village',
                'house_num',
                'street_num',
                'group_num',
                'address',
                'phone',
                'email',
                'dtmt_school',
                'sbsk_num',
                'tbl_disability.disability_kh as disability'
            )
            ->where('hrmis_staffs.payroll_id', $request->payroll_id)->first();

        if ($staff) {
            $cur_work = DB::table('hrmis_work_histories as workhis')
                ->join('sys_locations as location', 'workhis.location_code', '=', 'location.location_code')
                ->join('sys_positions as pos', 'workhis.position_id', '=', 'pos.position_id')
                // ->leftJoin('sys_admin_offices as admoffice', 'workhis.sys_admin_office_id', '=', 'admoffice.sys_admin_office_id')
                // ->leftJoin('sys_offices as office', 'admoffice.office_id', '=', 'office.office_id')
                ->leftJoin('sys_offices as office', 'workhis.sys_admin_office_id', '=', 'office.office_id')
                ->select('location.location_kh as location', 'office.office_kh as office', 'pos.position_kh as position')
                ->where('workhis.payroll_id', $request->payroll_id)
                ->where('workhis.cur_pos', 1)
                ->first();

            $salary_info = DB::table('hrmis_staff_salaries as salary')
                ->leftJoin('sys_official_ranks as rank', 'salary.official_rank_id', '=', 'rank.official_rank_id')
                ->leftJoin('salary_levels', 'salary.salary_level_id', '=', 'salary_levels.salary_level_id')
                ->select(
                    'rank.official_rank_kh as official_rank',
                    'salary_degree',
                    'salary_levels.salary_level_kh as salary_level',
                    DB::raw("DATE_FORMAT(salary_type_shift_date, '%d-%m-%Y') as last_received_date"),
                    'salary_type_prokah_num as prokah_num',
                    'salary_type_signdate',
                    DB::raw("DATE_FORMAT(salary_type_signdate, '%d-%m-%Y') as sign_date"),
                    'salary_type_prokah_order as rank_number'
                )
                ->where('salary.payroll_id', $request->payroll_id)
                ->orderBy('salary_type_signdate', 'desc')->first();

            $teachingData = StaffTeaching::join('sys_academic_years', 'sys_academic_years.year_id', '=', 'hrmis_staff_teachings.year_id')
                ->select(
                    'hrmis_staff_teachings.year_id',
                    'sys_academic_years.year_kh',
                    'add_teaching',
                    'class_incharge',
                    'chief_technical',
                    'multi_grade',
                    'double_shift',
                    'bi_language',
                    'teach_english',
                    'teach_cross_school',
                    'location_code',
                    'triple_grade',
                    'overtime'
                )
                ->where('payroll_id', $request->payroll_id)
                ->orderBy('hrmis_staff_teachings.year_id', 'desc')
                ->limit(3)
                ->get();

            $workHisData = WorkHistory::join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
                ->select(
                    'description',
                    'sys_locations.location_kh as location',
                    'cur_pos',
                    DB::raw("DATE_FORMAT(start_date, '%d-%m-%Y') as start_date"),
                    DB::raw("DATE_FORMAT(end_date, '%d-%m-%Y') as end_date")
                )
                ->where('payroll_id', $request->payroll_id)
                ->whereNotIn('his_type_id', [5])
                ->orderBy('start_date', 'DESC')
                ->limit(3)
                ->get();

            $admiraData = AdmirationBlame::leftJoin('sys_admiration_sources as src', 'hrmis_admiration_blames.admiration_source_id', '=', 'src.source_id')
                ->select('admiration', 'src.source_kh as source', DB::raw("DATE_FORMAT(admiration_date, '%d-%m-%Y') as admiration_date"))
                ->where('payroll_id', $request->payroll_id)
                ->orderBy('admiration_date', 'DESC')
                ->limit(3)
                ->get();

            $qualData = StaffQualification::join('sys_qualification_codes', 'hrmis_staff_qualifications.qualification_code', '=', 'sys_qualification_codes.qualification_code')
                ->leftJoin('sys_subjects AS subj', 'hrmis_staff_qualifications.subject_id', '=', 'subj.subject_id')
                ->leftJoin('sys_countries AS country', 'hrmis_staff_qualifications.country_id', '=', 'country.country_id')
                ->select(
                    'sys_qualification_codes.qualification_kh as qualification',
                    'subj.subject_kh as skill',
                    DB::raw("DATE_FORMAT(qual_date, '%d-%m-%Y') as qual_date"),
                    'country.country_kh as country',
                    'location_kh as location'
                )
                ->where('hrmis_staff_qualifications.payroll_id', $request->payroll_id)
                ->orderBy('qualification_hierachy', 'DESC')
                ->get();

            $profData = StaffProfessional::join('sys_professional_categories AS cat', 'hrmis_staff_professions.prof_category_id', '=', 'cat.prof_category_id')
                ->leftJoin('sys_subjects AS subj1', 'hrmis_staff_professions.subject_id1', '=', 'subj1.subject_id')
                ->leftJoin('sys_subjects AS subj2', 'hrmis_staff_professions.subject_id2', '=', 'subj2.subject_id')
                ->leftJoin('sys_professional_types as proftype', 'hrmis_staff_professions.prof_type_id', '=', 'proftype.prof_type_id')
                ->leftJoin('sys_locations as location', 'hrmis_staff_professions.location_code', '=', 'location.location_code')
                ->select(
                    'cat.prof_category_kh as skill',
                    'subj1.subject_kh as subject1',
                    'subj2.subject_kh as subject2',
                    'proftype.prof_type_kh as training_system',
                    'location_kh as location',
                    DB::raw("DATE_FORMAT(prof_date, '%d-%m-%Y') as prof_date")
                )
                ->where('payroll_id', $request->payroll_id)
                ->orderBy('cat.prof_hierachy')
                ->get();

            $shortCourseData = ShortCourse::join('sys_shortcourse_categories AS cat', 'hrmis_shortcourses.shortcourse_cat_id', '=', 'cat.shortcourse_cat_id')
                ->join('sys_duration_types AS durtype', 'hrmis_shortcourses.duration_type_id', '=', 'durtype.dur_type_id')
                ->leftJoin('sys_training_partner_types AS org', 'hrmis_shortcourses.organized', '=', 'org.partner_type_id')
                ->leftJoin('sys_training_partner_types AS don', 'hrmis_shortcourses.donor', '=', 'don.partner_type_id')
                ->select(
                    'cat.shortcourse_cat_kh AS category',
                    'qualification as skill',
                    DB::raw("DATE_FORMAT(start_date, '%d-%m-%Y') as start_date"),
                    DB::raw("DATE_FORMAT(end_date, '%d-%m-%Y') as end_date"),
                    DB::raw("CONCAT(duration, durtype.dur_type_kh) AS duration"),
                    'org.partner_type_kh as organized',
                    'don.partner_type_kh as donor',
                )
                ->where('payroll_id', $request->payroll_id)
                ->orderBy('start_date', 'DESC')
                ->limit(6)
                ->get();

            $languageData = StaffLanguage::join('sys_languages', 'sys_languages.language_id', '=', 'hrmis_staff_languages.language_id')
                ->select('sys_languages.language_kh as language', 'reading', 'writing', 'conversation')
                ->where('payroll_id', $request->payroll_id)
                ->get();

            $spouse = StaffFamily::where('payroll_id', $request->payroll_id)
                ->whereIn('relation_type_id', [1, 2])
                ->select(
                    'fullname_kh',
                    'occupation',
                    'spouse_workplace',
                    'phone_number',
                    'allowance',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob")
                )
                ->first();

            $childrenData = StaffFamily::where('payroll_id', $request->payroll_id)
                ->where('relation_type_id', 3)
                ->select('fullname_kh', 'gender', DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"), 'occupation', 'allowance')
                ->get();

            $tcpProfessional = ProfessionRecording::join('tcp_prof_ranks as t2', 'tcp_prof_recordings.tcp_prof_rank_id', '=', 't2.tcp_prof_rank_id')
                ->select(
                    't2.tcp_prof_rank_kh as tcp_professional',
                    'description',
                    'prokah_num',
                    'date_received',
                    DB::raw("DATE_FORMAT(date_received, '%d-%m-%Y') as date_received2")
                )
                ->where('payroll_id', $request->payroll_id)
                ->orderBy('date_received', 'DESC')
                ->get();

            $leaveHistory = StaffLeave::join('sys_leave_types as t2', 'hrmis_staff_leaves.leave_type_id', '=', 't2.leave_type_id')
                ->select(
                    't2.leave_type_kh as leave_type',
                    'description',
                    'start_date',
                    DB::raw("DATE_FORMAT(start_date, '%d-%m-%Y') as start_date2"),
                    DB::raw("DATE_FORMAT(end_date, '%d-%m-%Y') as end_date")
                )
                ->where('payroll_id', $request->payroll_id)
                ->orderBy('start_date', 'DESC')
                ->get();

            $level_id = $request->level_id;
            $pendingData = 0;
            if ($level_id == 5) { //school
                $pendingData = ProfileCheck::where('payroll_id', $request->payroll_id)
                    ->where(function ($q) {
                        $q->where(function ($query) {
                            $query->where('field_id', '<>', '011')
                                ->where('school_check_status', 4);
                        })
                            ->orWhere(function ($query) {
                                $query->where('field_id', '011')
                                    ->where('admin_check_status', 4);
                            });
                    })->count('id');
            } else if ($level_id == 4) { //doe
                $pendingData = ProfileCheck::where('payroll_id', $request->payroll_id)
                    ->where(function ($q) {
                        $q->where(function ($query) {
                            $query->where('field_id', '<>', '011')
                                ->where('doe_check_status', 4);
                        })
                            ->orWhere(function ($query) {
                                $query->where('field_id', '011')
                                    ->where('admin_check_status', 4);
                            });
                    })->count('id');
            } else if ($level_id == 3) { //poe
                $pendingData = ProfileCheck::where('payroll_id', $request->payroll_id)
                    ->where(function ($q) {
                        $q->where(function ($query) {
                            $query->where('field_id', '<>', '011')
                                ->where('poe_check_status', 4);
                        })
                            ->orWhere(function ($query) {
                                $query->where('field_id', '011')
                                    ->where('admin_check_status', 4);
                            });
                    })->count('id');
            } else { //central (department)
                $pendingData = ProfileCheck::where('payroll_id', $request->payroll_id)
                    ->where(function ($q) {
                        $q->where(function ($query) {
                            $query->where('field_id', '<>', '011')
                                ->where('department_check_status', 4);
                        })
                            ->orWhere(function ($query) {
                                $query->where('field_id', '011')
                                    ->where('admin_check_status', 4);
                            });
                    })->count('id');
            }

            $response = [
                'data'  => [
                    'staff'             => $staff,
                    'cur_work'          => $cur_work ? $cur_work : [],
                    'salary_info'       => $salary_info ? $salary_info : [],
                    'teachingData'      => $teachingData,
                    'workHisData'       => $workHisData,
                    'admiraData'        => $admiraData,
                    'qualData'          => $qualData,
                    'profData'          => $profData,
                    'shortCourseData'   => $shortCourseData,
                    'languageData'      => $languageData,
                    'spouse'            => $spouse ? $spouse : [],
                    'childrenData'      => $childrenData,
                    'tcpProfessional'   => $tcpProfessional,
                    'leaveHistory'      => $leaveHistory,
                    'pendingData'       => $pendingData
                ],
                'code'              => config('constants.codes.success'),
                'message'           => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
            ];
            return response($response, 200);
        } else {
            return response([
                'code'  => config('constants.codes.fail_404'),
                'message' => $lang == 'en' ? config('constants.messages_en.request_fail') : config('constants.messages.request_fail')
            ], 404);
        }
    }

    public function contractProfile(Request $request)
    {
        $lang = $request->lang;
        $staff = DB::table('hrmis_staffs')
            ->leftJoin('sys_provinces as pro0', 'hrmis_staffs.birth_pro_code', '=', 'pro0.pro_code')
            ->leftJoin('sys_provinces as pro', 'hrmis_staffs.adr_pro_code', '=', 'pro.pro_code')
            ->leftJoin('sys_districts as dis', 'hrmis_staffs.adr_dis_code', '=', 'dis.dis_code')
            ->leftJoin('sys_communes as com', 'hrmis_staffs.adr_com_code', '=', 'com.com_code')
            ->leftJoin('sys_villages as vil', 'hrmis_staffs.adr_vil_code', '=', 'vil.vil_code')
            ->select(
                'hrmis_staffs.payroll_id',
                'nid_card',
                'bank_account',
                'surname_kh',
                'hrmis_staffs.name_kh',
                'surname_en',
                'hrmis_staffs.name_en',
                'sex',
                DB::raw("DATE_FORMAT(hrmis_staffs.dob, '%d-%m-%Y') as dob"),
                'photo',
                'hrmis_staffs.experience',
                'pro0.name_kh as birth_province',
                'birth_district',
                'birth_commune',
                'birth_village',
                DB::raw("DATE_FORMAT(start_date, '%d-%m-%Y') as start_date"),
                'pro.name_kh as province',
                'dis.name_kh as district',
                'com.name_kh as commune',
                'vil.name_kh as village',
                'house_num',
                'street_num',
                'group_num',
                'phone'
            )
            ->where('hrmis_staffs.payroll_id', $request->payroll_id)->first();

        if ($staff) {
            $cur_work = DB::table('hrmis_work_histories as workhis')
                ->join('sys_locations as location', 'workhis.location_code', '=', 'location.location_code')
                ->join('sys_contract_types as cont_type', 'workhis.contract_type_id', '=', 'cont_type.contract_type_id')
                ->join('sys_contstaff_positions as pos', 'workhis.cont_pos_id', '=', 'pos.cont_pos_id')
                ->leftJoin('sys_provinces as pro', 'workhis.location_pro_code', '=', 'pro.pro_code')
                ->leftJoin('sys_districts as dis', 'workhis.location_dis_code', '=', 'dis.dis_code')
                ->leftJoin('sys_communes as com', 'workhis.location_com_code', '=', 'com.com_code')
                ->leftJoin('sys_villages as vil', 'workhis.location_vil_code', '=', 'vil.vil_code')
                ->select(
                    DB::raw("DATE_FORMAT(workhis.start_date, '%d-%m-%Y') as start_date"),
                    'location.location_kh as location',
                    'pro.name_kh as province',
                    'dis.name_kh as district',
                    'com.name_kh as commune',
                    'vil.name_kh as village',
                    'workhis.contract_type_id',
                    'cont_type.contract_type_kh as contract_type',
                    'pos.cont_pos_kh as position',
                    'workhis.has_refilled_training',
                    'workhis.year_refilled_num'
                )
                ->where('workhis.payroll_id', $request->payroll_id)
                ->where('workhis.cur_pos', 1)
                ->first();

            $teachingData = StaffTeaching::join('sys_academic_years', 'sys_academic_years.year_id', '=', 'hrmis_staff_teachings.year_id')
                ->select(
                    'hrmis_staff_teachings.year_id',
                    'sys_academic_years.year_kh',
                    'multi_grade',
                    'double_shift',
                    'bi_language',
                    'teach_english'
                )
                ->where('payroll_id', $request->payroll_id)
                ->orderBy('hrmis_staff_teachings.year_id', 'desc')
                ->limit(3)
                ->get();

            $workHisData = DB::table('hrmis_work_histories as workhis')
                ->join('sys_locations as location', 'workhis.location_code', '=', 'location.location_code')
                ->join('sys_contract_types as cont_type', 'workhis.contract_type_id', '=', 'cont_type.contract_type_id')
                ->join('sys_contstaff_positions as pos', 'workhis.cont_pos_id', '=', 'pos.cont_pos_id')
                ->select(
                    'location.location_kh as location',
                    'cont_type.contract_type_kh as contract_type',
                    'pos.cont_pos_kh as position',
                    'cur_pos',
                    DB::raw("DATE_FORMAT(workhis.start_date, '%d-%m-%Y') as start_date"),
                    DB::raw("DATE_FORMAT(workhis.end_date, '%d-%m-%Y') as end_date"),
                    'workhis.annual_eval'
                )
                ->where('payroll_id', $request->payroll_id)
                ->orderBy('workhis.start_date', 'DESC')
                ->limit(3)
                ->get();

            $qualData = StaffQualification::join('sys_qualification_codes', 'hrmis_staff_qualifications.qualification_code', '=', 'sys_qualification_codes.qualification_code')
                ->leftJoin('sys_subjects AS subj', 'hrmis_staff_qualifications.subject_id', '=', 'subj.subject_id')
                ->select(
                    'sys_qualification_codes.qualification_kh as qualification',
                    'subj.subject_kh as skill'
                )
                ->where('hrmis_staff_qualifications.payroll_id', $request->payroll_id)
                ->orderBy('qualification_hierachy', 'DESC')
                ->first();

            $response = [
                'data'  => [
                    'staff'             => $staff,
                    'cur_work'          => $cur_work ? $cur_work : [],
                    'teachingData'      => $teachingData,
                    'workHisData'       => $workHisData,
                    'qualData'          => $qualData
                ],
                'code'              => config('constants.codes.success'),
                'message'           => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
            ];
            return response($response, 200);
        } else {
            return response([
                'code'  => config('constants.codes.fail_404'),
                'message' => $lang == 'en' ? config('constants.messages_en.request_fail') : config('constants.messages.request_fail')
            ], 404);
        }
    }

    public function teachingDetails(Request $request)
    {
        $lang = $request->lang;
        $teaching = StaffTeaching::join('sys_academic_years', 'sys_academic_years.year_id', '=', 'hrmis_staff_teachings.year_id')
            ->leftJoin('sys_locations', 'hrmis_staff_teachings.location_code', '=', 'sys_locations.location_code')
            ->select(
                'hrmis_staff_teachings.year_id',
                'sys_academic_years.year_kh',
                'add_teaching',
                'class_incharge',
                'chief_technical',
                'multi_grade',
                'double_shift',
                'bi_language',
                'teach_english',
                'teach_cross_school',
                'location_kh',
                'triple_grade',
                'overtime'
            )
            ->where('payroll_id', $request->payroll_id)
            ->where('hrmis_staff_teachings.year_id', $request->year_id)
            ->first();
        if ($teaching) {
            $teachingRows = TeachingSubject::join('sys_grades', 'hrmis_teaching_subjects.grade_id', '=', 'sys_grades.grade_id')
                ->leftJoin('sys_subjects', 'hrmis_teaching_subjects.subject_id', '=', 'sys_subjects.subject_id')
                ->leftJoin('sys_day_teachings', 'hrmis_teaching_subjects.day_id', '=', 'sys_day_teachings.day_id')
                ->leftJoin('sys_hour_teachings', 'hrmis_teaching_subjects.hour_id', '=', 'sys_hour_teachings.hour_id')
                ->select('subject_kh', 'grade_kh', 'grade_alias', 'day_kh', 'hour_kh')
                ->where('payroll_id', $request->payroll_id)
                ->where('hrmis_teaching_subjects.year_id', $request->year_id)
                ->orderByRaw('subject_kh, grade_kh, day_kh, hour_kh')
                ->get();

            $response = [
                'data'  => [
                    'teaching'      => $teaching,
                    'teachingRows'  => $teachingRows
                ],
                'code'              => config('constants.codes.success'),
                'message'           => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
            ];
            return response($response, 200);
        } else {
            return response([
                'code'  => config('constants.codes.fail_404'),
                'message' => $lang == 'en' ? config('constants.messages_en.request_fail') : config('constants.messages.request_fail')
            ], 404);
        }
    }

    public function addCommentData(Request $request)
    {
        $lang = $request->lang;
        $data = $request->data;
        if ($data) {
            ProfileCheck::upsert(
                $data,
                ['field_id', 'payroll_id'],
                [
                    'admin_approver', 'admin_check_date', 'admin_check_status', 'correct_value', 'department_approver', 'department_check_date', 'department_check_status',
                    'doe_approver', 'doe_check_date', 'doe_check_status', 'poe_approver', 'poe_check_date', 'poe_check_status',
                    'school_approver', 'school_check_date', 'school_check_status', 'staff_check_date', 'staff_check_status'
                ]
            );
            $level_id = $request->level_id;
            $pendingData = ProfileCheck::where('payroll_id', $request->payroll_id)
                //->where('field_id', '<>', '011')->where('school_check_status', 4)
                ->where(function ($q) use ($level_id) {
                    if ($level_id == 5) { //School
                        $q->where(function ($query) {
                            $query->where('field_id', '<>', '011')
                                ->where('school_check_status', 4);
                        })
                            ->orWhere(function ($query) {
                                $query->where('field_id', '011')
                                    ->where('admin_check_status', 4);
                            });
                    } else if ($level_id == 4) { //DOE
                        $q->where(function ($query) {
                            $query->where('field_id', '<>', '011')
                                ->where('doe_check_status', 4);
                        })
                            ->orWhere(function ($query) {
                                $query->where('field_id', '011')
                                    ->where('admin_check_status', 4);
                            });
                    } else if ($level_id == 3) { //POE
                        $q->where(function ($query) {
                            $query->where('field_id', '<>', '011')
                                ->where('poe_check_status', 4);
                        })
                            ->orWhere(function ($query) {
                                $query->where('field_id', '011')
                                    ->where('admin_check_status', 4);
                            });
                    } else { //Central levels CPDMO and Department
                        $q->where(function ($query) {
                            $query->where('field_id', '<>', '011')
                                ->where('department_check_status', 4);
                        })
                            ->orWhere(function ($query) {
                                $query->where('field_id', '011')
                                    ->where('admin_check_status', 4);
                            });
                    }
                })->count('id');

            $response = [
                'pendingData'  => $pendingData,
                'code'  => config('constants.codes.success'),
                'message' => $lang == 'en' ? 'Your profile verification has been submitted successfully.' : 'ការស្នើសុំកែប្រែព័ត៌មានរបស់អ្នកត្រូវបានបញ្ជូនដោយជោគជ័យ។'
            ];
            return response($response, 201);
        }
        return response([
            'code'  => config('constants.codes.fail_404'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_fail') : config('constants.messages.request_fail')
        ], 404);
    }

    public function getProfilePending(Request $request)
    {
        $request->validate([
            'payroll_id'    => 'required',
            'level_id'      => 'required',
            'lang'          => 'required'
        ]);

        $lang = $request->lang;
        $level_id = $request->level_id;
        $data = DB::table('hrmis_profile_checks as t1')
            ->join('sys_field_checks as t2', 't1.field_id', '=', 't2.field_id')
            ->leftJoin('sys_ethnics as t3', 't1.correct_value', '=', 't3.ethnic_id')
            ->leftJoin('sys_disabilities as t4', 't1.correct_value', '=', 't4.disability_id')
            ->leftJoin('sys_provinces as t5', 't1.correct_value', '=', 't5.pro_code')
            ->leftJoin('sys_maritalstatus as t6', 't1.correct_value', '=', 't6.maritalstatus_id')
            ->leftJoin('sys_provinces as pro', 't1.correct_value', '=', 'pro.pro_code')
            ->leftJoin('sys_districts as dis', 't1.correct_value', '=', 'dis.dis_code')
            ->leftJoin('sys_communes as com', 't1.correct_value', '=', 'com.com_code')
            ->leftJoin('sys_villages as vil', 't1.correct_value', '=', 'vil.vil_code')
            ->where('t1.payroll_id', $request->payroll_id);
        $data = $data->where(function ($q) use ($level_id) {
            if ($level_id == 5) { //School
                $q->where(function ($query) {
                    $query->where('t1.field_id', '<>', '011')
                        ->where('school_check_status', 4);
                })
                    ->orWhere(function ($query) {
                        $query->where('t1.field_id', '011')
                            ->where('admin_check_status', 4);
                    });
            } else if ($level_id == 4) { //DOE
                $q->where(function ($query) {
                    $query->where('t1.field_id', '<>', '011')
                        ->where('doe_check_status', 4);
                })
                    ->orWhere(function ($query) {
                        $query->where('t1.field_id', '011')
                            ->where('admin_check_status', 4);
                    });
            } else if ($level_id == 3) { //POE
                $q->where(function ($query) {
                    $query->where('t1.field_id', '<>', '011')
                        ->where('poe_check_status', 4);
                })
                    ->orWhere(function ($query) {
                        $query->where('t1.field_id', '011')
                            ->where('admin_check_status', 4);
                    });
            } else { //Central levels CPDMO and Department
                $q->where(function ($query) {
                    $query->where('t1.field_id', '<>', '011')
                        ->where('department_check_status', 4);
                })
                    ->orWhere(function ($query) {
                        $query->where('t1.field_id', '011')
                            ->where('admin_check_status', 4);
                    });
            }
        });

        if ($lang == 'en') {
            $data = $data->select(
                't1.field_id',
                't2.field_title_en as field_title',
                DB::raw("(CASE WHEN t1.field_id='011' OR t1.field_id='029' THEN DATE_FORMAT(correct_value, '%d-%m-%Y')
            WHEN t1.field_id='012' THEN t3.ethnic_kh WHEN t1.field_id='013' THEN t4.disability_kh
            WHEN t1.field_id='014' THEN t5.name_kh WHEN t1.field_id='027' THEN t6.maritalstatus_kh
            WHEN t1.field_id='038' THEN pro.name_kh WHEN t1.field_id='039' THEN dis.name_kh
            WHEN t1.field_id='040' THEN com.name_kh WHEN t1.field_id='041' THEN vil.name_kh
            ELSE t1.correct_value END) as correct_value"),
                't1.school_check_status',
                't1.doe_check_status',
                't1.poe_check_status',
                't1.department_check_status',
                't1.admin_check_status'
            )
                ->orderBy('t1.field_id')
                ->get();

            $response = [
                'data'  => $data,
                'code'  => config('constants.codes.success'),
                'message' => config('constants.messages_en.request_success')
            ];
            return response($response, 201);
        } else {
            $data = $data->select(
                't1.field_id',
                't2.field_title_kh as field_title',
                DB::raw("(CASE WHEN t1.field_id='011' OR t1.field_id='029' THEN DATE_FORMAT(correct_value, '%d-%m-%Y')
            WHEN t1.field_id='012' THEN t3.ethnic_kh WHEN t1.field_id='013' THEN t4.disability_kh
            WHEN t1.field_id='014' THEN t5.name_kh WHEN t1.field_id='027' THEN t6.maritalstatus_kh
            WHEN t1.field_id='038' THEN pro.name_kh WHEN t1.field_id='039' THEN dis.name_kh
            WHEN t1.field_id='040' THEN com.name_kh WHEN t1.field_id='041' THEN vil.name_kh
            ELSE t1.correct_value END) as correct_value"),
                't1.school_check_status',
                't1.doe_check_status',
                't1.poe_check_status',
                't1.department_check_status',
                't1.admin_check_status'
            )
                ->orderBy('t1.field_id')
                ->get();

            $response = [
                'data'  => $data,
                'code'  => config('constants.codes.success'),
                'message' => config('constants.messages.request_success')
            ];
            return response($response, 201);
        }
    }
}
