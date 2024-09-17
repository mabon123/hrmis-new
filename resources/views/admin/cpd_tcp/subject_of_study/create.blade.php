@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.subject_of_study') }}
                </h1>
            </div>
            <?php /* ?><div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.contract_teacher_info') }}</li>
                    <li class="breadcrumb-item active">{{ __('menu.new_contract_teacher') }}</li>
                </ol>
            </div><?php */ ?>
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
                            @if ( isset($subject_of_study) )
                                {!! Form::model($subject_of_study, ['route' => ['subject-of-study.update', [app()->getLocale(), $subject_of_study->cpd_subject_id]], 'method' => 'PUT', 'id' => 'frmCreateSubjectOfStudy']) !!}
                            @else
                                {!! Form::open(['route' => ['subject-of-study.store', [app()->getLocale()]], 'method' => 'POST', 'id' => 'frmCreateSubjectOfStudy']) !!}
                            @endif

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="cpd_subject_code">@lang('cpd.subject_code') <span
                                                class="required">*</span></label>

                                        {{ Form::text('cpd_subject_code', null, ['id' => 'cpd_subject_code', 'class' => 'form-control', 'autocomplete' => 'off', 'maxlength' => 10]) }}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="cpd_subject_kh">@lang('cpd.subject_kh') <span
                                                class="required">*</span></label>

                                        {{ Form::text('cpd_subject_kh', null, ['id' => 'cpd_subject_kh', 'class' => 'form-control kh', 'autocomplete' => 'off', 'maxlength' => 200]) }}
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="cpd_subject_en">@lang('cpd.subject_en')</label>

                                        {{ Form::text('cpd_subject_en', null, ['id' => 'cpd_subject_en', 'class' => 'form-control kh', 'autocomplete' => 'off', 'maxlength' => 70]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="cpd_field_id">@lang('cpd.field_of_study')<span
                                                class="required">*</span></label></label>

                                        {{ Form::select('cpd_field_id', ['' => __('common.choose'). '...'] + $fieldOfStudies, null, ['id' => 'cpd_field_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 'required' => true]) }}
                                    </div>

                                </div>
                                <?php /* ?><div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="credits">@lang('cpd.credits') <span
                                                class="required">*</span></label>

                                        {{ Form::number('credits', null, ['id' => 'credits', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="end_date">@lang('common.end_date') <span
                                                class="required">*</span></label>

                                        <div class="input-group date" data-provide="datepicker"
                                            data-date-format="dd-mm-yyyy">
                                            {{ Form::text('end_date', null, ['class' => 'form-control datepicker '.($errors->has('end_date') ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'placeholder' => 'dd-mm-yyyy']) }}
                                            <div class="input-group-addon">
                                                <span class="far fa-calendar-alt"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php */ ?>
                                <div class="col-sm-1">
                                    <div class="form-group clearfix" style="margin-top:40px;">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="active" name="active" value="1" checked>
                                            <label for="active">{{__('login.active')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="cpd_subject_desc_kh">@lang('cpd.subject_desc_kh') <span
                                                class="required">*</span></label>

                                        {{ Form::textarea(
                                            'cpd_subject_desc_kh', null, 
                                            [
                                                'id' => 'cpd_subject_desc_kh', 
                                                'class' => 'form-control kh summernote', 
                                                'style' => 'width:100%;font-size:14px;line-height:18px;border:1px solid #dddddd;padding:10px;'
                                            ]) 
                                        }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="cpd_subject_desc_en">@lang('cpd.subject_desc_en')</label>

                                        {{ Form::textarea(
                                            'cpd_subject_desc_en', null, 
                                            [
                                                'id' => 'cpd_subject_desc_en', 'class' => 'form-control en summernote', 
                                                'style' => 'width:100%;font-size:14px;line-height:18px;border:1px solid #dddddd;padding:10px;'
                                            ]) 
                                        }}
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
                                                <button type="submit" class="btn btn-info btn-save"
                                                    style="width:150px;">
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

<script>
$(function() {
    $("#subject-study").addClass("menu-open");
    $("#create-subject-study > a").addClass("active");
    $('.summernote').summernote({height:120});

    // Validation
    $("#frmCreateSubjectOfStudy").validate({
        rules: {
            cpd_subject_code: "required",
            cpd_subject_kh: "required",
            cpd_field_id: "required",
        },
        messages: {
            cpd_subject_code: "{{ __('validation.required_field') }}",
            cpd_subject_kh: "{{ __('validation.required_field') }}",
            cpd_field_id: "{{ __('validation.required_field') }}",
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

});
</script>

@endpush