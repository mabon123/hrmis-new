<form method="post" id="frmCreateAcademicYear" action="{{ route('academic-years.store', app()->getLocale()) }}">
    @csrf

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{ __('common.create_academic_year') }}</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fas fa-minus"></i></button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md">
                    <div class="form-group">
                        <label for="year_kh">{{ __('common.academic_year_kh') }} 
                            <span class="required">*</span></label>
                        <input type="text" name="year_kh" id="year_kh" value="{{ old('year_kh') }}" 
                            maxlength="30" autocomplete="off" class="form-control kh">
                    </div>
                </div>

                <div class="col-md">
                    <div class="form-group">
                        <label for="year_en">{{ __('common.academic_year_en') }}</label>
                        <input type="text" name="year_en" id="year_en" value="{{ old('year_en') }}" 
                            maxlength="10" autocomplete="off" class="form-control">
                    </div>
                </div>

                <!-- Is current academic year -->
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="cur_year">{{ __('common.cur_academic_year') }}</label>
                        <div class="icheck-primary">
                            {{ Form::checkbox('cur_year', 1, false, ['id' => 'cur_year']) }}
                            <label for="cur_year"></label>
                        </div>
                    </div>
                </div>

                <!-- Academic year start date -->
                <div class="col-md">
                    <div class="form-group">
                        <label for="start_date">{{ __('common.start_date') }}</label>
                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                            {{ Form::text('start_date', null, 
                                ['class' => 'form-control datepicker '.($errors->has('start_date') ? ' is-invalid' : null), 
                                'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 
                                'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 
                                'id' => 'academic_start_date']) 
                            }}
                            <div class="input-group-addon">
                                <span class="far fa-calendar-alt"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic year end date -->
                <div class="col-md">
                    <div class="form-group">
                        <label for="end_date">{{ __('common.end_date') }}</label>
                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                            {{ Form::text('end_date', null, 
                                ['class' => 'form-control datepicker '.($errors->has('end_date') ? ' is-invalid' : null), 
                                'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 
                                'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 
                                'id' => 'academic_end_date']) 
                            }}
                            <div class="input-group-addon">
                                <span class="far fa-calendar-alt"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="button" id="btn-reset" class="btn btn-danger" 
                data-add-url="{{ route('academic-years.store', app()->getLocale()) }}" style="width:150px;">
                <i class="far fa-times-circle"></i>&nbsp;{{ __('button.reset') }}
            </button>

            <button type="submit" class="btn btn-info" style="width:150px;">
                <i class="far fa-save"></i>&nbsp;{{ __('button.save') }}
            </button>
        </div>
    </div>
</form>