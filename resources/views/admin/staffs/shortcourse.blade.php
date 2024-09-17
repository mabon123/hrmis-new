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
                                            <span class="section-num">{{ __('number.num10').'. ' }}</span>
                                            {{ __('common.short_course') }}
                                        </h4>

                                        <table class="table table-bordered table-head-fixed text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>{{__('common.category')}}</th>
                                                    <th>{{__('common.skill')}}</th>
                                                    <th>{{__('common.start_date')}}</th>
                                                    <th>{{__('common.end_date')}}</th>
                                                    <th>{{__('common.duration')}}</th>
                                                    <th>{{__('common.organised_by')}}</th>
                                                    <th>{{__('common.donor')}}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @foreach($shortCourses as $index => $shortCourse)

                                                    <tr id="record-{{ $shortCourse->shortcourse_id }}">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td class="kh">{{ !empty($shortCourse->category) ? $shortCourse->category->shortcourse_cat_kh : '' }}</td>
                                                        <td class="kh">{{ $shortCourse->qualification }}</td>
                                                        <td>{{ $shortCourse->start_date > 0 ? date('d-m-Y', strtotime($shortCourse->start_date)) : '' }}</td>
                                                        
                                                        <td>{{ $shortCourse->end_date > 0 ? date('d-m-Y', strtotime($shortCourse->end_date)) : '' }}</td>

                                                        <td class="kh">{{ $shortCourse->duration.' '.(!empty($shortCourse->durationType) ? $shortCourse->durationType->dur_type_kh : '') }}</td>
                                                        
                                                        <td class="kh">{{ !empty($shortCourse->organizer) ? $shortCourse->organizer->partner_type_kh : '' }}</td>

                                                        <td class="kh">{{ !empty($shortCourse->donator) ? $shortCourse->donator->partner_type_kh : '' }}</td>
                                                        
                                                        <td class="text-right">
                                                            <button type="button" class="btn btn-xs btn-info btn-edit-course" data-edit-url="{{ route('shortcourses.edit', [app()->getLocale(), $staff->payroll_id, $shortCourse->shortcourse_id]) }}" data-update-url="{{ route('shortcourses.update', [app()->getLocale(), $staff->payroll_id, $shortCourse->shortcourse_id]) }}"><i class="far fa-edit"></i> @lang('button.edit')</button>

                                                            <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('shortcourses.destroy', [app()->getLocale(), $staff->payroll_id, $shortCourse->shortcourse_id]) }}"><i class="fas fa-trash-alt"></i> @lang('button.delete')</button>
                                                        </td>
                                                    </tr>
                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12 text-right">
                                        <button type="button" class="btn btn-sm btn-primary" id="btn-add-course" data-add-url="{{ route('shortcourses.store', [app()->getLocale(), $staff->payroll_id]) }}" style="width:220px;"><i class="fas fa-plus"></i> {{ __('button.addtolist') }}</button>
                                    </div>

                                    <!-- Modal create new short course -->
                                    @include('admin.staffs.modals.modal_short_course')
                                </div>

                                

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 style="border-bottom:none;margin-bottom:15px;">
                                            <span class="section-num">{{ __('number.num11').'. ' }}</span>
                                            {{ __('common.foreign_language') }}
                                        </h4>

                                        <table class="table table-bordered table-head-fixed text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>{{__('common.languages')}}</th>
                                                    <th>{{__('common.reading')}}</th>
                                                    <th>{{__('common.writing')}}</th>
                                                    <th>{{__('common.conversation')}}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @foreach($staffLanguages as $index => $staffLanguage)

                                                    <tr id="lang-record-{{ $staffLanguage->staff_lang_id }}">
                                                        <td>{{ $index + 1 }}</td>

                                                        <td class="kh">{{ !empty($staffLanguage->language) ? $staffLanguage->language->language_kh : '' }}</td>

                                                        <td>{{ $staffLanguage->reading }}</td>
                                                        <td>{{ $staffLanguage->writing }}</td>
                                                        <td>{{ $staffLanguage->conversation }}</td>
                                                        
                                                        <td class="text-right">
                                                            <button type="button" class="btn btn-xs btn-info btn-edit-language" data-edit-url="{{ route('staff-language.edit', [app()->getLocale(), $staff->payroll_id, $staffLanguage->staff_lang_id]) }}" data-update-url="{{ route('staff-language.update', [app()->getLocale(), $staff->payroll_id, $staffLanguage->staff_lang_id]) }}"><i class="far fa-edit"></i> @lang('button.edit')</button>

                                                            <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('staff-language.destroy', [app()->getLocale(), $staff->payroll_id, $staffLanguage->staff_lang_id]) }}"><i class="fas fa-trash-alt"></i> @lang('button.delete')</button>
                                                        </td>
                                                    </tr>
                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12 text-right">
                                        <button type="button" class="btn btn-sm btn-primary" id="btn-add-language" data-add-url="{{ route('staff-language.store', [app()->getLocale(), $staff->payroll_id]) }}" style="width:220px;"><i class="fas fa-plus"></i> {{ __('button.addtolist') }}</button>
                                    </div>

                                    <!-- Modal create new foreign language -->
                                    @include('admin.staffs.modals.modal_languages')
                                </div>
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

    <script>
        
        $(function() {
            $('[data-mask]').inputmask();

            $("#staff-info").addClass("menu-open");
            $("#create-staff > a").addClass("active");
            $("#tab-shortcourse").addClass("active");

            // Date rank
            $("#start_date, #end_date").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                yearRange: '1900:' + ((new Date).getFullYear() + 10),
                onSelect: function( selectedDate ) {
                    if(this.id == 'start_date'){
                      var dateMin = $('#start_date').datepicker("getDate");
                      var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 1); 
                      var rMax = new Date();
                      $('#end_date').datepicker("option","minDate", rMin);
                      $('#end_date').datepicker("option","maxDate", rMax);                    
                    }
                    
                }
            });

            // Validation
            $("#frmCreateShortCourse").validate({
                rules: {
                    shortcourse_cat_id: "required",
                    qual_date: "required",
                    start_date: "required",
                    end_date: "required",
                    qualification: "required",
                    organized: "required",
                    donor: "required",
                    duration: "required",
                    duration_type_id: "required",
                },
                messages: {
                    shortcourse_cat_id: "{{ __('validation.required_field') }}",
                    qual_date: "{{ __('validation.required_field') }}",
                    start_date: "{{ __('validation.required_field') }}",
                    end_date: "{{ __('validation.required_field') }}",
                    qualification: "{{ __('validation.required_field') }}",
                    organized: "{{ __('validation.required_field') }}",
                    donor: "{{ __('validation.required_field') }}",
                    duration: "{{ __('validation.required_field') }}",
                    duration_type_id: "{{ __('validation.required_field') }}",
                },
                submitHandler: function(frm) {
                    var startDate = new Date($('#start_date').val());
                    var endDate = new Date($('#end_date').val());

                    if (endDate < startDate) {
                        $("#alert-section").removeClass("d-none");
                        $("#gte").remove();
                        $("#errors").append("<li id='gte'>{{ __('validation.gte_start_date') }}</li>");
                        $("#end_date").addClass("is-invalid");

                        return false;
                    }
                    
                    $("#modal-short-course").hide();
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

            // Language Validation
            $("#frmCreateLanguage").validate({
                rules: {
                    language_id: "required",
                    reading: "required",
                    writing: "required",
                    conversation: "required",
                },
                messages: {
                    language_id: "{{ __('validation.required_field') }}",
                    reading: "{{ __('validation.required_field') }}",
                    writing: "{{ __('validation.required_field') }}",
                    conversation: "{{ __('validation.required_field') }}",
                },
                submitHandler: function(frm) {
                    $("#modal-languages").hide();
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
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            // CREATE NEW SHORT COURSE
            $("#btn-add-course").click(function() {
                var addURL = $(this).data("add-url");

                $("#frmCreateShortCourse").trigger("reset");
                $("#select2-shortcourse_cat_id-container").text('ជ្រើសរើស ...');
                $("#select2-duration_type_id-container").text('ជ្រើសរើស ...');
                $("#select2-organized-container").text('ជ្រើសរើស ...');
                $("#select2-donor-container").text('ជ្រើសរើស ...');

                $("input[name='_method']").remove();
                $("#frmCreateShortCourse").attr("action", addURL);
                $("#modal-short-course").modal("show");
            });


            // EDIT SHORT COURSE
            $(document).on("click", ".btn-edit-course", function() {

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function(shortcourse) {

                    // CATEGORY
                    if( shortcourse.shortcourse_cat_id != null ) {
                        $("#shortcourse_cat_id option[value='"+shortcourse.shortcourse_cat_id+"']").prop("selected", true);
                        $("#select2-shortcourse_cat_id-container")
                            .text($("#shortcourse_cat_id option[value='"+shortcourse.shortcourse_cat_id+"']").text());
                    } else {
                        $("#select2-shortcourse_cat_id-container").text('ជ្រើសរើស ...');
                        $("#shortcourse_cat_id").find("option").prop("selected", false);
                    }

                    // DURATION TYPE
                    if( shortcourse.duration_type_id != null ) {
                        $("#duration_type_id option[value='"+shortcourse.duration_type_id+"']").prop("selected", true);
                        $("#select2-duration_type_id-container")
                            .text($("#duration_type_id option[value='"+shortcourse.duration_type_id+"']").text());
                    } else {
                        $("#select2-duration_type_id-container").text('ជ្រើសរើស ...');
                        $("#duration_type_id").find("option").prop("selected", false);
                    }

                    // ORGANIZER
                    if( shortcourse.organized != null ) {
                        $("#organized option[value='"+shortcourse.organized+"']").prop("selected", true);
                        $("#select2-organized-container")
                            .text($("#organized option[value='"+shortcourse.organized+"']").text());
                    } else {
                        $("#select2-organized-container").text('ជ្រើសរើស ...');
                        $("#organized").find("option").prop("selected", false);
                    }

                    // DONATOR
                    if( shortcourse.donor != null ) {
                        $("#donor option[value='"+shortcourse.donor+"']").prop("selected", true);
                        $("#select2-donor-container")
                            .text($("#donor option[value='"+shortcourse.donor+"']").text());
                    } else {
                        $("#select2-donor-container").text('ជ្រើសរើស ...');
                        $("#donor").find("option").prop("selected", false);
                    }
                    
                    $("#shortcourse_skill").val(shortcourse.qualification);
                    $("#qual_date").val(shortcourse.qual_date);
                    $("#start_date").val(shortcourse.start_date);
                    $("#end_date").val(shortcourse.end_date);
                    $("#duration").val(shortcourse.duration);

                    $("input[name='_method']").remove();
                    $("#frmCreateShortCourse").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateShortCourse").prepend(putMethod);
                    $("#modal-short-course").modal("show");
                });

            });

            // CREATE NEW LANGUAGE
            $("#btn-add-language").click(function() {
                var addURL = $(this).data("add-url");

                $("#frmCreateLanguage").trigger("reset");
                $("#select2-language_id-container").text('ជ្រើសរើស ...');
                $("#select2-reading-container").text('ជ្រើសរើស ...');
                $("#select2-writing-container").text('ជ្រើសរើស ...');
                $("#select2-conversation-container").text('ជ្រើសរើស ...');

                $("input[name='_method']").remove();
                $("#frmCreateLanguage").attr("action", addURL);
                $("#modal-languages").modal("show");
            });

            // EDIT LANGUAGE
            $(document).on("click", ".btn-edit-language", function() {

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function(language) {

                    // LANGUAGE
                    if( language.language_id != null ) {
                        $("#language_id option[value='"+language.language_id+"']").prop("selected", true);
                        $("#select2-language_id-container")
                            .text($("#language_id option[value='"+language.language_id+"']").text());
                    } else {
                        $("#select2-language_id-container").text('ជ្រើសរើស ...');
                        $("#language_id").find("option").prop("selected", false);
                    }

                    // READING
                    if( language.reading != null ) {
                        $("#reading option[value='"+language.reading+"']").prop("selected", true);
                        $("#select2-reading-container")
                            .text($("#reading option[value='"+language.reading+"']").text());
                    } else {
                        $("#select2-reading-container").text('ជ្រើសរើស ...');
                        $("#reading").find("option").prop("selected", false);
                    }

                    // WRITING
                    if( language.writing != null ) {
                        $("#writing option[value='"+language.writing+"']").prop("selected", true);
                        $("#select2-writing-container")
                            .text($("#writing option[value='"+language.writing+"']").text());
                    } else {
                        $("#select2-writing-container").text('ជ្រើសរើស ...');
                        $("#writing").find("option").prop("selected", false);
                    }

                    // CONVERSATION
                    if( language.conversation != null ) {
                        $("#conversation option[value='"+language.conversation+"']").prop("selected", true);
                        $("#select2-conversation-container")
                            .text($("#conversation option[value='"+language.conversation+"']").text());
                    } else {
                        $("#select2-conversation-container").text('ជ្រើសរើស ...');
                        $("#conversation").find("option").prop("selected", false);
                    }

                    $("input[name='_method']").remove();
                    $("#frmCreateLanguage").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateLanguage").prepend(putMethod);
                    $("#modal-languages").modal("show");
                });

            });

        });

    </script>

@endpush
