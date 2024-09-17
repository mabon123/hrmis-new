@extends('layouts.admin')

@section('content')
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <i class="fa fa-file"></i> {{ __('menu.contract_teacher_info') }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>
                                {{ __('menu.home') }}</a></li>
                        <li class="breadcrumb-item active">@lang('menu.contract_teacher_info')</li>
                        <li class="breadcrumb-item active">@lang('common.teaching')</li>
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
                        @include('admin.contract_teachers.header_tab')
                    </div>

                    <div class="card-body custom-card">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-personal_details" role="tabpanel" aria-labelledby="custom-tabs-personal_details-tab">

                                <form method="post" id="frm" action="{{ route('contract-teachers.teaching.update', [app()->getLocale(), $teaching->payroll_id, $teaching->teaching_id]) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row-box">
                                                <div class="row">
                                                	<div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="year_id">
                                                                <span class="section-num">{{ __('number.num11') }}.</span>
                                                                {{ __('common.year') }}
                                                                <span class="required">*</span>
                                                            </label>

                                                            <select name="year_id" id="year_id" class="form-control kh select2" style="width:100%;">
                                                                <option value="">{{ __('common.choose') }} ...</option>

                                                                @foreach($academicYears as $academicYear)
                                                                    <option value="{{ $academicYear->year_id }}" {{ $teaching->year_id == $academicYear->year_id ? 'selected' : '' }}>
                                                                        {{ $academicYear->year_kh }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-8 custom-checkbox">
                                                        <div class="row teaching-box" style="padding-top:22px;">
                                                            <div class="col-sm-12">
                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group mr-3 mr-sm-0">
                                                                            <div class="icheck-primary">
                                                                                <input class="form-check-input" name="multi_grade" id="multi_grade" type="checkbox" value="1" {{ $teaching->multi_grade == 1 ? 'checked' : '' }}>
                                                                                <label for="multi_grade" class="form-check-label">{{__('common.multi_grade')}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group mr-3 mr-sm-0">
                                                                            <div class="icheck-primary">
                                                                                <input class="form-check-input" name="double_shift" id="double_shift" type="checkbox" value="1" {{ $teaching->double_shift == 1 ? 'checked' : '' }}>
                                                                                <label for="double_shift" class="form-check-label">{{__('common.double_shift')}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group mr-3 mr-sm-0">
                                                                            <div class="icheck-primary">
                                                                                <input class="form-check-input" name="bi_language" id="bi_language" type="checkbox" value="1" {{ $teaching->bi_language == 1 ? 'checked' : '' }}>
                                                                                <label for="bi_language" class="form-check-label">{{__('common.bi_language')}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group mr-3 mr-sm-0">
                                                                            <div class="icheck-primary">
                                                                                <input class="form-check-input" name="teach_english" id="teach_english" type="checkbox" value="1" {{ $teaching->teach_english == 1 ? 'checked' : '' }}>
                                                                                <label for="teach_english" class="form-check-label">{{__('common.teach_english')}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                            <select name="subject_id[]" class="form-control select2" style="width:100%;">
                                                                <option value="">{{ __('common.choose') }} ...</option>

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
                                                            <select name="grade_id[]" class="form-control select2" style="width:100%;">
                                                                <option value="">{{ __('common.choose') }} ...</option>

                                                                @foreach($grades as $grade)
                                                                    <option value="{{ $grade->grade_id }}" {{ $teachingSubject->grade_id == $grade->grade_id ? 'selected' : '' }}>
                                                                        {{ $grade->grade_kh }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Day teaching -->
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <select name="day_id[]" class="form-control select2" style="width:100%;">
                                                                <option value="">{{ __('common.choose') }} ...</option>

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
                                                            <select name="hour_id[]" class="form-control select2" style="width:100%;">
                                                                <option value="">{{ __('common.choose') }} ...</option>
                                                                
                                                                @foreach($hourTeachings as $hourTeaching)
                                                                    <option value="{{ $hourTeaching->hour_id }}" {{ $teachingSubject->hour_id == $hourTeaching->hour_id ? 'selected' : '' }}>
                                                                        {{ $hourTeaching->hour_kh }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2" style="padding-top:5px;">
                                                        <button type="button" class="btn btn-xs btn-danger" onclick="removeTeachingSubject({{ $index }})">
                                                            <i class="far fa-times-circle"></i> @lang('button.delete')
                                                        </button>
                                                    </div>
                                                </div>

                                            @endforeach

                                            <h5></h5>

                                            <div id="teaching-subject-sec" class="row">
                                                <!-- Subject -->
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <select name="subject_id[]" class="form-control select2" style="width:100%;">
                                                            <option value="">{{ __('common.choose') }} ...</option>

                                                            @foreach($subjects as $subject)

                                                                <option value="{{ $subject->subject_id }}" {{ $teaching->subject_id == $subject->subject_id ? 'selected' : '' }}>
                                                                    {{ $subject->subject_kh }}
                                                                </option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Grade -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <select name="grade_id[]" class="form-control select2" style="width:100%;">
                                                            <option value="">{{ __('common.choose') }} ...</option>

                                                            @foreach($grades as $grade)
                                                                <option value="{{ $grade->grade_id }}">
                                                                    {{ $grade->grade_kh }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Day teaching -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <select name="day_id[]" class="form-control select2" style="width:100%;">
                                                            <option value="">{{ __('common.choose') }} ...</option>

                                                            @foreach($dayTeachings as $dayTeaching)
                                                                <option value="{{ $dayTeaching->day_id }}">
                                                                    {{ $dayTeaching->day_kh }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Hour teaching -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <select name="hour_id[]" class="form-control select2" style="width:100%;">
                                                            <option value="">{{ __('common.choose') }} ...</option>
                                                            
                                                            @foreach($hourTeachings as $hourTeaching)
                                                                <option value="{{ $hourTeaching->hour_id }}">
                                                                    {{ $hourTeaching->hour_kh }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2 single-button" style="padding-top:0;">
                                                    <button type="button" id="btn-add-more" class="btn btn-default" style="width:100%;">
                                                        <i class="fa fa-plus"></i> @lang('button.add_more')
                                                    </button>
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
                                                    <td style="padding:5px">
                                                        <a href="{{ route('contract-teachers.teaching.index', [app()->getLocale(), $teaching->payroll_id, $teaching->payroll_id]) }}" class="btn btn-danger btn-cancel" style="width:150px;">
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

        <!-- Pagination -->
        <div class="row">
            <div class="col-md-12"></div>
        </div>
    </section>

@endsection


@push('scripts')
    
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>

    <script>

        function removeTeachingSubject(numrow=null) {
            $("#subject-"+numrow).remove();
        }

        
        $(function() {

            $("#contract-teacher").addClass("menu-open");
            $("#contract-teacher-listing > a").addClass("active");
            $("#tab-teaching").addClass("active");


            // ADD MORE TEACHING SUBJECT
            var index = parseInt("{{ count($teachingSubjects) }}");

            $("#btn-add-more").click(function(e) {
                e.preventDefault();
                var numrow = index++;

                $("#new-teaching-subject-sec").append('<div class="row" id="subject-'+numrow+'">' + $("#teaching-subject-sec").html() + '</div>');
                $("#new-teaching-subject-sec").find(".form-group").find("span").remove();
                $("#new-teaching-subject-sec").find(".single-button").empty();
                $("#new-teaching-subject-sec").find(".single-button").replaceWith('<div class="col-sm-2" style="padding-top:5px;"><button class="btn btn-xs btn-danger" onclick="removeTeachingSubject('+numrow+')"><i class="far fa-times-circle"></i> លុបចេញ</button></div>');
                $(".select2").select2();

            });

        });

    </script>

@endpush
