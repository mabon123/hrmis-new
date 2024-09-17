@extends('layouts.admin')

@push('styles')
    <style>
        .cust-info-box {min-height:40px;box-shadow:none;margin-bottom:0px !important;padding-bottom:0px !important;}
        .report-title {padding: 8px !important;}
        .report-icon {box-shadow:0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);padding:6px;}
        .info-box-content {padding-left:0px !important;}
        span.info-box-icon i { font-size:24px; }
        .form-group {margin-bottom: 0px !important;}
        .fa-file-pdf {color:red !important}
        .fa-file-excel {color:green !important}
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
    {!! Form::open(['route' => ['reports.index', app()->getLocale()], 'method' => 'post', 'id' => 'frmGeneralReport', 'target' => '_blank']) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('report.choose_workplace') }}</h3>
                    </div>
                    
                    <div class="card-body">
                        <div class="row justify-content-md-center">
                            <!-- Province -->
                            <div class="col-sm-3">
                                <div class="form-group @error('pro_code') has-error @enderror">
                                    <label for="pro_code">{{ __('common.province') }} <span class="required">*</span></label>

                                    {{ Form::select('pro_code', $provinces, request()->pro_code, 
                                    	['id' => 'pro_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 
                                            'required' => true]) 
                                    }}
                                </div>
                            </div>

                            <!-- District -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="dis_code">{{ __('common.district') }}</label>

                                    {{ Form::select('dis_code', $districts, request()->dis_code, 
                                        ['id' => 'dis_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) 
                                    }}
                                </div>
                            </div>

                            <!-- Current location -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="location_code">{{ __('common.current_location') }}</label>

                                    {{ Form::select('location_code', $locations, 
                                        (!empty($userLocationName) ? $userLocationName : request()->location_code), 
                                        ['id' => 'location_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                    }}
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
                        
                        @include('admin.reports.partials.report_lists')
                    </div> <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="button" id="btn-reset" class="btn btn-danger" style="width:160px;">
                            <i class="fa fa-undo"></i>&nbsp;{{ __('button.reset') }}
                        </button>
                    </div>
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
		$("#reports-page > a").addClass("active");

		$("#pro_code").change(function() {
            if ($(this).val() > 0) {
                loading();

                $.ajax({
                    type: "GET",
                    url: "/provinces/" + $(this).val() + "/locations",
                    success: function (locations) {
                        var locationCount = Object.keys(locations).length;
                        $("#location_code").find('option:not(:first)').remove();

                        if ( locationCount > 0 ) {
                            for(var key in locations) {
                                $("#location_code").append('<option value="'+key+'">'+ locations[key] +'</option>');
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }
        });

		// District change -> auto-fill data for location belong to that district
        $("#dis_code").change(function() {
        	loadModalOverlay(true, 1000);

            if ($(this).val() > 0) {
                $.ajax({
                    type: "GET",
                    url: "/districts/" + $(this).val() + "/locations",
                    success: function (locations) {
                        var locationCount = Object.keys(locations).length;
                        $("#location_code").find('option:not(:first)').remove();

                        if ( locationCount > 0 ) {
                            for(var key in locations) {
                                $("#location_code").append('<option value="'+key+'">'+ locations[key] +'</option>');
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }
        });

        // Generating report
        $('.btn-generate-report').click(function() {
            $('#frmGeneralReport').attr('action', $(this).data('report-url'));
            $('#frmGeneralReport').trigger('submit');
        });
	});
</script>
@endpush
