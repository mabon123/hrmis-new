<?php

namespace App\Http\Requests;

use DB;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TraineeRequest extends FormRequest
{
    public function rules()
    {
        $trainee = $this->route('trainee');

        $rules = [];
        switch($this->method()) {
            case 'POST':
                $rules = [
                    'trainee_payroll_id' => [
                        'required',
                        'min:10',
                        'max:10',
                        function ($attribute, $value, $fail) {
                            $staffExisted = DB::table('hrmis_staffs')
                                    ->where('payroll_id', $value)
                                    ->exists();

                            $traineeExisted = DB::table('hrmis_trainee_teachers')
                                    ->where('trainee_payroll_id', $value)
                                    ->exists();

                            if ($traineeExisted || ($staffExisted && !request()->former_staff)) {
                                $fail(__('validation.unique', ['attribute' => __('common.payroll_num')]));
                            }
                        }
                    ]
                ];

                if (request()->prof_type_id != 12 && request()->prof_type_id != 13) {
                    $rules = $rules + ['subject_id1' => 'required'];
                }
                break;

            case 'PUT':
            case 'PATCH':
                $rules = [
                    'trainee_payroll_id' => [
                        'required',
                        'min:10',
                        'max:10',
                        function ($attribute, $value, $fail) use ($trainee) {
                            $staffExisted = DB::table('hrmis_staffs')
                                    ->where('payroll_id', $value)
                                    ->exists();

                            $traineeExisted = DB::table('hrmis_trainee_teachers')
                                    ->where('trainee_payroll_id', $value)
                                    ->where('trainee_payroll_id', '!=', $trainee->trainee_payroll_id)
                                    ->exists();

                            if ($traineeExisted || ($staffExisted && !request()->former_staff)) {
                                $fail(__('validation.unique', ['attribute' => __('common.payroll_num')]));
                            }
                        }
                    ]
                ];
                break;
        }

        return $rules + [
            'surname_kh' => 'required|max:150',
            'name_kh' => 'required|max:150',
            'surname_en' => 'required|max:50',
            'name_en' => 'required|max:50',
            'sex' => 'required',
            'dob' => 'required',
            'birth_pro_code' => 'required',
            'birth_district' => 'required',
            'fullname_kh' => 'required_if:maritalstatus_id,==,2',
            'stu_generation' => 'required|numeric|min:0',
            'year_id' => 'required',
            'future_location_code' => 'required',
            'location_code' => 'required',
            'prof_type_id' => 'required',
            //'subject_id1' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
        ];
    }

    public function attributes()
    {
        return [
            'trainee_payroll_id' => __('common.payroll_num'),
            'staff_status_id' => __('common.current_status'),
            'surname_kh' => __('common.surname_kh'),
            'name_kh' => __('common.name_kh'),
            'surname_en' => __('common.surname_latin'),
            'name_en' => __('common.name_latin'),
            'sex' => __('common.sex'),
            'dob' => __('common.dob'),
            'birth_pro_code' => __('common.province'),
            'birth_district' => __('common.district'),
            'fullname_kh' => __('family_info.spouse_name'),
            'stu_generation' => __('common.stu_generation'),
            'year_id' => __('common.year'),
            'future_location_code' => __('trainee.future_location'),
            'location_code' => __('qualification.training_institution'),
            'prof_type_id' => __('qualification.training_sys'),
            //'subject_id1' => __('qualification.first_subject'),
            'start_date' => __('common.start_date'),
            'end_date' => __('common.end_date'),
        ];
    }

    public function messages() {
        return [
            // __('validation.min.string', ['attribute' => __('school.id'), 'min' => 11]);
        ];
    }
}
