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

                                <form method="post" id="frmCreateTeaching" action="{{ route('teaching.store', [app()->getLocale(), $payroll_id]) }}">
                                    @csrf

                                    <input type="hidden" name="location_code">

                                    <div class="row row-box">
                                        <div class="col-sm-3">
                                            <div class="form-group @error('year_id') has-error @enderror">
                                                <label for="year_id" style="color:#0a7698;">
                                                    <strong>
                                                        <span class="section-num">{{ __('number.num14').'.' }}</span>
                                                        {{ __('common.year') }}
                                                        <span class="required">*</span>
                                                    </strong>
                                                </label>

                                                <select name="year_id" id="year_id" class="form-control select2" style="width:100%;">
                                                    <option value="">{{ __('common.choose') }} ...</option>

                                                    @foreach($academicYears as $academicYear)
                                                        <option value="{{ $academicYear->year_id }}">
                                                            {{ $academicYear->year_kh }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <div style="margin-top:15px;">
                                                    <label for="overtime">@lang('common.overtime')</label>
                                                    <input type="number" name="overtime" maxlength="2" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-9 custom-checkbox teaching-box">
                                            <div class="form pl-xl-3 pt-xl-3 mt-xl-3 d-flex flex-wrap justify-content-sm-between" style="padding-top:0px !important;">
                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="add_teaching" id="add_teaching" type="checkbox" value="1">
                                                        <label for="add_teaching">@lang('common.add_teaching')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="teach_english" id="teach_english" type="checkbox" value="1">
                                                        <label for="teach_english">@lang('common.teach_english')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="multi_grade" id="multi_grade" type="checkbox" value="1">
                                                        <label for="multi_grade">@lang('common.multi_grade')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="triple_grade" id="triple_grade" type="checkbox" value="1">
                                                        <label class="form-check-label" for="triple_grade">@lang('common.triple_grade')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="double_shift" id="double_shift" type="checkbox" value="1">
                                                        <label for="double_shift">@lang('common.double_shift')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="bi_language" id="bi_language" type="checkbox" value="1">
                                                        <label class="form-check-label" for="bi_language">@lang('common.bi_language')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="class_incharge" id="class_incharge" type="checkbox" value="1">
                                                        <label class="form-check-label" for="class_incharge">@lang('common.class_incharge')</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form pl-xl-3 pt-xl-3 mt-xl-3 d-flex flex-wrap justify-content-sm-start" style="padding-top:0px !important;margin-top:0px !important;">
                                                <div class="form-group mr-3 mr-sm-0" style="margin-right:15px !important;">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="chief_technical" id="chief_technical" type="checkbox" value="1">
                                                        <label class="form-check-label" for="chief_technical">@lang('common.technical_lead')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="teach_cross_school" id="teach_cross_school" type="checkbox" value="1">
                                                        <label for="teach_cross_school">
                                                            @lang('common.teach_cross_school')
                                                            <strong><span id="cross-school-display"></span></strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <!-- Teaching subject -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="teaching-subject-sec" class="row">
                                                <!-- Subject -->
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <!--
                                                        <label for="subject_id">{{ __('common.subject') }}</label>
                                                        <select name="subject_id[]" class="form-control select2 subject_id" style="width:100%;">
                                                            <option value="">{{ __('common.choose') }} ...</option>
                                                            @foreach($subjects as $subject)
                                                                <option value="{{ $subject->subject_id }}">
                                                                    {{ $subject->subject_kh }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        -->
                                                    </div>
                                                </div>

                                                <!-- Grade -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <!--
                                                        <label for="grade_id">{{ __('common.grade') }}</label>

                                                        <select name="grade_id[]" class="form-control select2 grade_id" style="width:100%;" hidden="true">
                                                            <option value="">{{ __('common.choose') }} ...</option>

                                                            @foreach($grades as $grade)
                                                                <option value="{{ $grade->grade_id }}">
                                                                    {{ $grade->grade_kh }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        -->
                                                    </div>
                                                </div>

                                                <div class="col-sm-1" style="padding-left:0;">
                                                    <div class="form-group">
                                                        <!--
                                                        <label for="grade_alias">@lang('common.grade_alias')</label>
                                                        <input type="text" name="grade_alias[]" class="form-control grade_alias" maxlength="1" style="width:65px;">
                                                         -->
                                                    </div>
                                                </div>

                                                <!-- Day teaching -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <!--
                                                        <label for="day_id">{{ __('common.day_teaching') }}</label>

                                                        <select name="day_id[]" class="form-control select2 day_id" style="width:100%;">
                                                            <option value="">{{ __('common.choose') }} ...</option>

                                                            @foreach($dayTeachings as $dayTeaching)
                                                                <option value="{{ $dayTeaching->day_id }}">
                                                                    {{ $dayTeaching->day_kh }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        -->
                                                    </div>
                                                </div>

                                                <!-- Hour teaching -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <!--
                                                        <label for="hour_id">{{ __('common.hour_teaching') }}</label>

                                                        <select name="hour_id[]" class="form-control select2 hour_id" style="width:100%;">
                                                            <option value="">{{ __('common.choose') }} ...</option>
                                                            
                                                            @foreach($hourTeachings as $hourTeaching)
                                                                <option value="{{ $hourTeaching->hour_id }}">
                                                                    {{ $hourTeaching->hour_kh }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        -->
                                                    </div>
                                                </div>

                                                <div class="col-sm-1 single-button">
                                                    <!--
                                                    <button type="button" id="btn-add-more" class="btn btn-default" style="width:100%;">
                                                        <i class="fa fa-plus"></i> @lang('button.add')
                                                    </button>
                                                -->
                                                </div>
                                            </div>

                                            <!-- New teaching subject section -->
                                            <div id="new-teaching-subject-sec"></div>
                                        </div>
                                    </div>


                                    <!-- Teaching subject listing -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table style="margin: auto;">
                                                <tr>
                                                    <!-- <td style="padding:5px">
                                                        <button type="button" class="btn btn-danger btn-cancel" style="width:150px;">
                                                            <i class="far fa-times-circle"></i> {{__('button.cancel')}}
                                                        </button>
                                                    </td> -->

                                                    <td style="padding: 5px">
                                                        <button type="submit" class="btn btn-info btn-save" style="width:150px;">
                                                            <i class="far fa-save"></i> {{ __('button.save') }}
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </form>

                                <!-- Teaching listing -->
                                @include('admin.staffs.partials.teaching_info')
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>

    @include('admin.staffs.modals.modal_teaching')

@endsection


@push('scripts')
    
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>

        function removeTeachingSubject(numrow) {
            $("#subject-"+numrow).remove();
        }

        
        $(function() {

            $("#staff-info").addClass("menu-open");
            $("#create-staff > a").addClass("active");
            $("#tab-teaching").addClass("active");

            // Validation
            $("#frmCreateTeaching").validate({
                rules: {
                    year_id: "required",
                },
                messages: {
                    year_id: "{{ __('validation.required_field') }}",
                },
                submitHandler: function(frmCreateTeaching) {
                    loadModalOverlay();
                    frmCreateTeaching.submit();
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
                    //element.closest('.form-group').append(error);
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

            // Multi-grade event
            $("#multi_grade").change(function() {
                $("#double_shift").prop("disabled", $(this).is(":checked"));
                $("#triple_grade").prop("disabled", $(this).is(":checked"));
            });

            // Double-shift checkbox event
            $("#double_shift").change(function() {
                $("#multi_grade").prop("disabled", $(this).is(":checked"));
                $("#triple_grade").prop("disabled", $(this).is(":checked"));
            });

            $("#triple_grade").change(function() {
                $("#multi_grade").prop("disabled", $(this).is(":checked"));
                $("#double_shift").prop("disabled", $(this).is(":checked"));
            });

            // Teach cross school
            $("#teach_cross_school").change(function() {
                if($(this).is(':checked')) {
                    $("#modalCrossTeaching").modal({show:true, backdrop:'static'});
                } else {
                    $("#cross-school-display").empty();
                    $("input[name='location_code']").val("");
                }
            });

            // Cancel select cross school
            $("#btn-cancel-cross-school").click(function() {
                $("#teach_cross_school").prop("checked", false);
            });

            // Ok with cross school
            $("#btn-save-cross-school").click(function() {
                $("input[name='location_code']").val($("#cross_school").val());
                $("#cross-school-display").text(' - ' + $("#cross_school option:selected").text());
                $("#modalCrossTeaching").modal("hide");
            });

            // ADD MORE TEACHING SUBJECT
            var index = 1;

            $("#btn-add-more").click(function(e) {
                e.preventDefault();
                var numrow = index++;

                $("#new-teaching-subject-sec").append('<div class="row" id="subject-'+numrow+'">' + $("#teaching-subject-sec").html() + '</div>');
                $("#new-teaching-subject-sec").find(".form-group").find("label").remove();
                $("#new-teaching-subject-sec").find(".form-group").find("span").remove();
                $("#new-teaching-subject-sec").find(".single-button").empty();
                $("#new-teaching-subject-sec").find(".single-button").replaceWith('<div class="col-sm-1" style="padding-top:5px;"><button class="btn btn-xs btn-danger" style="width:40px;" title="Remove" onclick="removeTeachingSubject('+numrow+')"><i class="far fa-times-circle"></i></button></div>');
                $(".select2").select2();

                $('#subject-'+numrow).find('.subject_id').val($('.subject_id option:selected').val()).change();
                $('#subject-'+numrow).find('.grade_id').val($('.grade_id option:selected').val()).change();
                $('#subject-'+numrow).find('.grade_alias').val($('.grade_alias').val());
                $('#subject-'+numrow).find('.day_id').val($('.day_id option:selected').val()).change();
                $('#subject-'+numrow).find('.hour_id').val($('.hour_id option:selected').val()).change();
            });
        });

    </script>

@endpush
