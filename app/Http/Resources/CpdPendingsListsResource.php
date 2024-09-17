<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CpdCreditOfferingsResource extends JsonResource
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
            'surname_kh' => (string)$this->surname_kh,
            'name_kh' => (string)$this->name_kh,
            'surname_en' => (string)$this->surname_en,
            'name_en' => (string)$this->name_en,
            'sex' => (string)$this->sex,
            'dob' => (string)$this->dob,
            'position_hierarchy' => (string)$this->position_hierarchy,
            'position_kh' => (string)$this->position_kh,
        ];
    }
}
