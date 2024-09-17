<form method="post" id="frmCreateAdmiration" action="{{ route('admirations.store', [app()->getLocale(), $staff->payroll_id]) }}" enctype="multipart/form-data">
    @csrf

    <div class="modal fade" id="modal-admiration">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.admiration') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="admiration_type_id">
                                        {{ __('common.admiration_type') }}
                                        <span class="required">*</span>
                                    </label>

                                    <select class="form-control select2" name="admiration_type_id" id="admiration_type_id" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>

                                        @foreach($admirationTypes as $admirationType)
                                            
                                            <option value="{{ $admirationType->admiration_type_id }}">
                                                {{ $admirationType->admiration_type_kh }}
                                            </option>

                                        @endforeach

                                        <option value="0">--- ផ្សេងៗ ---</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="admiration_source_id">
                                        {{ __('common.provided_by') }} <span class="required">*</span>
                                    </label>

                                    <select name="admiration_source_id" id="admiration_source_id" class="form-control select2" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>

                                        @foreach($admirationSources as $admirationSource)

                                            <option value="{{ $admirationSource->source_id }}">
                                                {{ $admirationSource->source_kh }}
                                            </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Prokah number -->
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="prokah_num">@lang('common.prokah_num')</label>
                                    <input type="text" name="prokah_num" id="prokah_num" maxlength="50" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="admiration_date">
                                        {{ __('common.date_obtained') }}
                                        <span class="required">*</span>
                                    </label>

                                    <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                        <input type="text" autocomplete="off" name="admiration_date" id="admiration_date" class="datepicker form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Prokah attach document -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="prokah_doc">
                                        @lang('common.prokah_attachment')
                                        <strong><span id="ref-name"></span></strong>
                                    </label>
                                    <input type="file" class="form-control" name="prokah_doc" id="prokah_doc">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="admiration">{{__('common.description')}}</label>
                                    <textarea name="admiration" id="admiration" rows="3" class="form-control"></textarea>
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
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal work info -->

</form>
