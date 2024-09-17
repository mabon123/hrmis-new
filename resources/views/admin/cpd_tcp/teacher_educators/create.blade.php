@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.cpd_teacher_educator') }}
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

                            @if ( isset($cpd_teacher_educator) )
                                {!! Form::model($cpd_teacher_educator, ['route' => ['cpd-teacher-educators.update', 
                                    [app()->getLocale(), $cpd_teacher_educator->teacher_educator_id]], 'method' => 'PUT', 
                                    'id' => 'frmCreateCPDTeacherEducator']) !!}
                            @else
                                {!! Form::open(['route' => ['cpd-teacher-educators.store', [app()->getLocale()]], 
                                    'method' => 'POST', 'id' => 'frmCreateCPDTeacherEducator']) !!}
                            @endif

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="payroll_id">
                                            {{ __('common.payroll_num') }}
                                            <span class="required">*</span>
                                        </label>

                                        {{ Form::text('payroll_id', null, ['id' => 'payroll_id', 'class' => 'form-control ' . 
                                            ($errors->has('payroll_id') ? 'is-invalid' : null), 
                                            "data-inputmask" => "'mask':'9999999999'", "data-mask"]) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group @error('sex') has-error @enderror">
                                        <label for="sex">
                                            {{ __('common.sex') }}
                                        </label>

                                        {{ Form::select('sex', ['' => __('common.choose').' ...', '1' => 'ប្រុស', '2' => 'ស្រី'], null, ['class' => 'form-control kh select2', 'style' => 'width:100%;', 'id' => 'sex', 'disabled' => true]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name_kh">@lang('common.name')</label>

                                        {{ Form::text('name_kh', null, ['id' => 'name_kh', 'class' => 'form-control kh', 
                                            'maxlength' => 90, 'autocomplete' => 'off', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name_en">@lang('common.fullname_en')</label>

                                        {{ Form::text('name_en', null, ['id' => 'name_en', 'class' => 'form-control kh', 
                                            'maxlength' => 60, 'autocomplete' => 'off', 'disabled' => true]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="phone_number">{{ __('common.telephone') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" name="phone_number" id="phone_number" class="form-control"
                                            disabled=true data-inputmask="'mask': ['999-999-9999', '+855 99 999 9999']"
                                            data-mask>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="teps_position_id">{{ __('cpd.position_to_teps') }} <span 
                                            class="required">*</span></label>
                                        {{ Form::select('teps_position_id', [
                                            '' => __('common.choose').' ...'] + $tempPositions, null, 
                                            ['id' => 'teps_position_id', 'class' => 'form-control kh select2', 
                                            'style' => 'width:100%;']) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="courses_certified">{{ __('cpd.courses_certified') }} (multiple
                                        select) <span class="required">*</span></label>
                                    <div class="select2-blue" style="{{ $errors->has('course_ids') ? 'border:1px red solid;' : '' }}">
                                        {{ Form::select('course_ids[]', $courses, (isset($cpd_teacher_educator) ? $selectedCourse : null), 
                                            ['id' => 'course_ids', 'class' => 'select2', 'multiple' => 'multiple', 
                                            'data-placeholder' => 'Select a State', 
                                            'data-dropdown-css-class' => 'select2-blue', 
                                            'style' => 'width:100%;']) }}
                                    </div>
                                </div>
                            </div>
                            <br /><br />
                            <div class="row">
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

<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

<script>
$(function() {

    $('[data-mask]').inputmask();

    $("#teacher-educator").addClass("menu-open");
    $("#create-educator > a").addClass("active");

    // Validation
    $("#frmCreateCPDTeacherEducator").validate({
        rules: {
            payroll_id: "required",
            teps_position_id: "required",
        },
        messages: {
            payroll_id: "{{ __('validation.required_field') }}",
            teps_position_id: "{{ __('validation.required_field') }}",
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
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    // Event on payroll id
    $("#payroll_id").on("blur", function() {
        $.ajax({
            type: "GET",
            url: "/staff/" + $(this).val(),
            success: function (staff) {
                var gender = staff.sex == 1 ? 'ប្រុស' : 'ស្រី';
                
                $("#name_kh").val(staff.surname_kh +" "+ staff.name_kh);
                $("#name_en").val(staff.surname_en +" "+ staff.name_en);
                $("#phone_number").val(staff.phone);
                $("#select2-sex-container").text(gender);
            },
            error: function (err) {
                console.log('Error:', err);
            }
        });
    });

    if ($("#payroll_id").val() != "") {
        $("#payroll_id").trigger("blur");
    }

});
</script>

@endpush