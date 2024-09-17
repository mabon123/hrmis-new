<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class ContStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()) {
            case 'POST':
            {
                return [
                    'nid_card' => 'required|max:15|unique:hrmis_staffs',
                    'bank_account' => 'required|max:17',
                    'surname_kh' => 'required|max:150',
                    'name_kh' => 'required|max:150',
                    'surname_en' => 'required|max:50',
                    'name_en' => 'required|max:50',
                    'start_date' => 'required',
                    'contract_type_id' => 'required',
                    'sex' => 'required',
                    'dob' => 'required',
                    'birth_pro_code' => 'required',
                    'birth_district' => 'required',
                    'location_code' => 'required',
                ];
            }

            case 'PUT':
            case 'PATCH':
            {
                return [
                    'nid_card' => 'required|max:15',
                    'bank_account' => 'required|max:17',
                    'surname_kh' => 'required|max:150',
                    'name_kh' => 'required|max:150',
                    'surname_en' => 'required|max:50',
                    'name_en' => 'required|max:50',
                    'sex' => 'required',
                    'dob' => 'required',
                    'birth_pro_code' => 'required',
                    'birth_district' => 'required',
                ];
            }
        }
    }

    /**
     * Custome attributes of the form link to languages
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'nid_card' => __('common.nid'),
            'bank_account' => __('common.bankacc_num'),
            'surname_kh' => __('common.surname_kh'),
            'name_kh' => __('common.name_kh'),
            'surname_en' => __('common.surname_latin'),
            'name_en' => __('common.name_latin'),
            'sex' => __('common.sex'),
            'dob' => __('common.dob'),
            'birth_pro_code' => __('common.province'),
            'birth_district' => __('common.district'),
            'start_date' => __('common.start_date'),
            'contract_type_id' => __('common.contract_type'),
            'location_code' => __('common.current_location'),
        ];
    }
}
