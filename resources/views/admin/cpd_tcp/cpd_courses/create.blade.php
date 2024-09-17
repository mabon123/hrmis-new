@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.cpd_structured_course') }}
                </h1>
            </div>
            <?php /* ?><div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.contract_teacher_info') }}</li>
                    <li class="breadcrumb-item active">{{ __('menu.new_contract_teacher') }}</li>
                </ol>
            </div><?php */ ?>
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
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active">{{ __('common.basic_info') }}</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body custom-card">
                    <div class="tab-content">
                        <div class="tab-pane fade show active">
                            @if ( isset($cpd_course) )
                                {!! Form::model($cpd_course, ['route' => ['cpd-courses.update', [app()->getLocale(), $cpd_course->cpd_course_id]], 'method' => 'PUT', 'id' => 'frmCreateCPDCourse']) !!}
                            @else
                                {!! Form::open(['route' => ['cpd-courses.store', [app()->getLocale()]], 'method' => 'POST', 'id' => 'frmCreateCPDCourse']) !!}
                            @endif

                            <div class="row row-box">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cpd_course_kh">@lang('cpd.course_code') 
                                            <span class="required">*</span></label>

                                        {{ Form::text(
                                            'cpd_course_code', null, 
                                            ['id' => 'cpd_course_code', 'class' => 'form-control', 'autocomplete' => 'off', 'maxlength' => 10]) 
                                        }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cpd_course_kh">@lang('cpd.course_kh') <span
                                                class="required">*</span></label>

                                        {{ Form::text('cpd_course_kh', null, ['id' => 'cpd_course_kh', 'class' => 'form-control kh', 'autocomplete' => 'off', 'maxlength' => 200]) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cpd_course_en">@lang('cpd.course_en')</label>

                                        {{ Form::text('cpd_course_en', null, ['id' => 'cpd_course_en', 'class' => 'form-control kh', 'autocomplete' => 'off', 'maxlength' => 70]) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cpd_course_type_id">@lang('cpd.course_type') <span
                                                class="required">*</span></label>

                                        {{ Form::select('cpd_course_type_id', ['' => __('common.choose'). '...'] + $courseTypes, null, ['id' => 'cpd_course_type_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="duration_hour">@lang('cpd.duration') <span
                                                class="required">*</span></label>

                                        {{ Form::number('duration_hour', null, ['id' => 'duration_hour', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="credits">@lang('cpd.credits') <span
                                                class="required">*</span></label>

                                        {{ Form::number('credits', null, ['id' => 'credits', 'class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="provider_id">@lang('menu.cpd_provider') <span
                                                class="required">*</span></label>
                                        <div class="select2-blue">
                                            {{ Form::select('providers[]', $providers, null, 
                                                [
                                                    'id' => 'provider_id', 'class' => 'select2 kh', 'style' => 'width:100%;', 
                                                    'multiple' => 'multiple', 'data-dropdown-css-class' => 'select2-blue', 
                                                    'required' => true,
                                                ]) 
                                            }}
                                        </div>

                                        <?php /* ?>{{ Form::select('provider_id', ['' => __('common.choose'). '...'] + $providers, null, 
                                            ['id' => 'provider_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) }}<?php */ ?>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group clearfix" style="margin-top:40px;">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="active" name="active" value="1" checked>
                                            <label for="active">{{__('login.active')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Field of study & subject of study section -->
                            <hr class="border-info" style="margin-bottom:15px !important;">
                            <div class="row row-box">
                                <div class="col-md-12">
                                    <!-- #1 -->
                                    <div id="course-relation-sec" class="row">
                                        <div class="col-md-auto">
                                            <label style="margin-top:36px;font-size:16px;"><strong>1.</strong></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cpd_field_id">@lang('cpd.field_of_study')<span
                                                        class="required">*</span></label></label>
                                                {{ Form::select(
                                                    'cpd_field_id_1', 
                                                    ['' => __('common.choose'). '...'] + $fieldOfStudies, ((isset($cpd_course) and !empty($cpd_course->courseRelations[0])) ? $cpd_course->courseRelations[0]->cpd_field_id : null), 
                                                    ['id' => 'cpd_field_id_1', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                                }}
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cpd_subject_id">@lang('cpd.subject') <span
                                                        class="required">*</span></label>

                                                {{ Form::select(
                                                    'cpd_subject_id_1', 
                                                    ['' => __('common.choose'). '...'] + $subjectOfStudies, ((isset($cpd_course) and !empty($cpd_course->courseRelations[0])) ? $cpd_course->courseRelations[0]->cpd_subject_id : null), 
                                                    ['id' => 'cpd_subject_id_1', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                                }}
                                            </div>
                                        </div>

                                        <!-- <div class="col-sm-1 single-button">
                                            <button type="button" id="btn-add-more" class="btn btn-default" 
                                                style="width:100%;"><i class="fa fa-plus"></i></button>
                                        </div> -->
                                    </div>

                                    <!-- #2 -->
                                    <div id="course-relation-sec" class="row">
                                        <div class="col-md-auto">
                                            <label style="margin-top:6px;font-size:16px;"><strong>2.</strong></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                {{ Form::select(
                                                    'cpd_field_id_2', 
                                                    ['' => __('common.choose'). '...'] + $fieldOfStudies, ((isset($cpd_course) and !empty($cpd_course->courseRelations[1])) ? $cpd_course->courseRelations[1]->cpd_field_id : null), 
                                                    ['id' => 'cpd_field_id_2', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                                }}
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                {{ Form::select(
                                                    'cpd_subject_id_2', 
                                                    ['' => __('common.choose'). '...'] + $subjectOfStudies, ((isset($cpd_course) and !empty($cpd_course->courseRelations[1])) ? $cpd_course->courseRelations[1]->cpd_subject_id : null), 
                                                    ['id' => 'cpd_subject_id_2', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                                }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- #3 -->
                                    <div id="course-relation-sec" class="row">
                                        <div class="col-md-auto">
                                            <label style="margin-top:6px;font-size:16px;"><strong>3.</strong></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                {{ Form::select(
                                                    'cpd_field_id_3', 
                                                    ['' => __('common.choose'). '...'] + $fieldOfStudies, ((isset($cpd_course) and !empty($cpd_course->courseRelations[2])) ? $cpd_course->courseRelations[2]->cpd_field_id : null), 
                                                    ['id' => 'cpd_field_id_3', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                                }}
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                {{ Form::select(
                                                    'cpd_subject_id_3', 
                                                    ['' => __('common.choose'). '...'] + $subjectOfStudies, ((isset($cpd_course) and !empty($cpd_course->courseRelations[2])) ? $cpd_course->courseRelations[0]->cpd_subject_id : null), 
                                                    ['id' => 'cpd_subject_id_3', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                                }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- New teaching subject section -->
                                    <!-- <div id="new-course-relation-sec"></div> -->
                                </div>
                            </div>
                            <hr class="border-info" style="margin-bottom:15px !important;">

                            <div class="row row-box">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="cpd_course_desc_kh">@lang('cpd.course_desc_kh') <span
                                                class="required">*</span></label>

                                        {{ Form::textarea(
                                            'cpd_course_desc_kh', null, 
                                            ['id' => 'cpd_course_desc_kh', 'class' => 'form-control kh summernote', 'style' => 'width:100%;font-size:14px;line-height:18px;border:1px solid #dddddd;padding:10px;']) 
                                        }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="cpd_course_desc_en">@lang('cpd.course_desc_en') </label>

                                        {{ Form::textarea(
                                            'cpd_course_desc_en', null, 
                                            [
                                                'id' => 'cpd_course_desc_en', 'class' => 'form-control en summernote', 
                                                'style' => 'width:100%;font-size:14px;line-height:18px;border:1px solid #dddddd;padding:10px;'
                                            ]) 
                                        }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table style="margin:auto;">
                                        <tr>
                                            <td style="padding:5px">
                                                <a href="{{ route('cpd-courses.index', [app()->getLocale()]) }}" 
                                                    class="btn btn-danger btn-cancel" style="width:150px;">
                                                    <i class="far fa-times-circle"></i> {{__('button.cancel')}}</a>
                                            </td>

                                            <td style="padding:5px">
                                                <button type="submit" class="btn btn-info btn-save"
                                                    style="width:150px;">
                                                    <i class="far fa-save"></i> {{ __('button.save') }}
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            {{ Form::close() }}

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
    <script>
        /*function removeCourseRelation(numrow) {
            $("#relation-"+numrow).remove();
        }*/

        function autofilSubjectOfStudy(p_value, p_subject_el) {
            if (p_value != "") {
                $.ajax({
                    type: "GET",
                    url: "/field-study/" + p_value + "/subject-study",
                    success: function (subject_of_studies) {
                        $("#"+p_subject_el).find('option:not(:first)').remove();
                        
                        if( subject_of_studies.length > 0 ) {
                            for(var index in subject_of_studies) {
                                $("#"+p_subject_el).append('<option value="'+subject_of_studies[index].cpd_subject_id+'">'+ subject_of_studies[index].cpd_subject_code+" - "+subject_of_studies[index].cpd_subject_kh +'</option>');
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }
            else { $("#"+p_subject_el).find('option:not(:first)').remove(); }
        }

        $(function() {
            $("#structured-course").addClass("menu-open");
            $("#create-structured-course > a").addClass("active");

            $('.summernote').summernote({
                height: 120,
                fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '18', '20', '24', '36', '48'],
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Validation
            $("#frmCreateCPDCourse").validate({
                rules: {
                    cpd_course_code: "required",
                    provider_id: "required",
                    cpd_course_type_id: "required",
                    cpd_course_kh: "required",
                    credits: "required",
                    end_date: "required",
                    duration_hour: "required",
                    cpd_course_desc_kh: "required",
                    cpd_field_id_1: "required",
                    cpd_subject_id_1: "required",
                },
                messages: {
                    cpd_course_code: "{{ __('validation.required_field') }}",
                    provider_id: "{{ __('validation.required_field') }}",
                    cpd_course_type_id: "{{ __('validation.required_field') }}",
                    cpd_course_kh: "{{ __('validation.required_field') }}",
                    credits: "{{ __('validation.required_field') }}",
                    end_date: "{{ __('validation.required_field') }}",
                    duration_hour: "{{ __('validation.required_field') }}",
                    cpd_course_desc_kh: "{{ __('validation.required_field') }}",
                    cpd_field_id_1: "{{ __('validation.required_field') }}",
                    cpd_subject_id_1: "{{ __('validation.required_field') }}",
                },
                submitHandler: function(frm) {
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

            // ADD MORE COURSE RELATION
            /*var index = 1;

            $("#btn-add-more").click(function(e) {
                e.preventDefault();
                var numrow = index++;

                $("#new-course-relation-sec").append('<div class="row" id="relation-'+numrow+'">' + $("#course-relation-sec").html() + '</div>');
                $("#new-course-relation-sec").find(".form-group").find("label").remove();
                $("#new-course-relation-sec").find(".form-group").find("span").remove();
                $("#new-course-relation-sec").find(".single-button").empty();
                $("#new-course-relation-sec").find(".single-button").replaceWith('<div class="col-sm-1" style="padding-top:5px;"><button type="button" class="btn btn-xs btn-danger" style="width:40px;" title="Remove" onclick="removeCourseRelation('+numrow+')"><i class="far fa-times-circle"></i></button></div>');
                $(".select2").select2();

            });*/

            // Field of study event #1
            $("#cpd_field_id_1").change(function() {
                autofilSubjectOfStudy($(this).val(), "cpd_subject_id_1");
            });

            // Field of study event #2
            $("#cpd_field_id_2").change(function() {
                autofilSubjectOfStudy($(this).val(), "cpd_subject_id_2");
            });

            // Field of study event #3
            $("#cpd_field_id_3").change(function() {
                autofilSubjectOfStudy($(this).val(), "cpd_subject_id_3");
            });
        });
    </script>
@endpush
