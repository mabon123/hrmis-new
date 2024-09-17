<div class="modal fade" id="modalCreateWorkHistory">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="post" id="frmCreateWorkHistory" action="{{ route('workHistory.store', [app()->getLocale(), $staff->payroll_id]) }}">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.work_info') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <input type="hidden" name="staff_status_id" value="1">

                <div class="modal-body">
                    <div id="alert-section" class="alert alert-danger d-none">
                        <ul id="errors" style="margin-bottom:0;"></ul>
                    </div>

                    <div class="row-box">
                        <div class="row">
                            <!-- Province -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pro_code">@lang('common.province')</label>
                                    
                                    {{ Form::select('pro_code', ['' => __('common.choose').' ...'] + $provinces, 
                                        (isset($staffProCode) ? $staffProCode : null), 
                                        ['id' => 'workinfo_procode', 'class' => 'form-control kh select2 procode_location', 
                                        'disabled' => (!auth()->user()->hasRole('administrator') ? true : false)]) }}
                                </div>
                            </div>

                            <!-- Current location -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="location_code">
                                        <span class="section-num">@lang('number.num7').</span>
                                        {{ __('common.current_location') }}
                                        <span class="required">*</span>
                                    </label>

                                    {{ Form::select('location_code', ['' => __('common.choose').' ...'] + $locations, 
                                        (!empty($lastWorkHist->location_code) ? $lastWorkHist->location_code : null), 
                                        ['id' => 'location_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%']) 
                                    }}
                                </div>
                            </div>

                            <!-- Admin office -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="sys_admin_office_id">
                                        <span class="section-num">@lang('number.num8').</span> {{ __('common.office') }}
                                    </label>

                                    {{ Form::select('sys_admin_office_id', ['' => __('common.choose').' ...'] + $offices, (!empty($lastWorkHist->sys_admin_office_id) ? $lastWorkHist->sys_admin_office_id : null), ['id' => 'sys_admin_office_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 'disabled' => (empty($offices) ? true : false)]) }}
                                </div>
                            </div>

                            <!-- Position -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="position_id">
                                        <span class="section-num">@lang('number.num9'). </span>
                                        {{ __('common.position') }} <span class="required">*</span>
                                    </label>

                                    {{ Form::select('position_id', ['' => __('common.choose').' ...'] + $positions, (!empty($lastWorkHist) ? $lastWorkHist->position_id : null), ['id' => 'position_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                                </div>
                            </div>

                            <!-- Equal position -->
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="additional_position_id">{{ __('common.position_equal') }}</label>

                                    {{ Form::select('additional_position_id', ['' => __('common.choose').' ...'] + $positions, (!empty($lastWorkHist) ? $lastWorkHist->additional_position_id : null), ['id' => 'additional_position_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                                </div>
                            </div>

                            <div class="col-sm-1"></div>

                            <!-- Prokah -->
                            <div class="form-group col-2 col-sm-3 col-md-auto mr-md-1">
                                <label for="prokah">@lang('common.prokah')</label>

                                <div class="icheck-primary">
                                    {{ Form::checkbox('prokah', 1, ((!empty($lastWorkHist) and $lastWorkHist->prokah == 1) ? 'true' : 'false'), 
                                        ['id' => 'prokah']) }}
                                    <label for="prokah"></label>
                                </div>
                            </div>

                            <!-- Prokah number -->
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="prokah_num">@lang('common.prokah_num') <span 
                                        id="subject_req" class="required d-none">*</span></label>

                                    {{ Form::text('prokah_num', null, 
                                        ['id' => 'prokah_num', 'class' => 'form-control', 'autocomplete' => 'off', 
                                        'maxlength' => 50, 'disabled' => true]) 
                                    }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Current position -->
                            <div class="col-sm-2 div-checkbox">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        {{ Form::checkbox('cur_pos', 1, ((!empty($lastWorkHist) and $lastWorkHist->cur_pos == 1) ? 'true' : 'false'), 
                                            ['id' => 'cur_pos', 'disabled' => 'true']) }}
                                        <label for="cur_pos">{{__('common.cur_position')}}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="start_date">
                                        {{ __('common.start_date') }} <span class="required">*</span>
                                    </label>

                                    <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                        {{ Form::text('start_date', null, ['id' => 'start_date', 'class' => 'datepicker form-control', 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="end_date">{{__('common.end_date')}}</label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                        {{ Form::text('end_date', ((!empty($lastWorkHist) and $lastWorkHist->end_date > 0) ? date('d-m-Y', strtotime($lastWorkHist->end_date)) : null), ['id' => 'end_date', 'class' => 'datepicker form-control', 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'disabled' => true]) }}
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main duty -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="main_duty">{{__('common.description')}}</label>

                                    {{ Form::textarea('main_duty', (!empty($lastWorkHist) ? $lastWorkHist->main_duty : null), ['class' => 'form-control kh', 'id' => 'main_duty', 'rows' => 2]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:150px;">
                        <i class="far fa-times-circle"></i> {{ __('button.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-info" style="width:150px;">
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