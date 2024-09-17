<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Staff;
use App\Models\Province;
use App\Models\CPD\LearningOption;
use App\Models\CPD\SubjectOfStudy;
use App\Models\CPD\Course;
use App\Models\CPD\Provider;
use App\Models\CPD\ScheduleCourse;
use App\Models\CPD\EnrollmentCourse;
use App\Models\CPD\RejectReason;

class CPDController extends Controller
{
    private static $item_per_screen = 10;

    public function __construct()
    {
        //$this->middleware('auth:sanctum');
    }
    //GET: no token required
    public function getSubjectsbyFieldId($field_id)
    {
        $subjectData = SubjectOfStudy::where('cpd_field_id', $field_id)->active()
            ->select('cpd_subject_id as id', 'cpd_subject_kh as value')->get();

        $response = [
            'data' => $subjectData,
            'code'  => config('constants.codes.success'),
            'message' => config('constants.messages.request_success')
        ];
        return response($response, 200);
    }
    //GET: no token required
    public function getCoursesbySubjId($subj_id)
    {
        $courseData = Course::join('cpd_course_relations as t2', 'cpd_courses.cpd_course_id', '=', 't2.cpd_course_id')
            ->where('t2.cpd_subject_id', $subj_id)->active()
            ->select('cpd_course_id as id', 'cpd_course_kh as value')->get();
        $response = [
            'data' => $courseData,
            'code'  => config('constants.codes.success'),
            'message' => config('constants.messages.request_success')
        ];
        return response($response, 200);
    }
    //GET: no token required
    public function searchBoxCPDActivities()
    {
        $trainingModes = LearningOption::select('learning_option_id as id', 'learning_option_kh as value')->get();
        $provinces = Province::active()->select('pro_code as id', 'name_kh as value')->get();
        $districts = [];
        $providers = Provider::select('provider_id as id', 'provider_kh as value')->get();
        $courses = $this->getActivities(0, self::$item_per_screen, null);
        $response = [
            'data' => [
                'lookup' => [
                    'trainingModes' => $trainingModes,
                    'provinces' => $provinces,
                    'districts' => $districts,
                    'providers' => $providers
                ],
                'courses' => $courses
            ],
            'code'  => config('constants.codes.success'),
            'message' => config('constants.messages.request_success')
        ];
        return response($response, 200);
    }
    public static function getActivities($skip, $limit, $request)
    {
        $data = ScheduleCourse::join('cpd_courses as t2', 'cpd_schedule_courses.cpd_course_id', '=', 't2.cpd_course_id')
            //->join('cpd_course_relations as trelation', 't2.cpd_course_id', '=', 'trelation.cpd_course_id')
            ->join('cpd_learning_options as t3', 'cpd_schedule_courses.learning_option_id', '=', 't3.learning_option_id')
            ->join('cpd_providers as t4', 'cpd_schedule_courses.provider_id', '=', 't4.provider_id')
            ->leftJoin('sys_qualification_codes as t5', 'cpd_schedule_courses.qualification_code', '=', 't5.qualification_code')
            ->leftJoin('sys_provinces as pro', 'cpd_schedule_courses.pro_code', '=', 'pro.pro_code')
            ->leftJoin('sys_districts as dis', 'cpd_schedule_courses.dis_code', '=', 'dis.dis_code')
            ->where('is_mobile', true); //Receive only new activities
        //->whereDate('reg_start_date', '<=', date("Y-m-d"))
        //->whereDate('reg_end_date', '>=', date("Y-m-d"));
        if ($request) {
            if ($request->training_mode) {
                $data = $data->where('cpd_schedule_courses.learning_option_id', $request->training_mode);
            }
            if ($request->cpd_offering) {
                $data = $data->where('cpd_course_kh', 'like', '%' . $request->cpd_offering . '%')
                    ->orWhere('cpd_course_en', 'like', '%' . $request->cpd_offering . '%');
            }
            if ($request->pro_code) {
                $data = $data->where('cpd_schedule_courses.pro_code', $request->pro_code);
            }
            if ($request->dis_code) {
                $data = $data->where('cpd_schedule_courses.dis_code', $request->dis_code);
            }
            if ($request->provider_id) {
                $data = $data->where('cpd_schedule_courses.provider_id', $request->provider_id);
            }
        }

        $data = $data->select(
            'cpd_schedule_courses.schedule_course_id',
            't2.cpd_course_id',
            'cpd_course_code',
            'cpd_course_kh',
            'cpd_course_en',
            'cpd_course_desc_kh',
            't4.provider_id',
            't4.provider_kh',
            'credits',
            'duration_hour',
            't3.learning_option_id',
            'learning_option_kh',
            'learning_option_en',
            'pro.name_kh as province',
            'dis.name_kh as district',
            'address',
            't5.qualification_kh',
            DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_start_date, '%d/%m/%Y') As reg_start_date"),
            DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_end_date, '%d/%m/%Y') As reg_end_date"),
            DB::raw("DATE_FORMAT(cpd_schedule_courses.start_date, '%d/%m/%Y') As start_date"),
            DB::raw("DATE_FORMAT(cpd_schedule_courses.end_date, '%d/%m/%Y') As end_date"),
            DB::raw("(CASE WHEN curdate() BETWEEN cpd_schedule_courses.reg_start_date AND cpd_schedule_courses.reg_end_date THEN 0 ELSE 1 END) As is_expired"),
        )
            ->orderBy('cpd_schedule_courses.reg_start_date', 'DESC')
            ->get()->slice($skip, $limit)->values()->all();

        return $data;
    }
    //POST: no token required
    public function searchCPDActivities(Request $request)
    {
        $limit = $request->limit ? $request->limit : self::$item_per_screen;
        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $skip = ($page - 1) * $limit;
        $courses = $this->getActivities($skip, $limit, $request);
        $response = [
            'data' => $courses,
            'code'  => config('constants.codes.success'),
            'message' => config('constants.messages.request_success')
        ];
        return response($response, 200);
    }

    //GET: no token required
    public function viewCPDActivityDetails(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'lang' => 'required'
        ]);
        $lang = $request->lang;
        $course = ScheduleCourse::join('cpd_courses as t2', 'cpd_schedule_courses.cpd_course_id', '=', 't2.cpd_course_id')
            ->join('cpd_learning_options as t3', 'cpd_schedule_courses.learning_option_id', '=', 't3.learning_option_id')
            ->join('cpd_providers as t4', 'cpd_schedule_courses.provider_id', '=', 't4.provider_id')
            ->leftJoin('sys_qualification_codes as t5', 'cpd_schedule_courses.qualification_code', '=', 't5.qualification_code')
            ->leftJoin('sys_provinces as pro', 'cpd_schedule_courses.pro_code', '=', 'pro.pro_code')
            ->leftJoin('sys_districts as dis', 'cpd_schedule_courses.dis_code', '=', 'dis.dis_code')
            ->where('schedule_course_id', $request->id)
            ->select(
                'schedule_course_id',
                't2.cpd_course_id',
                'cpd_course_code',
                'cpd_course_kh',
                'cpd_course_desc_kh',
                't4.provider_id',
                't4.provider_kh',
                'credits',
                'duration_hour',
                't3.learning_option_id',
                'learning_option_kh',
                'pro.name_kh as province',
                'dis.name_kh as district',
                'address',
                't5.qualification_kh',
                DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_start_date, '%d/%m/%Y') As reg_start_date"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_end_date, '%d/%m/%Y') As reg_end_date"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.start_date, '%d/%m/%Y') As start_date"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.end_date, '%d/%m/%Y') As end_date")
            )
            ->first();

        $enroll = null;
        if ($request->payroll_id) {
            $enroll = EnrollmentCourse::join('cpd_schedule_courses', 'cpd_schedule_courses.schedule_course_id', '=', 'cpd_enrollment_courses.schedule_course_id')
                ->leftJoin('cpd_reject_reasons as t2', 'cpd_enrollment_courses.reason_id', '=', 't2.reason_id')
                ->where('cpd_enrollment_courses.schedule_course_id', $request->id)
                ->where('payroll_id', $request->payroll_id);
            if ($lang == 'en') {
                $enroll = $enroll->select('id', 'is_verified', 'enroll_status_id', 't2.reason_id', 'reason_en as reason', 'other_reason')->first();
            } else {
                $enroll = $enroll->select('id', 'is_verified', 'enroll_status_id', 't2.reason_id', 'reason_kh as reason', 'other_reason')->first();
            }
        }
        $audiences = Position::join('cpd_course_audiences as t2', 'sys_positions.position_id', '=', 't2.position_id')
            ->select('position_kh')->where('t2.schedule_course_id', $request->id)
            ->orderBy('position_hierarchy')->get();

        if ($course) {
            $response = [
                'data' => [
                    'course'      => $course,
                    'item_status'   => $enroll,
                    'audiences'     => $audiences
                ],
                'code'  => config('constants.codes.success'),
                'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
            ];
            return response($response, 200);
        } else {
            $response_fail = [
                'code' => config('constants.codes.fail_500'),
                'message' => $lang == 'en' ? config('constants.messages_en.request_fail') : config('constants.messages.request_fail')
            ];
            return response($response_fail, 500);
        }
    }
    //GET: require token
    public function viewOwnCPDList(Request $request)
    {
        $request->validate([
            'payroll_id' => 'required',
            'lang' => 'required'
        ]);

        // $limit = $request->limit ? $request->limit : 20;
        // $page = $request->page && $request->page > 0 ? $request->page : 1;
        // $skip = ($page - 1) * $limit;
        $lang = $request->lang;

        $data = EnrollmentCourse::join('cpd_schedule_courses', 'cpd_schedule_courses.schedule_course_id', '=', 'cpd_enrollment_courses.schedule_course_id')
            ->join('cpd_enrollment_status', 'cpd_enrollment_status.enroll_status_id', '=', 'cpd_enrollment_courses.enroll_status_id')
            ->join('cpd_courses as t2', 'cpd_schedule_courses.cpd_course_id', '=', 't2.cpd_course_id')
            ->join('cpd_learning_options as t3', 'cpd_schedule_courses.learning_option_id', '=', 't3.learning_option_id')
            ->join('cpd_providers as t4', 'cpd_schedule_courses.provider_id', '=', 't4.provider_id')
            ->leftJoin('sys_qualification_codes as t5', 'cpd_schedule_courses.qualification_code', '=', 't5.qualification_code')
            ->leftJoin('sys_provinces as pro', 'cpd_schedule_courses.pro_code', '=', 'pro.pro_code')
            ->leftJoin('sys_districts as dis', 'cpd_schedule_courses.dis_code', '=', 'dis.dis_code')
            ->where('cpd_enrollment_courses.payroll_id', $request->payroll_id)
            ->whereNotIn('cpd_enrollment_courses.enroll_status_id', [4, 7]); //Not showing for those rejected and unregistered records

        if ($lang == 'en') {
            $data = $data->select(
                'cpd_schedule_courses.schedule_course_id',
                'is_verified',
                'cpd_enrollment_courses.id',
                'cpd_course_code',
                'cpd_course_kh',
                'cpd_course_desc_kh',
                't4.provider_id',
                't4.provider_kh',
                'credits',
                'duration_hour',
                't3.learning_option_id',
                'learning_option_kh',
                'pro.name_kh as province',
                'dis.name_kh as district',
                'address',
                't5.qualification_kh',
                'cpd_enrollment_courses.enroll_status_id',
                'enroll_status_en as enroll_status',
                DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_start_date, '%d/%m/%Y') As reg_start_date"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_end_date, '%d/%m/%Y') As reg_end_date"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.start_date, '%d/%m/%Y') As start_date"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.end_date, '%d/%m/%Y') As end_date")
            )
                ->orderByRaw('cpd_enrollment_courses.enroll_status_id, cpd_schedule_courses.start_date', 'ASC');
        } else {
            $data = $data->select(
                'cpd_schedule_courses.schedule_course_id',
                'is_verified',
                'cpd_enrollment_courses.id',
                'cpd_course_code',
                'cpd_course_kh',
                'cpd_course_desc_kh',
                't4.provider_id',
                't4.provider_kh',
                'credits',
                'duration_hour',
                't3.learning_option_id',
                'learning_option_kh',
                'pro.name_kh as province',
                'dis.name_kh as district',
                'address',
                't5.qualification_kh',
                'cpd_enrollment_courses.enroll_status_id',
                'enroll_status_kh as enroll_status',
                DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_start_date, '%d/%m/%Y') As reg_start_date"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_end_date, '%d/%m/%Y') As reg_end_date"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.start_date, '%d/%m/%Y') As start_date"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.end_date, '%d/%m/%Y') As end_date")
            )
                ->orderByRaw('cpd_enrollment_courses.enroll_status_id, cpd_schedule_courses.start_date', 'ASC');
        }
        $data = $data->get(); //->slice($skip, $limit)->values()->all();

        $response = [
            'data' => $data,
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }

    //GET: require token
    public function viewCPDCredits(Request $request)
    {
        $request->validate([
            'payroll_id' => 'required'
        ]);
        $data = EnrollmentCourse::join('cpd_schedule_courses', 'cpd_schedule_courses.schedule_course_id', '=', 'cpd_enrollment_courses.schedule_course_id')
            ->join('cpd_courses as t2', 'cpd_schedule_courses.cpd_course_id', '=', 't2.cpd_course_id')
            ->where('payroll_id', $request->payroll_id)
            ->where('confirm_completed', 1)
            ->where('is_verified', true) //Verified by CPDMO
            ->select('cpd_course_kh', 'credits', DB::raw("DATE_FORMAT(completed_date, '%d-%m-%Y') As completed_date"))
            ->orderBy('completed_date', 'DESC')
            ->get();
        $response = [
            'data' => $data,
            'code'  => config('constants.codes.success'),
            'message' => config('constants.messages_en.request_success')
        ];
        return response($response, 200);
    }

    //POST: require token
    public function registerCPDActivity(Request $request)
    {
        $request->validate([
            'schedule_course_id' => 'required',
            'payroll_id' => 'required',
            'enroll_option' => 'required',
            'enroll_status_id' => 'required',
            'staff_check_status' => 'required',
            'lang' => 'required',
            'provider_id' => 'required'
        ]);
        $lang = $request->lang;

        //Check expired CPD
        $expired_cpd = ScheduleCourse::where('schedule_course_id', $request->schedule_course_id)
            ->select(DB::raw("(CASE WHEN curdate() BETWEEN reg_start_date AND reg_end_date THEN 0 ELSE 1 END) As is_expired"))->first();
        if (!empty($expired_cpd) && $expired_cpd->is_expired == 1) {
            $response_fail = [
                'code' => config('constants.codes.fail_403'),
                'message' => $lang == 'en' ? 'This CPD offering has already expired!' : 'វគ្គអវបនេះបានអស់សុពលភាពហើយ!'
            ];
            return response($response_fail, 403);
        }

        //Check if staff already registered
        $old_enroll = EnrollmentCourse::where('schedule_course_id', $request->schedule_course_id)
            ->where('payroll_id', $request->payroll_id)->first();
        if (!empty($old_enroll)) {
            $response_fail = [
                'code' => config('constants.codes.fail_403'),
                'message' => $lang == 'en' ? 'You have previously registered this CPD offering already!' : 'អ្នកបានចុះឈ្មោះការផ្តល់ជូនវគ្គអវបនេះពីមុនរួចហើយ!'
            ];
            return response($response_fail, 403);
        }

        $enroll = EnrollmentCourse::create([
            'schedule_course_id'    => $request->schedule_course_id,
            'payroll_id'            => $request->payroll_id,
            'enroll_option'         => $request->enroll_option,
            'enroll_status_id'      => $request->enroll_status_id,
            'staff_check_status'    => $request->staff_check_status,
            'staff_check_date'      => now(),
            'enroll_date'           => now(),
            'supervisor_payroll'    => null,
            'supervisor_status'     => null,
            'supervisor_check_date' => null,
            'provider_id'           => $request->provider_id,
            'provider_status'       => 4, //pending
            'provider_check_date'   => null,
            'confirm_completed'     => 0,
            'completed_date'        => null
        ]);
        if ($enroll) {
            $response = [
                'data' => $enroll,
                'code'  => config('constants.codes.success'),
                'message' => $lang == 'en' ? 'You have successfully requested to register this CPD offering.' : 'អ្នកបានស្នើរជោគជ័យការចុះឈ្មោះសកម្មភាពCPDនេះ។'
            ];
            return response($response, 201);
        } else {
            $response_fail = [
                'code' => config('constants.codes.fail_403'),
                'message' => $lang == 'en' ? config('constants.messages_en.create_fail') : config('constants.messages.create_fail')
            ];
            return response($response_fail, 500);
        }
    }

    //GET: require token
    public function unRegisterCPDActivity(Request $request)
    {
        $request->validate([
            'enroll_status' => 'required',
            'lang' => 'required'
        ]);
        $data = null;
        if ($request->enroll_status == 3) { //If unregister for in progress activity then just update
            $update_row = array();
            $update_row['enroll_status_id'] = 7;
            $update_row['staff_check_date'] = now();
            EnrollmentCourse::where('id', $request->id)->update($update_row);

            $data = array();
            $data['id'] = $request->id;
            $data['enroll_status_id'] = 7;
        } else {
            EnrollmentCourse::find($request->id)->delete();
        }
        $lang = $request->lang;
        $response = [
            'data' => $data,
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? 'You have successfully unregistered this CPD offering.' : 'អ្នកបានបោះបង់ការចុះឈ្មោះសកម្មភាពCPDនេះ។'
        ];
        return response($response, 200);
    }
    //GET: no token
    public function checkActivityStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'lang' => 'required'
        ]);
        $lang = $request->lang;
        $enroll = null;
        if ($request->payroll_id) {
            $enroll = EnrollmentCourse::join('cpd_schedule_courses', 'cpd_schedule_courses.schedule_course_id', '=', 'cpd_enrollment_courses.schedule_course_id')
                ->leftJoin('cpd_reject_reasons as t2', 'cpd_enrollment_courses.reason_id', '=', 't2.reason_id')
                ->where('cpd_enrollment_courses.schedule_course_id', $request->id)
                ->where('payroll_id', $request->payroll_id);
            if ($lang == 'en') {
                $enroll = $enroll->select('id', 'is_verified', 'enroll_status_id', 't2.reason_id', 'reason_en as reason', 'other_reason')->first();
            } else {
                $enroll = $enroll->select('id', 'is_verified', 'enroll_status_id', 't2.reason_id', 'reason_kh as reason', 'other_reason')->first();
            }
        }

        $audiences = Position::join('cpd_course_audiences as t2', 'sys_positions.position_id', '=', 't2.position_id')
            ->select('position_kh')->where('t2.schedule_course_id', $request->id)
            ->orderBy('position_hierarchy')->get();

        $response = [
            'data' => [
                'item_status'   => $enroll,
                'audiences'     => $audiences
            ],
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }

    /*----Provider's function-----*/
    //GET: require token. This function will be used by both CPD provider and staff's data administrator
    public function providerCPDList(Request $request)
    {
        $request->validate([
            'enroll_status' => 'required'
        ]);

        $limit = $request->limit ? $request->limit : self::$item_per_screen;
        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $skip = ($page - 1) * $limit;
        $enroll_status = $request->enroll_status;
        $data = ScheduleCourse::join('cpd_courses as t2', 'cpd_schedule_courses.cpd_course_id', '=', 't2.cpd_course_id')
            ->join('cpd_learning_options as t3', 'cpd_schedule_courses.learning_option_id', '=', 't3.learning_option_id')
            ->join('cpd_providers as t4', 'cpd_schedule_courses.provider_id', '=', 't4.provider_id')
            ->join('cpd_enrollment_courses as t5', 'cpd_schedule_courses.schedule_course_id', '=', 't5.schedule_course_id')
            ->join('hrmis_staffs', 't5.payroll_id', '=', 'hrmis_staffs.payroll_id')
            ->where('t5.enroll_status_id', $enroll_status);
        if ($request->provider_id) {
            $data = $data->where('cpd_schedule_courses.provider_id', $request->provider_id)
                ->where(function ($query) {
                    //$query->where('enroll_option', 1)
                    $query->where(DB::raw('IFNULL(supervisor_status, 0)'), 5) //Approved by supervisor
                        ->orWhere('enroll_option', 2); //Own Budget
                });
        } else if ($request->location_code) { //location_code if he is DEPT, POE, DOE or School Administrator
            $location_code = $request->location_code;
            $staffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
                ->where('hrmis_work_histories.cur_pos', 1)
                ->where('hrmis_work_histories.location_code', $location_code)
                ->select('hrmis_staffs.payroll_id')
                ->distinct()
                ->pluck('payroll_id');

            $data = $data->where('enroll_option', 1)
                ->whereNull('supervisor_status')
                ->whereIn('t5.payroll_id', $staffs);
        }
        $data = $data->select(
            DB::raw('count(t5.payroll_id) as user_count'),
            'cpd_schedule_courses.schedule_course_id',
            't2.cpd_course_id',
            't4.provider_id',
            't4.provider_kh',
            'cpd_course_code',
            'cpd_course_kh',
            'credits',
            'duration_hour',
            'learning_option_kh',
            DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_start_date, '%d/%m/%Y') As reg_start_date"),
            DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_end_date, '%d/%m/%Y') As reg_end_date"),
            DB::raw("DATE_FORMAT(cpd_schedule_courses.start_date, '%d/%m/%Y') As start_date"),
            DB::raw("DATE_FORMAT(cpd_schedule_courses.end_date, '%d/%m/%Y') As end_date")
        )
            ->groupBy(
                'cpd_schedule_courses.schedule_course_id',
                't2.cpd_course_id',
                't4.provider_id',
                't4.provider_kh',
                'cpd_course_code',
                'cpd_course_kh',
                'credits',
                'duration_hour',
                'learning_option_kh',
                DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_start_date, '%d/%m/%Y')"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.reg_end_date, '%d/%m/%Y')"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.start_date, '%d/%m/%Y')"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.end_date, '%d/%m/%Y')")
            )
            ->orderBy('cpd_schedule_courses.start_date', 'DESC')
            ->get()->slice($skip, $limit)->values()->all();

        $response = [
            'data' => $data,
            'code'  => config('constants.codes.success'),
            'message' => config('constants.messages.request_success')
        ];
        return response($response, 200);
    }
    private function getCPDRegistrations($provider_id, $schedule_id, $reg_status, $location_code, $skip, $limit)
    {
        $data = EnrollmentCourse::join('hrmis_staffs as t2', 'cpd_enrollment_courses.payroll_id', '=', 't2.payroll_id')
            ->join('hrmis_work_histories as t3', 'cpd_enrollment_courses.payroll_id', '=', 't3.payroll_id')
            ->join('sys_locations as t5', 't3.location_code', '=', 't5.location_code')
            ->leftJoin('sys_positions as t4', 't3.position_id', '=', 't4.position_id')
            ->leftJoin('sys_contract_types as cont_type', 't3.contract_type_id', '=', 'cont_type.contract_type_id')
            ->where('cur_pos', 1)
            ->where('cpd_enrollment_courses.provider_id', $provider_id)
            ->where('cpd_enrollment_courses.schedule_course_id', $schedule_id)
            ->where('cpd_enrollment_courses.enroll_status_id', $reg_status); //2: Registered, 3: In progress
        //If workplace's admin
        if ($location_code != '') {
            $staffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
                ->where('hrmis_work_histories.cur_pos', 1)
                ->where('hrmis_work_histories.location_code', $location_code)
                ->select('hrmis_staffs.payroll_id')
                ->distinct()
                ->pluck('payroll_id');

            $data = $data->where('enroll_option', 1)
                ->whereNull('supervisor_status')
                ->whereIn('cpd_enrollment_courses.payroll_id', $staffs);
        } else { //CPD provider user
            $data = $data->where(function ($query) {
                //$query->where('enroll_option', 1)
                $query->where(DB::raw('IFNULL(supervisor_status, 0)'), 5) //Approved by supervisor
                    ->orWhere('enroll_option', 2); //Own Budget
            });
        }

        $data = $data->select(
            'cpd_enrollment_courses.id',
            'cpd_enrollment_courses.schedule_course_id',
            DB::raw('CONCAT(surname_kh, " ", name_kh) as fullname'),
            't2.sex',
            't2.phone',
            't2.is_cont_staff',
            't4.position_kh',
            'cont_type.contract_type_kh',
            't5.location_kh',
            'enroll_option',
            DB::raw("DATE_FORMAT(enroll_date, '%d-%m-%Y %H:%i') As enroll_date"),
            DB::raw("(SELECT qualification_kh from hrmis_staff_qualifications INNER JOIN sys_qualification_codes 
            ON hrmis_staff_qualifications.qualification_code = sys_qualification_codes.qualification_code 
            WHERE hrmis_staff_qualifications.payroll_id=cpd_enrollment_courses.payroll_id
            ORDER BY sys_qualification_codes.qualification_code DESC LIMIT 1) As qualification"),
            DB::raw("(SELECT subject_kh from hrmis_staff_qualifications INNER JOIN sys_qualification_codes 
            ON hrmis_staff_qualifications.qualification_code = sys_qualification_codes.qualification_code 
            INNER JOIN sys_subjects ON hrmis_staff_qualifications.subject_id=sys_subjects.subject_id
            WHERE hrmis_staff_qualifications.payroll_id=cpd_enrollment_courses.payroll_id
            ORDER BY sys_qualification_codes.qualification_code DESC LIMIT 1) As subject"),
            DB::raw("(SELECT prof_category_kh FROM hrmis_staff_professions 
            INNER JOIN sys_professional_categories ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
            WHERE hrmis_staff_professions.payroll_id=cpd_enrollment_courses.payroll_id
            ORDER BY sys_professional_categories.prof_hierachy LIMIT 1) As prof_title"),
            DB::raw("(SELECT subject_kh FROM hrmis_staff_professions 
            INNER JOIN sys_professional_categories ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
            INNER JOIN sys_subjects ON hrmis_staff_professions.subject_id1=sys_subjects.subject_id
            WHERE hrmis_staff_professions.payroll_id=cpd_enrollment_courses.payroll_id
            ORDER BY sys_professional_categories.prof_hierachy LIMIT 1) As subject1"),
            DB::raw("(SELECT subject_kh FROM hrmis_staff_professions 
            INNER JOIN sys_professional_categories ON hrmis_staff_professions.prof_category_id = sys_professional_categories.prof_category_id
            INNER JOIN sys_subjects ON hrmis_staff_professions.subject_id2=sys_subjects.subject_id
            WHERE hrmis_staff_professions.payroll_id=cpd_enrollment_courses.payroll_id
            ORDER BY sys_professional_categories.prof_hierachy LIMIT 1) As subject2")
        )
            ->orderBy('enroll_date')
            ->get()->slice($skip, $limit)->values()->all();

        return $data;
    }
    //GET: require token
    public function viewActivityRegistrations(Request $request)
    {
        $request->validate([
            'provider_id' => 'required',
            'schedule_id' => 'required',
            'supervisor' => 'required',
            'reg_status' => 'required'
        ]);
        $limit = $request->limit ? $request->limit : self::$item_per_screen;
        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $skip = ($page - 1) * $limit;

        $provider_id = $request->provider_id;
        $schedule_id = $request->schedule_id;
        $supervisor = $request->supervisor;
        $reg_status = $request->reg_status;
        $location_code = $supervisor ? $request->location_code : '';
        $data = $this->getCPDRegistrations($provider_id, $schedule_id, $reg_status, $location_code, $skip, $limit);
        $reasons = [];
        if ($reg_status == 2 && $page == 1) {
            $reasons = RejectReason::select('reason_id as id', 'reason_kh as value', 'reason_en as value_en')->get();
        }

        $response = [
            'data' => $data,
            'reasons' => $reasons,
            'code'  => config('constants.codes.success'),
            'message' => config('constants.messages.request_success')
        ];
        return response($response, 200);
    }

    //POST: require token
    public function confirmActivityRegistrations(Request $request)
    {
        $request->validate([
            'lang'  => 'required',
            'provider_id' => 'required',
            'schedule_id' => 'required',
            'supervisor' => 'required'
        ]);
        $limit = $request->limit ? $request->limit : self::$item_per_screen;
        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $skip = ($page - 1) * $limit;

        $lang = $request->lang;
        $provider_id = $request->provider_id;
        $schedule_id = $request->schedule_id;
        $supervisor = $request->supervisor;
        $reg_status = 2; //Registered
        $location_code = $supervisor ? $request->location_code : '';
        $approves = $request->approve_item;

        if (count($approves)) {
            if ($location_code != '') {
                $supervisor_id = $request->payroll_id;
                $update_approves = array();
                $update_approves['supervisor_payroll']    = $supervisor_id;
                $update_approves['supervisor_status']     = 5;
                $update_approves['supervisor_check_date'] = now();
                EnrollmentCourse::whereIn('id', $approves)->update($update_approves);
            } else {
                $update_approves = array();
                $update_approves['enroll_status_id']    = 3; //Make to in progress
                $update_approves['provider_id']         = $provider_id;
                $update_approves['provider_status']     = 5; // approved by provider
                $update_approves['provider_check_date'] = now();
                EnrollmentCourse::whereIn('id', $approves)->update($update_approves);
            }
        }
        $response = [
            'data' => $this->getCPDRegistrations($provider_id, $schedule_id, $reg_status, $location_code, $skip, $limit),
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? 'You have successfully confirmed CPD registrations.' : 'អ្នកបានឯកភាពបេក្ខភាពចុះឈ្មោះអវបរួចរាល់។'
        ];
        return response($response, 200);
    }

    //POST: require token
    public function rejectCPDRegistration(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'lang'  => 'required',
            'rejected_by' => 'required',
            'reason_id' => 'required',
            'provider_id' => 'required',
            'supervisor' => 'required'
        ]);
        $id = $request->id;
        $lang = $request->lang;
        $rejected_by = $request->rejected_by;
        $reason_id = $request->reason_id;
        $other_reason = $request->other_reason ? $request->other_reason : '';
        $provider_id = $request->provider_id;
        $supervisor = $request->supervisor;

        $update_rejects = array();
        $update_rejects['enroll_status_id']     = 4; //Make to rejected
        $update_rejects['rejected_by'] = $rejected_by;
        $update_rejects['reason_id'] = $reason_id;
        $update_rejects['other_reason'] = $other_reason;
        if ($supervisor) {
            $supervisor_id = $request->payroll_id;
            $update_rejects['supervisor_payroll']    = $supervisor_id;
            $update_rejects['supervisor_status']     = 6;
            $update_rejects['supervisor_check_date'] = now();
        } else {
            $update_rejects['provider_id']          = $provider_id;
            $update_rejects['provider_status']      = 6; //Rejected by provider
            $update_rejects['provider_check_date']  = now();
        }
        EnrollmentCourse::where('id', $id)->update($update_rejects);

        $response = [
            'data' => [],
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? 'You have successfully rejected a CPD registration.' : 'អ្នកបានបដិសេធបេក្ខភាពចុះឈ្មោះអវបម្នាក់រួចរាល់។'
        ];
        return response($response, 200);
    }

    //POST: require token
    public function confirmActivityCompletion(Request $request)
    {
        $request->validate([
            'lang'  => 'required',
            'provider_id' => 'required',
            'schedule_id' => 'required'
        ]);
        $limit = $request->limit ? $request->limit : self::$item_per_screen;
        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $skip = ($page - 1) * $limit;

        $lang = $request->lang;
        $provider_id = $request->provider_id;
        $schedule_id = $request->schedule_id;
        $reg_status = 3;
        $location_code = '';
        $com_items = $request->completed_item;
        $fail_items = $request->failed_item;

        if (count($com_items)) {
            $update_approves = array();
            $update_approves['enroll_status_id']    = 6; //Make to completed
            $update_approves['provider_check_date']  = now();
            $update_approves['confirm_completed']   = 1;
            $update_approves['completed_date']      = now();
            EnrollmentCourse::whereIn('id', $com_items)->update($update_approves);
        }
        if (count($fail_items)) {
            $update_rejects = array();
            $update_rejects['enroll_status_id']     = 5; //Make to failed
            $update_rejects['provider_check_date']  = now();
            EnrollmentCourse::whereIn('id', $fail_items)->update($update_rejects);
        }

        $response = [
            'data' => $this->getCPDRegistrations($provider_id, $schedule_id, $reg_status, $location_code, $skip, $limit),
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? 'You have successfully confirmed CPD completion.' : 'បានបញ្ជាក់ជោគជ័យ។'
        ];
        return response($response, 200);
    }
}
