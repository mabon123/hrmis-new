<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'payroll_id' => (string)$this->payroll_id,

            'staff' => [            
                'sex' => (string)$this->sex,
                'dob' => (string)$this->dob,
                'status_kh' => (string)$this->status_kh,
                'prof_category_kh' => (string)$this->prof_category_kh,
                'subject1' => (string)$this->subject1,
                'subject2' => (string)$this->subject2,
                'teach_official' => (string)$this->teach_official,
                'position_kh' => (string)$this->position_kh,                
                'qualification_kh' => (string)$this->qualification_kh,
                'salary_level_kh' => (string)$this->salary_level_kh,
                'salary_degree' => (string)$this->salary_degree,
                'class_incharge' => (string)$this->class_incharge,
            ],

            'timetable_teacher_primary' => [
                'multi_grade' => (string)$this->multi_grade,
                'triple_grade' => (string)$this->triple_grade,
                'double_shift' => (string)$this->double_shift,
                'grade_1' => (string)$this->grade_1,
                'grade_1_name' => (string)$this->grade_1_name,
                'grade_2' => (string)$this->grade_2,
                'grade_2_name' => (string)$this->grade_2_name,
                'grade_3' => (string)$this->grade_3,
                'grade_3_name' => (string)$this->grade_3_name,
                'grade_4' => (string)$this->grade_4,
                'grade_4_name' => (string)$this->grade_4_name,
            ],

            'timetable_teacher_high' => [
                'teaching_high_class_1' => (string)$this->teaching_high_class_1,
                'teaching_high_sub_1' => (string)$this->teaching_high_sub_1,
                'teaching_high_sub_1_kh' => (string)$this->teaching_high_sub_1_kh,
                'teaching_high_number_1' => (string)$this->teaching_high_number_1,
                'teaching_high_class_2' => (string)$this->teaching_high_class_2,
                'teaching_high_sub_2' => (string)$this->teaching_high_sub_2,
                'teaching_high_sub_2_kh' => (string)$this->teaching_high_sub_2_kh,
                'teaching_high_number_2' => (string)$this->teaching_high_number_2,
                'teaching_high_class_3' => (string)$this->teaching_high_class_3,
                'teaching_high_sub_3' => (string)$this->teaching_high_sub_3,
                'teaching_high_sub_3_kh' => (string)$this->teaching_high_sub_3_kh,
                'teaching_high_number_3' => (string)$this->teaching_high_number_3,
                'teaching_high_class_4' => (string)$this->teaching_high_class_4,
                'teaching_high_sub_4' => (string)$this->teaching_high_sub_4,
                'teaching_high_sub_4_kh' => (string)$this->teaching_high_sub_4_kh,
                'teaching_high_number_4' => (string)$this->teaching_high_number_4,
                'teaching_high_class_5' => (string)$this->teaching_high_class_5,
                'teaching_high_sub_5' => (string)$this->teaching_high_sub_5,
                'teaching_high_sub_5_kh' => (string)$this->teaching_high_sub_5_kh,
                'teaching_high_number_5' => (string)$this->teaching_high_number_5,
            ],

            'location' => [
                'location_code' => (string)$this->location_code,
                'emis_code' => (string)$this->emis_code,            
                'location_type_kh' => (string)$this->location_type_kh,
                'location_kh' => (string)$this->location_kh,    
                'parent_location' => (string)$this->parent_location,    
            ],

            'address_workplace_code' => [
                'province' =>(string)$this->workplace_province_code,
                'district' => (string)$this->workplace_district_code,
                'commune' => (string)$this->workplace_commune_code,
                'village' => (string)$this->workplace_village_code,            
            ],

            'address_workplace' => [
                'province' =>(string)$this->workplace_province,
                'district' => (string)$this->workplace_district,
                'commune' => (string)$this->workplace_commune,
                'village' => (string)$this->workplace_village,            
            ]


        ];
    }
    
}
