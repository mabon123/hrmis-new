@extends('layouts.admin')

@push('styles')
	<style type="text/css">
		[class*=icheck-]>input:first-child+input[type=hidden]+label::before, 
		[class*=icheck-]>input:first-child+label::before {
			border-color:#000 !important;
		}
	</style>
@endpush

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	    <div class="container-fluid">
	        <div class="row mb-2">
	            <div class="col-sm-6">
	                <h1><i class="fa fa-user"></i> {{ __('menu.manage_teacher_subject') }}</h1>
	            </div>
	            <div class="col-sm-6">
	                <ol class="breadcrumb float-sm-right">
	                    <li class="breadcrumb-item">
	                        <a href="{{ route('index', app()->getLocale()) }}">
	                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
	                    </li>
	                    <li class="breadcrumb-item"><a href="#"> {{ __('menu.manage_timetables') }} </a></li>
	                    <li class="breadcrumb-item active">{{ __('menu.manage_teacher_subject') }}</li>
	                </ol>

	            </div>
	        </div>
	    </div>
	</section>

	<!-- Main content -->
	<section class="content">
	    <!-- Validations -->
	    <div class="row">
	        <div class="col-md-12">
	            @include('admin.validations.validate')
	        </div>
	    </div>

	    <!-- Search -->
	    @include('admin.timetables.teacher_primary.search')

	    <!-- Grade listing -->
	    <div class="row">
	    	<div class="col-sm-6">
	    		@include('admin.timetables.teacher_primary.form_primary')
	    	</div>

	        <div class="col-sm">
	            <div class="card card-info">
	                <div class="card-header">
	                    <h3 class="card-title" style="line-height:38px;">
	                    	{{ __('menu.manage_grades').' ('.count($teacherSubjects).')' }}</h3>
	                    <a href="{{ route('timetable.printStaffDuty', [app()->getLocale()]) }}" 
                            class="btn btn-md btn-primary float-right" title="{{ __('button.print') }}" 
                            target="_blank" style="width:180px;">
                            <i class="fa fa-print"></i> {{ __('button.print') }}
                        </a>
	                </div>

	                <div class="card-body table-responsive p-0">
	                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
	                        <thead>
	                            <tr>
	                                <th>#</th>
	                                <th>{{ __('timetables.teacher_name') }}</th>
	                                <th>{{ __('common.sex') }}</th>
	                                <th>{{ __('common.dob') }}</th>
	                                <th>{{ __('timetables.grade_level') }}</th>
	                                <th></th>
	                            </tr>
	                        </thead>

	                        <tbody>
	                            @foreach($teacherSubjects as $index => $teacherSubject)
	                                <tr id="record-{{ $teacherSubject->teacher_primary_id }}">
	                                    <td>{{ $index + 1 }}</td>
	                                    <td class="kh">
	                                    	{{ $teacherSubject->staff->surname_kh.' '.$teacherSubject->staff->name_kh }}
	                                    </td>

	                                    <td class="kh">{{ $teacherSubject->staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
	                                    <td>{{ date('d-m-Y', strtotime($teacherSubject->staff->dob)) }}</td>

	                                    <td class="kh">
	                                    	{{ $teacherSubject->tgrade->grade->grade_kh.' '.$teacherSubject->tgrade->grade_name }}
	                                    </td>

	                                    <td class="text-right">
	                                        <button type="button" class="btn btn-xs btn-danger btn-delete" 
	                                        	data-route="{{ route('teacher-primary.destroy', [app()->getLocale(), $teacherSubject->teacher_primary_id]) }}">
	                                        	<i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
	                                    </td>
	                                </tr>
	                            @endforeach
	                        </tbody>
	                    </table>
	                </div>

	                <div class="card-footer"></div>
	            </div>
	        </div>
	    </div>
	</section>
@endsection



@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $("#timetables-section").addClass("menu-open");
            $("#teacher-subject-primary > a").addClass("active");

            // Validation
            $("#frmNewRecord").validate({
                submitHandler: function(frm) {
                    $('#modal-form').modal('hide');
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

            // Edit Grade
            $(document).on("click", ".btn-edit", function() {
                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#academic_id").val(data.academic_id).change();
                    $("#shift").val(data.shift).change();
                    $("#grade_id").val(data.grade_id).change();
                    $("#grade_name_kh").val(data.grade_name_kh);
                    $("#grade_name_en").val(data.grade_name_en);

                    $("input[name='_method']").remove();
                    $("#frmNewRecord").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmNewRecord").prepend(putMethod);
                    $("#modal-form").modal("show");
                });
            });
        });
    </script>
@endpush
