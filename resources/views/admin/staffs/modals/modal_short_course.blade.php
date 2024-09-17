<div class="modal fade" id="modal-short-course">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            {!! Form::open(['route' => ['shortcourses.store', [app()->getLocale(), $staff->payroll_id]], 'method' => 'POST', 'id' => 'frmCreateShortCourse']) !!}

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.short_course') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="alert-section" class="alert alert-danger d-none">
                        <ul id="errors" style="margin-bottom:0;"></ul>
                    </div>
                    
                    <div class="row-box">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="shortcourse_cat_id">
                                        {{ __('common.category') }} <span class="required">*</span>
                                    </label>

                                    <select name="shortcourse_cat_id" id="shortcourse_cat_id" class="form-control select2" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        
                                        @foreach($shortCourseCats as $shortCourseCat)
                                            <option value="{{ $shortCourseCat->shortcourse_cat_id }}">
                                                {{ $shortCourseCat->shortcourse_cat_kh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="qualification">
                                        {{ __('common.skill') }} <span class="required">*</span>
                                    </label>

                                    <input type="text" name="qualification" id="shortcourse_skill" class="form-control kh">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="qual_date">{{ __('common.date_obtained') }} <span 
                                        class="required">*</span></label>

                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="qual_date" id="qual_date" class="datepicker form-control" placeholder="dd-mm-yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="start_date">
                                        {{ __('common.start_date') }} <span class="required">*</span>
                                    </label>

                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="start_date" id="start_date" class="form-control" placeholder="dd-mm-yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="end_date">
                                        {{ __('common.end_date') }} <span class="required">*</span>
                                    </label>

                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="end_date" id="end_date" class="form-control" placeholder="dd-mm-yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="duration">{{ __('common.duration') }}<span 
                                        class="required">*</span></label>

                                    <input type="number" name="duration" id="duration" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="duration_type_id">@lang('common.duration_type') <span 
                                        class="required">*</span></label>

                                    <select name="duration_type_id" id="duration_type_id" class="form-control select2" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        
                                        @foreach($durationTypes as $durationType)
                                            <option value="{{ $durationType->dur_type_id }}">
                                                {{ $durationType->dur_type_kh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="organized">{{ __('common.organised_by') }} <span class="required">*</span></label>

                                    <select name="organized" id="organized" class="form-control select2" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        
                                        @foreach($trainingPartnerTypes as $trainingPartnerType)
                                            <option value="{{ $trainingPartnerType->partner_type_id }}">
                                                {{ $trainingPartnerType->partner_type_kh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="donor">{{ __('common.donor') }} <span class="required">*</span></label>

                                    <select name="donor" id="donor" class="form-control select2" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        
                                        @foreach($trainingPartnerTypes as $trainingPartnerType)
                                            <option value="{{ $trainingPartnerType->partner_type_id }}">
                                                {{ $trainingPartnerType->partner_type_kh }}
                                            </option>
                                        @endforeach
                                    </select>
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
            {{ Form::close() }}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal work info -->
