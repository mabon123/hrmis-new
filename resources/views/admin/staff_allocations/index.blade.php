@extends('layouts.admin')

@push('styles')
    <style type="text/css">
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, 
        .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
            border:1px #999 solid !important;
        }
        .bg-total{background:#17a2b8;color:#fff;}
        .page-break{margin-top:50px;}
    </style>
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-book-reader"></i> {{ __('menu.staff_allocation') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('index', app()->getLocale()) }}">
                                <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('menu.staff_allocation') }}</li>
                    </ol>

                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
    	<form id="frmSftaffAllocation" action="{{ route('staff-allocation.index', app()->getLocale()) }}" target="_blank">
	        <div class="row">
	            <div class="col-sm-12">
	                <div class="card card-info">
	                    <div class="card-header">
	                        <h1 class="card-title" style="width:100%;text-align:center;">
	                            {{ __('menu.staff_allocation') }}</h1>
	                    </div>

                    	<!-- Staff shortage, allocation and recruitment report -->
                    	@if (request()->btn_student_statistic && request()->btn_student_statistic == true)
                    		<div class="card-body custom-card table-responsive">
                    			<h6 class="kh"><strong><i>{{ __('ក. ស្ថិតិសិស្ស ថ្នាក់៖') }}</i></strong></h6>

	                    		@include('admin.staff_allocations.partials.teacher_statistic')
		                    </div>

	                    @else
	                    	<div class="card-body custom-card">
		                    	<!-- Academic Year -->
		                    	<div class="row justify-content-md-center">
		                    		<div class="col-sm-4">
		                    			<div class="form-group">
		                    				<label for="year_id">{{ __('common.year') }} <span class="required">*</span></label>
		                    				{{ Form::select('year_id', ['' => __('common.choose').' ...'] + $academicYears, 
		                    					(request()->year_id ? request()->year_id : $curAcademicYear->year_id), 
								          		['id' => 'year_id', 'class' => 'form-control kh select2', 
								          		'style' => 'width:100%;', 'required' => true]) 
								            }}
		                    			</div>
		                    		</div>
		                    	</div>

		                    	<!-- Province -->
		                    	<div class="row justify-content-md-center">
		                    		<div class="col-sm-4">
		                    			<div class="form-group">
		                    				<label for="pro_code">{{ __('common.province') }} <span class="required">*</span></label>
		                    				{{ Form::select('pro_code', ['' => __('common.choose').' ...'] + $provinces, 
		                    					(request()->pro_code ? request()->pro_code : $curAcademicYear->year_id), 
								          		['id' => 'pro_code', 'class' => 'form-control kh select2', 
								          		'style' => 'width:100%;', 'required' => true]) 
								            }}
		                    			</div>
		                    		</div>
		                    	</div>

		                    	<!-- District -->
		                    	<div class="row justify-content-md-center">
		                    		<div class="col-sm-4">
		                    			<div class="form-group">
		                    				<label for="dis_code">{{ __('common.district') }}</label>
		                    				{{ Form::select('dis_code', ['' => __('common.choose').' ...'], request()->dis_code, 
								          		['id' => 'dis_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) 
								            }}
		                    			</div>
		                    		</div>
		                    	</div>

		                    	<!-- Workplace -->
		                    	<div class="row justify-content-md-center">
		                    		<div class="col-sm-4">
		                    			<div class="form-group">
		                    				<label for="location_code">{{ __('common.location') }} <span class="required">*</span></label>
		                    				{{ Form::select('location_code', ['' => __('common.choose').' ...'], request()->location_code, 
								          		['id' => 'location_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 
								          		'required' => true]) 
								            }}
		                    			</div>
		                    		</div>
		                    	</div>

		                    	<input type="hidden" name="search" value="true">
		                    </div>
		                @endif

	                    <div class="card-footer" {{ request()->search ? 'style="display: none;"' : '' }}>
	                        <button type="submit" name="btn_student_statistic" value="true" class="btn btn-flat btn-info" style="width:180px;">
	                            <i class="fas fa-arrow-circle-right"></i> {{ __('ស្ថិតិសិស្ស ថ្នាក់') }}
	                        </button>

	                        <button type="button" name="btn-action" value="export" class="btn btn-flat btn-success" style="width:180px;">
	                            <i class="far fa-file-excel"></i> {{ __('button.export_to_excel') }}
	                        </button>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </form>
    </section>
@endsection

@push('scripts')
	<script src="{{ asset('js/custom_validation.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $("#staff-allocation-menu > a").addClass("active");

            // Validation
            $("#frmSftaffAllocation").validate({
                submitHandler: function(frm) {
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

            // District change -> auto-fill data for location belong to that district
            $("#dis_code").change(function() {
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
        });
    </script>
@endpush
