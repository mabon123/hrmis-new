<div class="row">
    {{-- Basic Info --}}
    <div class="col-md-12">
        <h4>{{ __('common.basic_info') }}</h4>

        <div class="row-box">
            <div class="row">
                <div class="col-sm-10">

                    <div class="row">
                        <!-- Payroll number -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="trainee_payroll_id">
                                    {{ __('common.payroll_num') }}
                                    <span class="required">*</span>
                                </label>

                                {{ Form::number('trainee_payroll_id', null, ['id' => 'trainee_payroll_id', 'class' => 'form-control ' . ($errors->has('trainee_payroll_id') ? 'is-invalid' : null)]) }}
                            </div>
                        </div>

                        <!-- National id number -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nid_card">{{ __('common.nid') }}</label>

                                {{ Form::text('nid_card', null, ['id' => 'nid_card', 'class' => 'form-control', 'autocomplete' => 'off', 'data-inputmask' => '"mask": "999999999(99)"', 'data-mask' => true]) }}
                            </div>
                        </div>


                        <!-- Trainee status -->
                        <div class="col-sm-4">
                            <div class="form-group @error('trainee_status_id') has-error @enderror">
                                <label for="trainee_status_id"> {{__('common.current_status')}} <span class="required">*</span></label>

                                {{ Form::select('trainee_status_id', ['' => __('common.choose').' ...'] + $traineeStatuses, isset($trainee) ? null : \App\Models\TraineeStatus::Trainee, ['id' => 'trainee_status_id', 'class' => 'form-control kh select2', 'style' => 'width:100%']) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Name in Khmer -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="surname_kh">
                                    {{ __('common.surname_kh') }}
                                    <span class="required">*</span>
                                </label>

                                {{ Form::text('surname_kh', null, ['id' => 'surname_kh', 'class' => 'form-control kh '.($errors->has('surname_kh') ? 'is-invalid' : null), 'maxlength' => 150]) }}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="name_kh">
                                    {{ __('common.name_kh') }} <span class="required">*</span>
                                </label>

                                {{ Form::text('name_kh', null, ['id' => 'name_kh', 'class' => 'form-control kh '.($errors->has('name_kh') ? 'is-invalid' : null), 'maxlength' => 150]) }}
                            </div>
                        </div>

                        <!-- Name in Latin -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="surname_en">
                                    {{ __('common.surname_latin') }}
                                    <span class="required">*</span>
                                </label>

                                {{ Form::text('surname_en', null, ['id' => 'surname_en', 'class' => 'form-control text-uppercase '.($errors->has('surname_en') ? 'is-invalid' : null), 'maxlength' => 50]) }}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="name_en">
                                    {{ __('common.name_latin') }}
                                    <span class="required">*</span>
                                </label>

                                {{ Form::text('name_en', null, ['id' => 'name_en', 'class' => 'form-control text-uppercase '.($errors->has('name_en') ? 'is-invalid' : null), 'maxlength' => 50]) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Gender -->
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group @error('sex') has-error @enderror">
                                <label for="sex">
                                    {{ __('common.sex') }} <span class="required">*</span>
                                </label>

                                {{ Form::select('sex', ['' => __('common.choose').' ...', '1' => 'ប្រុស', '2' => 'ស្រី'], null, ['class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                            </div>
                        </div>

                        <!-- Date of birth -->
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="dob">
                                    {{ __('common.dob') }}
                                    <span class="required">*</span>(dd-mm-yyyy)
                                </label>

                                <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                    {{ Form::text('dob', isset($trainee) ? date('d-m-Y', strtotime($trainee->dob)) : null, ['class' => 'form-control datepicker '.($errors->has('dob') ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                                    <div class="input-group-addon">
                                        <span class="far fa-calendar-alt"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Former staff -->
                        <div class="col-sm-6" style="margin-top:37px;">
                            <div class="form-group clearfix">
                                <input type="hidden" value="0" name="former_staff">
                                <div class="icheck-primary d-inline">
                                    {{ Form::checkbox('former_staff', '1', null, ['id' => 'former_staff']) }}
                                    <label for="former_staff">{{__('common.former_staff')}}</label>
                                </div>

                                <input type="hidden" value="0" name="result">
                                <div class="icheck-primary d-inline ml-3">
                                    {{ Form::checkbox('result', '1', null, ['id' => 'result', 'data-current-value' => (isset($trainee) ? $trainee->result : null)]) }}
                                    <label for="result" class="result-label">{{__('common.pass')}}</label>
                                </div>
                            </div>
                        </div>


                        <!-- Future Location -->
                        <div class="col-sm-3">
                            <div class="form-group {{ $errors->has('future_pro_code') ? 'has-error' : '' }}">
                                <label for="future_pro_code">{{__('trainee.future_province')}} <span class="required">*</span></label>
                                {{ Form::select(
                                    'future_pro_code',
                                    ['' => __('common.choose')] + $provinces,
                                    isset($futureLocation) ? $futureLocation->pro_code : null,
                                    ['data-old-value' => old('future_pro_code'), "class" => "form-control select2", 'id' => 'future_pro_code', 'style' => 'width:100%;'])
                                }}
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="future_location_code">{{ __('trainee.future_location') }} <span class="required">*</span></label>
                                {{ Form::select(
                                    'future_location_code',
                                    ['' => __('common.choose')] + (isset($futureLocations) ? $futureLocations : []),
                                    null,
                                    [
                                        'data-old-value' => old('future_location_code') ?? (isset($trainee) ? $trainee->future_location_code : null),
                                        "class" => "form-control kh select2",
                                        'id' => 'future_location_code',
                                        'style' => 'width:100%;'
                                    ])
                                }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trainee photo -->
                <div class="col-sm-2">
                    @if (isset($trainee) and !empty($trainee->photo))
                        <input type="hidden" name="profile_photo_asset" id="profile_photo_asset" value="{{ $trainee->photo }}">

                        <div id="profile-photo-sec" class="text-center">
                            <img id="image-thumbnail" class="img-thumbnail" src="{{ asset('storage/images/trainees/'.$trainee->photo) }}">
                            <button type="button" id="btn-cancel-profile" class="btn btn-danger btn-xs" style="width:90px;margin-top:15px;">
                                <i class="far fa-times-circle"></i> Remove
                            </button>
                        </div>

                        <div class="form-group upload-section d-none">
                            <div class="profile-icon">
                                <p><i class="fas fa-cloud-upload-alt" style="margin:0;font-size:32px;color:#0a7698;"></i></p>
                                {{ __('common.choose_photo') }}</label><br>
                            </div>
                            <input id="profile_photo" name="profile_photo" type="file">
                        </div>
                    @else
                        <div id="profile-photo-sec" class="text-center d-none">
                            <img id="image-thumbnail" class="img-thumbnail">
                            <button type="button" id="btn-cancel-profile" class="btn btn-danger btn-xs" style="width:90px;margin-top:15px;">
                                <i class="far fa-times-circle"></i> Cancel
                            </button>
                        </div>

                        <div class="form-group upload-section">
                            <div class="profile-icon">
                                <p><i class="fas fa-cloud-upload-alt" style="margin:0;font-size:32px;color:#0a7698;"></i></p>
                                {{ __('common.choose_photo') }}</label><br>
                            </div>
                            <input id="profile_photo" name="profile_photo" type="file">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Place of birth --}}
    <div class="col-md-12">
        <h4>{{ __('common.pob') }}</h4>
        <div class="row-box">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group {{ $errors->has('birth_pro_code') ? 'has-error' : '' }}">
                        <label for="birth_pro_code">{{__('common.province')}} <span class="required">*</span></label>
                        {{ Form::select(
                            'birth_pro_code',
                            ['' => __('common.choose')] + $provinces,
                            null,
                            ['data-old-value' => old('birth_pro_code'), "class" => "form-control select2", 'id' => 'pro_code_autocomplete', 'style' => 'width:100%;'])
                        }}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group {{ $errors->has('birth_district') ? 'has-error' : '' }}">
                        <label for="birth_district">{{__('common.district')}} <span class="required">*</span></label>
                        {{ Form::text('birth_district', null, ['class' => 'form-control kh​ '.($errors->has('birth_district') ? 'is-invalid' : null), 'autocomplete' => 'off', 'id' => 'birth_district']) }}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group {{ $errors->has('birth_commune') ? 'has-error' : '' }}">
                        <label for="birth_commune">{{__('common.commune')}}</label>
                        {{ Form::text(
                            'birth_commune',
                            null,
                            ["class" => "form-control ". ($errors->has('birth_commune') ? ' is-invalid' : null), 'autocomplete' => 'off', 'id' => 'birth_commune'])
                        }}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group {{ $errors->has('birth_village') ? 'has-error' : '' }}">
                        <label for="birth_village">{{__('common.village')}}</label>
                        {{ Form::text(
                            'birth_village',
                            null,
                            ["class" => "form-control ". ($errors->has('birth_village') ? ' is-invalid' : null), 'autocomplete' => 'off', 'id' => 'birth_village'])
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Qualification --}}
    <div class="col-md-12">
         <h4>{{ __('trainee.qualification') }}</h4>
        <div class="row-box">
            <div class="row">
                <!-- Academic Year -->
                <div class="col-sm-6 col-md-3">
                    <div class="form-group @error('year_id') has-error @enderror">
                        <label for="year_id"> {{__('common.year')}} <span class="required">*</span></label>
                        {{ Form::select('year_id', ['' => __('common.choose').' ...'] + $academicYears, isset($trainee) ? null : (isset($selectedYear) ? $selectedYear : null), ['id' => 'year_id', 'class' => 'form-control kh select2', 'style' => 'width:100%']) }}
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="location_code">{{ __('qualification.training_institution') }} <span class="required">*</span></label>
                        {{ Form::select(
                            'location_code',
                            ['' => __('common.choose')] + $trainingInstitutions,
                            auth()->user()->hasRole('dept-admin') && auth()->user()->is_ttc ? auth()->user()->work_place->location_code : null,
                            [
                                'data-old-value' => old('location_code'),
                                "class" => "form-control kh select2",
                                'id' => 'location_code',
                                'style' => 'width:100%;',
                                'data-location_code' => isset($trainee, $trainee->location) ? $trainee->location->location_code : null,
                                'data-location_type_id' => isset($trainee, $trainee->location) ? $trainee->location->location_type_id : null,
                            ])
                        }}
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="prof_type_id">{{ __('qualification.training_sys') }} <span class="required">*</span></label>
                        {{ Form::select(
                            'prof_type_id',
                            ['' => __('common.choose')] + $professionalTypes,
                            null,
                            ['id' => 'prof_type_id', 'data-old-value' => old('prof_type_id'), "class" => "form-control select2", 'style' => 'width:100%;', 'data-professional_types' => json_encode($professionalTypes)])
                        }}
                    </div>
                </div>

                <!-- Generation -->
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="stu_generation">{{ __('trainee.stu_generation') }} <span class="required">*</span></label>
                        {{ Form::select('stu_generation', ['' => __('common.choose').' ...'] + (isset($generations) ? $generations : []), isset($trainee) ? null : (isset($selectedGeneration) ? $selectedGeneration : null), ['id' => 'stu_generation', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="subject_id1">{{ __('qualification.first_subject') }} <span class="required">*</span></label>
                        {{ Form::select(
                            'subject_id1',
                            ['' => __('common.choose')] + $subjects,
                            null,
                            ['id' => 'subject_id1', 'data-old-value' => old('subject_id1'), "class" => "form-control select2", 'style' => 'width:100%;'])
                        }}
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="subject_id2">{{ __('qualification.second_subject') }}</label>
                        {{ Form::select(
                            'subject_id2',
                            ['' => __('common.choose')] + $subjects,
                            null,
                            ['id' => 'subject_id2', 'data-old-value' => old('subject_id2'), "class" => "form-control select2", 'style' => 'width:100%;'])
                        }}
                    </div>
                </div>

                <!-- Start date -->
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="start_date">
                            {{ __('common.start_date') }} <span class="required">*</span>
                        </label>

                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                            {{ Form::text('start_date', isset($trainee) ? date('d-m-Y', strtotime($trainee->start_date)) : null, ['class' => 'datepicker form-control '.($errors->has('start_date') ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                            <div class="input-group-addon">
                                <span class="far fa-calendar-alt"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End date -->
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="end_date">
                            {{ __('common.end_date') }} <span class="required">*</span>
                        </label>

                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                            {{ Form::text('end_date', isset($trainee) ? date('d-m-Y', strtotime($trainee->end_date)) : null, ['class' => 'datepicker form-control '.($errors->has('end_date') ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                            <div class="input-group-addon">
                                <span class="far fa-calendar-alt"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Current Address --}}
    <div class="col-md-12">
        <h4>{{ __('common.current_address') }}</h4>
        <div class="row-box">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label for="house_num">{{__('common.house_number')}}</label>
                        {{ Form::text(
                            'house_num',
                            null,
                            ["class" => "form-control ". ($errors->has('house_num') ? ' is-invalid' : null)])
                        }}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label for="group_num">{{__('common.group_number')}}</label>
                        {{ Form::text(
                            'group_num',
                            null,
                            ["class" => "form-control ". ($errors->has('group_num') ? ' is-invalid' : null)])
                        }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="street_num">{{__('common.street')}}</label>
                        {{ Form::text(
                            'street_num',
                            null,
                            ["class" => "form-control ". ($errors->has('street_num') ? ' is-invalid' : null)])
                        }}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group {{ $errors->has('adr_pro_code') ? 'has-error' : '' }}">
                        <label for="adr_pro_code">{{__('common.province')}} </label>
                        {{ Form::select(
                            'adr_pro_code',
                            ['' => __('common.choose')] + $provinces,
                            null,
                            ['id' => 'p_code', 'data-old-value' => old('adr_pro_code'), "class" => "form-control select2", 'style' => 'width:100%;'])
                        }}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group {{ $errors->has('adr_dis_code') ? 'has-error' : '' }}">
                        <label for="adr_dis_code">{{__('common.district')}}</label>
                        {{ Form::select(
                            'adr_dis_code',
                            ['' => __('common.choose')] + (isset($districts) ? $districts : []),
                            null,
                            ['id' => 'd_code', 'data-old-value' => old('adr_dis_code'), "class" => "form-control select2", 'style' => 'width:100%;', 'disabled' => isset($trainee, $trainee->adr_pro_code) ? false : true])
                        }}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group {{ $errors->has('adr_com_code') ? 'has-error' : '' }}">
                        <label for="adr_com_code">{{__('common.commune')}}</label>
                        {{ Form::select(
                            'adr_com_code',
                            ['' => __('common.choose')] + (isset($communes) ? $communes : []),
                            null,
                            ['id' => 'c_code', 'data-old-value' => old('adr_com_code'), "class" => "form-control select2", 'style' => 'width:100%;', 'disabled' => isset($trainee, $trainee->adr_dis_code) && $trainee->dis_code !== '9916' ? false : true])
                        }}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group {{ $errors->has('adr_vil_code') ? 'has-error' : '' }}">
                        <label for="adr_vil_code">{{__('common.village')}}</label>
                        {{ Form::select(
                            'adr_vil_code',
                            ['' => __('common.choose')] + (isset($villages) ? $villages : []),
                            null,
                            ['id' => 'v_code', 'data-old-value' => old('adr_vil_code'), "class" => "form-control select2", 'style' => 'width:100%;', 'disabled' => isset($trainee, $trainee->adr_com_code) ? false : true])
                        }}
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="phone">{{ __('common.telephone') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        {{
                            Form::text(
                                'phone',
                                null,
                                [
                                    "class" => "form-control ". ($errors->has('phone') ? ' is-invalid' : null),
                                    'data-inputmask' => "'mask': ['999-999-9999', '+855 99 999 9999']",
                                    'data-mask'
                                ]
                            )
                        }}
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="phone">{{ __('common.emergency_phone') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        {{
                            Form::text(
                                'emergency_phone',
                                null,
                                [
                                    "class" => "form-control ". ($errors->has('emergency_phone') ? ' is-invalid' : null),
                                    'data-inputmask' => "'mask': ['999-999-9999', '+855 99 999 9999']",
                                    'data-mask'
                                ]
                            )
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Family Info --}}
    <div class="col-md-12">
         <h4>{{ __('menu.family_details') }}</h4>
        <div class="row-box">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label for="maritalstatus_id">{{__('family_info.family_status')}} <span class="required">*</span></label>
                        {{ Form::select(
                            'maritalstatus_id',
                            ['' => __('common.choose')] + $maritalStatuses,
                            null,
                            ['id' => 'maritalstatus_id', 'data-old-value' => old('maritalstatus_id'), "class" => "form-control select2", 'style' => 'width:100%;'])
                        }}
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label for="fullname_kh">{{ __('family_info.spouse_name') }}</label>
                        {{ Form::text(
                            'fullname_kh',
                            isset($trainee, $trainee->spouse) ? $trainee->spouse->fullname_kh : null,
                            ["class" => "form-control ". ($errors->has('fullname_kh') ? ' is-invalid' : null)])
                        }}
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label for="spouse_phone">{{ __('common.couple_phone') }}</label>
                        {{
                        Form::text(
                            'spouse_phone',
                            isset($trainee, $trainee->spouse) ? $trainee->spouse->phone : null,
                            [
                                "class" => "form-control ". ($errors->has('spouse_phone') ? ' is-invalid' : null),
                                'data-inputmask' => "'mask': ['999-999-9999', '+855 99 999 9999']",
                                'data-mask'
                            ]
                        )
                        }}
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label for="spouse_dob">{{ __('family_info.spouse_dob') }}</label>

                        <div class="input-group date" data-provide="datepicker"
                            data-date-format="dd/mm/yyyy">
                            {{ Form::text(
                                'spouse_dob',
                                isset($trainee, $trainee->spouse) ? date('d-m-Y', strtotime($trainee->spouse->dob)) : null,
                                ['class' => 'form-control datepicker '.($errors->has('spouse_dob') ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']
                            ) }}
                            <div class="input-group-addon">
                                <span class="far fa-calendar-alt"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <?php
                        $occupations = [
                            'មន្រ្តីរាជការ' => 'មន្រ្តីរាជការ',
                            'ក្រុមហ៊ុនឯកជន' => 'ក្រុមហ៊ុនឯកជន',
                            'មេផ្ទះ' => 'មេផ្ទះ',
                            'អាជីវករ' => 'អាជីវករ',
                            'កសិករ' => 'កសិករ'
                        ];
                    ?>
                    <div class="form-group">
                        <label for="occupation">
                            {{ __('family_info.spouse_occupation') }}
                        </label>
                        {{ Form::select(
                            'occupation',
                            ['' => __('common.choose').' ...'] + $occupations,
                            isset($trainee, $trainee->spouse) ? $trainee->spouse->occupation : null,
                            ['id' => 'occupation', 'class' => 'form-control kh select2', 'style' => 'width:100%;']
                        ) }}
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label for="spouse_workplace">{{ __('family_info.spouse_unit') }}</label>
                        {{ Form::text(
                            'spouse_workplace',
                            isset($trainee, $trainee->spouse) ? $trainee->spouse->spouse_workplace : null,
                            ["class" => "form-control ". ($errors->has('spouse_workplace') ? ' is-invalid' : null)])
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="staff" value="">
    <input type="hidden" id="districtinfo" value="{{ isset($birthDistricts) ? $birthDistricts : null }}">
    {{-- <input type="hidden" id="locationInfo" value="{{ $locations }}"> --}}
    <input type="hidden" id="action" value="{{ isset($trainee) ? 'edit' : 'create' }}">
    <input type="hidden" id="editable" value="{{ isset($trainee) && ($trainee->stu_generation != $currentGeneration || $trainee->trainee_status_id == \App\Models\TraineeStatus::Completed) ? 0 : 1 }}">
</div>
