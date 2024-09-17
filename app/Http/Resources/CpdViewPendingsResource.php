<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CpdViewPendingsResource extends JsonResource
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
            'enroll_id' => (string)$this->id,
            'payroll_id' => (string)$this->payroll_id,
            'surname_kh' => (string)$this->surname_kh,
            'name_kh' => (string)$this->name_kh,
            'surname_en' => (string)$this->surname_en,
            'name_en' => (string)$this->name_en,
            'name_en' => (string)$this->name_en,
            'sex' => (string)$this->sex,
            'dob' => (string)$this->dob,
            'position_kh' => (string)$this->position_kh,
            'position_hierarchy' => (string)$this->position_hierarchy,
            'completed_date' => (string)$this->completed_date,
            'location_kh' => (string)$this->location_kh,
        ];
    }
}
