<div class="row row-box">

    @if (isset($staff))

        @include('admin.staffs.partials.salary_history')

    @else

        <div class="col-md-12">
            <h4>
                <span class="section-num">@lang('number.num4').</span> 
                {{ __('common.official_rank_degree') }}
            </h4>

            <div class="row">
                <!-- Salary level -->
                <div class="col-sm-3">
                    <div class="form-group @error('salary_level_id') has-error @enderror">
                        <label for="salary_level_id">
                            {{ __('common.salary_type') }} <span class="required">*</span>
                        </label>

                        {{ Form::select('salary_level_id', ['' => __('common.choose').' ...'] + $salaryLevels, null, ['id' => 'salary_level_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 'data-old-value' => old('salary_level_id')]) }}
                    </div>
                </div>

                <!-- Salary degree -->
                <div class="col-sm-3">
                    <div class="form-group @error('salary_degree') has-error @enderror">
                        <label for="salary_degree">{{ __('common.degree') }} <span class="required">*</span></label>

                        @php
                            $salary_degrees = ['១' => '១', '២' => '២', '៣' => '៣', '៤' => '៤', '៥' => '៥', 
                                '៦' => '៦', '៧' => '៧', '៨' => '៨', '៩' => '៩', '១០' => '១០'];
                        @endphp

                        {{ Form::select('salary_degree', ['' => __('common.choose').' ...'] + $salary_degrees, null, 
                            ['id' => 'salary_degree', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) }}
                    </div>
                </div>

                <!-- Official rank -->
                <div class="col-sm-3">
                    <div class="form-group @error('official_rank_id') has-error @enderror">
                        <label for="official_rank_id">{{ __('common.status') }}</label>

                        {{ Form::select('official_rank_id', ['' => __('common.choose').' ...'], null, ['id' => 'official_rank_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 'required' => false]) }}
                    </div>
                </div>

                <!-- Salary type shift data -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="salary_type_shift_date">{{ __('common.promotion_date_cycle') }}</label>

                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                            {{ Form::text('salary_type_shift_date', null, ['id' => 'salary_type_shift_date', 
                                'class' => 'form-control datepicker', 'autocomplete' => 'off', 
                                'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) 
                            }}
                            <div class="input-group-addon">
                                <span class="far fa-calendar-alt"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Prokah number -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="salary_type_prokah_num">{{ __('common.code_num') }}</label>

                        {{ Form::text('salary_type_prokah_num', null, ['id' => 'salary_type_prokah_num', 
                            'class' => 'form-control', 'autocomplete' => 'off']) }}
                    </div>
                </div>

                <!-- Sign date -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="salary_type_signdate">{{ __('common.sign_date') }}</label>

                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                            {{ Form::text('salary_type_signdate', null, ['id' => 'salary_type_signdate', 
                                'class' => 'form-control datepicker', 'autocomplete' => 'off', 
                                'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) 
                            }}
                            <div class="input-group-addon">
                                <span class="far fa-calendar-alt"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rank number -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="salary_type_prokah_order">{{ __('common.rank_num') }}</label>

                        {{ Form::number('salary_type_prokah_order', null, ['id' => 'salary_type_prokah_order', 
                            'class' => 'form-control']) }}
                    </div>
                </div>
            </div>
        </div>

    @endif


    <!-- Other information section -->
    <div class="col-md-12">
        <h4>
            <span class="section-num">@lang('number.num6').</span>
            {{ __('common.other_info') }}
        </h4>
        
        <div class="row">
            <div class="col-sm-3 div-checkbox">
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                        {{ Form::checkbox('dtmt_school', '1', (isset($staff) ? $staff->dtmt_school : ''), ['id' => 'dtmt_school']) }}
                        <label for="dtmt_school">{{__('common.dtmt_school')}}</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 div-checkbox">
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                        {{ Form::checkbox('sbsk', '1', (isset($staff) ? $staff->sbsk : ''), ['id' => 'sbsk']) }}
                        <label for="sbsk">{{__('common.kesa_long')}}</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label for="sbsk_num">@lang('common.membership_id')</label>

                    {{ Form::text('sbsk_num', null, ['id' => 'sbsk_num', 'class' => 'form-control '.($errors->has('sbsk_num') ? 'is-invalid' : null), 'maxlength' => 10, 'autocomplete' => 'off', 'disabled' => true]) }}
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Disability teacher -->
            <div class="col-sm-2 div-checkbox">
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                        {{ Form::checkbox('disability_teacher', '1', (isset($staff) ? $staff->disability_teacher : ''), ['id' => 'disability_teacher']) }}
                        <label for="disability_teacher">{{ __('common.disability_teacher') }}</label>
                    </div>
                </div>
            </div>

            <!-- Disability -->
            <div class="col-sm-4">
                <div class="form-group @error('disability_id') has-error @enderror">
                    <label for="disability_id">{{ __('common.disability_type') }}</label>

                    {{ Form::select('disability_id', ['' => __('common.choose').' ...'] + $disabilities, null, ['id' => 'disability_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 'disabled' => true]) }}
                </div>
            </div>

            <!-- Notes -->
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="disability_note">{{ __('common.disability_desc') }}</label>
                    {{ Form::text('disability_note', null, ['id' => 'disability_note', 'class' => 'form-control', 'autocomplete' => 'off', 'disabled' => true]) }}
                </div>
            </div>
        </div>
    </div>
</div>
