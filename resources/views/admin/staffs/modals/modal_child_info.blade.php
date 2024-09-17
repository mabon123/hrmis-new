<div class="modal fade" id="modal-child-info">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" id="frmCreateChild" action="{{ route('childrens.store', [app()->getLocale(), $payroll_id]) }}">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('family_info.child_info') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row-box">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="fullname_kh">
                                        {{ __('family_info.child_name') }}
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" name="fullname_kh" id="fullname_kh" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="gender">{{ __('common.sex') }} <span class="required">*</span></label>

                                    <select name="gender" id="gender" class="form-control select2" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        <option value="1">ប្រុស</option>
                                        <option value="2">ស្រី</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="dob">{{ __('common.dob') }} <span class="required">*</span></label>

                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="dob" id="dob" class="datepicker form-control" placeholder="dd-mm-yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label for="occupation">{{ __('common.occupation') }}</label>
                                    <input type="text" name="occupation" id="occupation" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div style="padding-top:38px" class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="allowance" name="allowance" value="1">
                                        <label for="allowance">{{ __('family_info.amount') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:150px;">
                        <i class="far fa-times-circle"></i> {{ __('button.cancel') }}
                    </button>

                    <button type="button" id="btn-save-child" class="btn btn-info" style="width:150px;">
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