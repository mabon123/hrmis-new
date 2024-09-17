@extends('layouts.admin')

@push('styles')
<style>
    .cust-info-box {
        min-height: 40px;
        box-shadow: none;
        margin-bottom: 0px !important;
        padding-bottom: 0px !important;
    }

    .report-title {
        padding: 8px !important;
    }

    .report-icon {
        box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
        padding: 6px;
    }

    .info-box-content {
        padding-left: 0px !important;
    }

    span.info-box-icon i {
        font-size: 24px;
    }

    .form-group {
        margin-bottom: 0px !important;
    }
</style>
@endpush

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="nav-icon fas fa-chart-line"></i> {{ __('menu.report_and_chart') }}</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    {!! Form::open(['route' => ['cpd-reports.index', app()->getLocale()], 'method' => 'post', 'id' => 'frmGeneralReport']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('report.cpd_report_home_title') }}</h3>
                </div>

                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-3">
                            <div class="form-group @error('provider_id') has-error @enderror">
                                <label for="provider_id">{{ __('menu.cpd_provider') }}</label>

                                {{ Form::select('provider_id', $providers, request()->provider_id, 
                                    	['id' => 'provider_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) 
                                    }}
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="start_date">@lang('cpd.start_date')</label>

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
                                <label for="end_date">@lang('cpd.end_date')</label>

                                <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                    {{ Form::text('end_date', null, ['class' => 'form-control datepicker '.(($errors->has('end_date') or $errors->has('date_error')) ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'placeholder' => 'dd-mm-yyyy']) }}
                                    <div class="input-group-addon">
                                        <span class="far fa-calendar-alt"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Error validation message -->
                            @if ($errors->any())
                            <div class="alert alert-danger" style="margin-top:15px;">
                                <ul style="margin-bottom:0;">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    @include('admin.cpd_tcp.cpd_reports.partials.report_lists')
                    
                </div> <!-- /.card-body -->
                <!-- /.card -->
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>

@endsection

@push('scripts')
<script type="text/javascript">
    $(function() {
        $("#cpd-reports-page > a").addClass("active");

        // Generating report
        $('.btn-generate-report').click(function() {
            $('#frmGeneralReport').attr('action', $(this).data('report-url'));
            $('#frmGeneralReport').trigger('submit');
        });
    });
</script>
@endpush