@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.new_schedule_course') }}
                </h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @include('admin.validations.validate')
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card card-info card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active">{{ __('common.basic_info') }}</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body custom-card">
                    <div class="tab-content">
                        <div class="tab-pane fade show active">

                            @if ( isset($cpd_schedule_course) )
                            {!! Form::model(
                            $cpd_schedule_course,
                            ['route' => ['cpd-schedule-courses.update', [app()->getLocale(), $cpd_schedule_course->schedule_course_id]],
                            'method' => 'PUT',
                            'id' => 'frmCreateCPDScheduleCourse'])
                            !!}
                            @else
                            {!! Form::open(
                            ['route' => ['cpd-schedule-courses.store', [app()->getLocale()]],
                            'method' => 'POST',
                            'id' => 'frmCreateCPDScheduleCourse'])
                            !!}
                            @endif

                            @if (auth()->user()->hasRole('administrator'))
                            <div class="row">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        {{ Form::checkbox('is_mobile', '1', (isset($cpd_schedule_course) ? $cpd_schedule_course->is_mobile : true), ['id' => 'is_mobile']) }}
                                        <label for="is_mobile">@lang('cpd.reg_cpd_via_mobile')</label>
                                    </div>
                                </div>
                            </div>
                            @else
                            {{ Form::hidden('is_mobile', '1') }}
                            @endif

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group {{ $errors->has('cpd_course_id') ? 'has-error' : null }}">
                                        <label for="cpd_course_id">@lang('cpd.course') <span class="required">*</span></label>

                                        {{ Form::select(
                                            'cpd_course_id', 
                                            ['' => __('common.choose'). '...'] + $courses, null, 
                                            ['id' => 'cpd_course_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                        }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="target_audience">{{ __('cpd.target_audience') }}
                                            <span class="required">*</span></label>
                                        <div class="select2-blue">
                                            {{ Form::select('target_audiences[]', $positions, (isset($cpd_schedule_course) ? $audiences : null), 
                                                [
                                                    'id' => 'position_id', 'class' => 'select2 kh', 'style' => 'width:100%;', 
                                                    'multiple' => 'multiple', 'data-dropdown-css-class' => 'select2-blue', 
                                                    'required' => true,
                                                ]) 
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="participant_num">@lang('cpd.participant_num')
                                            <span class="required">*</span></label>

                                        {{ Form::number('participant_num', null, ['id' => 'participant_num', 'class' => 'form-control', 'required' => true]) }}
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="qualification_code">@lang('common.qualification')
                                            <span class="required">*</span></label>

                                        {{ Form::select(
                                            'qualification_code', 
                                            ['' => __('common.choose').' ...'] + $qualifications, null, 
                                            ['id' => 'qualification_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
                                                'required' => true]) 
                                        }}
                                    </div>
                                </div>

                                <!-- Registration Start Date -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="reg_start_date">@lang('cpd.registration_start_date')
                                            <span class="required">*</span></label>

                                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                            {{ Form::text('reg_start_date', null, ['id' => 'reg_start_date', 'class' => 'form-control datepicker '.($errors->has('reg_start_date') ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'placeholder' => 'dd-mm-yyyy']) }}
                                            <div class="input-group-addon">
                                                <span class="far fa-calendar-alt"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Registration End Date -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="reg_end_date">@lang('cpd.registration_end_date')
                                            <span class="required">*</span></label>

                                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                            {{ Form::text('reg_end_date', null, ['id' => 'reg_end_date', 'class' => 'form-control datepicker '.(($errors->has('reg_end_date') or $errors->has('reg_date_error')) ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'placeholder' => 'dd-mm-yyyy']) }}
                                            <div class="input-group-addon">
                                                <span class="far fa-calendar-alt"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="start_date">@lang('cpd.start_date') <span class="required">*</span></label>

                                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                            {{ Form::text('start_date', null, ['class' => 'form-control datepicker '.($errors->has('start_date') ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'placeholder' => 'dd-mm-yyyy']) }}
                                            <div class="input-group-addon">
                                                <span class="far fa-calendar-alt"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="end_date">@lang('cpd.end_date') <span class="required">*</span></label>

                                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                            {{ Form::text('end_date', null, ['class' => 'form-control datepicker '.(($errors->has('end_date') or $errors->has('date_error')) ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'placeholder' => 'dd-mm-yyyy']) }}
                                            <div class="input-group-addon">
                                                <span class="far fa-calendar-alt"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group {{ $errors->has('learning_option_id') ? 'has-error' : null }}">
                                        <label for="learning_option">
                                            @lang('cpd.learning_option') <span class="required">*</span>
                                        </label>

                                        {{ Form::select(
                                            'learning_option_id', 
                                            ['' => __('common.choose').' ...'] + $learningOptions, null, 
                                            ['id' => 'learning_option', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                        }}
                                    </div>
                                </div>

                                <!-- Province -->
                                <div class="col-sm-3">
                                    <div class="form-group {{ $errors->has('pro_code') ? 'has-error' : null }}">
                                        <label for="pro_code">@lang('common.province') <span id="required_pro_code" class="required">*</span></label>
                                        {{ Form::select(
                                            'pro_code', 
                                            ['' => __('common.choose').' ...'] + $provinces, null, 
                                            ['id' => 'pro_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%']) 
                                        }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="dis_code">@lang('common.district')</label>
                                        {{ Form::select(
                                            'dis_code', 
                                            ['' => __('common.choose').' ...'] + $districts, 
                                            (isset($cpd_schedule_course) ? $cpd_schedule_course->dis_code : null), 
                                            ['id' => 'dis_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%', 'disabled' => (!empty($districts) ? false : true)]) 
                                        }}
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">@lang('cpd.course_location')</label>
                                        {{ Form::text('address', null, ['id' => 'address', 'class' => 'form-control kh', 'autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group {{ $errors->has('partner_type_id') ? 'has-error' : null }}">
                                        <label for="partner_type_id">@lang('cpd.funder') <span class="required">*</span></label>

                                        {{ Form::select(
                                            'partner_type_id', 
                                            ['' => __('common.choose').' ...'] + $partners, null, 
                                            ['id' => 'partner_type_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                        }}
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group {{ $errors->has('provider_id') ? 'has-error' : null }}">
                                        <label for="provider_id">@lang('menu.cpd_provider') <span class="required">*</span></label>
                                        {{ Form::select(
                                            'provider_id', 
                                            $providers, null, 
                                            ['id' => 'provider_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                        }}
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="teacher_educator">@lang('cpd.teacher_educator')</label>
                                        {{ Form::text('teacher_educator', null, ['id' => 'teacher_educator', 'class' => 'form-control kh']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                </div>

                                <div class="col-md-12">
                                    <table style="margin:auto;">
                                        <tr>
                                            <td style="padding:5px">
                                                <button type="submit" class="btn btn-info btn-save" style="width:150px;">
                                                    <i class="far fa-save"></i> {{ __('button.save') }}
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')

<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

<script>
    $(function() {

        $('[data-mask]').inputmask();

        $("#schedule-course").addClass("menu-open");
        $("#create-schedule-course > a").addClass("active");

        // If online class => disable province
        if ($("#learning_option").val() == 1) {
            $('#pro_code').prop('disabled', true);
            $("#required_pro_code").addClass("d-none");
            $('#dis_code').prop('disabled', true);
            $('#address').prop('disabled', true);
        }

        // Validation
        $("#frmCreateCPDScheduleCourse").validate({
            rules: {
                cpd_course_id: "required",
                reg_start_date: "required",
                reg_end_date: "required",
                start_date: "required",
                end_date: "required",
                learning_option_id: "required",
                pro_code: "required",
                partner_type_id: "required",
                provider_id: "required",
                participant_num: "required",
                qualification_code: "required",
            },
            messages: {
                cpd_course_id: "{{ __('validation.required_field') }}",
                reg_start_date: "{{ __('validation.required_field') }}",
                reg_end_date: "{{ __('validation.required_field') }}",
                start_date: "{{ __('validation.required_field') }}",
                end_date: "{{ __('validation.required_field') }}",
                learning_option_id: "{{ __('validation.required_field') }}",
                pro_code: "{{ __('validation.required_field') }}",
                partner_type_id: "{{ __('validation.required_field') }}",
                provider_id: "{{ __('validation.required_field') }}",
                participant_num: "{{ __('validation.required_field') }}",
                qualification_code: "{{ __('validation.required_field') }}",
            },
            submitHandler: function(frm) {
                loadModalOverlay();
                frm.submit();
            },
            invalidHandler: function(event, validator) {
                var errors = validator.numberOfInvalids();

                if (errors) {
                    toastMessage("bg-danger", "{{ __('validation.error_message') }}");
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $(element).closest('.form-group').removeClass('has-error');
            }
        });

        // Learning Option
        $('#learning_option').change(function() {
            // Online class
            if ($(this).val() == 1) {
                $('#pro_code').prop('disabled', true);
                $("#required_pro_code").addClass("d-none");
                $('#address').prop('disabled', true);
            } else {
                $('#pro_code').prop('disabled', false);
                $("#required_pro_code").removeClass("d-none");
                $('#address').prop('disabled', false);
            }
        });

        function checkMobile(checkbox) {
            if (checkbox.is(":checked")) {
                $("#reg_start_date").removeAttr('disabled');
                $("#reg_start_date").attr('required', 'true');
                $("#reg_end_date").removeAttr('disabled');
                $("#reg_end_date").attr('required', 'true');
            } else {
                $("#reg_start_date").val('');
                $("#reg_end_date").val('');

                $("#reg_start_date").removeAttr('required');
                $("#reg_start_date").attr('disabled', 'true');
                $("#reg_end_date").removeAttr('required');
                $("#reg_end_date").attr('disabled', 'true');
            }
        }

        if ($('#is_mobile').length) {
            checkMobile($('#is_mobile'));
        }

        $('#is_mobile').change(function() {
            checkMobile($(this));
        });

    });
</script>

@endpush