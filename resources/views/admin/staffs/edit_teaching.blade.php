@extends('layouts.admin')

@section('content')
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <i class="fa fa-file"></i> {{ __('menu.staff_info') }}
                        <span class="kh" style="font-size:2rem;">- {{ $staff->surname_kh.' '.$staff->name_kh }}</span>
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
                        @include('admin.staffs.partials.header_tab')
                    </div>

                    <div class="card-body custom-card">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-personal_details" role="tabpanel" aria-labelledby="custom-tabs-personal_details-tab">

                                <form method="post" id="frmUpdateTeaching" action="{{ route('teaching.update', [app()->getLocale(), $staff->payroll_id, $teaching->teaching_id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="location_code">

                                    <div class="row row-box">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="year_id">
                                                    <strong>
                                                        <span class="section-num">
                                                            {{ __('number.num1').__('number.num3').'.' }}
                                                        </span>
                                                        {{ __('common.year') }}
                                                        <span class="required">*</span>
                                                    </strong>
                                                </label>

                                                <select name="year_id" id="year_id" class="form-control select2" style="width:100%;">
                                                    <option>{{ __('common.choose') }} ...</option>

                                                    @foreach($academicYears as $academicYear)
                                                        <option value="{{ $academicYear->year_id }}" {{ $teaching->year_id == $academicYear->year_id ? 'selected' : '' }}>
                                                            {{ $academicYear->year_kh }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <div style="margin-top:15px;">
                                                    <label for="overtime">@lang('common.overtime')</label>
                                                    <input type="number" name="overtime" maxlength="2" value="{{ $teaching->overtime }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-9 custom-checkbox teaching-box">
                                            <div class="form pl-xl-3 pt-xl-3 mt-xl-3 d-flex flex-wrap justify-content-sm-between" style="padding-top:0px !important;">
                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="add_teaching" id="add_teaching" type="checkbox" value="1" {{ $teaching->add_teaching == 1 ? 'checked' : '' }}>
                                                        <label for="add_teaching" class="form-check-label">@lang('common.add_teaching')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="teach_english" id="teach_english" type="checkbox" value="1" {{ $teaching->teach_english == 1 ? 'checked' : '' }}>
                                                        <label for="teach_english">@lang('common.teach_english')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="multi_grade" id="multi_grade" type="checkbox" value="1" {{ $teaching->multi_grade == 1 ? 'checked' : '' }}>
                                                        <label for="multi_grade" class="form-check-label">@lang('common.multi_grade')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="triple_grade" id="triple_grade" type="checkbox" value="1" {{ $teaching->triple_grade == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="triple_grade">@lang('common.triple_grade')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="double_shift" id="double_shift" type="checkbox" value="1" {{ $teaching->double_shift == 1 ? 'checked' : '' }}>
                                                        <label for="double_shift" class="form-check-label">@lang('common.double_shift')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="bi_language" id="bi_language" type="checkbox" 
                                                            value="1" {{ $teaching->bi_language == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="bi_language">@lang('common.bi_language')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="class_incharge" id="class_incharge" type="checkbox" 
                                                            value="1" {{ $teaching->class_incharge == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="class_incharge">@lang('common.class_incharge')</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form pl-xl-3 pt-xl-3 mt-xl-3 d-flex flex-wrap justify-content-sm-start" style="padding-top:0px !important;margin-top:0px !important;">
                                                <div class="form-group mr-3 mr-sm-0" style="margin-right:15px !important;">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="chief_technical" id="chief_technical" type="checkbox" value="1" {{ $teaching->chief_technical == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="chief_technical">@lang('common.technical_lead')</label>
                                                    </div>
                                                </div>

                                                <div class="form-group mr-3 mr-sm-0">
                                                    <div class="icheck-primary">
                                                        <input class="form-check-input" name="teach_cross_school" id="teach_cross_school" type="checkbox" value="1" {{ $teaching->teach_cross_school == 1 ? 'checked' : '' }}>
                                                        <label for="teach_cross_school">@lang('common.teach_cross_school')
                                                            <strong><span id="cross-school-display">{{ !empty($teaching->crossSchool) ? ' - '.$teaching->crossSchool->location_kh : '' }}</span></strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <!-- Teaching subject -->
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="subject">{{ __('common.subject') }}</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="grade">{{ __('common.grade') }}</label>
                                                </div>
                                                <div class="col-sm-1" style="padding-left:0;">
                                                    <label for="grade">{{ __('common.grade_alias') }}</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="grade">{{ __('common.day_teaching') }}</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="grade">{{ __('common.hour_teaching') }}</label>
                                                </div>
                                            </div>
                                   
                                            @foreach($teachingSubjects as $index => $teachingSubject)

                                                <div class="row" id="subject-{{ $index }}">
                                                    <!-- Subject -->
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <select name="subject_id[]" class="form-control select2" style="width:100%;" disabled=true>
                                                                <option value="">{{ __('') }}</option>

                                                                @foreach($subjects as $subject)

                                                                    <option value="{{ $subject->subject_id }}" {{ $teachingSubject->subject_id == $subject->subject_id ? 'selected' : '' }}>
                                                                        {{ $subject->subject_kh }}
                                                                    </option>

                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Grade -->
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <select name="grade_id[]" class="form-control select2" style="width:100%;" disabled=true>
                                                                <option value="">{{ __('') }}</option>

                                                                @foreach($grades as $grade)
                                                                    <option value="{{ $grade->grade_id }}" {{ $teachingSubject->grade_id == $grade->grade_id ? 'selected' : '' }}>
                                                                        {{ $grade->grade_kh }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Grade alias -->
                                                    <div class="col-sm-1" style="padding-left:0;">
                                                        <div class="form-group">
                                                            <input type="text" name="grade_alias[]" value="{{ $teachingSubject->grade_alias }}" class="form-control" maxlength="1" style="width:65px;" disabled=true>
                                                        </div>
                                                    </div>

                                                    <!-- Day teaching -->
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <select name="day_id[]" class="form-control select2" style="width:100%;" disabled=true>
                                                                <option value="">{{ __('') }}</option>

                                                                @foreach($dayTeachings as $dayTeaching)
                                                                    <option value="{{ $dayTeaching->day_id }}" {{ $teachingSubject->day_id == $dayTeaching->day_id ? 'selected' : '' }}>
                                                                        {{ $dayTeaching->day_kh }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Hour teaching -->
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <select name="hour_id[]" class="form-control select2" style="width:100%;" disabled=true>
                                                                <option value="">{{ __('') }} </option>
                                                                
                                                                @foreach($hourTeachings as $hourTeaching)
                                                                    <option value="{{ $hourTeaching->hour_id }}" {{ $teachingSubject->hour_id == $hourTeaching->hour_id ? 'selected' : '' }}>
                                                                        {{ $hourTeaching->hour_kh }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-1" style="padding-top:5px;">
                                                        <!--
                                                        <button type="button" class="btn btn-xs btn-danger" onclick="removeTeachingSubject({{ $index }})" style="width:40px;" title="Remove">
                                                            <i class="far fa-times-circle"></i>
                                                        </button>
                                                    -->
                                                    </div>
                                                </div>

                                            @endforeach

                                        </div>
                                    </div>


                                    <!-- Teaching subject listing -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table style="margin: auto;">
                                                <tr>
                                                    <td style="padding:5px">
                                                        <a href="javascript:history.go(-1);" class="btn btn-danger btn-cancel" style="width:150px;">
                                                            <i class="far fa-times-circle"></i> {{__('button.cancel')}}
                                                        </a>
                                                    </td>

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

    <script>

        function removeTeachingSubject(numrow=null) {
            $("#subject-"+numrow).remove();
        }

        
        $(function() {

            $("#staff-info").addClass("menu-open");
            $("#create-staff > a").addClass("active");
            $("#tab-teaching").addClass("active");

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
            var index = parseInt("{{ count($teachingSubjects) }}");

            $("#btn-add-more").click(function(e) {
                e.preventDefault();
                var numrow = index++;

                $("#new-teaching-subject-sec").append('<div class="row" id="subject-'+numrow+'">' + $("#teaching-subject-sec").html() + '</div>');
                $("#new-teaching-subject-sec").find(".form-group").find("span").remove();
                $("#new-teaching-subject-sec").find(".single-button").empty();
                $("#new-teaching-subject-sec").find(".single-button").replaceWith('<div class="col-sm-1" style="padding-top:5px;"><button class="btn btn-xs btn-danger" style="width:40px;" title="Remove" onclick="removeTeachingSubject('+numrow+')"><i class="far fa-times-circle"></i></button></div>');
                $(".select2").select2();

            });

        });

    </script>

@endpush
