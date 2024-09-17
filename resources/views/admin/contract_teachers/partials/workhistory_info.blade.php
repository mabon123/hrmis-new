<div class="card-body">
    @if (isset($contract_teacher))
        <!-- Last work history listing -->
        <div class="table-responsive">
            <table class="table table-bordered table-head-fixed text-nowrap">
                <thead>
                    <th>@lang('common.current_location')</th>
                    <th>@lang('common.contract_type')</th>
                    <th>@lang('common.contract_position')</th>
                    <th>@lang('common.cur_position')</th>
                    <th>@lang('common.start_date')</th>
                    <th>@lang('common.end_date')</th>
                    <th></th>
                </thead>

                <tbody>
                    <tr id="record-{{ $lastWorkHist->workhis_id }}">
                        <td class="kh">{{ !empty($lastWorkHist->location) ? $lastWorkHist->location->location_kh : $lastWorkHist->location_kh }}</td>
                        <td class="kh">{{ !empty($lastWorkHist->contractType) ? $lastWorkHist->contractType->contract_type_kh : '' }}</td>
                        <td class="kh">{{ !empty($lastWorkHist->contractPosition) ? $lastWorkHist->contractPosition->cont_pos_kh : '' }}</td>

                        <td class="text-center">
                            @if( $lastWorkHist->cur_pos == 1 )
                                <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                            @else
                                <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                            @endif
                        </td>

                        <td>{{ $lastWorkHist->start_date > 0 ? date('d-m-Y', strtotime($lastWorkHist->start_date)) : '' }}</td>

                        <td>{{ $lastWorkHist->end_date > 0 ? date('d-m-Y', strtotime($lastWorkHist->end_date)) : '' }}</td>

                        <td class="text-right">
                            <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('contract-teachers.work-histories.edit', [app()->getLocale(), $contract_teacher->payroll_id, $lastWorkHist->workhis_id]) }}" data-update-url="{{ route('contract-teachers.work-histories.update', [app()->getLocale(), $contract_teacher->payroll_id, $lastWorkHist->workhis_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="row">
            <!-- Start date -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="start_date">
                        <span class="section-num">{{ __('number.num6') }}.</span>
                        {{ __('common.start_date') }} <span class="required">*</span>
                    </label>

                    <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                        {{ Form::text('start_date', null, ['class' => 'datepicker form-control', 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                        <div class="input-group-addon">
                            <span class="far fa-calendar-alt"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End date -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="end_date">
                        <span class="section-num">{{ __('number.num7') }}.</span>
                        {{ __('common.end_date') }}
                    </label>

                    <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                        {{ Form::text('end_date', null, ['class' => 'datepicker form-control', 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                        <div class="input-group-addon">
                            <span class="far fa-calendar-alt"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contract type -->
            <div class="col-sm-3">
                <div class="form-group {{ $errors->has('contract_type_id') ? 'has-error' : '' }}">
                    <label for="contract_type_id"> {{__('common.contract_type')}} <span class="required">*</span></label>

                    {{ Form::select('contract_type_id', ['' => __('common.choose').' ...'] + $contractTypes, null, ['class' => 'form-control kh select2', 'id' => 'contract_type_dropdown', 'style' => 'width:100%', 'data-old-value' => old('contract_type_id')]) }}
                </div>
            </div>

            <!-- Contract skill -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="cont_pos_id">@lang('common.contract_position')</label>

                    {{ Form::select('cont_pos_id', ['' => __('common.choose').' ...'], null, ['class' => 'form-control kh select2', 'id' => 'cont_pos_id', 'style' => 'width:100%', 'disabled' => isset($contract_teacher, $contract_teacher->cont_pos_id) ? false : true, 'data-old-value' => old('cont_pos_id')]) }}
                </div>
            </div>
        </div>

        <div id="location-address" class="row d-none">
            <!-- Province -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="location_pro_code">{{ __('common.province') }}</label>

                    {{ Form::select('location_pro_code', ['' => __('common.choose').' ...'] + $provinces, null, ['class' => 'form-control kh select2 province_dropdown', 'id' => 'p_code', 'data-old-value' => old('location_pro_code'), 'disabled' => true]) }}
                </div>
            </div>

            <!-- District -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="location_dis_code">{{ __('common.district') }}</label>

                    {{ Form::select('location_dis_code', ['' => __('common.choose').' ...'], null, ['class' => 'form-control kh select2', 'id' => 'd_code', 'style' => 'width:100%', 'data-old-value' => old('location_dis_code'), 'disabled' => true]) }}
                </div>
            </div>

            <!-- Commune -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="location_com_code">{{ __('common.commune') }}</label>

                    {{ Form::select('location_com_code', ['' => __('common.choose').' ...'], null, ['class' => 'form-control kh select2', 'id' => 'c_code', 'style' => 'width:100%', 'data-old-value' => old('location_com_code'), 'disabled' => true]) }}
                </div>
            </div>

            <!-- Village -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="location_vil_code">{{ __('common.village') }}</label>

                    {{ Form::select('location_vil_code', ['' => __('common.choose').' ...'], null, ['class' => 'form-control kh select2', 'id' => 'v_code', 'style' => 'width:100%', 'data-old-value' => old('location_vil_code'), 'disabled' => true]) }}
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Current location -->
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="com_code">
                        <span class="section-num">{{ __('number.num8') }}.</span>
                        {{ __('common.current_location') }} <span class="required">*</span>
                    </label>

                    {{ Form::select(
                        'location_code', $locations, null, 
                        ['id' => 'location_code', 'class' => 'form-control select2 kh']) 
                    }}
                </div>
            </div>

            <div id="equivalent-section" class="col-sm-8 d-none">
                <div class="row">
                    <!-- refilled_equivalent -->
                    <div class="form-group col-2 col-sm-3 col-md-auto mr-md-3">
                        <label for="refilled_equivalent">@lang('common.refilled_equivalent')</label>

                        <div class="icheck-primary">
                            {{ Form::checkbox('has_refilled_training', 1, null, ['id' => 'refilled_equivalent']) }}
                            <label for="refilled_equivalent"></label>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="refilled_equivalent_year">@lang('common.refilled_equivalent_year')</label>
                            
                            {{ Form::number('refilled_equivalent_year', null, ['id' => 'refilled_equivalent_year', 'class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div id="back-school-section" class="col-sm-8 d-none">
                <div class="row">
                    <!-- refilled_back_school -->
                    <div class="form-group col-2 col-sm-3 col-md-auto mr-md-3">
                        <label for="refilled_back_school">@lang('common.refilled_back_school')</label>

                        <div class="icheck-primary">
                            {{ Form::checkbox('has_refilled_training', 1, null, ['id' => 'refilled_back_school']) }}
                            <label for="refilled_back_school"></label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="refilled_back_school_year">@lang('common.refilled_back_school_year')</label>
                            
                            {{ Form::number('refilled_back_school_year', null, ['id' => 'refilled_back_school_year', 'class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div id="edu-specialist-section" class="col-sm-8 d-none">
                <div class="row">
                    <!-- refilled_edu_specialist -->
                    <div class="form-group col-2 col-sm-3 col-md-auto mr-md-3">
                        <label for="refilled_edu_specialist">@lang('common.refilled_edu_specialist')</label>

                        <div class="icheck-primary">
                            {{ Form::checkbox('has_refilled_training', 1, null, ['id' => 'refilled_edu_specialist']) }}
                            <label for="refilled_edu_specialist"></label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="refilled_edu_specialist_year">@lang('common.refilled_edu_specialist_year')</label>
                            
                            {{ Form::number('refilled_edu_specialist_year', null, ['id' => 'refilled_edu_specialist_year', 'class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div id="literacy-teacher-section" class="col-sm-8 d-none">
                <div class="row">
                    <!-- refilled_literacy_teacher -->
                    <div class="form-group col-2 col-sm-3 col-md-auto mr-md-3">
                        <label for="refilled_literacy_teacher">@lang('common.refilled_literacy_teacher')</label>

                        <div class="icheck-primary">
                            {{ Form::checkbox('has_refilled_training', 1, null, ['id' => 'refilled_literacy_teacher']) }}
                            <label for="refilled_literacy_teacher"></label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="refilled_literacy_teacher_year">@lang('common.refilled_literacy_teacher_year')</label>
                            
                            {{ Form::number('refilled_literacy_teacher_year', null, ['id' => 'refilled_literacy_teacher_year', 'class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main duty -->
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="duty">{{__('common.main_duty')}}</label>

                    {{ Form::textarea('duty', null, ['class' => 'form-control kh', 'id' => 'duty', 'rows' => 2]) }}
                </div>
            </div>
        </div>

        <!-- Annual Evaluation -->
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="annual_eval">{{ __('common.annual_evaluation') }}</label>

                    {{ Form::textarea('annual_eval', null, ['class' => 'form-control kh', 'id' => 'annual_eval', 'rows' => 2]) }}
                </div>
            </div>
        </div>
    @endif
</div>

@if (isset($contract_teacher))
    <div class="card-footer text-right">
        <button type="button" class="btn btn-sm btn-primary" id="btn-add-hist" data-add-url="{{ route('contract-teachers.work-histories.store', [app()->getLocale(), $contract_teacher->payroll_id]) }}" style="width:120px;">
            <i class="fa fa-plus"></i> @lang('button.add')
        </button>
    </div>
@endif
