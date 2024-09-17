<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
                $rules = [
                    'payroll_id' => 'required|size:10|unique:hrmis_staffs',
                    'location_code' => 'required',
                    'salary_level_id' => 'required',
                    'salary_degree' => 'required',
                    'staff_status_id' => 'required',
                    'salary_level_id' => 'required',
                    'salary_degree' => 'required',
                    //'official_rank_id' => 'required',
                    'dob' => ['required',
                        function ($attribute, $value, $fail) {
                            $dob = explode('-', $value);
                            if ($dob[2] < 1900 || $dob[2] > (date('Y') - 17)) {
                                $fail(__('common.dob').__('validation.dob_age_validate').(date('Y') - 17).'។');
                            }
                        }],
                ];
            }

            case 'PUT':
            case 'PATCH':
            {
                if (auth()->user()->hasRole('administrator')) {
                    $rules = [
                        'payroll_id' => 'required|size:10',
                        'dob' => ['required',
                            function ($attribute, $value, $fail) {
                                $dob = explode('-', $value);
                                if ($dob[2] < 1900 || $dob[2] > (date('Y') - 17)) {
                                    $fail(__('common.dob').__('validation.dob_age_validate').(date('Y') - 17).'។');
                                }
                            }],
                    ];
                }

                $rules = [];
            }
        }

        return $rules + [
                'surname_kh' => 'required|max:150',
                'name_kh' => 'required|max:150',
                'surname_en' => 'required|max:50',
                'name_en' => 'required|max:50',
                'sex' => 'required',
                'birth_pro_code' => 'required',
                'birth_district' => 'required',
                'sbsk_num' => 'required_if:sbsk,==,1|max:10',
                'disability_id' => 'required_if:disability_teacher,==,1',
                'start_date' => ['required',
                    function ($attribute, $value, $fail) {
                        $dob = explode('-', $value);
                        if ($dob[2] < 1980 || $dob[2] > date('Y')) {
                            $fail(__('common.datestart_work').__('validation.start_date_validate').date('Y').'។');
                        }
                    }],
            ];
    }

    /**
     * Custome attributes of the form link to languages
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'payroll_id' => __('common.payroll_num'),
            'staff_status_id' => __('common.current_status'),
            'surname_kh' => __('common.surname_kh'),
            'name_kh' => __('common.name_kh'),
            'surname_en' => __('common.surname_latin'),
            'name_en' => __('common.name_latin'),
            'sex' => __('common.sex'),
            'dob' => __('common.dob'),
            'birth_pro_code' => __('common.province'),
            'birth_district' => __('common.district'),
            'contract_type_id' => __('common.contract_type'),
            'location_code' => __('common.current_location'),
            'salary_level_id' => __('common.salary_type'),
            'salary_degree' => __('common.degree'),
            'start_date' => __('common.datestart_work'),
        ];
    }

    public function messages() {
        return [
            'sbsk_num.required_if' => __('validation.required', ['attribute' => __('common.membership_id')]),
            'disability_id.required_if' => __('validation.required', ['attribute' => __('common.disability_type')]),
        ];
    }
}
