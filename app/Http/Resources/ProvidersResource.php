<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProvidersResource extends JsonResource
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
            'provider_id' => (string)$this->provider_id,
            'provider_type_id' => (string)$this->provider_type_id,
            'payroll_id' => (string)$this->payroll_id,
            'provider_cat_id' => (string)$this->provider_cat_id,
            'accreditation_id' => (string)$this->accreditation_id,
            'accreditation_date' => (string)$this->accreditation_date,
            'provider_kh' => (string)$this->provider_kh,
            'provider_en' => (string)$this->provider_en,
            'provider_email' => (string)$this->provider_email,
            'provider_phone' => (string)$this->provider_phone,
            'provider_logo' => (string)$this->provider_logo,
            'pro_code' => (string)$this->pro_code,
            'dis_code' => (string)$this->dis_code,
            'com_code' => (string)$this->com_code,
            'vil_code' => (string)$this->vil_code,
            'created_by' => (string)$this->created_by,
            'updated_by' => (string)$this->updated_by,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,

            'providerCategory' => $this->providerCategory,
            'accreditation' => $this->accreditation,
            'province' => $this->province,
            'district' => $this->district,
            'commune' => $this->commune,
            'village' => $this->village,
            'CPDCourses' => $this->CPDCourses,        
            'providerUser' => $this->providerUser,        
        ];
    }
}
