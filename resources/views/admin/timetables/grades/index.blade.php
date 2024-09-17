@extends('layouts.admin')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	    <div class="container-fluid">
	        <div class="row mb-2">
	            <div class="col-sm-6">
	                <h1><i class="fa fa-user"></i> {{ __('menu.manage_grades') }}</h1>
	            </div>
	            <div class="col-sm-6">
	                <ol class="breadcrumb float-sm-right">
	                    <li class="breadcrumb-item">
	                        <a href="{{ route('index', app()->getLocale()) }}">
	                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
	                    </li>
	                    <li class="breadcrumb-item"><a href="#"> {{ __('menu.manage_timetables') }} </a></li>
	                    <li class="breadcrumb-item active">{{ __('menu.manage_grades') }}</li>
	                </ol>

	            </div>
	        </div>
	    </div>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row row-box">
	        <div class="col-md-6">
	            <button type="button" id="btn-add" class="btn btn-info loc_{{ auth()->user()->work_place->location_code }}" 
	                data-add-url="{{ route('tgrades.store', app()->getLocale()) }}" style="width:200px;">
	                <i class="fas fa-plus"></i> {{ __('timetables.create_new_grade') }}</button>
	        </div>
	    </div>

	    <!-- Validations -->
	    <div class="row">
	        <div class="col-md-12">
	            @include('admin.validations.validate')
	        </div>
	    </div>

	    <!-- Search -->
	    @include('admin.timetables.grades.search')

	    <!-- Grade listing -->
	    <div class="row">
	        <div class="col-sm-12">
	            <div class="card card-info">
	                <div class="card-header">
	                    <h3 class="card-title">{{ __('menu.manage_grades').' ('.$tgrades->total().')' }}</h3>
	                </div>

	                <div class="card-body table-responsive p-0">
	                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
	                        <thead>
	                            <tr>
	                                <th>#</th>
	                                <th>{{ __('menu.academic_year') }}</th>
	                                <th>{{ __('timetables.grade_level') }}</th>
	                                <th>{{ __('timetables.grade_name_kh') }}</th>
	                                <th>{{ __('timetables.class_incharge') }}</th>
	                                <th></th>
	                            </tr>
	                        </thead>

	                        <tbody>
	                            @foreach($tgrades as $index => $tgrade)
	                                <tr id="record-{{ $tgrade->tgrade_id }}">
	                                    <td>{{ $index + 1 }}</td>

	                                    <td class="kh">{{ $tgrade->academicYear->year_kh }}</td>
	                                    <td class="kh">{{ $tgrade->grade ? $tgrade->grade->grade_kh : '---' }}</td>
	                                    <td class="kh">{{ $tgrade->grade_name }}</td>

	                                    <td class="kh">
	                                    	{{ !empty($tgrade->staff) ? ($tgrade->staff->surname_kh.' '.$tgrade->staff->name_kh) : '' }}
	                                    </td>

	                                    <td class="text-right">
	                                        <button type="button" class="btn btn-xs btn-info btn-edit" 
	                                        	data-edit-url="{{ route('tgrades.edit', [app()->getLocale(), $tgrade->tgrade_id]) }}" 
	                                        	data-update-url="{{ route('tgrades.update', [app()->getLocale(), $tgrade->tgrade_id]) }}">
	                                        	<i class="far fa-edit"></i> {{ __('button.edit') }}</button>

	                                        <button type="button" class="btn btn-xs btn-danger btn-delete" 
	                                        	data-route="{{ route('tgrades.destroy', [app()->getLocale(), $tgrade->tgrade_id]) }}">
	                                        	<i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
	                                    </td>
	                                </tr>
	                            @endforeach
	                        </tbody>
	                    </table>
	                </div>

	                <div class="card-footer">
	                	<div>
		                    @if($tgrades->hasPages())
		                        {!! $tgrades->appends(Request::except('page'))->render() !!}
		                    @endif
		                </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
@endsection

@include('admin.timetables.grades.modal_form')

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $("#timetables-section").addClass("menu-open");
            $("#manage-grades > a").addClass("active");

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

            // Add
            $('#btn-add').click(function() {
                var addURL = $(this).data("add-url");
                $("#frmNewRecord").trigger("reset");
                $("#grade_id").val('').change();
                $("#grade_name_2").removeClass('d-none');
                $("#grade_name_3").removeClass('d-none');
                $("#grade_name_4").removeClass('d-none');
                $("#grade_name_5").removeClass('d-none');
                $("#grade_name_6").removeClass('d-none');
                $("#grade_name_7").removeClass('d-none');
                $("#grade_name_8").removeClass('d-none');
                $("#grade_name_9").removeClass('d-none');
                $("#grade_name_10").removeClass('d-none');
                $("#grade-sec-2").removeClass('d-none');
                $("#grade-sec-3").removeClass('d-none');
                $("input[name='_method']").remove();
                $("#frmNewRecord").attr("action", addURL);
                $("#modal-form").modal("show");
            });

            // Edit Grade
            $(document).on("click", ".btn-edit", function() {
                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#academic_id").val(data.academic_id).change();
                    $("#grade_id").val(data.grade_id).change();
                    $("#grade_name_1").val(data.grade_name);

                    $("#grade_name_2").addClass('d-none');
                    $("#grade_name_3").addClass('d-none');
                    $("#grade_name_4").addClass('d-none');
                    $("#grade_name_5").addClass('d-none');
                    $("#grade_name_6").addClass('d-none');
                    $("#grade_name_7").addClass('d-none');
                    $("#grade_name_8").addClass('d-none');
                    $("#grade_name_9").addClass('d-none');
                    $("#grade_name_10").addClass('d-none');
                    $("#grade-sec-2").addClass('d-none');
                    $("#grade-sec-3").addClass('d-none');

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
