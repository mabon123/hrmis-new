<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleCoursesResource extends JsonResource
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
            "schedule_course" => [
                'schedule_course_id' => $this->schedule_course_id,
                'cpd_course_id' => (string)$this->cpd_course_id,
                'qualification_code' => (string)$this->qualification_code,
                'participant_num' => (string)$this->participant_num,
                'reg_start_date' => (string)$this->reg_start_date,
                'reg_end_date' => (string)$this->reg_end_date,
                'start_date' => (string)$this->start_date,
                'end_date' => (string)$this->end_date,
                'partner_type_id' => (string)$this->partner_type_id,
                'provider_id' => (string)$this->provider_id,
                'teacher_educator_id' => (string)$this->teacher_educator_id,
                'teacher_educator' => (string)$this->teacher_educator,
                'course_status' => (string)$this->course_status,
                'learning_option_id' => (string)$this->learning_option_id,
                'pro_code' => (string)$this->pro_code,
                'dis_code' => (string)$this->dis_code,
                'address' => (string)$this->address,
                'is_mobile' => (string)$this->is_mobile,
                'remark' => (string)$this->remark,

                'created_by' => (string)$this->created_by,
                'updated_by' => (string)$this->updated_by,
                'created_at' => (string)$this->created_at,
                'updated_at' => (string)$this->updated_at,
            ],
            

            'CPDCourse' => $this->CPDCourse,
            'qualification' => $this->qualification,
            'TrainingPartnerType' => $this->partnerType,
            'learningOption' => $this->learningOption,
            'targetAudiences' => $this->targetAudiences,

            'targetAudiences_desc' => [
                'schedule_course_id' => $this->schedule_course_id,
                'audience_course' => $this->targetAudiencesCourse(),
                'audience_position' => $this->targetAudiencesPosition(),
            ],
            'enrollmentCourses' => $this->enrollmentCourses,
            'provider' => $this->provider,

        ];
    }
}
