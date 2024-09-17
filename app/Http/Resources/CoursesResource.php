<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoursesResource extends JsonResource
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
            'cpd_course_id' => (string)$this->cpd_course_id,
            'cpd_course_code' => (string)$this->cpd_course_code,
            'cpd_course_type_id' => (string)$this->cpd_course_type_id,
            'cpd_course_kh' => (string)$this->cpd_course_kh,
            'cpd_course_en' => (string)$this->cpd_course_en,
            'cpd_course_desc_kh' => (string)$this->cpd_course_desc_kh,
            'cpd_course_desc_en' => (string)$this->cpd_course_desc_en,
            'end_date' => (string)$this->end_date,
            'credits' => (string)$this->credits,
            'duration_hour' => (string)$this->duration_hour,
            'active' => (string)$this->active,


            'created_by' => (string)$this->created_by,
            'updated_by' => (string)$this->updated_by,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,

            'courseType' => $this->courseType,
            'courseRelations' => $this->courseRelations,
            'courseRelations_desc' => [
                'cpd_course_id' => (string)$this->cpd_course_id,
                'fieldOfStudy' => $this->fieldOfStudy(),
                'subjectOfStudy' => $this->subjectOfStudy(),
            ],
            'providers' => $this->providers,
        ];
    }
}
