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

                                <form method="post" id="frmCreateContTeaching" 
                                    action="{{ route('contract-teachers.teaching.store', 
                                        [app()->getLocale(), $contract_teacher->payroll_id]) }}">
                                    @csrf

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
                                                                    <option value="{{ $academicYear->year_id }}">
                                                                        {{ $academicYear->year_kh }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-8 custom-checkbox teaching-box" style="height:100px !important;">
                                                        <div class="form pl-xl-3 pt-xl-3 mt-xl-3 d-flex flex-wrap justify-content-sm-between" style="padding-top:0px !important;">
                                                            <div class="form-group mr-3 mr-sm-0">
                                                                <div class="icheck-primary">
                                                                    <input class="form-check-input" name="multi_grade" id="multi_grade" type="checkbox" value="1">
                                                                    <label for="multi_grade">@lang('common.multi_grade')</label>
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
                                                                    <label for="bi_language">@lang('common.bi_language')</label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group mr-3 mr-sm-0">
                                                                <div class="icheck-primary">
                                                                    <input class="form-check-input" name="teach_english" id="teach_english" type="checkbox" value="1">
                                                                    <label for="teach_english">@lang('common.teach_english')</label>
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
                                            <div id="teaching-subject-sec" class="row">
                                                <!-- Subject -->
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="subject_id">{{ __('common.subject') }}</label>

                                                        <select name="subject_id[]" class="form-control kh select2" style="width:100%;">
                                                            <option value="">{{ __('common.choose') }} ...</option>

                                                            @foreach($subjects as $subject)

                                                                <option value="{{ $subject->subject_id }}">
                                                                    {{ $subject->subject_kh }}
                                                                </option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Grade -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label for="grade_id">{{ __('common.grade') }}</label>

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
                                                        <label for="day_id">{{ __('common.day_teaching') }}</label>

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
                                                        <label for="hour_id">{{ __('common.hour_teaching') }}</label>

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

                                                <div class="col-sm-2 single-button">
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
                                <div class="row" style="margin-top:20px;">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title" style="color:#000;">{{ __('common.teaching') }}</h3>
                                            </div>

                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered table-head-fixed text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10px">#</th>
                                                                <th>{{__('common.year')}}</th>
                                                                <th class="text-center">{{__('common.multi_grade')}}</th>
                                                                <th class="text-center">{{__('common.double_shift')}}</th>
                                                                <th class="text-center">{{__('common.bi_language')}}</th>
                                                                <th class="text-center">{{__('common.teach_english')}}</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="teaching-subject-listing">

                                                            @foreach($teachings as $index => $teaching)

                                                                <tr id="record-{{ $teaching->teaching_id }}">
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td class="kh">{{ $teaching->academicYear->year_kh }}</td>

                                                                    <td class="text-center">
                                                                        @if( $teaching->multi_grade == 1 )
                                                                             <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                                                        @else
                                                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                                                        @endif
                                                                    </td>

                                                                    <td class="text-center">
                                                                        @if( $teaching->double_shift == 1 )
                                                                             <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                                                        @else
                                                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                                                        @endif
                                                                    </td>

                                                                    <td class="text-center">
                                                                        @if( $teaching->bi_language == 1 )
                                                                             <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                                                        @else
                                                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                                                        @endif
                                                                    </td>

                                                                    <td class="text-center">
                                                                        @if( $teaching->teach_english == 1 )
                                                                             <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                                                        @else
                                                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                                                        @endif
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <a href="{{ route('cont_teaching.edit', [app()->getLocale(), $teaching->teaching_id]) }}" class="btn btn-xs btn-info btn-edit"><i class="far fa-edit"></i> {{ __('button.edit') }}</a>

                                                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $teaching->teaching_id }}" data-delete-url="{{ route('contract-teachers.teaching.destroy', [app()->getLocale(), $teaching->teaching_id, $teaching->teaching_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                                                    </td>
                                                                </tr>

                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
            <div class="col-md-12"></div>
        </div>
    </section>

@endsection


@push('scripts')
    
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>

    <!-- Validation -->
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>

        function removeTeachingSubject(numrow) {
            $("#subject-"+numrow).remove();
        }

        
        $(function() {

            $("#contract-teacher").addClass("menu-open");
            $("#contract-teacher-listing > a").addClass("active");
            $("#tab-teaching").addClass("active");

            // Validation
            $("#frmCreateContTeaching").validate({
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
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
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
                $("#new-teaching-subject-sec").find(".single-button").replaceWith('<div class="col-sm-2" style="padding-top:5px;"><button class="btn btn-xs btn-danger" onclick="removeTeachingSubject('+numrow+')"><i class="far fa-times-circle"></i> លុបចេញ</button></div>');
                $(".select2").select2();

            });

            // Remove contract teacher - teaching info
            $(document).on("click", ".btn-delete", function() {
                var deleteURL = $(this).data("delete-url");
                var deleted = confirm('Are you sure you want to remove this entry?');

                if( deleted ) {
                    var itemID = $(this).val();

                    $.ajax({
                        type: "DELETE",
                        url: deleteURL,
                        success: function (data) {
                            $("#record-" + itemID).remove();
                            
                            // Toast
                            toastMessage("bg-success", "{{ __('validation.delete_success') }}");
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
