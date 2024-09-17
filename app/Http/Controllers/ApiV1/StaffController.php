<?php

namespace App\Http\Controllers\ApiV1;
use App\Models\Staff;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\StaffsResource;

class StaffController extends Controller
{

    public function getStaffs(Request $request) {        
        try {
            $request->validate([
                'pro_code' => 'required',
            ]);
            $locationcode = $request->location_code;
            $discode = $request->dis_code;
            $comcode = $request->com_code;
            $procode = $request->pro_code;
            $data = Staff::leftJoin('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                                ->leftJoin('sys_staff_status', 'hrmis_staffs.staff_status_id', '=', 'sys_staff_status.status_id')
                                ->leftJoin('sys_locations as loca', 'hrmis_work_histories.location_code', '=', 'loca.location_code')                              
                                ->leftJoin("sys_locations as ploca", "ploca.location_code", "=", "loca.parent_location_code")
                                ->leftJoin("sys_positions", "sys_positions.position_id", "=", "hrmis_work_histories.position_id")
                                ->leftJoin('sys_location_types', 'loca.location_type_id', '=', 'sys_location_types.location_type_id')
                                ->leftJoin('sys_provinces', 'loca.pro_code', '=', 'sys_provinces.pro_code')
                                ->leftJoin('sys_districts', 'loca.dis_code', '=', 'sys_districts.dis_code')
                                ->leftJoin('sys_communes', 'loca.com_code', '=', 'sys_communes.com_code')
                                ->leftJoin('sys_villages', 'loca.vil_code', '=', 'sys_villages.vil_code')
                                ->leftJoin('hrmis_staff_professions as prof', 'hrmis_staffs.payroll_id', '=', 'prof.payroll_id')
                                ->leftJoin('sys_professional_categories', 'prof.prof_category_id', '=', 'sys_professional_categories.prof_category_id')
                                ->leftJoin('sys_subjects as sys_subjects1', 'prof.subject_id1', '=', 'sys_subjects1.subject_id')
                                ->leftJoin('sys_subjects_teachings_hours as sys_subjects_teachings_hours1', 'sys_subjects1.schoolsubid', '=', 'sys_subjects_teachings_hours1.schoolsub_id')
                                ->leftJoin('sys_subjects as sys_subjects2', 'prof.subject_id2', '=', 'sys_subjects2.subject_id')
                                ->leftJoin('sys_subjects_teachings_hours as sys_subjects_teachings_hours2', 'sys_subjects2.schoolsubid', '=', 'sys_subjects_teachings_hours2.schoolsub_id')
                                ->leftJoin('hrmis_staff_qualifications as qual', 'hrmis_staffs.payroll_id', '=', 'qual.payroll_id')
                                ->leftJoin('sys_qualification_codes', 'qual.qualification_code', '=', 'sys_qualification_codes.qualification_code')
                                ->leftJoin('hrmis_staff_salaries as salarie', 'hrmis_staffs.payroll_id', '=', 'salarie.payroll_id')
                                ->leftJoin('salary_levels', 'salarie.salary_level_id', '=', 'salary_levels.salary_level_id')
                                ->leftJoin(
                                    DB::raw('
                                        (
                                            SELECT 
                                            tt3.payroll_id,
                                            -- grade1
                                            SUBSTRING_INDEX(
                                                SUBSTRING_INDEX(grade,",", 1)
                                                ,".",1) AS `grade_1`,
                                            REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                SUBSTRING_INDEX(grade,",", 1)
                                                ,".",2),".",-1),"[0-9]", "") AS `grade_1_name`,
                                            -- grade2
                                            IF(string_index >= 2,
                                                SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade,",", 2),",",-1)
                                                    ,".",1)
                                               ,"") AS `grade_2`,
                                            IF(string_index >= 2,		
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade,",", 2),",",-1)
                                                    ,".",2),".",-1),"[0-9]", "")
                                               ,"") AS `grade_2_name`,
                                            -- grade3
                                            IF(string_index >= 3,	
                                                SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade,",", 3),",",-1)
                                                    ,".",1)
                                               ,"") AS `grade_3`,
                                            IF(string_index >= 3,	
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade,",", 3),",",-1)
                                                    ,".",2),".",-1),"[0-9]", "")
                                               ,"") AS `grade_3_name`,			
                                            -- grade4
                                            IF(string_index >= 4,		
                                                SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade,",", 4),",",-1)
                                                    ,".",1)
                                               ,"") AS `grade_4`,
                                            IF(string_index >= 4,	
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade,",", 4),",",-1)
                                                    ,".",2),".",-1),"[0-9]", "")
                                              ,"") AS `grade_4_name`		
                                            
                                        FROM
                                           (
                                            SELECT payroll_id, GROUP_CONCAT(CONCAT(grade, cc) ORDER BY grade ASC) AS grade,
                                                ROUND (   
                                                (
                                                    LENGTH(GROUP_CONCAT(CONCAT(grade, cc)))
                                                    - LENGTH( REPLACE ( GROUP_CONCAT(CONCAT(grade, cc)), ".", "") ) 
                                                ) / LENGTH(".")        
                                                ) AS string_index   
                                            FROM
                                               (
                                                SELECT payroll_id, COUNT(grade) AS cc, grade
                                                FROM
                                                   (
                                                    SELECT payroll_id,
                                                        CONCAT(grade_id,".",grade_name)AS grade
                                                    FROM
                                                       (
                                                         SELECT
                                                        ttable.`payroll_id`,
                                                        g.`grade_kh` AS grade_id,
                                                        tgrade.`grade_name`
                                                         FROM timetable_grades tgrade
                                                         INNER JOIN `timetable_teacher_primary` ttable ON(ttable.`tgrade_id`=tgrade.`tgrade_id`)	
                                                         INNER JOIN sys_grades g ON(g.`grade_id`=tgrade.`grade_id`)                                                         
                                                         INNER JOIN sys_academic_years ON(tgrade.`academic_id`=sys_academic_years.`year_id`)
                                                         WHERE `cur_year`=1
                                                         GROUP BY tgrade.`grade_id`, tgrade.`grade_name`, payroll_id 	
                                                       )tt0
                                                   )tt
                                                  GROUP BY `grade`, payroll_id
                                               )tt2 
                                            GROUP BY payroll_id
                                           )tt3
                                    )tt_pr
                                    '),function($join){           
                                        $join->on('tt_pr.payroll_id', '=','hrmis_staffs.payroll_id');
                                    }
                                )
                                ->leftJoin(
                                    DB::raw('
                                        (
                                            SELECT 
                                            tt3.payroll_id AS `payroll_id`,
                                            -- teaching_sub_1
                                            IF(string_index >= 1,
                                                SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(grade_teacher_subject,",", 1)
                                                    ,".",1)
                                                ,"") AS `teaching_class_1`,
                                            IF(string_index >= 1,
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(grade_teacher_subject,",", 1)
                                                    ,".",2),".",-1),"[0-9]", "")
                                                ,"") AS `teaching_sub_1`,
                                            IF(string_index >= 1,	
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(grade_teacher_subject,",", 1)
                                                    ,".",2),".",-1),"[A-Zf]", "")
                                                ,"") AS `teaching_number_1`,
                                            
                                            -- teaching_sub_2
                                            IF(string_index >= 2,
                                                SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 2),",",-1)
                                                    ,".",1) 
                                                ,"") AS `teaching_class_2`,
                                            IF(string_index >= 2,
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 2),",",-1)
                                                    ,".",2),".",-1),"[0-9]", "")
                                                ,"") AS `teaching_sub_2`,
                                            IF(string_index >= 2,		
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 2),",",-1)
                                                    ,".",2),".",-1),"[A-Zf]", "")
                                                ,"") AS `teaching_number_2`,
                                                
                                            -- teaching_sub_3
                                            IF(string_index >= 3,	
                                                SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 3),",",-1)
                                                    ,".",1) 
                                                ,"") AS `teaching_class_3`,
                                            IF(string_index >= 3,	
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 3),",",-1)
                                                    ,".",2),".",-1),"[0-9]", "") 
                                                ,"") AS `teaching_sub_3`,
                                            IF(string_index >= 3,	
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 3),",",-1)
                                                    ,".",2),".",-1),"[A-Zf]", "")
                                                ,"") AS `teaching_number_3`,
                                                
                                            -- teaching_sub_4
                                            IF(string_index >= 4,	
                                                SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 4),",",-1)
                                                    ,".",1) 
                                                ,"")AS `teaching_class_4`,
                                            IF(string_index >= 4,	
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 4),",",-1)
                                                    ,".",2),".",-1),"[0-9]", "")
                                                ,"") AS `teaching_sub_4`,
                                            IF(string_index >= 4,	
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 4),",",-1)
                                                    ,".",2),".",-1),"[A-Zf]", "")
                                                ,"") AS `teaching_number_4`,
                                            
                                            -- teaching_sub_5
                                            IF(string_index >= 5,	
                                                SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 5),",",-1)
                                                    ,".",1) 
                                                ,"") AS `teaching_class_5`,
                                            IF(string_index >= 5,	
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 5),",",-1)
                                                    ,".",2),".",-1),"[0-9]", "")
                                                ,"") AS `teaching_sub_5`,
                                            IF(string_index >= 5,	
                                                REGEXP_REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(
                                                    SUBSTRING_INDEX(SUBSTRING_INDEX(grade_teacher_subject,",", 5),",",-1)
                                                    ,".",2),".",-1),"[A-Zf]", "")
                                                ,"") AS `teaching_number_5`									
                                        FROM
                                           (
                                            SELECT payroll_id, GROUP_CONCAT(CONCAT(grade_teacher_subject, cc) ORDER BY grade_teacher_subject ASC) AS grade_teacher_subject,
                                                ROUND (   
                                                    (
                                                        LENGTH(GROUP_CONCAT(CONCAT(grade_teacher_subject, cc)))
                                                        - LENGTH( REPLACE ( GROUP_CONCAT(CONCAT(grade_teacher_subject, cc)), ".", "") ) 
                                                    ) / LENGTH(".")        
                                                    ) AS string_index    
                                            FROM
                                               (
                                                SELECT payroll_id, COUNT(grade_teacher_subject) AS cc, grade_teacher_subject
                                                FROM
                                                   (
                                                    SELECT payroll_id,
                                                        CONCAT(grade_id,".",teacher_subject)AS grade_teacher_subject
                                                    FROM
                                                      (
                                                         SELECT
                                                            tsubj.`payroll_id`,
                                                            -- tgrade.`grade_id`,
                                                            g.`grade_kh` AS grade_id,
                                                            tgrade.`grade_name`,
                                                            REGEXP_REPLACE(tsubj.`teacher_subject`, "[0-9]+", "") AS `teacher_subject`
                                                         FROM timetable_grades `tgrade`
                                                         INNER JOIN timetables ttable ON(ttable.`tgrade_id`=tgrade.`tgrade_id`)
                                                         INNER JOIN timetable_teacher_subjects tsubj ON(tsubj.`teacher_subject_id`=ttable.`teacher_subject_id`)
                                                         INNER JOIN sys_grades g ON(g.`grade_id`=tgrade.`grade_id`)
                                                         -- AND tgrade.`academic_id` = 5
                                                         INNER JOIN sys_academic_years ON(tgrade.`academic_id`=sys_academic_years.`year_id`)
                                                         WHERE `cur_year`=1
                                                         GROUP BY tgrade.`grade_id`, tgrade.`grade_name`, tsubj.teacher_subject, payroll_id, ttable.`timetable_id`		    
                                                      )tt0		 
                                                    )tt1
                                                  GROUP BY `grade_teacher_subject`, payroll_id
                                               )tt2   
                                               GROUP BY payroll_id
                                           )tt3
                                     )tt_hi
                                    '),function($join){           
                                        $join->on('tt_hi.payroll_id', '=','hrmis_staffs.payroll_id');
                                    }
                                )
                                ->leftJoin('hrmis_staff_teachings', 'hrmis_staffs.payroll_id', '=', 'hrmis_staff_teachings.payroll_id')
                                ->leftJoin('sys_subjects_teachings_hours as subj1', 'tt_hi.teaching_sub_1', '=', 'subj1.subject_short')
                                ->leftJoin('sys_subjects_teachings_hours as subj2', 'tt_hi.teaching_sub_2', '=', 'subj2.subject_short')
                                ->leftJoin('sys_subjects_teachings_hours as subj3', 'tt_hi.teaching_sub_3', '=', 'subj3.subject_short')
                                ->leftJoin('sys_subjects_teachings_hours as subj4', 'tt_hi.teaching_sub_4', '=', 'subj4.subject_short')
                                ->leftJoin('sys_subjects_teachings_hours as subj5', 'tt_hi.teaching_sub_5', '=', 'subj5.subject_short')
                                // class_incharge
                                ->leftJoin(
                                    DB::raw('
                                    (	
                                        SELECT tgrade.`payroll_id`,1 AS class_incharge
                                            FROM timetable_grades tgrade
                                            INNER JOIN sys_academic_years ON(tgrade.`academic_id`=sys_academic_years.`year_id`)
                                            WHERE `cur_year`=1
                                            GROUP BY payroll_id 
                                        )gg
                                    '),function($join){           
                                        $join->on('hrmis_staffs.payroll_id', '=', 'gg.payroll_id');
                                    }
                                )
                                ->where('hrmis_staffs.is_cont_staff', 0)
                                ->where('hrmis_work_histories.cur_pos', 1)
                                ->where('prof.highest_profession', 1)
                                ->where('qual.highest_qualification', 1)
                                ->where('salarie.highest_salary', 1)
                                ->whereIn('hrmis_staffs.staff_status_id', [1,2,4,7,8,10])
                                ->when($locationcode <> '' , function($query) use($procode, $locationcode) {
                                    $query->where('loca.pro_code',$procode)
                                              ->where('loca.location_code',$locationcode);
                                })                            
                                ->when($discode <> '' , function($query) use($procode, $discode) {
                                    $query->where('loca.pro_code',$procode)
                                            ->where('loca.dis_code',$discode);
                                })
                                ->when($comcode <> '' , function($query) use($procode, $comcode) {
                                    $query->where('loca.pro_code',$procode)
                                            ->where('loca.com_code',$comcode);
                                })
                                ->when($procode <> '' , function($query) use($procode) {
                                    $query->where('loca.pro_code',$procode);
                                })
                                ->select(
                                    'loca.location_code as location_code', 
                                    'loca.emis_code as emis_code', 
                                    'sys_location_types.location_type_kh as location_type_kh', 
                                    'loca.location_kh as location_kh',      
                                    'hrmis_staffs.payroll_id as payroll_id', 
                                    DB::raw('If(hrmis_staffs.sex=1, "ប្រុស", "ស្រី") as sex'),
                                    'hrmis_staffs.dob as dob', 
                                    'sys_staff_status.status_kh as status_kh', 
                                    'sys_professional_categories.prof_category_kh as prof_category_kh', 
                                    'sys_subjects_teachings_hours1.subject as subject1', 
                                    'sys_subjects_teachings_hours2.subject as subject2', 
                                    DB::raw('If(hrmis_work_histories.position_id IN(32,36,40,43,44,61,82,83,86,87,98), "បង្រៀន","រដ្ឋបាល") as teach_official'),
                                    'sys_positions.position_kh as position_kh', 
                                    'sys_qualification_codes.qualification_kh as qualification_kh', 
                                    'salary_levels.salary_level_kh as salary_level_kh', 
                                    'salarie.salary_degree as salary_degree', 
                                    'sys_provinces.name_kh as workplace_province', 
                                    'loca.pro_code as workplace_province_code', 
                                    'sys_districts.name_kh as workplace_district', 
                                    'loca.dis_code as workplace_district_code', 
                                    'sys_communes.name_kh as workplace_commune', 
                                    'loca.com_code as workplace_commune_code', 
                                    'sys_villages.name_kh as workplace_village', 
                                    'loca.vil_code as workplace_village_code', 
                                    'multi_grade as multi_grade',
                                    'triple_grade as triple_grade',
                                    'double_shift as double_shift',
                                    'grade_1 as grade_1',
                                    'grade_1_name as grade_1_name',
                                    'grade_2 as grade_2',
                                    'grade_2_name as grade_2_name',
                                    'grade_3 as grade_3',
                                    'grade_3_name as grade_3_name',
                                    'grade_4 as grade_4',
                                    'grade_4_name as grade_4_name',
                                    'teaching_class_1 as teaching_high_class_1',
                                    'teaching_sub_1 as teaching_high_sub_1',
                                    'subj1.subject as teaching_high_sub_1_kh',
                                    'teaching_number_1 as teaching_high_number_1',
                                    'teaching_class_2 as teaching_high_class_2',
                                    'teaching_sub_2 as teaching_high_sub_2',
                                    'subj2.subject as teaching_high_sub_2_kh',
                                    'teaching_number_2 as teaching_high_number_2',
                                    'teaching_class_3 as teaching_high_class_3',
                                    'teaching_sub_3 as teaching_high_sub_3',
                                    'subj3.subject as teaching_high_sub_3_kh',
                                    'teaching_number_3 as teaching_high_number_3',
                                    'teaching_class_4 as teaching_high_class_4',
                                    'teaching_sub_4 as teaching_high_sub_4',
                                    'subj4.subject as teaching_high_sub_4_kh',
                                    'teaching_number_4 as teaching_high_number_4',
                                    'teaching_class_5 as teaching_high_class_5',
                                    'teaching_sub_5 as teaching_high_sub_5',
                                    'subj5.subject as teaching_high_sub_5_kh',
                                    'teaching_number_5 as teaching_high_number_5',       
                                    'gg.class_incharge as class_incharge',  
                                    'ploca.location_kh as parent_location'
                                 )
                                ->orderby("hrmis_work_histories.location_code", "ASC")
                                ->groupBy('hrmis_staffs.payroll_id')
                                ->get()->all();
            ;

            if(!empty($data)) {
              return StaffsResource::collection($data)
                ->response()
                ->setStatusCode(202);
            }else{
                return response(array(
                    'message' => 'Not record found!',
                 ), 404);
            }
        } catch (\Exception $exeption) {
            return response(["message"=>$exeption->getMessage()]);
        }
    }

}
