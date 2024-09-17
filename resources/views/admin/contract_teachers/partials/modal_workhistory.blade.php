<!-- Modal work history -->
<div class="modal fade" id="modalCreateWorkHistory">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <form method="post" id="frmCreateWorkHistory" action="">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.work_info') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row row-box">
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

                        <div id="equivalent-section" class="col-sm-6 {{ ($lastWorkHist and ($lastWorkHist->cont_pos_id == 2 or $lastWorkHist->cont_pos_id == 3)) ? '' : 'd-none' }}">
                            <div class="row">
                                <!-- refilled_equivalent -->
                                <div class="form-group col-2 col-sm-3 col-md-auto mr-md-3">
                                    <label for="refilled_equivalent">@lang('common.refilled_equivalent')</label>

                                    <div class="icheck-primary">
                                        {{ Form::checkbox('has_refilled_training', 1, null, ['id' => 'refilled_equivalent']) }}
                                        <label for="refilled_equivalent"></label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="refilled_equivalent_year">@lang('common.refilled_equivalent_year')</label>
                                        
                                        {{ Form::number('refilled_equivalent_year', null, ['id' => 'refilled_equivalent_year', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="back-school-section" class="col-sm-6 {{ ($lastWorkHist and $lastWorkHist->cont_pos_id == 4) ? '' : 'd-none' }}">
                            <div class="row">
                                <!-- refilled_back_school -->
                                <div class="form-group col-2 col-sm-3 col-md-auto mr-md-3">
                                    <label for="refilled_back_school">@lang('common.refilled_back_school')</label>

                                    <div class="icheck-primary">
                                        {{ Form::checkbox('has_refilled_training', 1, null, ['id' => 'refilled_back_school']) }}
                                        <label for="refilled_back_school"></label>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="refilled_back_school_year">@lang('common.refilled_back_school_year')</label>
                                        
                                        {{ Form::number('refilled_back_school_year', null, ['id' => 'refilled_back_school_year', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="edu-specialist-section" class="col-sm-6 {{ ($lastWorkHist and $lastWorkHist->cont_pos_id == 5) ? '' : 'd-none' }}">
                            <div class="row">
                                <!-- refilled_edu_specialist -->
                                <div class="form-group col-2 col-sm-3 col-md-auto mr-md-3">
                                    <label for="refilled_edu_specialist">@lang('common.refilled_edu_specialist')</label>

                                    <div class="icheck-primary">
                                        {{ Form::checkbox('has_refilled_training', 1, null, ['id' => 'refilled_edu_specialist']) }}
                                        <label for="refilled_edu_specialist"></label>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="refilled_edu_specialist_year">@lang('common.refilled_edu_specialist_year')</label>
                                        
                                        {{ Form::number('refilled_edu_specialist_year', null, ['id' => 'refilled_edu_specialist_year', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="literacy-teacher-section" class="col-sm-6 {{ ($lastWorkHist and $lastWorkHist->cont_pos_id == 1) ? '' : 'd-none' }}">
                            <div class="row">
                                <!-- refilled_literacy_teacher -->
                                <div class="form-group col-2 col-sm-3 col-md-auto mr-md-3">
                                    <label for="refilled_literacy_teacher">@lang('common.refilled_literacy_teacher')</label>

                                    <div class="icheck-primary">
                                        {{ Form::checkbox('has_refilled_training', 1, null, ['id' => 'refilled_literacy_teacher']) }}
                                        <label for="refilled_literacy_teacher"></label>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="refilled_literacy_teacher_year">@lang('common.refilled_literacy_teacher_year')</label>
                                        
                                        {{ Form::number('refilled_literacy_teacher_year', null, ['id' => 'refilled_literacy_teacher_year', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="location-address" class="row d-none">
                        <!-- Province -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="location_pro_code">{{ __('common.province') }}</label>

                                {{ Form::select('location_pro_code', ['' => __('common.choose').' ...'] + $provinces, $lastWorkHist->pro_code, ['class' => 'form-control kh select2 province_dropdown', 'id' => 'p_code', 'data-old-value' => old('location_pro_code'), 'disabled' => true]) }}
                            </div>
                        </div>

                        <!-- District -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="location_dis_code">{{ __('common.district') }}</label>

                                {{ Form::select('location_dis_code', ['' => __('common.choose').' ...'] + $districtCodes, $lastWorkHist->dis_code, ['class' => 'form-control kh select2', 'id' => 'd_code', 'style' => 'width:100%', 'data-old-value' => old('location_dis_code'), 'disabled' => ($districtCodes ? false : true)]) }}
                            </div>
                        </div>

                        <!-- Commune -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="location_com_code">{{ __('common.commune') }}</label>

                                {{ Form::select('location_com_code', ['' => __('common.choose').' ...'] + $communeCodes, $lastWorkHist->com_code, ['class' => 'form-control kh select2', 'id' => 'c_code', 'style' => 'width:100%', 'data-old-value' => old('location_com_code'), 'disabled' => ($communeCodes ? false : true)]) }}
                            </div>
                        </div>

                        <!-- Village -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="location_vil_code">{{ __('common.village') }}</label>

                                {{ Form::select('location_vil_code', ['' => __('common.choose').' ...'] + $villageCodes, $lastWorkHist->vil_code, ['class' => 'form-control kh select2', 'id' => 'v_code', 'style' => 'width:100%', 'data-old-value' => old('location_vil_code'), 'disabled' => ($villageCodes ? false : true)]) }}
                            </div>
                        </div>
                    </div>

                    <div class="row row-box">
                        <!-- Current location -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="location_kh">
                                    <span class="section-num">{{ __('number.num7') }}.</span>
                                    {{ __('common.current_location') }}
                                    <span class="required">*</span>
                                </label>

                                {{ Form::select('location_code', $locations, null, 
                                    ['id' => 'location_code', 'class' => 'form-control select2 kh']) 
                                }}
                            </div>
                        </div>

                        <!-- Current position -->
                        <div class="col-sm-2 div-checkbox">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="curpos" name="curpos" value="1" checked disabled>
                                    <label for="curpos">{{__('common.cur_position')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="start_date">
                                    {{ __('common.start_date') }}
                                    <span class="required">*</span>
                                </label>

                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                    <input type="text" autocomplete="off" id="start_date" name="start_date"
                                        class="datepicker form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                    <div class="input-group-addon">
                                        <span class="far fa-calendar-alt"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="end_date">{{__('common.end_date')}}</label>
                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                    <input type="text" autocomplete="off" name="end_date" id="end_date" 
                                        class="datepicker form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                    <div class="input-group-addon">
                                        <span class="far fa-calendar-alt"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-box">
                        <!-- Main duty -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="duty">{{__('common.main_duty')}}</label>

                                <textarea id="duty" name="duty" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <!-- Main duty -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="annual_eval">{{__('common.annual_evaluation')}}</label>

                                <textarea id="annual_eval" name="annual_eval" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:150px;">
                        <i class="far fa-times-circle"></i> {{ __('button.cancel') }}
                    </button>

                    <button type="submit" id="btn-save-hist" class="btn btn-info" style="width:150px;">
                        <i class="far fa-save"></i> {{ __('button.save') }}
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal work info -->
