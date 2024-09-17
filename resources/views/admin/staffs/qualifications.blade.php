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
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 style="border-bottom:none;margin-bottom:15px;">
                                            <span class="section-num">{{ __('number.num9').'. ' }}</span>
                                            {{ __('qualification.teaching_qual') }}
                                        </h4>

                                        <h6 style="margin-top:20px;margin-bottom:20px;">
                                            {{ __('qualification.high_teaching_qual') }}: 
                                            <strong class="kh">{{ !empty($highestQual) ? $highestQual->prof_category_kh : '' }}</strong>
                                        </h6>

                                        <table class="table table-bordered table-head-fixed text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>{{__('qualification.prof_skill_desc')}}</th>
                                                    <th>{{__('qualification.first_subject')}}</th>
                                                    <th>{{__('qualification.second_subject')}}</th>
                                                    <th>{{__('qualification.training_sys')}}</th>
                                                    <th>{{__('common.development_school')}}</th>
                                                    <th>{{__('qualification.date_obtained')}}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @foreach($qualifications as $index => $qualification)

                                                    <tr id="record-{{ $qualification->prof_id }}">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td class="kh">
                                                            {{ !empty($qualification->professionalCategory) ? 
                                                                $qualification->professionalCategory->prof_category_kh : '---' }}
                                                        </td>

                                                        <td class="kh">{{ !empty($qualification->firstSubject) ? 
                                                            $qualification->firstSubject->subject_kh : '---' }}</td>
                                                        
                                                        <td class="kh">
                                                            {{ !empty($qualification->secondSubject) ? 
                                                                $qualification->secondSubject->subject_kh : '---' }}
                                                        </td>

                                                        <td class="kh">
                                                            {{ !empty($qualification->professionalType) ? 
                                                                $qualification->professionalType->prof_type_kh : '---' }}
                                                        </td>

                                                        <td class="kh">
                                                            {{ !empty($qualification->location) ? 
                                                                $qualification->location->location_kh : '---' }}
                                                        </td>

                                                        <td>
                                                            {{ $qualification->prof_date > 0 ? 
                                                                date('d-m-Y', strtotime($qualification->prof_date)) : '---' }}
                                                        </td>

                                                        <td class="text-right">
                                                            <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('qualifications.edit', [app()->getLocale(), $staff->payroll_id, $qualification->prof_id]) }}" data-update-url="{{ route('qualifications.update', [app()->getLocale(), $staff->payroll_id, $qualification->prof_id]) }}"><i class="far fa-edit"></i> @lang('button.edit')</button>

                                                            <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('qualifications.destroy', [app()->getLocale(), $staff->payroll_id, $qualification->prof_id]) }}"><i class="fas fa-trash-alt"></i> @lang('button.delete')</button>
                                                        </td>
                                                    </tr>
                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12 text-right">
                                        <button type="button" class="btn btn-sm btn-primary" id="btn-add" data-add-url="{{ route('qualifications.store', [app()->getLocale(), $staff->payroll_id]) }}" style="width:220px;"><i class="fas fa-plus"></i> {{ __('button.addtolist') }}</button>
                                    </div>

                                    <!-- Modal create new short course -->
                                    @include('admin.staffs.modals.modal_qualification')
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-md-12">{{ $qualifications->links() }}</div>
        </div>
    </section>

@endsection


@push('scripts')
    
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>
        
        $(function() {

            $('[data-mask]').inputmask();

            $("#staff-info").addClass("menu-open");
            $("#create-staff > a").addClass("active");
            $("#tab-qualification").addClass("active");

            // Validation
            $("#frmCreateQualification").validate({
                rules: {
                    prof_category_id: "required",
                    prof_date: "required",
                    prof_type_id: "required",
                },
                messages: {
                    prof_category_id: "{{ __('validation.required_field') }}",
                    prof_date: "{{ __('validation.required_field') }}",
                    prof_type_id: "{{ __('validation.required_field') }}",
                },
                submitHandler: function(frm) {
                    $("#modal-qualification").hide();
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

            // Professional Category Event
            $("#prof_category_id").change(function() {
                $("#subject_req").addClass("d-none");
                $("#subject-group").removeClass("has-error");
                
                if ($(this).val() != "") {
                    $.ajax({
                        type: "GET",
                        url: "/qualification/" + $(this).val() + "/ranks",
                        success: function (prof_hierachy) {
                            if (prof_hierachy <= 7) {
                                $("#subject_req").removeClass("d-none");
                                $("#subject_id1").prop("required", true);
                                $("#subject-group").addClass("has-error");
                            }
                            else {
                                $("#subject_req").addClass("d-none");
                                $("#subject_id1").prop("required", false);
                                $("#subject-group").removeClass("has-error");
                                $("#subject_id1-error").addClass("d-none");
                            }
                        },
                        error: function (err) {
                            console.log('Error:', err);
                        }
                    });
                }
            });

            $("#subject_id1").change(function() {
                if ($(this).val() != "") { $("#subject-group").removeClass("has-error"); }
            });

            // CREATE NEW QUALIFICATION
            $("#btn-add").click(function() {
                var addURL = $(this).data("add-url");

                $("#frmCreateQualification").trigger("reset");
                $("#select2-prof_category_id-container").text('ជ្រើសរើស ...');
                $("#select2-subject_id1-container").text('ជ្រើសរើស ...');
                $("#select2-subject_id2-container").text('ជ្រើសរើស ...');
                $("#select2-prof_type_id-container").text('ជ្រើសរើស ...');

                $("input[name='_method']").remove();
                $("#frmCreateQualification").attr("action", addURL);
                $("#modal-qualification").modal("show");
            });


            // EDIT QUALIFICATION
            $(document).on("click", ".btn-edit", function() {

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function(qualification) {

                    $("#prof_category_id option[value='"+qualification.prof_category_id+"']").prop("selected", true);
                    $("#select2-prof_category_id-container")
                        .text($("#prof_category_id option[value='"+qualification.prof_category_id+"']").text());

                    // SUBJECT 1st
                    if( qualification.subject_id1 != null ) {
                        $("#subject_id1 option[value='"+qualification.subject_id1+"']").prop("selected", true);
                        $("#select2-subject_id1-container")
                            .text($("#subject_id1 option[value='"+qualification.subject_id1+"']").text());
                    } else {
                        $("#select2-subject_id1-container").text('ជ្រើសរើស ...');
                        $("#subject_id1").find("option").prop("selected", false);
                    }

                    // SUBJECT 2nd
                    if( qualification.subject_id2 != null ) {
                        $("#subject_id2 option[value='"+qualification.subject_id2+"']").prop("selected", true);
                        $("#select2-subject_id2-container")
                            .text($("#subject_id2 option[value='"+qualification.subject_id2+"']").text());
                    } else {
                        $("#select2-subject_id2-container").text('ជ្រើសរើស ...');
                        $("#subject_id2").find("option").prop("selected", false);
                    }

                    // PROFESSIONAL TYPE
                    if( qualification.prof_type_id != null ) {
                        $("#prof_type_id option[value='"+qualification.prof_type_id+"']").prop("selected", true);
                        $("#select2-prof_type_id-container")
                            .text($("#prof_type_id option[value='"+qualification.prof_type_id+"']").text());
                    } else {
                        $("#select2-prof_type_id-container").text('ជ្រើសរើស ...');
                        $("#prof_type_id").find("option").prop("selected", false);
                    }

                    // Location
                    if( qualification.location_code != null ) {
                        $("#location_code option[value='"+qualification.location_code+"']").prop("selected", true);
                        $("#select2-location_code-container")
                            .text($("#location_code option[value='"+qualification.location_code+"']").text());
                    } else {
                        $("#select2-location_code-container").text('ជ្រើសរើស ...');
                        $("#location_code").find("option").prop("selected", false);
                    }

                    if (qualification.prof_date != '') { $("#prof_date").val(qualification.prof_date); }

                    $("input[name='_method']").remove();
                    $("#frmCreateQualification").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateQualification").prepend(putMethod);
                    $("#modal-qualification").modal("show");
                });

            });

        });

    </script>

@endpush
