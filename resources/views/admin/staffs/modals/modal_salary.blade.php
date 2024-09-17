<div class="modal fade" id="modalCreateSalary">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="post" id="frmCreateSalary" action="{{ route('salary-histories.store', [app()->getLocale()]) }}">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.salary_info') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <input type="hidden" name="payroll_id" value="{{ $staff->payroll_id }}">
                {{ Form::hidden('location_code', ((isset($lastWorkHist) and !empty($lastWorkHist->location)) ? $lastWorkHist->location->location_code : ''), ['id' => 'location_code2', 'class' => 'form-control kh']) }}

                <div class="modal-body">
                    <div class="row-box">
                        <div class="row">
                            <!-- Cardre -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="cardre_type_id">@lang('staff.cardretype') 
                                        <span class="required">*</span></label>

                                    {{ Form::select('cardre_type_id', ['' => __('common.choose').' ...'] + $cardretypes, null, ['id' => 'cardre_type_id', 'class' => 'rm-control kh select2', 'required' => true]) }}
                                </div>
                            </div>

                            <!-- Salary level -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="salary_level_id">
                                        {{ __('common.salary_type') }} <span class="required">*</span>
                                    </label>

                                    {{ Form::select('salary_level_id', ['' => __('common.choose').' ...'] + $salaryLevels, null, ['id' => 'salary_level_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                                </div>
                            </div>

                            <!-- Salary degree -->
                            @php
                                $salary_degrees = ['១' => '១', '២' => '២', '៣' => '៣', '៤' => '៤', '៥' => '៥', 
                                    '៦' => '៦', '៧' => '៧', '៨' => '៨', '៩' => '៩', '១០' => '១០'];
                            @endphp
                            <div class="col-sm-4">
                                <div class="form-group @error('salary_degree') has-error @enderror">
                                    <label for="salary_degree">{{ __('common.degree') }} 
                                        <span class="required">*</span></label>

                                    {{ Form::select('salary_degree', ['' => __('common.choose').' ...'] + $salary_degrees, null, 
                                        ['id' => 'salary_degree', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
                                            'required' => true]) 
                                    }}
                                </div>
                            </div>

                            <!-- Official rank -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="official_rank_id">{{ __('common.status') }}</label>

                                    {{ Form::select('official_rank_id', ['' => __('common.choose').' ...'], null, ['id' => 'official_rank_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                                </div>
                            </div>

                            <!-- Salary type shift data -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="salary_type_shift_date">{{ __('common.promotion_date') }}</label>

                                    <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                        {{ Form::text('salary_type_shift_date', null, ['id' => 'salary_type_shift_date', 'class' => 'form-control datepicker', 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sign date -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="salary_type_signdate">{{ __('common.sign_date') }}</label>

                                    <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                        {{ Form::text('salary_type_signdate', null, ['id' => 'salary_type_signdate', 'class' => 'form-control datepicker', 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Prokah number -->
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="salary_type_prokah_num">{{ __('common.code_num') }}</label>
                                    
                                    {{ Form::text('salary_type_prokah_num', null, 
                                        ['id' => 'salary_type_prokah_num', 'class' => 'form-control', 'maxlength' => 50]) 
                                    }}
                                </div>
                            </div>

                            <!-- Rank number -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="salary_type_prokah_order">
                                        {{ __('common.rank_num') }}
                                    </label>

                                    {{ Form::number('salary_type_prokah_order', null, ['id' => 'salary_type_prokah_order', 'class' => 'form-control']) }}
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