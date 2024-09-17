<div class="modal fade" id="modalUpdateStaffStatus">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form method="post" id="frmUpdateStaffStatus" action="{{ route('workHistory.store', [app()->getLocale(), $staff->payroll_id]) }}">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.work_info') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <input type="hidden" name="staff_status_id" id="staff_status_id" value="">

                <div class="modal-body">
                    <div class="row row-box">
                        <!-- Start date -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="start_date">{{ __('common.start_date') }} <span class="required">*</span></label>

                                <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                    {{ Form::text('start_date', null, ['id' => 'start_date_status', 'class' => 'datepicker form-control', 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'required']) }}
                                    <div class="input-group-addon">
                                        <span class="far fa-calendar-alt"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Apoitment date -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="end_date">{{ __('common.end_date') }}</label>

                                <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                    {{ Form::text('end_date', null, ['id' => 'end_date_status', 'class' => 'datepicker form-control', 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                                    <div class="input-group-addon">
                                        <span class="far fa-calendar-alt"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Prokah number -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="prokah_num">{{__('common.prokah_num')}} <span class="required">*</span></label>

                                {{ Form::text('prokah_num', ((isset($staff) && $staff->prokah) ? null : ''), 
                                    ['id' => 'prokah_num_status', 'class' => 'form-control', 'autocomplete' => 'off', 
                                    'maxlength' => 50, 'required' => true]) }}
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div id="transfer_out_province" class="row d-none">
                                <!-- Province -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="pro_code">@lang('common.province')</label>
                                        <input type="hidden" name="staff_province" value="{{ $staffProCode }}">

                                        {{ Form::select('pro_code', ['' => __('common.choose').' ...'] + $provinces, $staffProCode, 
                                            ['id' => 'pro_code_status', 'class' => 'form-control kh select2']) }}
                                    </div>
                                </div>
                                <!-- Location -->
                                <div id="col-location" class="col-md-12">
                                    <div class="form-group">
                                        <label for="new_location_code">@lang('common.current_location') <span class="required">*</span></label>

                                        {{ Form::select('new_location_code', ['' => __('common.choose').' ...'] + $locations, null, 
                                            ['id' => 'new_location_code', 'class' => 'form-control kh select2', 'required']) }}
                                    </div>
                                </div>
                            </div>

                            <div id="continue_study" class="row d-none">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="pro_code">@lang('common.country')</label>

                                        {{ Form::select('country_id', ['' => __('common.choose').' ...'] + $countries, null, 
                                            ['id' => 'country_id_status', 'class' => 'form-control kh select2']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <a href="{{ route('work-histories.index', [app()->getLocale(), $staff->payroll_id]) }}" 
                        class="btn btn-danger" style="width:150px;" onclick="$('#modalUpdateStaffStatus').modal('hide');loadModalOverlay();">
                        <i class="far fa-times-circle"></i> {{ __('button.cancel') }}
                    </a>

                    <button type="submit" class="btn btn-info" style="width:150px;">
                        <i class="far fa-save"></i> {{ __('button.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
