<?php

namespace App\Http\Requests;

use DB;
use App\Models\Location;
use App\Models\LocationType;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
{
    public function rules()
    {
        $school = $this->route('school');

        $rules = [];

        if ($school) {
            $rules = [
                'location_codes' => [
                    function ($attribute, $value, $fail) use ($school) {
                        if (count(array_filter($value)) !== 5) {
                            $fail(__('validation.required', ['attribute' => __('school.id')]));
                        } elseif (strlen(str_replace('_', '', implode('', $value))) !== 11) {
                            $fail(__('validation.min.string', ['attribute' => __('school.id'), 'min' => 11]));
                        }
                    },
                    function ($attribute, $value, $fail) use ($school) {
                        $existed = DB::table('sys_locations')
                                    ->where('location_code', implode('', $value))
                                    ->where('location_code', '!=', $school->location_code)
                                    ->exists();

                        if (!$existed) {
                            $emisCode = $value['emis_code'];
                            $id = (int)request()->location_type_id;

                            switch ($id) {
                                case LocationType::HighSchool:
                                    $existed = $emisCode < 900;
                                    break;

                                case LocationType::SecondarySchool:
                                    $existed = $emisCode < 700 || $emisCode >= 900;
                                    break;

                                case LocationType::PrimarySchool:
                                    $existed = $emisCode < 1 || $emisCode >= 500;
                                    break;

                                case LocationType::PreSchool:
                                    $existed = $emisCode < 500 || $emisCode >= 700;
                                    break;

                                default:
                                    break;
                            }
                        }

                        if ($existed) {
                            // $fail(__('validation.unique', ['attribute' => __('school.id')]));
                            $fail(__('validation.location_code_exist'));
                        }
                    },
                ],
                'emis_code' => [
                    'nullable',
                    'max:11',
                    'min:11',
                    function ($attribute, $value, $fail) use ($school) {
                        if (strlen(str_replace("_", "", $value)) != 11) {
                            $fail(__('validation.min.string', ['attribute' => __('school.emis_code'), 'min' => 11]));
                        }
                    },
                ]
            ];
        } else {
            $rules = [
                'location_codes' => [
                    function ($attribute, $value, $fail) use ($school) {
                        if (count($value) !== 5 || strlen(implode('', $value)) !== 11) {
                            $fail(__('validation.required', ['attribute' => __('school.id')]));
                        }
                    },
                    function ($attribute, $value, $fail) {
                        $existed = DB::table('sys_locations')
                                    ->where('location_code', implode('', $value))
                                    ->exists();

                        if (!$existed) {
                            $emisCode = $value['emis_code'];
                            $id = (int)request()->location_type_id;

                            switch ($id) {
                                case LocationType::HighSchool:
                                    $existed = $emisCode < 900;
                                    break;

                                case LocationType::SecondarySchool:
                                    $existed = $emisCode < 700 || $emisCode >= 900;
                                    break;

                                case LocationType::PrimarySchool:
                                    $existed = $emisCode < 1 || $emisCode >= 500;
                                    break;

                                case LocationType::PreSchool:
                                    $existed = $emisCode < 500 || $emisCode >= 700;
                                    break;

                                default:
                                    break;
                            }
                        }

                        if ($existed) {
                            $fail(__('validation.unique', ['attribute' => __('school.id')]));
                        }
                    },
                ],
                'emis_code' => [
                    'nullable',
                    'max:11',
                    'min:11',
                    function ($attribute, $value, $fail) use ($school) {
                        if (strlen(str_replace("_", "", $value)) != 11) {
                            $fail(__('validation.min.string', ['attribute' => __('school.emis_code'), 'min' => 11]));
                        }
                    },
                ]
            ];
        }
        $notSchoolIds = LocationType::whereIsSchool(false)->pluck('location_type_id')->all();

        return $rules + [
            'location_kh' => 'required|max:150',
            'location_en' => 'required|max:50',
            'location_type_id' => 'required|exists:sys_location_types,location_type_id',
            //'schoolclaster'=>'required_unless:schoolclaster,' . join(',',$notSchoolIds),
            'region_id' => 'required_unless:location_type_id,' . join(',',$notSchoolIds),
            'pro_code' => (auth()->user()->hasRole('poe-admin', 'doe-admin', 'school-admin') ? 'nullable' : 'required') . '|min:2|max:2|exists:sys_provinces,pro_code',
            'dis_code' => 'nullable|min:4|max:4|exists:sys_districts,dis_code',
            'com_code' => 'nullable|min:6|max:6|exists:sys_communes,com_code',
            'vil_code' => 'nullable|min:8|max:8|exists:sys_villages,vil_code',
            'building_num' => 'nullable|numeric|between:0,99',
            'prokah_num' => 'required_if:prokah,==,1|max:10',
            'main_school' => 'required_if:school_annex,==,1|max:11',
            'gd_location_code' => [
                'max:11',
                function ($attribute, $value, $fail){
                    $depIds = [LocationType::Department, LocationType::Institute];
                    if ((request()->sub_location && in_array(request()->location_type_id, $depIds)) && !request()->gd_location_code) {
                        $fail(__('validation.required', ['attribute' => __('school.gd')]));
                    }
                }
            ],
            'rttc_location_code' => 'required_if:location_type_id,==,'.LocationType::PracticalSecondarySchool.'|max:11',
            'pttc_location_code' => 'required_if:location_type_id,==,'.LocationType::PracticalPrimarySchool.'|max:11',
            'institute_location_code' => 'required_if:location_type_id,==,'.LocationType::PracticalHighSchool.'|max:11',
        ];
    }

    public function attributes()
    {
        return [
            // 'location_code' => __('school.id'),
            'location_kh' => __('school.name_kh'),
            'location_en' => __('school.name_en'),
            'location_type_id' => __('school.location_type'),
            'region_id' => __('school.area_type'),
            'schoolclaster'=>__('school.claster_school'),
            'pro_code' => __('common.province'),
            'dis_code' => __('common.district'),
            'com_code' => __('common.commune'),
            'vil_code' => __('common.village'),
            'building_num' => __('school.number_of_building'),
            'prokah_attachment' => __('school.prokah_attachment'),
        ];
    }

    public function messages() {
        return [
            'prokah_num.required_if' => __('validation.required', ['attribute' => __('common.prokah_num')]),
            'main_school.required_if' => __('validation.required', ['attribute' => __('school.annex_of_school')]),
            'region_id.required_unless' => __('validation.required', ['attribute' => __('school.area_type')]),
            //'schoolclaster.required_unless'=>__('validation.required',['attribute'=>__('school.claster_school')]),
            'gd_location_code.required_if' => __('validation.required', ['attribute' => __('school.gd')]),
            'rttc_location_code.required_if' => __('validation.required', ['attribute' => __('school.rttc')]),
            'pttc_location_code.required_if' => __('validation.required', ['attribute' => __('school.pttc')]),
            'institute_location_code.required_if' => __('validation.required', ['attribute' => __('school.institute')]),
        ];
    }
}
