@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.tcp_assessment_specialist') }}
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
                            
                            {!! Form::open(['route' => ['tcp-assessment-specialists.store', [app()->getLocale()]], 'method' => 'POST', 'id' => 'frmCreateTCPAssessmentSpecialist']) !!}

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="specialist_id">@lang('tcp.specialist')</label>

                                            {{ Form::select('specialist_id', ['' => __('common.choose').' ...'], null, ['id' => 'specialist_id', 'class' => 'form-control select2 kh']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat1_weighting">@lang('tcp.cat1_weighting')</label>

                                            {{ Form::text('cat1_weighting', null, ['id' => 'cat1_weighting', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat1_indicator_num">@lang('tcp.cat1_indicator_num')</label>

                                            {{ Form::number('cat1_indicator_num', null, ['id' => 'cat1_indicator_num', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat1_scoreby_indicator">@lang('tcp.cat1_scoreby_indicator')</label>

                                            {{ Form::text('cat1_scoreby_indicator', null, ['id' => 'cat1_scoreby_indicator', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat1_maxscore_sub">@lang('tcp.cat1_maxscore_sub')</label>

                                            {{ Form::text('cat1_maxscore_sub', null, ['id' => 'cat1_maxscore_sub', 'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat2_weighting">@lang('tcp.cat2_weighting')</label>

                                            {{ Form::text('cat2_weighting', null, ['id' => 'cat2_weighting', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat2_indicator_num">@lang('tcp.cat2_indicator_num')</label>

                                            {{ Form::number('cat2_indicator_num', null, ['id' => 'cat2_indicator_num', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat2_scoreby_indicator">@lang('tcp.cat2_scoreby_indicator')</label>

                                            {{ Form::text('cat2_scoreby_indicator', null, ['id' => 'cat2_scoreby_indicator', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat2_maxscore_sub">@lang('tcp.cat2_maxscore_sub')</label>

                                            {{ Form::text('cat2_maxscore_sub', null, ['id' => 'cat2_maxscore_sub', 'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat3_weighting">@lang('tcp.cat3_weighting')</label>

                                            {{ Form::text('cat3_weighting', null, ['id' => 'cat3_weighting', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat3_indicator_num">@lang('tcp.cat3_indicator_num')</label>

                                            {{ Form::number('cat3_indicator_num', null, ['id' => 'cat3_indicator_num', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat3_scoreby_indicator">@lang('tcp.cat3_scoreby_indicator')</label>

                                            {{ Form::text('cat3_scoreby_indicator', null, ['id' => 'cat3_scoreby_indicator', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat3_maxscore_sub">@lang('tcp.cat3_maxscore_sub')</label>

                                            {{ Form::text('cat3_maxscore_sub', null, ['id' => 'cat3_maxscore_sub', 'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat5_weighting">@lang('tcp.cat5_weighting')</label>

                                            {{ Form::text('cat5_weighting', null, ['id' => 'cat5_weighting', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat5_indicator_num">@lang('tcp.cat5_indicator_num')</label>

                                            {{ Form::number('cat5_indicator_num', null, ['id' => 'cat5_indicator_num', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat5_scoreby_indicator">@lang('tcp.cat5_scoreby_indicator')</label>

                                            {{ Form::text('cat5_scoreby_indicator', null, ['id' => 'cat5_scoreby_indicator', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="cat5_maxscore_sub">@lang('tcp.cat5_maxscore_sub')</label>

                                            {{ Form::text('cat5_maxscore_sub', null, ['id' => 'cat5_maxscore_sub', 'class' => 'form-control']) }}
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
            $("#tcp_assessment_specialist > a").addClass("active");

            // Validation
            /*$("#frmCreateTCPAssessmentSpecialist").validate({
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