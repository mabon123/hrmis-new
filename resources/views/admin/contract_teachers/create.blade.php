@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.contract_teacher_info') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('contract-teachers.index', app()->getLocale()) }}">
                                <i class="nav-icon fas fa-users"></i> {{ __('menu.contract_teacher_info') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.new_contract_teacher') }}</li>
                </ol>

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
                @if (isset($contract_teacher))
                    <div class="card-header p-0 pt-1">
                        @include('admin.contract_teachers.header_tab')
                    </div>
                @else
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active">{{ __('menu.contract_teacher_info') }}</a>
                            </li>
                        </ul>
                    </div>
                @endif
                
                <div class="card-body custom-card">
                    <div class="tab-content">
                        <div class="tab-pane fade show active">
                            
                            @if ( isset($contract_teacher) )
                                {!! Form::model($contract_teacher, 
                                    ['route' => ['contract-teachers.update', [app()->getLocale(), $contract_teacher->payroll_id]], 
                                    'method' => 'PUT', 'id' => 'frmCreateUpdateContTeacher', 'enctype' => 'multipart/form-data']) 
                                !!}
                            @else
                                {!! Form::open(['route' => ['contract-teachers.store', [app()->getLocale()]], 'method' => 'POST', 'id' => 'frmCreateUpdateContTeacher', 'files' => true]) !!}
                            @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>{{ __('common.basic_info') }}</h4>

                                        @include('admin.contract_teachers.partials.general_info')
                                    </div>

                                    <!-- Place of Birth -->
                                    <div class="col-md-12">
                                        <h4>
                                            <span class="section-num">@lang('number.num4'). </span>
                                            {{ __('common.pob') }}
                                        </h4>

                                        @include('admin.contract_teachers.partials.birthplace_info')
                                    </div>

                                    <!-- Qualification -->
                                    <div class="col-md-12">
                                        <h4>
                                            <span class="section-num">{{ __('number.num5') }}. </span>
                                            {{ __('common.qualification') }}
                                        </h4>

                                        @include('admin.contract_teachers.partials.qualification_info')
                                    </div>

                                    <!-- Work History -->
                                    <div id="div_workinfo" class="col-md-12">
                                        <div class="card card-default">
                                            <div class="card-header">
                                                <h3 class="card-title title-work-info">{{ __('common.work_info') }}</h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            @include('admin.contract_teachers.partials.workhistory_info')
                                        </div>
                                        <!-- /.card -->
                                    </div>

                                    <!-- Address info section -->
                                    <div class="col-md-12">
                                        <div class="row-box">
                                            <h4>
                                                <span class="section-num">{{ __('number.num10') }}.</span>
                                                {{ __('common.current_address') }}
                                            </h4>

                                            @include('admin.contract_teachers.partials.address_info')
                                        </div>
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

                            @if (isset($contract_teacher))
                                <!-- Modal work history -->
                                @include('admin.contract_teachers.partials.modal_workhistory')
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

@endsection

@push('scripts')
    
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

    <script src="{{ asset('js/location.js') }}"></script>
    <script src="{{ asset('js/contstaff.js') }}"></script>

    <script>

        $(function() {

            $('[data-mask]').inputmask();

            $("#contract-teacher").addClass("menu-open");
            $("#new-contract-teacher > a").addClass("active");
            $("#tab-detail").addClass("active");

            // Validation
            $("#frmCreateUpdateContTeacher").validate({
                rules: {
                    nid_card: "required",
                    bank_account: "required",
                    surname_kh: "required",
                    name_kh: "required",
                    surname_en: "required",
                    name_en: "required",
                    sex: "required",
                    dob: "required",
                    birth_pro_code: "required",
                    birth_district: "required",
                    start_date: "required",
                    contract_type_id: "required",
                    location_code: "required",
                },
                messages: {
                    nid_card: "{{ __('validation.required_field') }}",
                    bank_account: "{{ __('validation.required_field') }}",
                    surname_kh: "{{ __('validation.required_field') }}",
                    name_kh: "{{ __('validation.required_field') }}",
                    surname_en: "{{ __('validation.required_field') }}",
                    name_en: "{{ __('validation.required_field') }}",
                    sex: "{{ __('validation.required_field') }}",
                    dob: "{{ __('validation.required_field') }}",
                    birth_pro_code: "{{ __('validation.required_field') }}",
                    birth_district: "{{ __('validation.required_field') }}",
                    start_date: "{{ __('validation.required_field') }}",
                    contract_type_id: "{{ __('validation.required_field') }}",
                    location_code: "{{ __('validation.required_field') }}",
                },
                submitHandler: function(frm) {
                    loadModalOverlay(true, 500);
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
                }
            });

            $("select").change(function() {
                if ($(this).val() != "") {
                    $(this).closest('.form-group').removeClass('has-error');
                    $("#"+$(this).attr("id")+"-error").addClass("d-none");
                }
                else {
                    $(this).closest('.form-group').addClass('has-error');
                    $("#"+$(this).attr("id")+"-error").removeClass("d-none");
                }
            });

        });

    </script>

@endpush