<?php

namespace App\Http\Controllers\API;

use App\Models\Staff;
use App\Models\CPD\Course;
use App\Models\WorkHistory;
use App\Models\CPD\Provider;
use Illuminate\Http\Request;
use App\Models\CPD\FieldOfStudy;
use App\Models\CPD\CourseRelation;
use App\Models\CPD\ScheduleCourse;
use App\Models\CPD\SubjectOfStudy;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CPD\EnrollmentCourse;
use App\Http\Resources\CoursesResource;
use App\Http\Resources\ProvidersResource;
use App\Http\Resources\HrmisStaffsResource;
use App\Http\Resources\HrmisStaffsIIResource;
use App\Http\Resources\FieldOfStudiesResource;
use App\Http\Resources\CpdViewPendingsResource;
use App\Http\Resources\ScheduleCoursesResource;
use App\Http\Resources\CpdPendingsListsResource;
use App\Http\Resources\SubjectOfStudiesResource;
use App\Http\Resources\CpdCreditOfferingsResource;
use App\Http\Resources\HrmisStaffsWorkHistoriesResource;

class HrmisController extends Controller
{

    public function __construct() { $this->middleware(['checktoken']); }  

    // #1
    public function hrmis_staffs(Request $request)
    {
        try {
            $request->validate([
                'pro_code' => 'required',
            ]);
            $locationcode = $request->location_code;
            $discode = $request->dis_code;
            $comcode = $request->com_code;
            $procode = $request->pro_code;
            $select_query = [
                'hrmis_staffs.payroll_id',
                'hrmis_staffs.nid_card',
                'hrmis_staffs.bank_account',
                'hrmis_staffs.surname_kh',
                'hrmis_staffs.name_kh',
                'hrmis_staffs.surname_en',
                'hrmis_staffs.name_en',
                'hrmis_staffs.sex',
                'hrmis_staffs.dob',
                'hrmis_staffs.ethnic_id',
                'hrmis_staffs.photo',
                'hrmis_staffs.birth_pro_code',
                'b_provinces.name_kh as birth_province',
                'hrmis_staffs.birth_district',
                'hrmis_staffs.birth_commune',
                'hrmis_staffs.birth_village',
                'hrmis_staffs.start_date',
                'hrmis_staffs.appointment_date',
                'hrmis_staffs.staff_status_id',
                's_status.status_kh',
                'hrmis_staffs.is_newly_transferred',
                'hrmis_staffs.is_cont_staff',
                DB::raw('IF(hrmis_staffs.is_cont_staff=1,"former","contract") as is_cont_staffs'),
                'hrmis_staffs.experience',
                'hrmis_staffs.former_staff',
                DB::raw('IF(hrmis_staffs.former_staff=1,"former","contract") AS former_staffs'),
                'hrmis_staffs.maritalstatus_id',
                's_maritalstatus.maritalstatus_kh',
                'hrmis_staffs.adr_pro_code',
                'a_provinces.name_kh as adr_province',
                'hrmis_staffs.adr_dis_code',
                'a_districts.name_kh as adr_district',
                'hrmis_staffs.adr_com_code',
                'a_communes.name_kh as adr_commune',
                'hrmis_staffs.adr_vil_code',
                'a_villages.name_kh as adr_village',
                'hrmis_staffs.house_num',
                'hrmis_staffs.street_num',
                'hrmis_staffs.group_num',
                'hrmis_staffs.address',
                'hrmis_staffs.phone',
                'hrmis_staffs.email',
                'hrmis_staffs.dtmt_school',
                'hrmis_staffs.sbsk',
                'hrmis_staffs.sbsk_num',
                'hrmis_staffs.disability_teacher',
                'hrmis_staffs.disability_id',
                's_disabilities.disability_kh',
                'hrmis_staffs.disability_note',
                'hrmis_staffs.created_by',
                'hrmis_staffs.updated_by',
                'hrmis_staffs.created_at',
                'hrmis_staffs.updated_at'
            ];
            $data = [];
            $data = Staff::Join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->leftJoin('sys_locations as loca', 'hrmis_work_histories.location_code', '=', 'loca.location_code')
                ->leftJoin('sys_provinces as b_provinces', 'hrmis_staffs.birth_pro_code', '=', 'b_provinces.pro_code')
                ->leftJoin('sys_staff_status as s_status', 'hrmis_staffs.staff_status_id', '=', 's_status.status_id')
                ->leftJoin('sys_maritalstatus as s_maritalstatus', 'hrmis_staffs.maritalstatus_id', '=', 's_maritalstatus.maritalstatus_id')
                ->leftJoin('sys_provinces as a_provinces', 'hrmis_staffs.adr_pro_code', '=', 'a_provinces.pro_code')
                ->leftJoin('sys_districts as a_districts', 'hrmis_staffs.adr_dis_code', '=', 'a_districts.dis_code')
                ->leftJoin('sys_communes as a_communes', 'hrmis_staffs.adr_com_code', '=', 'a_communes.com_code')
                ->leftJoin('sys_villages as a_villages', 'hrmis_staffs.adr_vil_code', '=', 'a_villages.vil_code')
                ->leftJoin('sys_disabilities as s_disabilities', 'hrmis_staffs.disability_id', '=', 's_disabilities.disability_id')
                ->where('hrmis_work_histories.cur_pos', 1)
                ->when($locationcode <> '', function ($query) use ($procode, $locationcode) {
                    $query->where('loca.pro_code', $procode)
                        ->where('loca.location_code', $locationcode);
                })
                ->when($discode <> '', function ($query) use ($procode, $discode) {
                    $query->where('loca.pro_code', $procode)
                        ->where('loca.dis_code', $discode);
                })
                ->when($comcode <> '', function ($query) use ($procode, $comcode) {
                    $query->where('loca.pro_code', $procode)
                        ->where('loca.com_code', $comcode);
                })
                ->when($procode <> '', function ($query) use ($procode) {
                    $query->where('loca.pro_code', $procode);
                })
                ->select($select_query)
                ->orderby("hrmis_staffs.start_date", "DESC")
                ->groupBy('hrmis_staffs.payroll_id')
                ->get()->all();;

            if (!empty($data)) {
                return HrmisStaffsResource::collection($data)
                    ->response()
                    ->setStatusCode(202);
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), 404);
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()]);
        }
    }

    # 2
    public function hrmis_staffs_ii(Request $request)
    {
        try {
            $request->validate([
                'pro_code' => 'required',
            ]);
            $locationcode = $request->location_code;
            $discode = $request->dis_code;
            $comcode = $request->com_code;
            $procode = $request->pro_code;
            $payroll = $request->payroll_id;
            $select_query = [
                'hrmis_staffs.payroll_id',
                'hrmis_staffs.nid_card',
                'hrmis_staffs.bank_account',
                'hrmis_staffs.surname_kh',
                'hrmis_staffs.name_kh',
                'hrmis_staffs.surname_en',
                'hrmis_staffs.name_en',
                'hrmis_staffs.sex',
                'hrmis_staffs.dob',
                'hrmis_staffs.ethnic_id',
                'hrmis_staffs.photo',
                'hrmis_staffs.birth_pro_code',
                'hrmis_staffs.birth_district',
                'hrmis_staffs.birth_commune',
                'hrmis_staffs.birth_village',
                'hrmis_staffs.start_date',
                'hrmis_staffs.appointment_date',
                'hrmis_staffs.staff_status_id',
                'hrmis_staffs.is_newly_transferred',
                'hrmis_staffs.is_cont_staff',
                'hrmis_staffs.experience',
                'hrmis_staffs.former_staff',
                'hrmis_staffs.maritalstatus_id',
                'hrmis_staffs.adr_pro_code',
                'hrmis_staffs.adr_dis_code',
                'hrmis_staffs.adr_com_code',
                'hrmis_staffs.adr_vil_code',
                'hrmis_staffs.house_num',
                'hrmis_staffs.street_num',
                'hrmis_staffs.group_num',
                'hrmis_staffs.address',
                'hrmis_staffs.phone',
                'hrmis_staffs.email',
                'hrmis_staffs.dtmt_school',
                'hrmis_staffs.sbsk',
                'hrmis_staffs.sbsk_num',
                'hrmis_staffs.disability_teacher',
                'hrmis_staffs.disability_id',
                'hrmis_staffs.disability_note',
                'hrmis_staffs.created_by',
                'hrmis_staffs.updated_by',
                'hrmis_staffs.created_at',
                'hrmis_staffs.updated_at'
            ];
            $data = [];
            $data = Staff::Join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->when($payroll <> '', function ($query) use ($procode, $payroll) {
                    $query->where('hrmis_work_histories.pro_code', $procode)
                        ->where('hrmis_work_histories.payroll_id', $payroll);
                })
                ->when($locationcode <> '', function ($query) use ($procode, $locationcode) {
                    $query->where('hrmis_work_histories.pro_code', $procode)
                        ->where('hrmis_work_histories.location_code', $locationcode);
                })
                ->when($discode <> '', function ($query) use ($procode, $discode) {
                    $query->where('hrmis_work_histories.pro_code', $procode)
                        ->where('hrmis_work_histories.dis_code', $discode);
                })
                ->when($comcode <> '', function ($query) use ($procode, $comcode) {
                    $query->where('hrmis_work_histories.pro_code', $procode)
                        ->where('hrmis_work_histories.com_code', $comcode);
                })
                ->when($procode <> '', function ($query) use ($procode) {
                    $query->where('hrmis_work_histories.pro_code', $procode);
                })
                ->select($select_query)
                ->groupBy('hrmis_work_histories.workhis_id')
                ->orderby("hrmis_work_histories.start_date", "DESC")
                ->paginate();;

            if (!empty($data)) {
                return HrmisStaffsIIResource::collection($data)
                    ->response()
                    ->setStatusCode(202);
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), 404);
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()]);
        }
    }

    # cpd 1
    public function cpd_provider_index(Request $request)
    {
        try {
            $data = [];
            $data = Provider::orderBy('created_at')->paginate();

            if (!empty($data)) {
                return ProvidersResource::collection($data)
                    ->response()
                    ->setStatusCode(config('constants.codes.success'));
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), config('constants.codes.fail_404'));
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()], config('constants.codes.fail_500'));
        }
    }

    # cpd 2
    public function cpd_field_of_studies_index(Request $request)
    {
        try {
            $data = [];
            $data = FieldOfStudy::orderBy('created_at')->paginate();
            if (!empty($data)) {
                return FieldOfStudiesResource::collection($data)
                    ->response()
                    ->setStatusCode(config('constants.codes.success'));
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), config('constants.codes.fail_404'));
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()], config('constants.codes.fail_500'));
        }
    }

    # cpd 3
    public function cpd_subject_of_studies_index(Request $request)
    {
        try {
            $data = [];
            $data = SubjectOfStudy::orderBy('created_at')->paginate();
            if (!empty($data)) {
                return SubjectOfStudiesResource::collection($data)
                    ->response()
                    ->setStatusCode(config('constants.codes.success'));
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), config('constants.codes.fail_404'));
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()], config('constants.codes.fail_500'));
        }
    }

    # cpd 4
    public function cpd_courses_index(Request $request)
    {
        try {
            $data = [];
            $data = Course::orderBy('created_at')->paginate();
            if (!empty($data)) {
                return CoursesResource::collection($data)
                    ->response()
                    ->setStatusCode(config('constants.codes.success'));
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), config('constants.codes.fail_404'));
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()], config('constants.codes.fail_500'));
        }
    }

    # cpd 5
    public function cpd_schedule_courses_index(Request $request)
    {
        try {
            $data = [];
            $data = ScheduleCourse::orderBy('created_at')
                ->select('cpd_schedule_courses.*')->paginate();

            if (!empty($data)) {
                return ScheduleCoursesResource::collection($data)
                    ->response()
                    ->setStatusCode(config('constants.codes.success'));
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), config('constants.codes.fail_404'));
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()], config('constants.codes.fail_500'));
        }
    }

    # cpd 6
    public function cpd_credits_cpd_pendings_list(Request $request)
    {
        try {
            $data = [];
            $data = ScheduleCourse::join('cpd_enrollment_courses as t2', 'cpd_schedule_courses.schedule_course_id', '=', 't2.schedule_course_id')
                ->join('cpd_courses as t3', 'cpd_schedule_courses.cpd_course_id', '=', 't3.cpd_course_id')
                ->join('cpd_providers as t4', 'cpd_schedule_courses.provider_id', '=', 't4.provider_id')
                ->select(
                    'cpd_schedule_courses.schedule_course_id',
                    't4.provider_kh',
                    't3.cpd_course_kh',
                    't3.credits',
                    'participant_num',
                    DB::raw('count(t2.payroll_id) as user_count'),
                    'cpd_schedule_courses.start_date',
                    'cpd_schedule_courses.end_date'
                )
                ->where('t2.is_verified', false)
                ->where('t2.enroll_status_id', 6) //Completed
                ->groupBy(
                    'cpd_schedule_courses.schedule_course_id',
                    't4.provider_kh',
                    't3.cpd_course_kh',
                    't3.credits',
                    'participant_num',
                    'cpd_schedule_courses.start_date',
                    'cpd_schedule_courses.end_date'
                )
                ->orderBy('cpd_schedule_courses.end_date', 'DESC')
                ->paginate();
            if (!empty($data)) {
                return CpdPendingsListsResource::collection($data)
                    ->response()
                    ->setStatusCode(config('constants.codes.success'));
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), config('constants.codes.fail_404'));
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()], config('constants.codes.fail_500'));
        }
    }

    # cpd 7
    public function cpd_credits_view_pending_cpd(Request $request)
    {
        $request->validate([
            'schedule_course_id' => 'required',
        ]);
        try {
            $data = [];
            $data = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                ->join('cpd_enrollment_courses as enroll', 'hrmis_staffs.payroll_id', '=', 'enroll.payroll_id')
                ->join('sys_locations as l', 'l.location_code', '=', 't2.location_code')
                ->leftJoin('sys_positions as pos', 'pos.position_id', '=', 't2.position_id')
                ->leftJoin('sys_contract_types as cont_type', 'cont_type.contract_type_id', '=', 't2.contract_type_id')
                ->where('t2.cur_pos', 1)
                ->where('enroll.schedule_course_id', $request->schedule_course_id)
                ->where('enroll.enroll_status_id', 6) //Completed
                ->where('enroll.is_verified', false) //Pending Records
                ->when(request()->pro_code, function ($query) {
                    $query->where('t2.pro_code', request()->pro_code);
                })
                ->when(request()->dis_code, function ($query) {
                    $query->where(DB::raw("LEFT(t2.location_code, 4)"), request()->dis_code);
                })
                ->when(request()->location_code, function ($query) {
                    $query->where('t2.location_code', request()->location_code);
                })
                ->when(request()->payroll_name, function ($query) {
                    $query->where(function ($query) {
                        $query->where('enroll.payroll_id', request()->payroll_name)
                            ->orWhere(DB::raw('CONCAT(surname_kh, " ", name_kh)'), 'like', '%' . request()->payroll_name . '%')
                            ->orWhere(DB::raw('CONCAT(surname_en, " ", name_en)'), 'like', '%' . request()->payroll_name . '%');
                    });
                })
                ->orderBy('l.location_kh')->orderBy('surname_kh')->orderBy('name_kh')
                ->distinct()
                ->select(
                    'enroll.id',
                    'hrmis_staffs.payroll_id',
                    'surname_kh',
                    'name_kh',
                    'surname_en',
                    'name_en',
                    'sex',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                    DB::raw("(CASE hrmis_staffs.is_cont_staff WHEN 1 THEN cont_type.contract_type_kh ELSE position_kh END) As position_kh"),
                    'position_hierarchy',
                    DB::raw("DATE_FORMAT(enroll.completed_date, '%d-%m-%Y') as completed_date"),
                    'l.location_kh'
                )->paginate();
            if (!empty($data)) {
                return CpdViewPendingsResource::collection($data)
                    ->response()
                    ->setStatusCode(config('constants.codes.success'));
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), config('constants.codes.fail_404'));
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()], config('constants.codes.fail_500'));
        }
    }

    # cpd 8   Get staff to use in CPD credits recording || staff un registered via mobile app
    public function cpd_credits_staff_by_payroll_name(Request $request)
    {
        $request->validate([
            'payroll_name' => 'required',
            'schedule_course_id' => 'required',
        ]);
        $payroll_name = $request->payroll_name;
        $schedule_course_id = $request->schedule_course_id;
        try {
            $data = [];
            $statusLists = [1, 2, 7, 8, 10, 14];
            $data = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                ->leftJoin('sys_positions as pos', 'pos.position_id', '=', 't2.position_id')
                ->leftJoin('sys_contract_types as cont_type', 'cont_type.contract_type_id', '=', 't2.contract_type_id')
                ->where('t2.cur_pos', 1)
                ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                ->when(request()->pro_code, function ($query) {
                    $query->where('t2.pro_code', request()->pro_code);
                })
                ->when(request()->dis_code, function ($query) {
                    $query->where(DB::raw("LEFT(t2.location_code, 4)"), request()->dis_code);
                })
                ->when(request()->location_code, function ($query) {
                    $query->where('t2.location_code', request()->location_code);
                })
                ->where(function ($query) use ($payroll_name) {
                    $query->where('t2.payroll_id', $payroll_name)
                        ->orWhere(DB::raw('CONCAT(surname_kh, " ", name_kh)'), 'like', '%' . $payroll_name . '%')
                        ->orWhere(DB::raw('CONCAT(surname_en, " ", name_en)'), 'like', '%' . $payroll_name . '%');
                })
                ->whereNotIn('hrmis_staffs.payroll_id', function ($query) use ($schedule_course_id) {
                    $query->where('schedule_course_id', $schedule_course_id)
                        ->select('payroll_id')
                        ->from('cpd_enrollment_courses');
                })
                ->orderBy('surname_kh')
                ->orderBy('name_kh')
                ->distinct()
                ->select(
                    'hrmis_staffs.payroll_id',
                    'surname_kh',
                    'name_kh',
                    'surname_en',
                    'name_en',
                    'sex',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                    'position_hierarchy',
                    DB::raw("(CASE hrmis_staffs.is_cont_staff WHEN 1 THEN cont_type.contract_type_kh ELSE position_kh END) As position_kh")
                )->paginate();
            if (!empty($data)) {
                return CpdCreditOfferingsResource::collection($data)
                    ->response()
                    ->setStatusCode(config('constants.codes.success'));
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), config('constants.codes.fail_404'));
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()], config('constants.codes.fail_500'));
        }
    }

    # cpd 9   Get staff registered via mobile app
    public function cpd_credits_staff_mobile_registrations(Request $request)
    {
        $request->validate([
            'schedule_course_id' => 'required',
        ]);
        $schedule_course_id = $request->schedule_course_id;
        try {
            $data = [];
            $statusLists = [1, 2, 7, 8, 10, 14];
            $data = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                ->join('cpd_enrollment_courses as enroll', 'hrmis_staffs.payroll_id', '=', 'enroll.payroll_id')
                ->leftJoin('sys_positions as pos', 'pos.position_id', '=', 't2.position_id')
                ->leftJoin('sys_contract_types as cont_type', 'cont_type.contract_type_id', '=', 't2.contract_type_id')
                ->where('t2.cur_pos', 1)
                ->whereIn('hrmis_staffs.staff_status_id', $statusLists)
                ->where('enroll.schedule_course_id', $schedule_course_id)
                ->where('enroll.enroll_status_id', 3) //In progress
                ->orderBy('surname_kh')
                ->orderBy('name_kh')
                ->distinct()
                ->select(
                    'hrmis_staffs.payroll_id',
                    'surname_kh',
                    'name_kh',
                    'surname_en',
                    'name_en',
                    'sex',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                    'position_hierarchy',
                    DB::raw("(CASE hrmis_staffs.is_cont_staff WHEN 1 THEN cont_type.contract_type_kh ELSE position_kh END) As position_kh")
                )->paginate();
            if (!empty($data)) {
                return CpdCreditOfferingsResource::collection($data)
                    ->response()
                    ->setStatusCode(config('constants.codes.success'));
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), config('constants.codes.fail_404'));
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()], config('constants.codes.fail_500'));
        }
    }

    # cpd 10   viewCPDCredits
    public function cpd_credits_view_cpd_credits(Request $request)
    {
        // $request->validate([
        //     'payroll_id' => 'required'
        // ]);
        $data = EnrollmentCourse::join('cpd_schedule_courses', 'cpd_schedule_courses.schedule_course_id', '=', 'cpd_enrollment_courses.schedule_course_id')
            ->join('cpd_courses as t2', 'cpd_schedule_courses.cpd_course_id', '=', 't2.cpd_course_id')
            ->join('cpd_providers','cpd_schedule_courses.provider_id','=','cpd_providers.provider_id')
            //->where('payroll_id', $request->payroll_id)
           // ->where('confirm_completed', 1)
           // ->where('is_verified', true) //Verified by CPDMO
            ->select('cpd_enrollment_courses.payroll_id','is_verified','confirm_completed','provider_kh','cpd_course_kh','cpd_schedule_courses.start_date','cpd_schedule_courses.end_date', 'credits', 'completed_date')
            ->orderBy('completed_date', 'DESC')
            ->get();
        $response = [
            'data' => $data,
            'code'  => config('constants.codes.success'),
            'message' => config('constants.messages_en.request_success')
        ];
        return response($response, 200);
    }

    # 11
    public function cpd_enrollment_courses(Request $request)
    {
        try {
            $request->validate([
                'pro_code' => 'required',
            ]);
            $procode = $request->pro_code;
            $providerkh = $request->provider_kh;
            $coursekh = $request->course_kh;
            $payroll = $request->payroll_id;
            $select_query = [
                'sys_provinces.name_kh as province',
                'sys_districts.name_kh as district',
                'loca.location_kh',
                DB::raw('If(hrmis_staffs.is_cont_staff=0, "ក្របខណ្ឌ", "កិច្ចសន្យា") as is_staff'),
                'hrmis_staffs.payroll_id',
                DB::raw('CONCAT(hrmis_staffs.surname_kh," ",hrmis_staffs.name_kh) as fullname'),
                DB::raw('If(hrmis_staffs.sex=1, "ប្រុស", "ស្រី") as sex'),
                'admin_users.username',
                'hrmis_staffs.nid_card',
                'hrmis_staffs.phone',
                'ccs.cpd_course_kh',
                'ccs.start_date',
                'ccs.end_date',
                'cpd_enrollment_courses.enroll_date',
                'ccs.credits',
                'cpd_providers.provider_kh',
                DB::raw('IF(cpd_enrollment_courses.enroll_option=1 AND es.check_status_kh IS NULL,"មិនទាន់ឯកភាព",IF(cpd_enrollment_courses.enroll_option=2,"បានឯកភាព",es.check_status_kh)) as Superviser_statuse'),
                'es1.check_status_kh as Provider_statuse',
                'cpd_enrollment_courses.enroll_option as enroll_option',
            ];
            $data = [];
            $data = Staff::Join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
            ->leftJoin("admin_users", "hrmis_staffs.payroll_id", "=", "admin_users.payroll_id")
            ->leftJoin("sys_positions", "sys_positions.position_id", "=", "hrmis_work_histories.position_id")
            ->leftJoin('sys_locations as loca', 'hrmis_work_histories.location_code', '=', 'loca.location_code') 
            ->leftJoin('sys_provinces', 'loca.pro_code', '=', 'sys_provinces.pro_code')
            ->leftJoin('sys_districts', 'loca.dis_code', '=', 'sys_districts.dis_code')
            ->leftJoin('sys_communes', 'loca.com_code', '=', 'sys_communes.com_code')                             
            ->leftJoin('cpd_enrollment_courses','cpd_enrollment_courses.payroll_id','=','hrmis_staffs.payroll_id')
            ->leftJoin('cpd_providers','cpd_enrollment_courses.provider_id','=','cpd_providers.provider_id')
            ->leftJoin('sys_check_status as es','es.check_status_id','=','cpd_enrollment_courses.supervisor_status')
            ->leftJoin('sys_check_status as es1','es1.check_status_id','=','cpd_enrollment_courses.provider_status')
            ->leftJoin(
                DB::raw('
                    (
                        SELECT cc.cpd_course_id,cc.cpd_course_kh,cs.schedule_course_id, cs.`start_date`, cs.`end_date`,cc.`credits` 
                        FROM cpd_schedule_courses cs
                        INNER JOIN cpd_courses cc ON (cs.cpd_course_id=cc.cpd_course_id)
                    ) AS ccs
                '),function($join){           
                    $join->on('cpd_enrollment_courses.schedule_course_id', '=','ccs.schedule_course_id');
                }
            )
                ->where('hrmis_work_histories.cur_pos', 1)
                ->when($procode <> '', function ($query) use ($procode) {
                    $query->where('hrmis_work_histories.pro_code', $procode);
                })
                ->when($providerkh <> '', function ($query) use ($providerkh) {
                    $query->where('cpd_providers.provider_kh','like', '%'.$providerkh.'%');
                })
                ->when($coursekh <> '', function ($query) use ($coursekh) {
                    $query->where('ccs.cpd_course_kh','like', '%'.$coursekh.'%');
                })
                ->select($select_query)
                ->orderby("hrmis_work_histories.start_date", "DESC")
                ->get();
            if (!empty($data)) {
                return response([
                    'data' => $data,
                    'code'  => config('constants.codes.success'),
                    'message' => config('constants.messages.request_success')
                ]);
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), 404);
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()]);
        }
    }

    # 12
    public function cpd_users(Request $request)
    {
        try {
            $request->validate([
                'pro_code' => 'required',
            ]);
            $locationcode = $request->location_code;
            $procode = $request->pro_code;
            $discode = $request->dis_code;
            $payroll = $request->payroll_id;
            $select_query = [
                'sys_provinces.name_kh as province',
                'sys_districts.name_kh as district',
                'loca.location_kh',
                DB::raw('If(hrmis_staffs.is_cont_staff=0, "ក្របខណ្ឌ", "កិច្ចសន្យា") as is_staff'),
                'hrmis_staffs.payroll_id',
                DB::raw('CONCAT(hrmis_staffs.surname_kh," ",hrmis_staffs.name_kh) as fullname'),
                DB::raw('If(hrmis_staffs.sex=1, "ប្រុស", "ស្រី") as sex'),
                'admin_users.username',
                'hrmis_staffs.nid_card',
                'hrmis_staffs.phone',            
            ];
            $data = [];
            $data = Staff::Join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
            ->leftJoin("admin_users", "hrmis_staffs.payroll_id", "=", "admin_users.payroll_id")
            ->leftJoin("sys_positions", "sys_positions.position_id", "=", "hrmis_work_histories.position_id")
            ->leftJoin('sys_locations as loca', 'hrmis_work_histories.location_code', '=', 'loca.location_code') 
            ->leftJoin('sys_provinces', 'loca.pro_code', '=', 'sys_provinces.pro_code')
            ->leftJoin('sys_districts', 'loca.dis_code', '=', 'sys_districts.dis_code')
            ->leftJoin('sys_communes', 'loca.com_code', '=', 'sys_communes.com_code')    
                ->where('hrmis_work_histories.cur_pos', 1)
                ->when($procode <> '', function ($query) use ($procode) {
                    $query->where('hrmis_work_histories.pro_code', $procode);
                })
                ->when($locationcode <> '', function ($query) use ($procode, $locationcode) {
                    $query->where('loca.pro_code', $procode)
                        ->where('loca.location_code', $locationcode);
                })
                ->when($discode <> '', function ($query) use ($procode, $discode) {
                    $query->where('loca.pro_code', $procode)
                        ->where('loca.dis_code', $discode);
                })
                ->select($select_query)
                ->orderby("hrmis_work_histories.start_date", "DESC")
                ->get();
            if (!empty($data)) {
                return response([
                    'data' => $data,
                    'code'  => config('constants.codes.success'),
                    'message' => config('constants.messages.request_success')
                ]);
            } else {
                return response(array(
                    'message' => 'Not record found!',
                ), 404);
            }
        } catch (\Exception $exeption) {
            return response(["message" => $exeption->getMessage()]);
        }
    }


}
