<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectOfStudiesResource extends JsonResource
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
            'cpd_subject_id' => (string)$this->cpd_subject_id,
            'cpd_field_id' => (string)$this->cpd_field_id,
            'cpd_subject_code' => (string)$this->cpd_subject_code,
            'cpd_subject_kh' => (string)$this->cpd_subject_kh,
            'cpd_subject_en' => (string)$this->cpd_subject_en,
            'cpd_subject_desc_kh' => (string)$this->cpd_subject_desc_kh,
            'cpd_subject_desc_en' => (string)$this->cpd_subject_desc_en,
            'end_date' => (string)$this->end_date,
            'credits' => (string)$this->credits,
            'active' => (string)$this->active,

            'created_by' => (string)$this->created_by,
            'updated_by' => (string)$this->updated_by,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,

            'fieldOfStudy' => $this->fieldOfStudy,
        ];
    }
}
