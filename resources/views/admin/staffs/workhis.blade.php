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
                    @include('admin.staffs.partials.header_tab')
                </div>

                <div class="card-body custom-card">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-personal_details" role="tabpanel" aria-labelledby="custom-tabs-personal_details-tab">
                            <form method="post" id="frmChangeStaffStatus" action="#">
                                @csrf
                                <div class="row justify-content-md-center">
                                    <!-- Staff staus -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="status_change">{{ __('common.current_status') }}</label>

                                            {{ Form::select('status_change', ['' => __('common.choose').' ...'] + $staffStatus, null, 
                                                ['id' => 'status_change', 'class' => 'form-control kh select2', 'style' => 'width:100%', 
                                                'data-add-url' => route('workHistory.store', [app()->getLocale(), $staff->payroll_id]), 
                                                'disabled' => (($staff->staff_status_id == 1 or $staff->staff_status_id == 2) ? false : true)]) 
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Workhistory listing -->
                            <div class="row">
                                @include('admin.staffs.partials.workhistory_listing')
                            </div>

                            <!-- Leave info -->
                            <div class="row" style="margin-top:50px;">
                                @include('admin.staffs.partials.leave_listing')

                                <div class="col-md-12 text-right">
                                    <button type="button" class="btn btn-sm btn-primary" id="btn-add-leave" data-add-url="{{ route('leaves.store', [app()->getLocale(), $staff->payroll_id]) }}" style="width:220px;"><i class="fas fa-plus"></i> {{ __('button.addtolist') }}</button>
                                </div>
                            </div>

                            <!-- Modal workhistory -->
                            @include('admin.staffs.modals.workinfo')
                            @include('admin.staffs.modals.modal_status')

                            <!-- Modal leave management -->
                            @include('admin.staffs.modals.modal_leave')
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
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script>
        function disableAdditionalStatusAttributes() {
            $("#transfer_out_province").addClass("d-none");
            $("#continue_study").addClass("d-none");
        }

        function addValueToOfficeDropdown(locationName) {
            if( locationName !== "" ) {
                $("#sys_admin_office_id").empty();
                $("#sys_admin_office_id").append('<option value="">ជ្រើសរើស ...</option>');

                $.ajax({
                    type: "GET",
                    url: "/locations/" + locationName + "/offices",
                    success: function (offices) {
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

        // Fill data to position dropdown
        function addValueToPositionDropdown(locationCode) {
            if( locationCode !== "" ) {
                $.ajax({
                    type: "GET",
                    url: "/locations/" + locationCode + "/positions",
                    success: function (positions) {
                        if( positions.length > 0 ) {
                            $("#position_id").find('option:not(:first)').remove();

                            for(var index in positions) {
                                $("#position_id").append('<option value="'+positions[index].position_id+'">'+ positions[index].position_kh +'</option>');
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }
            else {
                $("#position_id").find('option:not(:first)').remove();
            }
        }
        
        $(function() {
            $("#staff-info").addClass("menu-open");
            $("#create-staff > a").addClass("active");
            $("#tab-workhistory").addClass("active");
            $('[data-mask]').inputmask();

            // Validation
            $('#frmUpdateStaffStatus').validate({
                submitHandler: function(frm) {
                    $("#modalUpdateStaffStatus").hide();
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

            // Event on student status
            $("#status_change").change(function() {
                $("#staff_status_id").val($(this).val());
                $("#frmUpdateStaffStatus").trigger("reset");
                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmUpdateStaffStatus").attr("action", addURL);

                if ($(this).val() != "") { $("#modalUpdateStaffStatus").modal("show"); }
                disableAdditionalStatusAttributes();
                var statusID = $(this).val();

                if(statusID == 4) { $("#transfer_out_province").removeClass("d-none"); }
                else if(statusID == 10) { $("#continue_study").removeClass("d-none"); }
            });

            // Staff transfer, if new pro_code selected, then do not show location
            $('#pro_code_status').change(function() {
                if ($(this).val() != $('input[name="staff_province"]').val()) {
                    $('#col-location').addClass('d-none');
                    $('input[name="location_code"]').prop('required', false);
                }
                else {
                    $('#col-location').removeClass('d-none');
                    $('input[name="location_code"]').prop('required', true);
                }
            });

            // Edit work history
            $(document).on("click", ".btn-edit", function() {
                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (workhistory) {
                    // If cur_pos == 1, disable workplace dropdown
                    $('#workinfo_procode').prop('disabled', workhistory.cur_pos);
                    $('#location_code').prop('disabled', workhistory.cur_pos);
                    
                    $("#location_code option[value='"+workhistory.location_code+"']").prop("selected", true);
                    $("#select2-location_code-container").text($("#location_code option[value='"+workhistory.location_code+"']").text());

                    if( workhistory.sys_admin_offices.length > 0 ) {
                        // Add values to office dropdown
                        for(var index in workhistory.sys_admin_offices) {
                            $("#sys_admin_office_id").append("<option value='"+workhistory.sys_admin_offices[index].office_id+"'>"+workhistory.sys_admin_offices[index].office_kh+"</option>");
                        }

                        $("#sys_admin_office_id option[value='"+workhistory.sys_admin_office_id+"']").prop("selected", true);
                        $("#select2-sys_admin_office_id-container").text(workhistory.sys_admin_office);
                        $("#sys_admin_office_id").prop("disabled", false);

                        if (workhistory.sys_admin_office_id == null) {
                            $("#select2-sys_admin_office_id-container").text('ជ្រើសរើស ...');
                        }
                    } else {
                        $("#sys_admin_office_id").prop("disabled", true);
                        $("#sys_admin_office_id").empty();
                        $("#sys_admin_office_id").append("<option value=''>ជ្រើសរើស ...</option>");
                        $("#select2-sys_admin_office_id-container").text('ជ្រើសរើស ...');
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
                    $("#prokah_num").prop("disabled", ! $("#prokah").is(":checked"));
                    $("#prokah_num").val(workhistory.prokah_num);
                    $("#cur_pos").prop("checked", workhistory.cur_pos);
                    $("#start_date").val(workhistory.start_date);

                    if( workhistory.cur_pos == null || workhistory.cur_pos == 0 ) {
                        if (workhistory.end_date != '') { $("#end_date").val(workhistory.end_date); }
                        $("#end_date").prop("disabled", false);
                    } else {
                        $("#end_date").val('');
                        $("#end_date").prop("disabled", true);
                    }

                    $("input[name='_method']").remove();
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';

                    if (workhistory.his_type_id == 1) {
                        $("#frmCreateWorkHistory").attr("action", updateURL);
                        $("#frmCreateWorkHistory").prepend(putMethod);
                        $("#modalCreateWorkHistory").modal("show");
                    }
                    else {
                        if(workhistory.his_type_id == 4) {
                            $("#transfer_out_province").removeClass("d-none");
                            $("#pro_code_status").val(workhistory.pro_code).trigger('change');
                        }
                        else if(workhistory.his_type_id == 10) {
                            $("#continue_study").removeClass("d-none");
                            $("#country_id_status").val(workhistory.country_id).trigger('change');
                        }

                        if (workhistory.start_date != '') { $("#start_date_status").val(workhistory.start_date); }
                        if (workhistory.end_date != '') { $("#end_date_status").val(workhistory.end_date); }
                        $("#prokah_num_status").val(workhistory.prokah_num);

                        $("#frmUpdateStaffStatus").attr("action", updateURL);
                        $("#frmUpdateStaffStatus").prepend(putMethod);
                        $("#modalUpdateStaffStatus").modal("show");
                    }
                });

            });
            
            // Location change event -> auto-fill data for office dropdown
            $("#location_code").change(function() {
                var locationCode = $(this).val();
                addValueToOfficeDropdown(locationCode);
                addValueToPositionDropdown(locationCode);
            });

            if ($("#location_code").attr("data-old-value")) {
                $("#location_code").trigger("change");
            }
            
            // Event on current position checkbox
            $("#cur_pos").change(function() {
                $("#end_date").prop("disabled", $(this).is(":checked"));
            });

            // Event on prokah
            $("#prokah").change(function() {
                $("#prokah_num").prop('disabled', !this.checked);
            });

            // Form submit
            $("#frmCreateWorkHistory").submit(function() {
                $("#modalCreateWorkHistory").hide();
                loadModalOverlay();
            });

            // Leave Request Validation
            $('#frmCreateLeave').validate({
                submitHandler: function(frm) {
                    $("#modalLeaveInfo").hide();
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

            // Add new leave
            $("#btn-add-leave").click(function() {
                var addURL = $(this).data("add-url");
                $("#frmCreateLeave").trigger("reset");
                $('#leave_type_id').val('').change();
                
                $("input[name='_method']").remove();
                $("#frmCreateLeave").attr("action", addURL);
                $("#modalLeaveInfo").modal("show");
            });

            // Edit Leave Info
            $(document).on("click", ".btn-edit-leave", function() {
                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function(data) {
                    $('#leave_type_id').val(data.leave_type_id).change();
                    $('#start_date_leave').val(data.start_date);
                    $('#end_date_leave').val(data.end_date);
                    $('#description').val(data.description);

                    $("input[name='_method']").remove();
                    $("#frmCreateLeave").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateLeave").prepend(putMethod);
                    $("#modalLeaveInfo").modal("show");
                });
            });
        });

    </script>

@endpush
