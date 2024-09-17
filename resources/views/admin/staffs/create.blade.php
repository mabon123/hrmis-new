@extends('layouts.admin')
@section('content')

<!-- Content Header (Page header) -->
@include('admin.staffs.partials.breadcrumb')

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
                    @if (isset($staff))
                        @include('admin.staffs.partials.header_tab')
                    @else
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active">{{ __('common.personal_details') }}</a>
                            </li>
                        </ul>
                    @endif
                </div>
                
                <div class="card-body custom-card">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-personal_details" role="tabpanel"
                            aria-labelledby="custom-tabs-personal_details-tab">

                            @if ( isset($staff) )
                                {!! Form::model($staff, ['route' => ['staffs.update', [app()->getLocale(), $staff->payroll_id]], 'method' => 'PUT', 'id' => 'frmCreateUpdateTeacher', 'files' => true]) !!}
                            @else
                                {!! Form::open(['route' => ['staffs.store', [app()->getLocale()]], 'method' => 'POST', 'id' => 'frmCreateUpdateTeacher', 'files' => true]) !!}
                            @endif

                                <!-- Personal information -->
                                @include('admin.staffs.partials.personal_info')

                                <!-- Place of birth -->
                                @include('admin.staffs.partials.birthplace_info')
                                
                                <!-- Work history -->
                                <div class="row">
                                    <div id="div_workinfo" class="col-md-12">
                                        <div class="card card-default">
                                            <div class="card-header">
                                                <h3 class="card-title title-work-info">
                                                    <span class="section-num">@lang('number.num3').</span>
                                                    {{ __('common.work_info') }}
                                                </h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            @include('admin.staffs.partials.workhistory_info')
                                        </div>

                                        {{-- @include('admin.staffs.workinfo') --}}
                                    </div>
                                </div>

                                <!-- TCP Profession Rank Information -->
                                @include('admin.staffs.partials.tcp_profession')

                                <!-- Salary info -->
                                @include('admin.staffs.partials.salary_info')

                                <div class="row row-box">
                                    <div class="col-md-12">
                                        <table style="margin:auto;">
                                            <tr>
                                                <td style="padding:5px">
                                                    <button type="button" class="btn btn-danger btn-cancel" style="width:150px;">
                                                        <i class="far fa-times-circle"></i> {{__('button.cancel')}}
                                                    </button>
                                                </td>

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


                            @if (isset($staff))

                                <!-- Modal workhistory -->
                                @include('admin.staffs.modals.workinfo')

                                <!-- Salary modal -->
                                @include('admin.staffs.modals.modal_salary')
                                @include('admin.staffs.modals.modal_tcp_profession')

                            @endif
                            
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>

<input type="hidden" id="districtinfo" value="{{ $districts }}">
<?php /* ?><input type="hidden" id="locationinfo" value="{{ $locations }}"><?php */ ?>

@endsection

@push('scripts')
    
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>
    <script src="{{ asset('js/staff.js') }}"></script>

    <script>

        $(function() {

            $('[data-mask]').inputmask();

            $("#staff-info").addClass("menu-open");
            $("#create-staff > a").addClass("active");
            $("#tab-detail").addClass("active");

            // Validation
            $("#frmCreateUpdateTeacher").validate({
                rules: {
                    payroll_id: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    staff_status_id: "required",
                    surname_kh: "required",
                    name_kh: "required",
                    surname_en: "required",
                    name_en: "required",
                    sex: "required",
                    dob: "required",
                    birth_pro_code: "required",
                    birth_district: "required",
                    salary_level_id: "required",
                    salary_degree: "required",
                    location_code: "required",
                    //official_rank_id: "required",
                    start_date: "required",
                },
                messages: {
                    payroll_id: {
                        required: "{{ __('validation.required_field', ['attribute' => __('common.payroll_num')]) }}",
                        minlength: "{{ __('validation.min.string', ['attribute' => __('common.payroll_num'), 'min' => 10]) }}",
                        maxlength: "{{ __('validation.max.string', ['attribute' => __('common.payroll_num'), 'max' => 10]) }}",
                    },
                    staff_status_id: "{{ __('validation.required_field') }}",
                    surname_kh: "{{ __('validation.required_field') }}",
                    name_kh: "{{ __('validation.required_field') }}",
                    surname_en: "{{ __('validation.required_field') }}",
                    name_en: "{{ __('validation.required_field') }}",
                    sex: "{{ __('validation.required_field') }}",
                    dob: "{{ __('validation.required_field') }}",
                    birth_pro_code: "{{ __('validation.required_field') }}",
                    birth_district: "{{ __('validation.required_field') }}",
                    salary_level_id: "{{ __('validation.required_field') }}",
                    salary_degree: "{{ __('validation.required_field') }}",
                    location_code: "{{ __('validation.required_field') }}",
                    //official_rank_id: "{{ __('validation.required_field') }}",
                    start_date: "{{ __('validation.required_field') }}",
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

            // Create work history validation
            $("#frmCreateWorkHistory").validate({
                rules: {
                    location_code: "required",
                    start_date: "required",
                    position_id: "required",
                },
                messages: {
                    location_code: "{{ __('validation.required_field') }}",
                    start_date: "{{ __('validation.required_field') }}",
                    position_id: "{{ __('validation.required_field') }}",
                },
                submitHandler: function(frm) {
                    var startDate = new Date($('#start_date').val());
                    var endDate = new Date($('#end_date').val());

                    if (endDate < startDate) {
                        $("#alert-section").removeClass("d-none");
                        $("#gte").remove();
                        $("#errors").append("<li id='gte'>{{ __('validation.gte_start_date') }}</li>");
                        $("#end_date").addClass("is-invalid");

                        return false;
                    }
                    
                    $("#modalCreateWorkHistory").hide();
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

            // Create salary validation
            $("#frmCreateSalary").validate({
                rules: {
                    cardre_type_id: "required",
                    salary_level_id: "required",
                    salary_degree: "required",
                    //official_rank_id: "required",
                },
                messages: {
                    cardre_type_id: "{{ __('validation.required_field') }}",
                    salary_level_id: "{{ __('validation.required_field') }}",
                    salary_degree: "{{ __('validation.required_field') }}",
                    //official_rank_id: "{{ __('validation.required_field') }}",
                },
                submitHandler: function(frm) {
                    $("#modalCreateSalary").hide();
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

            // Create salary validation
            $("#frmCreateTCPProfession").validate({
                submitHandler: function(frm) {
                    $("#modalCreateTCPProfession").hide();
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
        });
    </script>
@endpush