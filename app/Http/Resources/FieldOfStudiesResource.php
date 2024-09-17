<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldOfStudiesResource extends JsonResource
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
            'cpd_field_id' => (string)$this->cpd_field_id,
            'cpd_field_code' => (string)$this->cpd_field_code,
            'cpd_field_kh' => (string)$this->cpd_field_kh,
            'cpd_field_en' => (string)$this->cpd_field_en,
            'cpd_field_desc_kh' => (string)$this->cpd_field_desc_kh,
            'cpd_field_desc_en' => (string)$this->cpd_field_desc_en,
            'active' => (string)$this->active,
            'created_by' => (string)$this->created_by,
            'updated_by' => (string)$this->updated_by,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
