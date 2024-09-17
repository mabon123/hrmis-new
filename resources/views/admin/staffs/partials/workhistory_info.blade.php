<div class="card-body" style="padding-bottom:0;">
    <div class="row">
        <!-- Start date -->
        <div class="col-sm-3">
            <div class="form-group">
                <label for="start_date">
                    {{ __('common.datestart_work') }}
                    <span class="required">*</span>
                </label>

                <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                    {{ Form::text('start_date', null, ['id' => 'start_work_date', 'class' => 'datepicker form-control '.($errors->has('start_date') ? 'is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                    <div class="input-group-addon">
                        <span class="far fa-calendar-alt"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Apoitment date -->
        <div class="col-sm-3">
            <div class="form-group">
                <label for="appointment_date">
                    {{__('common.appointment_date')}}
                </label>

                <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                    {{ Form::text('appointment_date', null, ['id' => 'appointment_date', 'class' => 'datepicker form-control', 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                    <div class="input-group-addon">
                        <span class="far fa-calendar-alt"></span>
                    </div>
                </div>
            </div>
        </div>

        @if (!isset($staff))

            <!-- Current location -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="location_code">
                        {{ __('common.current_location') }}
                        <span class="required">*</span>
                    </label>

                    {{ Form::select('location_code', ['' => __('common.choose').' ...'] + $locations, null, ['id' => 'location_code', 'class' => 'form-control select2 kh '.($errors->has('location_code') ? 'is-invalid' : null), 'data-old-value' => old('location_code')]) }}
                </div>
            </div>

            <!-- Admin office -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="sys_admin_office_id">
                        {{ __('common.office') }}
                    </label>

                    {{ Form::select('sys_admin_office_id', ['' => __('common.choose').' ...'], null, ['id' => 'sys_admin_office_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 'data-old-value' => old('sys_admin_office_id'), 'disabled' => true]) }}
                </div>
            </div>

            <!-- Position -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="position_id">
                        {{ __('common.position') }}
                    </label>

                    {{ Form::select('position_id', ['' => __('common.choose').' ...'] + $positions, null, ['id' => 'position_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                </div>
            </div>

            <!-- Equal position -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="additional_position_id">{{ __('common.position_equal') }}</label>

                    {{ Form::select('additional_position_id', ['' => __('common.choose').' ...'] + $positions, null, ['id' => 'additional_position_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                </div>
            </div>

            <!-- Prokah -->
            <div class="form-group col-2 col-sm-3 col-md-auto mr-md-3">
                <label for="prokah">@lang('common.prokah')</label>

                <div class="icheck-primary">
                    {{ Form::checkbox('prokah', 1, true, ['id' => 'prokah']) }}
                    <label for="prokah"></label>
                </div>
            </div>

            <!-- Prokah number -->
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="prokah_num">{{__('common.prokah_num')}}</label>

                    {{ Form::text('prokah_num', ((isset($staff) && $staff->prokah) ? null : ''), 
                        ['id' => 'prokah_num', 'class' => 'form-control', 'autocomplete' => 'off', 
                            'disabled' => (isset($staff) ? !$staff->prokah : true), 'maxlength' => 20]) 
                    }}
                </div>
            </div>

            <?php /* ?><div class="form-group col-sm">
                <label for="customFile">@lang('common.prokah_attachment')</label>

                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="prokah_attachment" id="prokah_attachment" accept="application/pdf" disabled>
                        <label class="custom-file-label" for="prokah_attachment">@lang('common.choose_file') ...</label>
                    </div>

                    @if(isset($location) && $location->prokah && $location->ref_doc && file_exists(public_path($location->ref_doc)))
                        <div class="input-group-append">
                            <a href="{{ url($location->ref_doc) }}" target="_BLANK" class="input-group-text"><span>@lang('common.view_file')</span></a>
                        </div>
                    @endif
                </div>
            </div><?php */ ?>

            <!-- Main duty -->
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="main_duty">{{__('common.description')}}</label>

                    {{ Form::textarea('main_duty', null, ['class' => 'form-control kh', 'id' => 'main_duty', 'rows' => 2]) }}
                </div>
            </div>

        @endif

    </div>


    <!-- Staff work history listing -->
    @if (isset($staff) and isset($lastWorkHist))

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                <thead>
                    <tr>
                        <th>@lang('common.description')</th>
                        <th>@lang('common.location')</th>
                        <th>@lang('common.cur_position')</th>
                        <th>@lang('common.start_date')</th>
                        <th>@lang('common.end_date')</th>
                    </tr>
                </thead>

                <tbody>
                    <tr id="record-{{ $lastWorkHist->workhis_id }}">
                        <td class="kh">{{ $lastWorkHist->description }}</td>
                        <td class="kh">
                            {{ !empty($lastWorkHist->location) ? $lastWorkHist->location->location_kh : '---' }}
                            {{ !empty($lastWorkHist->province) ? ' រាជធានី/ខេត្ត'.$lastWorkHist->province->name_kh : '' }}
                        </td>
                        <td class="kh">{{ !empty($lastWorkHist->position) ? $lastWorkHist->position->position_kh : '---' }}</td>
                        <td>{{ $lastWorkHist->start_date > 0 ? date('d-m-Y', strtotime($lastWorkHist->start_date)) : '' }}</td>
                        <td>{{ $lastWorkHist->end_date > 0 ? date('d-m-Y', strtotime($lastWorkHist->end_date)) : '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    @endif

</div>

@if (isset($staff))

    <div class="card-footer text-right">
        <button type="button" class="btn btn-sm btn-primary" id="btn-add-workhistory" data-add-url="{{ route('workHistory.store', [app()->getLocale(), $staff->payroll_id]) }}" style="width:120px;">
            <i class="fa fa-plus"></i> @lang('button.add')
        </button>
    </div>

@endif
