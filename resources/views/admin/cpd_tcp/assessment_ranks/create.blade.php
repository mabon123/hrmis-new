@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.tcp_assessment_rank') }}
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
                            
                            {!! Form::open(['route' => ['tcp-assessment-ranks.store', [app()->getLocale()]], 'method' => 'POST', 'id' => 'frmCreateTCPAssessmentRank']) !!}

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="ass_rank_kh">@lang('tcp.ass_rank_kh')</label>

                                            {{ Form::text('ass_rank_kh', null, ['id' => 'ass_rank_kh', 'class' => 'form-control kh', 'maxlength' => 30, 'autocomplete' => 'off']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="ass_rank_en">@lang('tcp.ass_rank_en')</label>

                                            {{ Form::text('ass_rank_en', null, ['id' => 'ass_rank_en', 'class' => 'form-control', 'maxlength' => 20, 'autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="rank_low">@lang('cpd.rank_low')</label>

                                            {{ Form::number('rank_low', null, ['id' => 'rank_low', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="rank_high">@lang('cpd.rank_high')</label>

                                            {{ Form::number('rank_high', null, ['id' => 'rank_high', 'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
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

    <script src="{{ asset('js/location.js') }}"></script>
    <script src="{{ asset('js/contstaff.js') }}"></script>

    <script>

        $(function() {

            $('[data-mask]').inputmask();

            $("#cpd_and_tcp_modules").addClass("menu-open");
            $("#tcp_assessment_rank > a").addClass("active");

            // Validation
            /*$("#frmCreateTCPAssessmentRank").validate({
                rules: {
                    provider_email: "required",
                },
                messages: {
                    provider_email: "{{ __('validation.required_field') }}",
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
            });*/

        });

    </script>

@endpush