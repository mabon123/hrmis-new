<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HrmisStaffsResource extends JsonResource
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
            'staff' => [            
                'payroll_id' => (string)$this->payroll_id,
                'nid_card' => (string)$this->nid_card,
                'bank_account' => (string)$this->bank_account,
                'surname_kh' => (string)$this->surname_kh,
                'name_kh' => (string)$this->name_kh,
                'surname_en' => (string)$this->surname_en,
                'name_en' => (string)$this->name_en,
                'sex' => (string)$this->sex,
                'dob' => (string)$this->dob,
                'ethnic_id' => (string)$this->ethnic_id,
                'photo' => (string)$this->photo,
                'birth_pro_code' => (string)$this->birth_pro_code,
                'birth_province' => (string)$this->birth_province,
                'birth_district' => (string)$this->birth_district,
                'birth_commune' => (string)$this->birth_commune,
                'birth_village' => (string)$this->birth_village,
                'start_date' => (string)$this->start_date,
                'appointment_date' => (string)$this->appointment_date,
                'staff_status_id' => (string)$this->staff_status_id,
                'status_kh' => (string)$this->status_kh,
                'is_newly_transferred' => (string)$this->is_newly_transferred,
                'is_cont_staffs' => (string)$this->is_cont_staffs,
                'experience' => (string)$this->experience,
                'former_staff' => (string)$this->former_staff,
                'former_staffs' => (string)$this->former_staffs,
                'maritalstatus_id' => (string)$this->maritalstatus_id,
                'maritalstatus_kh' => (string)$this->maritalstatus_kh,
                'adr_pro_code' => (string)$this->adr_pro_code,
                'adr_province' => (string)$this->adr_province,
                'adr_dis_code' => (string)$this->adr_dis_code,
                'adr_district' => (string)$this->adr_district,
                'adr_com_code' => (string)$this->adr_com_code,
                'adr_commune' => (string)$this->adr_commune,
                'adr_vil_code' => (string)$this->adr_vil_code,
                'adr_village' => (string)$this->adr_village,
                'house_num' => (string)$this->house_num,
                'street_num' => (string)$this->street_num,
                'group_num' => (string)$this->group_num,
                'address' => (string)$this->address,
                'phone' => (string)$this->phone,
                'email' => (string)$this->email,
                'dtmt_school' => (string)$this->dtmt_school,
                'sbsk' => (string)$this->sbsk,
                'sbsk_num' => (string)$this->sbsk_num,
                'disability_teacher' => (string)$this->disability_teacher,
                'disability_id' => (string)$this->disability_id,
                'disability_kh' => (string)$this->disability_kh,
                'disability_note' => (string)$this->disability_note,
                'created_by' => (string)$this->created_by,
                'updated_by' => (string)$this->updated_by,
                'created_at' => (string)$this->created_at,
                'updated_at' => (string)$this->updated_at,
                'workHistories' => $this->workHistories
            ],           

        ];
    }
    
}
