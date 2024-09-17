<div class="modal fade" id="modalLeaveInfo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" id="frmCreateLeave" action="{{ route('leaves.store', [app()->getLocale(), $payroll_id]) }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('common.maternity_leave')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row-box">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="fullname_kh">@lang('common.maternity_leave') 
                                        <span class="required">*</span></label>

                                    {{ Form::select('leave_type_id', ['' => __('common.choose').' ...'] + $leaveTypes, null, 
                                        ['id' => 'leave_type_id', 'class' => 'form-control select2 kh', 'required' => true]) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_date">{{ __('common.start_date') }} <span class="required">*</span></label>

                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="start_date" id="start_date_leave" class="datepicker form-control" placeholder="dd-mm-yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask required>
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="end_date">{{ __('common.end_date') }} <span class="required">*</span></label>

                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="end_date" id="end_date_leave" class="datepicker form-control" placeholder="dd-mm-yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask required>
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php /* ?><div class="row">
                            <!-- Prokah -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="prokah_leave">@lang('common.prokah')</label>

                                    <div class="icheck-primary">
                                        {{ Form::checkbox('prokah', 1, null, ['id' => 'prokah_leave']) }}
                                        <label for="prokah_leave">@lang('school.has')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Prokah number -->
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="prokah_num">{{__('common.prokah_num')}}</label>

                                    {{ Form::text('prokah_num', ((isset($staff) && $staff->prokah) ? null : ''), ['id' => 'prokah_num_leave', 'class' => 'form-control', 'autocomplete' => 'off', 'disabled' => true]) }}
                                </div>
                            </div>
                        </div><?php */ ?>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="description">{{ __('common.description') }} <span class="required">*</span></label>
                                    <textarea name="description" id="description" rows="5" class="form-control kh" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:150px;">
                        <i class="far fa-times-circle"></i> {{ __('button.cancel') }}
                    </button>

                    <button type="submit" id="btn-save-leave" class="btn btn-info" style="width:150px;">
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