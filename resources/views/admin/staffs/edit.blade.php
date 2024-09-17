@extends('layouts.admin')

@section('content')
	
	<!-- Content Header (Page header) -->
	<section class="content-header">
	    <div class="container-fluid">
	        <div class="row mb-2">
	            <div class="col-sm-6">
	                <h1>
	                    <i class="fa fa-file"></i> {{ __('menu.staff_info') }}
	                    <span class="kh" style="font-size:1rem;">- {{ $staff->surname_kh.' '.$staff->name_kh }}</span>
	                </h1>
	            </div>
	            <div class="col-sm-6">
	                <ol class="breadcrumb float-sm-right">
	                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>
	                            {{ __('menu.home') }}</a></li>
	                    <li class="breadcrumb-item active">@lang('menu.staff_info')</li>
	                    <li class="breadcrumb-item active">@lang('staff.edit_staff')</li>
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
	                <div class="card-header p-0 pt-1">
	                    @include('admin.staffs.header_tab')
	                </div>

	                <div class="card-body custom-card">
	                    <div class="tab-content" id="custom-tabs-one-tabContent">
	                        <div class="tab-pane fade show active" id="custom-tabs-personal_details" role="tabpanel" aria-labelledby="custom-tabs-personal_details-tab">

	                            <form method="post" id="frmUpdateStaffInfo" action="{{ route('staffs.update', [app()->getLocale(), $staff->payroll_id]) }}" enctype="multipart/form-data">
								    @csrf
								    @method('PUT')

								    <div class="row">
								        <div class="col-md-12">
								            <h4>{{ __('common.basic_info') }}</h4>

								            <div class="row-box">
								                <div class="row">
								                    <div class="col-sm-10">
								                        <div class="row">
								                            <!-- Payroll number -->
								                            <div class="col-sm-3">
								                                <div class="form-group">
								                                    <label for="payroll_id">
								                                        <span class="section-num">1.</span>
								                                        {{ __('common.payroll_num') }}
								                                        <span class="required">*</span>
								                                    </label>

								                                    <input type="number" name="payroll_id" class="form-control @error('payroll_id') is-invalid @enderror" maxlength="10" value="{{ $staff->payroll_id }}" autocomplete="off">
								                                </div>
								                            </div>

								                            <!-- National id number -->
								                            <div class="col-sm-3">
								                                <div class="form-group">
								                                    <label for="nid_card">{{ __('common.nid') }}</label>
								                                    <input type="text" name="nid_card" value="{{ $staff->nid_card }}" class="form-control" autocomplete="off" data-inputmask='"mask": "999999999(99)"' data-mask>
								                                </div>
								                            </div>

								                            <!-- Bank account number -->
								                            <div class="col-sm-3">
								                                <div class="form-group">
								                                    <label for="bank_account">{{__('common.bankacc_num')}}</label>
								                                    <input type="text" name="bank_account" value="{{ $staff->bank_account }}" class="form-control" data-inputmask='"mask": "9999 99 999999 99"' data-mask>
								                                </div>
								                            </div>

								                            <!-- Staff staus -->
								                            <div class="col-sm-3">
								                                <div class="form-group">
								                                    <label for="staff_status_id"> {{__('common.current_status')}} <span class="required">*</span></label>

								                                    <select name="staff_status_id" class="form-control kh select2 @error('staff_status_id') is-invalid @enderror" style="width:100%;">
								                                        <option value="">{{ __('common.choose') }} ...</option>

								                                        @foreach($staffStatus as $status)

								                                            <option value="{{ $status->status_id }}" {{ $staff->staff_status_id == $status->status_id ? 'selected' : '' }}>
								                                            	{{ $status->status_kh }}
								                                            </option>

								                                        @endforeach
								                                    </select>
								                                </div>
								                            </div>
								                        </div>

								                        <div class="row">
								                            <!-- Name in Khmer -->
								                            <div class="col-sm-3">
								                                <div class="form-group">
								                                    <label for="surname_kh">
								                                        <span class="section-num">2.</span>
								                                        {{ __('common.surname_kh') }}
								                                        <span class="required">*</span>
								                                    </label>
								                                    <input type="text" name="surname_kh" value="{{ $staff->surname_kh }}" class="form-control kh @error('surname_kh') is-invalid @enderror" maxlength="150">
								                                </div>
								                            </div>
								                            <div class="col-sm-3">
								                                <div class="form-group">
								                                    <label for="name_kh">
								                                        {{ __('common.name_kh') }} <span class="required">*</span>
								                                    </label>
								                                    <input type="text" name="name_kh" value="{{ $staff->name_kh }}" class="form-control kh @error('name_kh') is-invalid @enderror" maxlength="150">
								                                </div>
								                            </div>

								                            <!-- Name in Latin -->
								                            <div class="col-sm-3">
								                                <div class="form-group">
								                                    <label for="surname_en">
								                                        {{ __('common.surname_latin') }}
								                                        <span class="required">*</span>
								                                    </label>
								                                    <input type="text" name="surname_en" value="{{ $staff->surname_en }}" class="form-control @error('surname_en') is-invalid @enderror" maxlength="50">
								                                </div>
								                            </div>
								                            <div class="col-sm-3">
								                                <div class="form-group">
								                                    <label for="name_en">
								                                        {{ __('common.name_latin') }}
								                                        <span class="required">*</span>
								                                    </label>
								                                    <input type="text" name="name_en" value="{{ $staff->name_en }}" class="form-control @error('name_en') is-invalid @enderror" maxlength="50">
								                                </div>
								                            </div>
								                        </div>

								                        <div class="row">
								                            <!-- Gender -->
								                            <div class="col-sm-3">
								                                <div class="form-group">
								                                    <label for="sex">
								                                        <span class="section-num">3.</span>
								                                        {{ __('common.sex') }} <span class="required">*</span>
								                                    </label>

								                                    <?php
								                                        $maleSelected = $staff->sex == 1 ? 'selected' : '';
								                                        $femaleSelected = $staff->sex == 2 ? 'selected' : '';
								                                    ?>

								                                    <select name="sex" class="form-control select2" style="width:100%;">
								                                        <option value="">{{ __('common.choose') }} ...</option>
								                                        <option value="1" {{$maleSelected}}>ប្រុស</option>
							                                            <option value="2" {{$femaleSelected}}>ស្រី</option>
								                                    </select>
								                                </div>
								                            </div>

								                            <!-- Date of birth -->
								                            <div class="col-sm-3">
								                                <div class="form-group">
								                                    <label for="dob">
								                                        {{ __('common.dob') }}
								                                        <span class="required">*</span>(dd-mm-yyyy)
								                                    </label>

								                                    <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
								                                        <input type="text" autocomplete="off" name="dob" value="{{ date('d-m-Y', strtotime($staff->dob)) }}" class="datepicker form-control @error('dob') is-invalid @enderror" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
								                                        <div class="input-group-addon">
								                                            <span class="far fa-calendar-alt"></span>
								                                        </div>
								                                    </div>
								                                </div>
								                            </div>

								                            <!-- Ethnic -->
								                            <div class="col-sm-3">
								                                <div class="form-group">
								                                    <label for="ethnic_id">{{__('common.ethnic')}}</label>
								                                    <select name="ethnic_id" class="form-control select2" style="width: 100%;">
								                                        <option value="">{{ __('common.choose') }} ...</option>

								                                        @foreach($ethnics as $ethnic)
								                                            <option value="{{ $ethnic->ethnic_id }}" {{ $staff->ethnic_id == $ethnic->ethnic_id ? 'selected' : '' }}>
								                                            	{{ $ethnic->ethnic_kh }}
								                                            </option>
								                                        @endforeach
								                                    </select>
								                                </div>
								                            </div>
								                            <div class="col-sm-3">
								                            </div>
								                        </div>
								                    </div>

								                    <!-- Staff photo -->
								                    <div class="col-sm-2">
								                        <div id="profile-photo" class="text-center">
								                            <img id="image-thumbnail" class="img-thumbnail" src="{{ asset('images/staffs/'.$staff->photo) }}">
								                            <button type="button" id="btn-cancel-profile" class="btn btn-danger btn-xs" style="width:90px;margin-top:15px;">
								                                <i class="far fa-times-circle"></i> Remove
								                            </button>
								                        </div>

								                        <div class="form-group upload-section d-none">
								                            <div class="profile-icon">
								                                <p><i class="fas fa-cloud-upload-alt" style="margin:0;font-size:32px;color:#0a7698;"></i></p>
								                                {{ __('common.choose_photo') }}</label><br>
								                            </div>
								                            <input id="profile_photo" name="profile_photo" type="file">
								                        </div>
								                    </div>
								                </div>
								            </div>
								        </div>

								        <div class="col-md-12">
								            <h4><span class="section-num">4. </span>{{ __('common.pob') }}</h4>
								            <div class="row-box">
								                <div class="row">
								                    <!-- Province -->
								                    <div class="col-sm-3">
								                        <div class="form-group">
								                            <label for="birth_pro_code">
								                                {{ __('common.province') }} <span class="required">*</span>
								                            </label>

								                            <select id="pro_code" name="birth_pro_code" class="form-control select2" data-lang="{{ app()->getLocale() }}">
								                                <option value="">{{ __('common.choose') }} ...</option>

								                                @foreach($provinces as $province)
								                                    <option value="{{ $province->pro_code }}" {{ $staff->birth_pro_code == $province->pro_code ? 'selected' : '' }}>{{ $province->name_kh }}</option>
								                                @endforeach
								                            </select>
								                        </div>
								                    </div>

								                    <!-- District -->
								                    <div class="col-sm-3">
								                        <div class="form-group">
								                            <label for="birth_district">
								                                {{ __('common.district') }} <span class="required">*</span>
								                            </label>

								                            <input type="text" name="birth_district" id="birth_district" value="{{ $staff->birth_district }}" class="form-control kh @error('birth_district') is-invalid @enderror">
								                        </div>
								                    </div>

								                    <!-- Commune -->
								                    <div class="col-sm-3">
								                        <div class="form-group">
								                            <label for="birth_commune">{{ __('common.commune') }}</label>
								                            <input type="text" name="birth_commune" id="birth_commune" value="{{ $staff->birth_commune }}" class="form-control kh" autocomplete="off">
								                        </div>
								                    </div>

								                    <!-- Village -->
								                    <div class="col-sm-3">
								                        <div class="form-group">
								                            <label for="birth_village">{{ __('common.village') }}</label>
								                            <input type="text" name="birth_village" id="birth_village" value="{{ $staff->birth_village }}" class="form-control kh" autocomplete="off">
								                        </div>
								                    </div>
								                </div>
								            </div>
								        </div>

								        <div id="div_workinfo" class="col-md-12">
								            <div class="card card-default">
								                <div class="card-header">
								                    <h3 class="card-title title-work-info">@lang('common.work_info')
								                        <button type="button" data-toggle="modal" data-target="#modalCreateWorkHistory">
								                        	<i class="fa fa-plus"></i> @lang('button.add')
								                        </button>
								                    </h3>
								                    <div class="card-tools">
								                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
								                        	<i class="fas fa-minus"></i>
								                        </button>
								                    </div>
								                </div>
								                
								                <div class="card-body">
								                    <div class="row">
								                        <!-- Start date -->
								                        <div class="col-sm-3">
								                            <div class="form-group">
								                                <label for="start_date">
								                                    <span class="section-num">5.</span>
								                                    {{ __('common.datestart_work') }}
								                                </label>

								                                <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
								                                    <input type="text" autocomplete="off" name="start_date" value="{{ date('d-m-Y', strtotime($staff->start_date)) }}" class="datepicker form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
								                                    <div class="input-group-addon">
								                                        <span class="far fa-calendar-alt"></span>
								                                    </div>
								                                </div>
								                            </div>
								                        </div>

								                        <!-- Apoitment date -->
								                        <div class="col-sm-3">
								                            <div class="form-group">
								                                <label for="appointment_date">
								                                    <span class="section-num">6. </span>{{__('common.appointment_date')}}
								                                </label>

								                                <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
								                                    <input type="text" autocomplete="off" name="appointment_date" value="{{ date('d-m-Y', strtotime($staff->appointment_date)) }}" class="datepicker form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
								                                    <div class="input-group-addon">
								                                        <span class="far fa-calendar-alt"></span>
								                                    </div>
								                                </div>
								                            </div>
								                        </div>
								                    </div>

								                    <!-- Work history list -->
								                    @if( count($staff->workHistories) > 0 )

								                    	<div class="table-responsive">
								                    		<table class="table table-bordered table-head-fixed text-nowrap">
								                    			<thead>
								                    				<th>#</th>
								                    				<th>@lang('common.position')</th>
								                    				<th>@lang('common.current_location')</th>
								                    				<th>@lang('common.cur_position')</th>
								                    				<th>@lang('common.start_date')</th>
								                    				<th>@lang('common.end_date')</th>
								                    				<th></th>
								                    			</thead>

								                    			<tbody>
								                    				
								                    				@foreach($workHistories as $index => $workHistory)

								                    					<tr id="record-{{ $workHistory->workhis_id }}">
								                    						<td>{{ $index +  1 }}</td>
								                    						<td class="kh">{{ !empty($workHistory->position) ? $workHistory->position->position_kh : '' }}</td>
								                    						<td class="kh">{{ !empty($workHistory->location) ? $workHistory->location->location_kh : '' }}</td>

								                    						<td class="text-center">
								                    							@if( $workHistory->cur_pos == 1 )
								                    								<i class="far fa-check-square" style="color:green;font-size:16px;"></i>
								                    							@else
								                    								<i class="far fa-window-close" style="color:red;font-size:16px;"></i>
								                    							@endif
								                    						</td>

								                    						<td>{{ $workHistory->start_date > 0 ? date('d-m-Y', strtotime($workHistory->start_date)) : '' }}</td>

								                    						<td>{{ $workHistory->end_date > 0 ? date('d-m-Y', strtotime($workHistory->end_date)) : '' }}</td>

								                    						<td class="text-right">
								                    							<button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('work-histories.edit', [app()->getLocale(), $workHistory->workhis_id]) }}" data-update-url="{{ route('work-histories.update', [app()->getLocale(), $workHistory->workhis_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

								                    							<button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $workHistory->workhis_id }}" data-delete-url="{{ route('work-histories.destroy', [app()->getLocale(), $workHistory->workhis_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
								                    						</td>
								                    					</tr>

								                    				@endforeach

								                    			</tbody>
								                    		</table>
								                    	</div>

								                    @endif

								                </div>
								                <!-- /.card-body -->
								            </div>
								            <!-- /.card -->
								        </div>


								        <!-- Staff salary history -->
								        @if (count($staff->staffSalaries))
								        	@include('admin.staffs.partials.salary_history')
								        @endif


								        <div class="col-md-12">
								            <h4>{{ __('common.other_info') }}</h4>
								            <div class="row-box">
								                <div class="row">
								                    <div class="col-sm-4">
								                        <div style="padding-top:8px" class="form-group clearfix">
								                            <div class="icheck-primary d-inline">
								                                <input type="checkbox" id="sbsk" name="sbsk" value="1" {{ $staff->sbsk == '1' ? 'checked' : '' }}>

								                                <label for="sbsk">{{__('common.kesa_long')}}</label>
								                            </div>
								                        </div>
								                    </div>
								                    <div class="col-sm-8">
								                        <table>
								                            <tr>
								                                <td>{{__('common.membership_id')}}</td>
								                                <td>
								                                    <input type="text" name="sbsk_num" value="{{ $staff->sbsk_num }}" class="form-control" maxlength="10">
								                                </td>
								                            </tr>
								                        </table>
								                    </div>
								                </div>

								                <div class="row">
								                    <!-- Disability teacher -->
								                    <div class="col-sm-2 div-checkbox">
								                        <div class="form-group clearfix">
								                            <div class="icheck-primary d-inline">
								                                <input type="checkbox" name="disability_teacher" id="disability_teacher" value="1" {{ $staff->disability_teacher == '1' ? 'checked' : '' }}>

								                                <label for="disability_teacher">
								                                    {{ __('common.disability_teacher') }}
								                                </label>
								                            </div>
								                        </div>
								                    </div>

								                    <!-- Disability -->
								                    <div class="col-sm-4">
								                        <div class="form-group">
								                            <label for="disability_id">{{ __('common.disability_type') }}</label>

								                            <select name="disability_id" class="form-control select2" style="width:100%;">
								                                <option value="">{{ __('common.choose') }} ...</option>

								                                @foreach($disabilities as $disability)

								                                    <option value="{{ $disability->disability_id }}" {{ $staff->disability_id == $disability->disability_id ? 'selected' : '' }}>
								                                        {{ $disability->disability_kh }}
								                                    </option>

								                                @endforeach
								                            </select>
								                        </div>
								                    </div>

								                    <!-- Notes -->
								                    <div class="col-sm-6">
								                        <div class="form-group">
								                            <label for="disability_note">
								                                {{ __('common.disability_desc') }}
								                            </label>

								                            <input type="text" name="disability_note" value="{{ $staff->disability_note }}" class="form-control kh">
								                        </div>
								                    </div>
								                </div>
								            </div>
								        </div>

								        <div class="col-md-12">
								            <table style="margin:auto;">
								                <tr>
								                    <td style="padding:5px">
								                    	<a href="javascript:history.go(-1);" class="btn btn-danger btn-cancel" style="width:150px;">
								                    		<i class="far fa-times-circle"></i> @lang('button.cancel')
								                    	</a>
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
								</form>

								<!-- Work history modal -->
								@include('admin.staffs.workinfo')

								<!-- Salary modal -->
								@include('admin.staffs.modals.modal_salary')

	                        </div>
	                    </div>
	                </div>
	                <!-- /.card -->
	            </div>
	        </div>
	    </div>

	</section>

	<input type="hidden" id="locationinfo" value="{{ $locations }}">

@endsection


@push('scripts')
	
	<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

	<script>

		function addValueToOfficeDropdown(locationName) {

            if( locationName !== "" ) {

                $("#sys_admin_office_id").empty();
                $("#sys_admin_office_id").append('<option value="">ជ្រើសរើស ...</option>');

                $.ajax({
                    type: "GET",
                    url: "/locations/" + locationName + "/offices",
                    success: function (offices) {
                        console.log(offices);
                        if( offices.length > 0 ) {

                            $("#sys_admin_office_id").prop("disabled", false);

                            for(var index in offices) {

                                $("#sys_admin_office_id").append('<option value="'+offices[index].office_id+'">'+ offices[index].office_kh +'</option>');
                            }
                        }
                        else { $("#sys_admin_office_id").prop("disabled", true); }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }
            else {
                $("#sys_admin_office_id").prop("disabled", true);
                $("#sys_admin_office_id").empty();
                $("#sys_admin_office_id").append('<option value="">ជ្រើសរើស ...</option>');
            }
        }
		
		$(function() {

			$('[data-mask]').inputmask();

			$("#staff-info").addClass("menu-open");
            $("#create-staff > a").addClass("active");
            $("#tab-detail").addClass("active");

            // Browse profile photo
            $("#profile_photo").change(function({target}) {
                readImageURL(this, "image-thumbnail");

                $("#profile-photo").removeClass("d-none");
                $(".upload-section").addClass("d-none");

                // Fixed issue for same image upload
                const files = target.files;
                target.value = '';
            });

            // Remove profile photo and browser new one
            $("#btn-cancel-profile").click(function() {
                $("#profile-photo").addClass("d-none");
                $(".upload-section").removeClass("d-none");
                $("#profile_photo_asset").val("");
            });

            // Current location autocomplete
            var locations = JSON.parse($("#locationinfo").val());

            $("#location_code").autocomplete({
                source: locations,
                select: function(event, ui) {
                    var locationName = ui.item.value;
                    addValueToOfficeDropdown(locationName);
                }
            });

            // $("#location_code").blur(function() {
            //     var locationName = $(this).val();
            //     addValueToOfficeDropdown(locationName);
            // });
            
            // Current position event
            $("#cur_pos").change(function() {
            	var isChecked = $(this).is(":checked") ? true : false;
            	$("#end_date").prop("disabled", isChecked);
            });

            // Edit work history
            $(document).on("click", ".btn-edit", function() {

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (workhistory) {

                    $("#location_code").val(workhistory.location_kh);

                    if( workhistory.sys_admin_office_id != null ) {
                    	// Add values to office dropdown
                    	for(var index in workhistory.sys_admin_offices) {
                    		$("#sys_admin_office_id").append("<option value='"+workhistory.sys_admin_offices[index].office_id+"'>"+workhistory.sys_admin_offices[index].office_kh+"</option>");
                    	}

                    	$("#sys_admin_office_id option[value='"+workhistory.sys_admin_office_id+"']").prop("selected", true);
                    	$("#select2-sys_admin_office_id-container").text(workhistory.sys_admin_office);
                    	$("#sys_admin_office_id").prop("disabled", false);
                    } else {
                    	$("#sys_admin_office_id").prop("disabled", true);
                    	$("#sys_admin_office_id").empty();
                    	$("#sys_admin_office_id").append("<option value=''>ជ្រើសរើស ...</option>");
                    	$("#select2-sys_admin_office_id-container").text('ជ្រើសរើស ...');
                    }

                    if( workhistory.official_rank_id != null ) {
                    	$("#official_rank_id option[value='"+workhistory.official_rank_id+"']").prop("selected", true);
                    	$("#select2-official_rank_id-container")
                    		.text($("#official_rank_id option[value='"+workhistory.official_rank_id+"']").text());
                    } else {
                    	$("#select2-official_rank_id-container").text('ជ្រើសរើស ...');
                    	$("#official_rank_id").find("option").prop("selected", false);
                    }

                    if( workhistory.position_id != null ) {
                    	$("#position_id option[value='"+workhistory.position_id+"']").prop("selected", true);
                    	$("#select2-position_id-container")
                    		.text($("#position_id option[value='"+workhistory.position_id+"']").text());
                    } else {
                    	$("#select2-position_id-container").text('ជ្រើសរើស ...');
                    	$("#position_id").find("option").prop("selected", false);
                    }

                    if( workhistory.additional_position_id != null ) {
                    	$("#additional_position_id option[value='"+workhistory.additional_position_id+"']")
                    		.prop("selected", true);
                    	$("#select2-additional_position_id-container")
                    		.text($("#additional_position_id option[value='"+workhistory.additional_position_id+"']").text());
                    } else {
                    	$("#select2-additional_position_id-container").text('ជ្រើសរើស ...');
                    	$("#additional_position_id").find("option").prop("selected", false);
                    }

                    $("#main_duty").val(workhistory.main_duty);
                    $("#prokah").prop("checked", workhistory.prokah);
                    $("#prokah_num").val(workhistory.prokah_num);
                    $("#cur_pos").prop("checked", workhistory.cur_pos);
                    $("#start_date").val(workhistory.start_date);

                    if( workhistory.cur_pos == null || workhistory.cur_pos == 0 ) {
                    	$("#end_date").val(workhistory.end_date);
                    	$("#end_date").prop("disabled", false);
                    } else {
                    	$("#end_date").val('');
                    	$("#end_date").prop("disabled", true);
                    }

                    console.log("workhistory.sys_admin_office_id: " + workhistory.sys_admin_office_id);

                    $("input[name='_method']").remove();
                    $("#frmCreateWorkHistory").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateWorkHistory").prepend(putMethod);
                    $("#modalCreateWorkHistory").modal("show");
                });

            });

            // Remove work history
            $(document).on("click", ".btn-delete", function() {
				var deleteURL = $(this).data('delete-url');
				var deleted = confirm('Are you sure you want to remove this entry?');

				if( deleted ) {
		            var itemID = $(this).val();

		            $.ajax({
		                type: "DELETE",
		                url: deleteURL,
		                success: function (data) {
		                    $("#record-" + itemID).remove();
		                    $("#delete-success").removeClass("d-none");
		                },
		                error: function (data) {
		                    console.log('Error:', data);
		                }
		            });
		        }
			});

			// Edit staff salary info
			$(document).on("click", ".btn-edit-salary", function() {

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (salary) {

                    if( salary.salary_level_id != null ) {
                    	$("#salary_level_id option[value='"+salary.salary_level_id+"']").prop("selected", true);
                    	$("#select2-salary_level_id-container")
                    		.text($("#salary_level_id option[value='"+salary.salary_level_id+"']").text());
                    } else {
                    	$("#select2-salary_level_id-container").text('ជ្រើសរើស ...');
                    	$("#salary_level_id").find("option").prop("selected", false);
                    }

                    if( salary.cardre_type_id != null ) {
                    	$("#cardre_type_id option[value='"+salary.cardre_type_id+"']").prop("selected", true);
                    	$("#select2-cardre_type_id-container")
                    		.text($("#cardre_type_id option[value='"+salary.cardre_type_id+"']").text());
                    } else {
                    	$("#select2-cardre_type_id-container").text('ជ្រើសរើស ...');
                    	$("#cardre_type_id").find("option").prop("selected", false);
                    }

                    $("#salary_degree").val(salary.salary_degree);
                    $("#salary_type_shift_date").val(salary.salary_type_shift_date);
                    $("#salary_special_shift_date").val(salary.salary_special_shift_date);
                    $("#salary_type_prokah_num").val(salary.salary_type_prokah_num);
                    $("#salary_type_signdate").val(salary.salary_type_signdate);
                    $("#salary_type_prokah_order").val(salary.salary_type_prokah_order);

                    $("input[name='_method']").remove();
                    $("#frmCreateSalary").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateSalary").prepend(putMethod);
                    $("#modalCreateSalary").modal("show");
                });

            });

            // Remove staff salary info
            $(document).on("click", ".btn-delete-salary", function() {
				var deleteURL = $(this).data('delete-url');
				var deleted = confirm('Are you sure you want to remove this entry?');

				if( deleted ) {
		            var itemID = $(this).val();

		            $.ajax({
		                type: "DELETE",
		                url: deleteURL,
		                success: function (data) {
		                    $("#salary-" + itemID).remove();
		                    
		                    // Display toast
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                autohide: true,
                                delay: 3000,
                                title: 'Success',
                                body: 'Staff salary information has been deleted successfully.'
                            });
		                },
		                error: function (data) {
		                    console.log('Error:', data);
		                }
		            });
		        }
			});

		});

	</script>

@endpush
