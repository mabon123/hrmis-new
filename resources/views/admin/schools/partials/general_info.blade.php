<div class="row">
    <div class="col-md-12">
        <div class="row-box">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('location_type_id') ? 'has-error' : '' }}">
                        <label for="location_type_id">{{__('school.location_type')}} <span style="color:#f00">*</span> </label>
                        {{ Form::select(
                            'location_type_id',
                            ['' => __('common.choose') ] + (isset($locationTypes) ? $locationTypes : []),
                            null,
                            ["class" => "form-control select2", 'data-old-value' => old('location_type_id'),  'style' => 'width:100%;'])
                        }}
                    </div>
                </div>
                <div class="col-md-6 col-lg col-xl-3 location-province-field d-none">
                    <div class="form-group {{ $errors->has('location_province') ? 'has-error' : '' }}">
                        <label for="location_province">{{__('common.province')}} </label>
                        {{ Form::select(
                            'location_province',
                            ['' => __('common.choose')] + $provinces,
                            null,
                            ['data-old-value' => old('location_province'), "class" => "form-control select2", 'style' => 'width:100%;'])
                        }}
                    </div>
                </div>
                <div class="col-auto text-lg-center equal-gd-field d-none">
                    <div class="form-group">
                        <label for="equal_gd" class="d-none d-lg-inline-block">{{__('school.equal_gd')}}</label>
                        <input type="hidden" value="0" name="equal_gd" data-old-value="{{ old('equal_gd') }}">
                        <div class="icheck-primary">
                            {{ Form::checkbox('equal_gd', 1, null, ['id' => 'equal_gd', 'data-old-value' => old('equal_gd')]) }}
                            <label for="equal_gd">
                                <span class="d-block d-lg-none">{{__('school.equal_gd')}}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="border-info">
        </div>
    </div>
    <div class="col-md-12">
        <div class="row-box">
            <div class="row">
                <div class="col-sm-6 col-lg-3 province-field">
                    <div class="form-group {{ $errors->has('pro_code') ? 'has-error' : '' }}">
                        <label for="pro_code">{{__('school.province')}} </label>
                        {{ Form::select(
                            'pro_code',
                            ['' => __('common.choose')] + $provinces,
                            auth()->user()->hasRole('poe-admin', 'doe-admin', 'school-admin') ? auth()->user()->work_place->pro_code : null,
                            [
                                'id' => 'p_code',
                                "class" => "form-control select2",
                                'style' => 'width:100%;',
                                'data-old-value' => old('pro_code'),
                                'data-provinces' => json_encode($provinces),
                                'data-disabled' => (int) auth()->user()->hasRole('poe-admin', 'doe-admin', 'school-admin'),
                            ])
                        }}
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 none-moey-block district-field">
                    <div class="form-group {{ $errors->has('dis_code') ? 'has-error' : '' }}">
                        <label for="dis_code">{{__('common.district')}}</label>
                        {{ Form::select(
                            'dis_code',
                            ['' => __('common.choose')] + (isset($districts) ? $districts : []),
                            auth()->user()->hasRole('doe-admin', 'school-admin') ? auth()->user()->work_place->dis_code : null,
                            [
                                'id' => 'd_code',
                                "class" => "form-control select2",
                                'style' => 'width:100%;',
                                'disabled' => auth()->user()->hasRole('doe-admin', 'school-admin') ? true : (isset($location, $location->pro_code) ? false : true),
                                'data-old-value' => old('dis_code'),
                                'data-selected' => auth()->user()->hasRole('doe-admin', 'school-admin') ? auth()->user()->work_place->dis_code : null,
                                'data-disabled' => (int) auth()->user()->hasRole('doe-admin', 'school-admin'),
                            ])
                        }}
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 none-moey-block commune-field">
                    <div class="form-group {{ $errors->has('com_code') ? 'has-error' : '' }}">
                        <label for="com_code">{{__('common.commune')}}</label>
                        {{ Form::select(
                            'com_code',
                            ['' => __('common.choose')] + (isset($communes) ? $communes : []),
                            null,
                            [
                                'id' => 'c_code',
                                'data-old-value' => old('com_code'),
                                "class" => "form-control select2", 'style' => 'width:100%;',
                                'disabled' => isset($location, $location->dis_code) && $location->dis_code !== '9916' ? false : true,
                            ])
                        }}
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 none-moey-block village-field">
                    <div class="form-group {{ $errors->has('vil_code') ? 'has-error' : '' }}">
                        <label for="vil_code">{{__('common.village')}}</label>
                        {{ Form::select(
                            'vil_code',
                            ['' => __('common.choose')] + (isset($villages) ? $villages : []),
                            null,
                            [
                                'id' => 'v_code',
                                'data-old-value' => old('vil_code'),
                                "class" => "form-control select2",
                                'style' => 'width:100%;',
                                'disabled' => isset($location, $location->com_code) ? false : true,
                            ])
                        }}
                    </div>
                </div>

                <div class="col-sm-6 col-lg col-xl-6 gd-field d-none">
                    <div class="form-row">
                        <div class="form-group col-auto">
                            <label for="sub_location">{{__('school.sub_location')}}</label>
                            <input type="hidden" value="0" name="sub_location" data-old-value="{{ old('sub_location') }}">
                            <div class="icheck-primary">
                                {{ Form::checkbox('sub_location', 1, isset($location) && $location->parent_location_code === '99160000000' ? false : null, ['id' => 'sub_location', 'data-old-value' => old('sub_location'),]) }}
                                <label for="sub_location"></label>
                            </div>
                        </div>
                        <div class="form-group col {{ $errors->has('gd_location_code') ? 'has-error' : '' }}">
                            <label for="gd_location_code">{{__('school.gd')}}</label>
                            {{
                                Form::select(
                                    'gd_location_code',
                                    ['' => __('common.choose') ] + (isset($generalDepartments) ? $generalDepartments : []),
                                    isset($location) ? $location->parent_location_code : null,
                                    [
                                        'id' => 'gd_location_code',
                                        "class" => "form-control select2",
                                        'style' => 'width:100%;',
                                        'data-old-value' => old('gd_location_code'),
                                        'disabled' => isset($location) ? !$location->sub_location : true,
                                    ]
                                )
                            }}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg col-xl-3 rttc-field d-none">
                    <div class="form-group {{ $errors->has('rttc_location_code') ? 'has-error' : '' }}">
                        <label for="rttc_location_code">{{__('school.rttc')}} <span style="color:#f00">*</span></label>
                        {{ Form::select(
                            'rttc_location_code',
                            ['' => __('common.choose')] + (isset($rttcs) ? $rttcs : []),
                            isset($location) ? $location->parent_location_code : null,
                            ['id' => 'rttc_code', 'data-old-value' => old('rttc_location_code'), "class" => "form-control select2", 'style' => 'width:100%;'])
                        }}
                    </div>
                </div>
                <div class="col-sm-6 col-lg col-xl-3 pttc-field d-none">
                    <div class="form-group {{ $errors->has('pttc_location_code') ? 'has-error' : '' }}">
                        <label for="pttc_location_code">{{__('school.pttc')}} <span style="color:#f00">*</span></label>
                        {{ Form::select(
                            'pttc_location_code',
                            ['' => __('common.choose')] + (isset($pttcs) ? $pttcs : []),
                            isset($location) ? $location->parent_location_code : null,
                            ['id' => 'pttc_code', 'data-old-value' => old('pttc_location_code'), "class" => "form-control select2", 'style' => 'width:100%;'])
                        }}
                    </div>
                </div>
                <div class="col-sm-6 col-lg col-xl-3 institute-field d-none">
                    <div class="form-group {{ $errors->has('institute_location_code') ? 'has-error' : '' }}">
                        <label for="institute_location_code">{{__('school.institute')}} <span style="color:#f00">*</span></label>
                        {{ Form::select(
                            'institute_location_code',
                            ['' => __('common.choose')] + (isset($institutes) ? $institutes : []),
                            isset($location) ? $location->parent_location_code : null,
                            ['id' => 'institute_code', 'data-old-value' => old('institute_location_code'), "class" => "form-control select2", 'style' => 'width:100%;'])
                        }}
                    </div>
                </div>
            </div>
            <hr class="border-info">
        </div>
    </div>
    <div class="col-md-12">
        <div class="row-box">
            <div class="row">
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-md-auto">
                            <div class="row">
                                <div class="col-sm-auto">
                                    <div class="form-group">
                                        <label for="location_code">{{__('school.id')}}<span style="color:#f00">*</span></label>
                                        {{-- {{ Form::text('location_code', null, ["class" => "form-control ". ($errors->has('location_code') ? ' is-invalid' : null), 'data-inputmask' => '"mask": "99999999999"', 'data-mask']) }} --}}
                                        <div class="form-row">
                                            <div class="form-group col-auto mb-0 pr-0">
                                                {{ Form::text('location_codes[pro_code]', isset($location) ? null : '00', ["class" => "form-control ". ($errors->has('location_codes') ? ' border-danger' : null), 'readonly', 'style' => 'width: 43px', 'data-inputmask' => '"mask": "99"', 'data-mask']) }}
                                            </div>
                                            <div class="form-group col-auto mb-0 pr-0">
                                                {{ Form::text('location_codes[dis_code]', isset($location) ? null : '00', ["class" => "form-control ". ($errors->has('location_codes') ? ' border-danger' : null), 'readonly', 'style' => 'width: 43px', 'data-inputmask' => '"mask": "99"', 'data-mask']) }}
                                            </div>
                                            <div class="form-group col-auto mb-0 pr-0">
                                                {{ Form::text('location_codes[com_code]', isset($location) ? null : '00', ["class" => "form-control ". ($errors->has('location_codes') ? ' border-danger' : null), 'readonly', 'style' => 'width: 43px', 'data-inputmask' => '"mask": "99"', 'data-mask']) }}
                                            </div>
                                            <div class="form-group col-auto mb-0 pr-0">
                                                {{ Form::text('location_codes[vil_code]', isset($location) ? null : '00', ["class" => "form-control ". ($errors->has('location_codes') ? ' border-danger' : null), 'readonly', 'style' => 'width: 43px', 'data-inputmask' => '"mask": "99"', 'data-mask']) }}
                                            </div>
                                            <div class="form-group col-auto mb-0">
                                                {{ Form::text('location_codes[emis_code]', isset($location) ? null : '000', ["class" => "form-control ". ($errors->has('location_codes') ? ' border-danger' : null), 'style' => 'width: 50px', 'data-inputmask' => '"mask": "999"', 'data-mask']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col text-sm-center school-block">
                                    <div class="form-group">
                                        <label for="temporary_code" class="d-none d-sm-inline-block">{{__('school.temporary_code')}}</label>
                                        <input type="hidden" value="0" name="temporary_code">
                                        <div class="icheck-primary">
                                            {{ Form::checkbox('temporary_code', 1, null, ['id' => 'temporary_code']) }}
                                            <label for="temporary_code">
                                                <span class="d-block d-sm-none">{{__('school.temporary_code')}}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md">
                            <div class="form-group">
                                <label for="location_kh">{{__('school.emis_code')}}</label>
                                {{ Form::text(
                                    'emis_code',
                                    null,
                                    ["class" => "form-control ". ($errors->has('emis_code') ? ' is-invalid' : null), 'data-inputmask' => '"mask": "99999999999"', 'data-mask'])
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="location_kh">{{__('school.name_kh')}} <span style="color:#f00">*</span></label>
                                {{ Form::text(
                                    'location_kh',
                                    null,
                                    ["class" => "form-control ". ($errors->has('location_kh') ? ' is-invalid' : null)])
                                }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="location_en">{{__('school.name_en')}} <span style="color:#f00">*</span></label>
                                {{ Form::text(
                                    'location_en',
                                    null,
                                    ["class" => "form-control ". ($errors->has('location_en') ? ' is-invalid' : null)])
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row school-block">
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-md-4 col-xl-3">
                            <div class="form-group">
                                <label for="name_kh">{{__('school.distance_to_poe')}}</label>
                                {{ Form::number(
                                    'distance_to_poe',
                                    null,
                                    ["class" => "form-control ", 'min' => 0])
                                }}
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-4">
                            <div class="form-row">
                                <div class="form-group col {{ $errors->has('claster_school') ? 'has-error' : '' }}">
                                    <label for="claster_school">{{__('school.claster_school')}} <span style="color:#f00">*</span></label>                                 
                                   {{
                                        Form::select(
                                            'schoolclaster',
                                            ['' => __('common.choose') ] + (isset($clasterSchoolLocations) ? $clasterSchoolLocations : []),
                                            isset($location) && $location? null : '',
                                            [
                                                'id' => 'schoolclaster',
                                                "class" => "form-control select2",
                                                'style' => 'width:100%;',
                                                'data-old-value' => old('schoolclaster') ? old('schoolclaster') : (isset($location) ? $location->schoolclaster : ''),  
                                                'enabled' => isset($location) ? !$location->schoolclaster : true,                                            
                                            ]
                                        )
                                    }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-5">
                            <div class="form-row">
                                <div class="form-group col-auto">
                                    <label for="school_annex">{{__('school.school_annex')}}</label>
                                    <input type="hidden" value="0" name="school_annex" data-old-value="{{ old('school_annex') }}">
                                    <div class="icheck-primary">
                                        {{ Form::checkbox('school_annex', 1, null, ['id' => 'school_annex', 'data-old-value' => old('school_annex'),]) }}
                                        <label for="school_annex">@lang('school.has')</label>
                                    </div>
                                </div>
                                <div class="form-group col {{ $errors->has('main_school') ? 'has-error' : '' }}">
                                    <label for="main_school">{{__('school.annex_of_school')}}</label>
                                    {{
                                        Form::select(
                                            'main_school',
                                            ['' => __('common.choose') ] + (isset($mainSchoolLocations) ? $mainSchoolLocations : []),
                                            isset($location) && $location->school_annex ? null : '',
                                            [
                                                'id' => 'main_school',
                                                "class" => "form-control select2",
                                                'style' => 'width:100%;',
                                                'data-old-value' => old('main_school') ? old('main_school') : (isset($location) ? $location->main_school : ''),  
                                                'disabled' => isset($location) ? !$location->main_school : true,                                            
                                            ]
                                        )
                                    }}
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-9">
                    <div class="row">
                        <div class="form-group col-auto">
                            <label for="prokah">{{__('common.prokah')}}</label>
                            <input type="hidden" value="0" name="prokah">
                            <div class="icheck-primary">
                                {{ Form::checkbox('prokah', 1, null, ['id' => 'prokah']) }}
                                <label for="prokah">@lang('school.has')</label>
                            </div>
                        </div>
                        <div class="form-group col">
                            <label for="prokah_num">{{__('common.prokah_num')}}</label>
                            {{
                                Form::text(
                                    'prokah_num',
                                    isset($location) && $location->prokah ? null : '',
                                    [
                                        "class" => "form-control ". ($errors->has('prokah_num') ? ' is-invalid' : null),
                                        'maxlength' => 10,
                                        'readonly' => isset($location) ? !$location->prokah : true
                                    ]
                                )
                            }}
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="customFile">@lang('common.prokah_attachment')</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="prokah_attachment" id="prokah_attachment" accept="application/pdf">
                                    <label class="custom-file-label" for="prokah_attachment">@lang('common.choose_file')</label>
                                </div>
                                @if(isset($location) && $location->prokah && $location->ref_doc && file_exists(public_path($location->ref_doc)))
                                <div class="input-group-append">
                                    <a href="{{ url($location->ref_doc) }}" target="_BLANK" class="input-group-text"><span>@lang('common.view_file')</span></a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="border-info">
        </div>
    </div>
    <div class="col-md-12">
        <div class="row-box">
            <div class="row">
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-4 col-sm-3 col-xl-4">
                            <div class="form-group {{ $errors->has('region_id') ? 'has-error' : '' }}">
                                <label for="region_id">{{__('school.area_type')}} <span style="color:#f00">*</span></label>
                                {{ Form::select(
                                    'region_id',
                                    ['' => __('common.choose') ] + $regions,
                                    null,
                                    ["class" => "form-control select2 ",  'style' => 'width:100%;'])
                                }}
                            </div>
                        </div>
                        <div class="col-4 col-sm-3 col-xl-4 school-block">
                            <div class="form-group {{ $errors->has('multi_level_edu') ? 'has-error' : '' }}">
                                <label for="multi_level_edu">@lang('school.school_in')</span></label>
                                {{ Form::select(
                                    'multi_level_edu',
                                    ['' => __('common.choose') ] + $multilevels,
                                    null, 
                                    ["class" => "form-control select2 ",  'style' => 'width:100%;', 'id' => 'multilevel'])
                                }}
                            </div>
                        </div>
                        <div class="col-3 col-sm-3 col-xl-3 school-block">
                            <div class="form-group">
                                <label for="building_num">{{__('school.number_of_building')}}</label>
                                {{
                                    Form::number(
                                        'building_num',
                                        null,
                                        [
                                            "class" => "form-control",
                                            'min' => 0, 'max' => "99",
                                            'placeholder' => '0',
                                            'onKeyPress' => "if(this.value.length==2) return false;",
                                        ]
                                    )
                                }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form pl-xl-3 pt-xl-3 mt-xl-3 d-flex flex-wrap justify-content-sm-between">
                        <div class="form-group mr-3 mr-sm-0">
                            <input type="hidden" value="0" name="disadvantage">
                            <div class="icheck-primary">
                                {{ Form::checkbox('disadvantage', 1, null, ['id' => 'disadvantage']) }}
                                <label for="disadvantage">@lang('school.disadvantage')</label>
                            </div>
                        </div>
                        <div class="form-group mr-3 mr-sm-0 school-block">
                            <input type="hidden" value="0" name="resource_center">
                            <div class="icheck-primary">
                                {{ Form::checkbox('resource_center', 1, null, ['id' => 'resource_center']) }}
                                <label for="resource_center">@lang('school.resource_center')</label>
                            </div>
                        </div>
                        <div class="form-group mr-3 mr-sm-0 school-block">
                            <input type="hidden" value="0" name="library">
                            <div class="icheck-primary">
                                {{ Form::checkbox('library', 1, null, ['id' => 'library']) }}
                                <label for="library">@lang('school.library')</label>
                            </div>
                        </div>
                       <div class="form-group mr-3 mr-sm-0 school-block">
                            <input type="hidden" value="0" name="technical_school" data-old-value="{{ old('technical_school') }}">
                            <div class="icheck-primary">
                                {{ Form::checkbox('technical_school', 1, null, ['id' => 'technical_school', 'data-old-value' => old('technical_school')]) }}
                                <label for="technical_school">@lang('school.technical_school')</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="border-info">
        </div>
    </div>
    <div class="col-md-12">
        <div class="row-box">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="location_his">{{__('school.school_history')}}</label>
                        {{ Form::textarea('location_his', null, ["class" => "form-control", 'rows' => 10]) }}
                    </div>
                </div>
            </div>
            <hr class="border-info">
        </div>
    </div>
</div>
