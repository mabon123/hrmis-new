<?php

namespace App\Http\Controllers\ApiV1;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CPD\ScheduleCourse;
use App\Models\CPD\EnrollmentCourse;

class CpdController extends Controller
{
    private static $item_per_screen = 10;

    public function __construct()
    {
        //$this->middleware('auth:sanctum');
    }

    public function getActiveCourses() {
        
        try {
            $data = ScheduleCourse::join('cpd_courses as tcourse', 'cpd_schedule_courses.cpd_course_id', '=', 'tcourse.cpd_course_id')
            ->join('cpd_providers as tprovider', 'cpd_schedule_courses.provider_id', '=', 'tprovider.provider_id')
            ->whereDate('cpd_schedule_courses.end_date', '>=', date("Y-m-d"))
            ->select(
                'cpd_schedule_courses.schedule_course_id as id',
                'cpd_course_kh as course_name',
                'tprovider.provider_id',
                'tprovider.provider_kh as provider_name',
                'credits',
                DB::raw("DATE_FORMAT(cpd_schedule_courses.start_date, '%d/%m/%Y') As start_date"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.end_date, '%d/%m/%Y') As end_date")
            )
            ->orderBy('cpd_schedule_courses.start_date', 'DESC')
            ->get()->all();

            if(!empty($data)) {
                return response($data);
            }else{
                return response(["message"=>"No record found!"]);
            }
        } catch (\Exception $exeption) {
            return response(["message"=>$exeption->getMessage()]);
        }
    }

    public function getCoursesById($id) {
        try {
            $data = ScheduleCourse::join('cpd_courses as tcourse', 'cpd_schedule_courses.cpd_course_id', '=', 'tcourse.cpd_course_id')
            ->join('cpd_providers as tprovider', 'cpd_schedule_courses.provider_id', '=', 'tprovider.provider_id')
            ->whereDate('cpd_schedule_courses.end_date', '>=', date("Y-m-d"))
            ->where('cpd_schedule_courses.schedule_course_id', $id)
            ->select(
                'cpd_schedule_courses.schedule_course_id as id',
                'cpd_course_kh as course_name',
                'tprovider.provider_id',
                'tprovider.provider_kh as provider_name',
                'credits',
                DB::raw("DATE_FORMAT(cpd_schedule_courses.start_date, '%d/%m/%Y') As start_date"),
                DB::raw("DATE_FORMAT(cpd_schedule_courses.end_date, '%d/%m/%Y') As end_date")
            )
            ->orderBy('cpd_schedule_courses.start_date', 'DESC')
            ->first();

            if(!empty($data)) {
                return response($data);
            }else{
                return response(["message"=>"No record found!"]);
            }
        } catch (\Exception $exeption) {
            return response(["message"=>$exeption->getMessage()]);
        }
    }

    public function getEnrollmentBySCourseId($id) {
        try {
            $data = ScheduleCourse::join('cpd_courses as tcourse', 'cpd_schedule_courses.cpd_course_id', '=', 'tcourse.cpd_course_id')
            ->join('cpd_enrollment_courses as enroll', 'cpd_schedule_courses.schedule_course_id', '=', 'enroll.schedule_course_id')
            ->select(
                'cpd_schedule_courses.schedule_course_id as id',
                'cpd_course_kh as course_name'
            )
            ->where('cpd_schedule_courses.schedule_course_id', $id)
            ->first();

            if(!empty($data)) {
                $enrollments = EnrollmentCourse::join('hrmis_staffs', 'cpd_enrollment_courses.payroll_id', '=', 'hrmis_staffs.payroll_id')
                    ->join('admin_users', 'cpd_enrollment_courses.payroll_id', '=', 'admin_users.payroll_id')
                    ->leftJoin('hrmis_work_histories', 'hrmis_work_histories.payroll_id', '=', 'hrmis_staffs.payroll_id')
                    ->leftJoin('sys_positions', 'hrmis_work_histories.position_id', '=', 'sys_positions.position_id')
                    ->leftJoin('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
                    ->leftJoin('sys_provinces', 'hrmis_work_histories.pro_code', '=', 'sys_provinces.pro_code')
                    ->select('username', 'hrmis_staffs.name_kh as first_name', 'hrmis_staffs.surname_kh as last_name', 
                        'position_kh as position', 'hrmis_staffs.payroll_id', 'sys_locations.location_kh as school', 'sys_provinces.name_kh as province')
                    ->where('cur_pos', 1)
                    ->where('schedule_course_id', $data->id)
                    ->get()->all();

                $response = [
                    'id'            => $data->id,
                    'course_name'   => $data->course_name,
                    'enrollments'   => $enrollments
                ];
                return response($response);
            }else{
                return response(["message"=>"No record found!"]);
            }
        } catch (\Exception $exeption) {
            return response(["message"=>$exeption->getMessage()]);
        }
    }

    public function awardCredit(Request $request) {
        try {
            $request->validate([
                'id' => 'required',
                'provider_id'   => 'required',
                'payroll_id'    => 'required',
                'enroll_option'  => 'required',
                'completed_date' => 'required',
                'source' => 'required'    
            ]);
            //check existing record
            $row_count = EnrollmentCourse::where('schedule_course_id', $request->id)
                ->where('payroll_id', $request->payroll_id)
                ->count('payroll_id');
            if($row_count > 0){
                return response(["message"=>"This payroll number has already registered this CPD offering previously."]);
            }

            $enrollment = EnrollmentCourse::create([
                'schedule_course_id'    => $request->id,
                'source'                => $request->source,
                'payroll_id'            => $request->payroll_id,
                'enroll_option'         => $request->enroll_option,
                'enroll_status_id'      => 6, //6: automatically completed
                'staff_check_status'    => 5, //5: auto approved
                'staff_check_date'      => date('Y-m-d', strtotime($request->completed_date)),
                'enroll_date'           => date('Y-m-d', strtotime($request->completed_date)),
                'supervisor_payroll'    => null,
                'supervisor_status'     => null,
                'supervisor_check_date' => null,
                'provider_id'           => $request->provider_id,
                'provider_status'       => 5, // Approved
                'provider_check_date'   => date('Y-m-d', strtotime($request->completed_date)),
                'confirm_completed'     => 1,
                'completed_date'        => date('Y-m-d', strtotime($request->completed_date)),
                'is_verified'           => 0 //Pending verification from CPDMO
            ]);
            if(empty($enrollment)){
                throw new \Exception('Error in saving data.');
            }else{
                $data = [
                    'username'      => $enrollment->staff->users->username,
                    'id'            => $enrollment->schedule_course_id, 
                    'payroll_id'    => $enrollment->payroll_id,
                    'provider_id'   => $enrollment->provider_id,
                    'credits'       => $enrollment->scheduled_course->CPDCourse->credits       
                ];
                return response($data);    
            }
        } catch (\Exception $exeption) {
            return response(["message"=>$exeption->getMessage()]);
        }
    }
    
}
