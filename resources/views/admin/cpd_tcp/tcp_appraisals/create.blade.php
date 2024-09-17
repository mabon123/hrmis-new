@extends('layouts.admin')

@section('content')

@php
$disabled = isset($view_data) ? true : false;
@endphp
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.new_tcp_appraisal') }}
                </h1>
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
    @if ( isset($tcp_appraisal) )
    {!! Form::model(
    $tcp_appraisal,
    ['route' => ['tcp-appraisals.update', [app()->getLocale(), $tcp_appraisal->tcp_appraisal_id]],
    'method' => 'PUT', 'files' => true,
    'id' => 'frmCreateTCPAppraisal'])
    !!}
    @else
    {!! Form::open(
    ['route' => ['tcp-appraisals.store', [app()->getLocale()]],
    'method' => 'POST', 'files' => true,
    'id' => 'frmCreateTCPAppraisal'])
    !!}
    @endif

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card card-info card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active">{{ __('menu.new_tcp_appraisal') }}</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body custom-card">
                    <div class="tab-content">
                        <div class="tab-pane fade show active">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tcp_prof_cat_id">{{ __('tcp.profession_category') }}
                                            <span class="required">*</span></label>

                                        {{ Form::select('tcp_prof_cat_id', 
                                        ['' => __('common.choose').' ...'] + $profCategories, 
                                        isset($tcp_appraisal) ? $tcp_appraisal->tcp_prof_cat_id : null, 
                                        ['id' => 'tcp_prof_cat_id', 'class' => 'form-control kh select2', 
                                            'style' => 'width:100%;', 'required' => true, 'disabled' => $disabled]) 
                                    }}
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tcp_appraisal_date">@lang('tcp.appraisal_date') <span class="required">*</span></label>

                                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                            {{ Form::text('tcp_appraisal_date', isset($tcp_appraisal->tcp_appraisal_date) ? $tcp_appraisal->tcp_appraisal_date : null, 
                                                ['required' => true, 'class' => 'form-control datepicker '.($errors->has('tcp_appraisal_date') ? ' is-invalid' : null), 
                                                'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 
                                                'data-mask', 'placeholder' => 'dd-mm-yyyy', 'disabled' => $disabled]) }}
                                            <div class="input-group-addon">
                                                <span class="far fa-calendar-alt"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="appraisers">{{ __('tcp.appraisers') }}
                                            <span class="required">*</span></label>
                                        <div class="select2-blue">
                                            {{ Form::select('appraisers[]', $staffs, (isset($tcp_appraisal) ? $appraisers : null), 
                                                [
                                                    'id' => 'appraisers', 'class' => 'select2 kh', 'style' => 'width:100%;', 
                                                    'multiple' => 'multiple', 'data-dropdown-css-class' => 'select2-blue', 
                                                    'required' => true, 'disabled' => $disabled
                                                ]) 
                                            }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tcp_prof_cat_id">{{ __('tcp.staff_name') }}
                                            <span class="required">*</span></label>

                                        {{ Form::select('staff_payroll', 
                                        ['' => __('common.choose').' ...'] + $appraisal_staffs, 
                                        isset($tcp_appraisal) ? $tcp_appraisal->staff_payroll : null, 
                                        ['id' => 'staff_payroll', 'class' => 'form-control kh select2', 
                                            'style' => 'width:100%;', 'required' => true, 'disabled' => $disabled]) 
                                    }}
                                    </div>
                                </div>
                                <div class="col-sm-3" id="staff_position"></div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tcp_prof_rank_id">{{ __('tcp.profession_rank') }}
                                            <span class="required">*</span></label>

                                        {{ Form::select('tcp_prof_rank_id', 
                                        $profRanks, isset($tcp_appraisal) ? $tcp_appraisal->tcp_prof_rank_id : null,  
                                        ['id' => 'tcp_prof_rank_id', 'class' => 'form-control kh select2', 
                                            'style' => 'width:100%;', 'required' => true, 'disabled' => $disabled]) 
                                    }}
                                    </div>
                                </div>

                            </div>

                            <div class="row row-box">
                                <div class="col-md-12">
                                    <h4>{{ __('tcp.appraisal_credits_rating') }}</h4>
                                    <!-- Qualification -->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cat1_score">{{ __('tcp.credits_qualification') }}
                                                    <span class="required">*</span></label>
                                                </label>
                                                {{ Form::number('cat1_score', isset($tcp_appraisal) ? $tcp_appraisal->cat1_score : null,
                                                    ['id' => 'cat1_score', 'class' => 'form-control', 'disabled' => $disabled]) }}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cat1_ref_doc">
                                                    @lang('tcp.ref_doc')
                                                    <span class="required">* max: 2 MB</span>
                                                    @if (isset($tcp_appraisal))
                                                    <a href="{{ asset('storage/images/tcp_docs/'.$tcp_appraisal->cat1_ref_doc) }}" target="_blank"><u>{{$tcp_appraisal->cat1_ref_doc}}</u></a>
                                                    @endif
                                                </label>
                                                @if(!isset($view_data))
                                                <input type="file" class="form-control" require="true" name="cat1_ref_doc" id="cat1_ref_doc" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cat1_note">{{__('tcp.additional_clarification')}}</label>
                                                {{ Form::textarea('cat1_note', isset($tcp_appraisal) ? $tcp_appraisal->cat1_note : null,
                                                    ['class' => 'form-control kh', 'id' => 'cat1_note', 'rows' => 2, 'disabled' => $disabled]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Qualification -->

                                    <!-- Experience -->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cat2_score">{{ __('tcp.credits_experience') }}
                                                    <span class="required">*</span></label>
                                                </label>
                                                {{ Form::number('cat2_score', isset($tcp_appraisal) ? $tcp_appraisal->cat2_score : null,
                                                    ['id' => 'cat2_score', 'class' => 'form-control', 'disabled' => $disabled]) }}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cat2_ref_doc">
                                                    @lang('tcp.ref_doc')
                                                    <span class="required">* max: 2 MB</span>
                                                    @if (isset($tcp_appraisal))
                                                    <a href="{{ asset('storage/images/tcp_docs/'.$tcp_appraisal->cat2_ref_doc) }}" target="_blank"><u>{{$tcp_appraisal->cat2_ref_doc}}</u></a>
                                                    @endif
                                                </label>
                                                @if(!isset($view_data))
                                                <input type="file" class="form-control" require="true" name="cat2_ref_doc" id="cat2_ref_doc" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cat2_note">{{__('tcp.additional_clarification')}}</label>
                                                {{ Form::textarea('cat2_note', isset($tcp_appraisal) ? $tcp_appraisal->cat2_note : null,
                                                    ['class' => 'form-control kh', 'id' => 'cat2_note', 'rows' => 2, 'disabled' => $disabled]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Experience -->

                                    <!-- Achievement -->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cat3_score">{{ __('tcp.credits_achievement') }}
                                                    <span class="required">*</span></label>
                                                </label>
                                                {{ Form::number('cat3_score', isset($tcp_appraisal) ? $tcp_appraisal->cat3_score : null,
                                                    ['id' => 'cat3_score', 'class' => 'form-control', 'disabled' => $disabled]) }}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cat3_ref_doc">
                                                    @lang('tcp.ref_doc')
                                                    <span class="required">* max: 2 MB</span>
                                                    @if (isset($tcp_appraisal))
                                                    <a href="{{ asset('storage/images/tcp_docs/'.$tcp_appraisal->cat3_ref_doc) }}" target="_blank"><u>{{$tcp_appraisal->cat3_ref_doc}}</u></a>
                                                    @endif
                                                </label>
                                                @if(!isset($view_data))
                                                <input type="file" class="form-control" require="true" name="cat3_ref_doc" id="cat3_ref_doc" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cat3_note">{{__('tcp.additional_clarification')}}</label>
                                                {{ Form::textarea('cat3_note', isset($tcp_appraisal) ? $tcp_appraisal->cat3_note : null,
                                                    ['class' => 'form-control kh', 'id' => 'cat3_note', 'rows' => 2, 'disabled' => $disabled]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Achievement -->

                                    <!-- Job Outcome -->
                                    <div class="row" id="div_job_outcome">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cat4_score">{{ __('tcp.credits_job_outcome') }}
                                                    <span class="required">*</span></label>
                                                </label>
                                                {{ Form::number('cat4_score', isset($tcp_appraisal) ? $tcp_appraisal->cat4_score : null,
                                                    ['id' => 'cat4_score', 'class' => 'form-control', 'disabled' => $disabled]) }}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cat4_ref_doc">
                                                    @lang('tcp.ref_doc')
                                                    <span class="required">* max: 2 MB</span>
                                                    @if (isset($tcp_appraisal))
                                                    <a href="{{ asset('storage/images/tcp_docs/'.$tcp_appraisal->cat4_ref_doc) }}" target="_blank"><u>{{$tcp_appraisal->cat4_ref_doc}}</u></a>
                                                    @endif
                                                </label>
                                                @if(!isset($view_data))
                                                <input type="file" class="form-control" name="cat4_ref_doc" id="cat4_ref_doc" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cat4_note">{{__('tcp.additional_clarification')}}</label>
                                                {{ Form::textarea('cat4_note', isset($tcp_appraisal) ? $tcp_appraisal->cat4_note : null,
                                                    ['class' => 'form-control kh', 'id' => 'cat4_note', 'rows' => 2, 'disabled' => $disabled]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Job Outcome -->

                                    <!-- Professional Competence -->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cat5_score">{{ __('tcp.credits_prof_competence') }}
                                                    <span class="required">*</span></label>
                                                </label>
                                                {{ Form::number('cat5_score', isset($tcp_appraisal) ? $tcp_appraisal->cat5_score : null,
                                                    ['id' => 'cat5_score', 'class' => 'form-control', 'disabled' => $disabled]) }}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="cat5_ref_doc">
                                                    @lang('tcp.ref_doc')
                                                    <span class="required">* max: 2 MB</span>
                                                    @if (isset($tcp_appraisal))
                                                    <a href="{{ asset('storage/images/tcp_docs/'.$tcp_appraisal->cat5_ref_doc) }}" target="_blank"><u>{{$tcp_appraisal->cat5_ref_doc}}</u></a>
                                                    @endif
                                                </label>
                                                @if(!isset($view_data))
                                                <input type="file" class="form-control" require="true" name="cat5_ref_doc" id="cat5_ref_doc" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cat5_note">{{__('tcp.additional_clarification')}}</label>
                                                {{ Form::textarea('cat5_note', isset($tcp_appraisal) ? $tcp_appraisal->cat5_note : null,
                                                    ['class' => 'form-control kh', 'id' => 'cat5_note', 'rows' => 2, 'disabled' => $disabled]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Professional competence -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="appraisal_ref_doc">
                                                    @lang('tcp.appraisal_ref_doc')
                                                    <span class="required">* max: 5 MB</span>
                                                    @if (isset($tcp_appraisal))
                                                    <a href="{{ asset('storage/images/tcp_docs/'.$tcp_appraisal->appraisal_ref_doc) }}" target="_blank"><u>{{$tcp_appraisal->appraisal_ref_doc}}</u></a>
                                                    @endif
                                                </label>
                                                @if(!isset($view_data))
                                                <input type="file" class="form-control" require="true" name="appraisal_ref_doc" id="appraisal_ref_doc" />
                                                @endif
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
    @if(!isset($view_data))
    <div class="row">
        <div class="col-md-12">
            <table style="margin:auto;">
                <tr>
                    <td style="padding:5px">
                        <a href="{{ route('tcp-appraisals.index', [app()->getLocale()]) }}" class="btn btn-danger btn-cancel" style="width:150px;">
                            <i class="far fa-times-circle"></i> {{__('button.cancel')}}</a>
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
    @endif
    <br />
    {{ Form::close() }}
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/delete.handler.js') }}"></script>
<script src="{{ asset('js/custom_validation.js') }}"></script>
<script type="text/javascript">
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 10000
        });
        $("#create-new-tcp-appraisal > a").addClass("active");
        var lang = '<?php echo app()->getLocale(); ?>';
        var positionKh = '<?php echo isset($position) ? $position->position_kh : ''; ?>';
        checkPosition(positionKh);

        function checkPosition(position_kh) {
            if (position_kh != '') {
                $('#staff_position').css('display', 'block');
                $('#staff_position').html('');
                $("#staff_position").append('<p style="margin-top: 40px">តួនាទី៖ ' + position_kh + '</p>');
            } else {
                $('#staff_position').css('display', 'none');
            }
        }

        function loadPositionAjax(sPayroll) {
            $.ajax({
                type: "GET",
                url: "/" + lang + "/tcp-appraisals/get-position-rank",
                dataType: 'json',
                data: {
                    category_id: $('#tcp_prof_cat_id').val(),
                    payroll_id: sPayroll
                },
                success: function(data) {
                    var dataCount = Object.keys(data).length;
                    if (dataCount > 0) {
                        checkPosition(data.position.position_kh);
                        if (data.profRank !== null) {
                            $('#tcp_prof_rank_id').html('');
                            var tcpRankHtml = '<option value="' + data.profRank.tcp_prof_rank_id + '" selected="selected">' + data.profRank.tcp_prof_rank_kh + '</option>';
                            $("#tcp_prof_rank_id").append(tcpRankHtml);
                        }
                    }
                },
                error: function(err) {
                    console.log('Error:', err);
                }
            });
        }
        $("#staff_payroll").change(function() {
            //loadModalOverlay(true, 1000);
            var staffPayroll = $(this).val();
            if (staffPayroll !== '') {
                loadPositionAjax(staffPayroll);
            } else {
                $('#staff_position').css('display', 'none');
            }
        });
        var categoryId = $('#tcp_prof_cat_id').val();
        //Call first to initialize
        configValidation(categoryId, positionKh);

        $('#tcp_prof_cat_id').change(function() {
            $("#frmCreateTCPAppraisal").removeData('validator');
            //Call to re-initialize
            configValidation($(this).val(), positionKh);

            //Show/hide position and rank
            $('#tcp_prof_rank_id').html('');
            var choose = '<?php echo __('common.choose') . ' ...'; ?>';
            var options = '<option value="">' + choose + '</option>';
            $('#tcp_prof_rank_id').append(options);

            var staffPayroll = $('#staff_payroll').val();
            if (staffPayroll !== '') {
                loadPositionAjax(staffPayroll);
            }
        });

        function configValidation(catId, pKh) {
            var ruleList = {};
            var messageList = {};
            if (catId == 3) {
                $('#div_job_outcome').hide();
                ruleList = {
                    tcp_prof_cat_id: "required",
                    tcp_appraisal_date: "required",
                    appraisers: "required",
                    staff_payroll: "required",
                    tcp_prof_rank_id: "required",
                    cat1_score: {
                        required: true,
                        min: 0,
                        max: 100,
                    },
                    cat2_score: {
                        required: true,
                        min: 0,
                        max: 75,
                    },
                    cat3_score: {
                        required: true,
                        min: 0,
                        max: 150,
                    },
                    cat5_score: {
                        required: true,
                        min: 0,
                        max: 175,
                    }
                };

                messageList = {
                    tcp_prof_cat_id: "{{ __('validation.required_field') }}",
                    tcp_appraisal_date: "{{ __('validation.required_field') }}",
                    appraisers: "{{ __('validation.required_field') }}",
                    staff_payroll: "{{ __('validation.required_field') }}",
                    tcp_prof_rank_id: "{{ __('validation.required_field') }}",
                    cat1_score: {
                        required: "{{ __('validation.required_field', ['attribute' => __('tcp.credits_qualification')]) }}",
                        min: "{{ __('validation.min.numeric', ['attribute' => __('tcp.credits_qualification'), 'min' => 0]) }}",
                        max: "{{ __('validation.max.numeric', ['attribute' => __('tcp.credits_qualification'), 'max' => 100 ]) }}",
                    },
                    cat2_score: {
                        required: "{{ __('validation.required_field', ['attribute' => __('tcp.credits_experience')]) }}",
                        min: "{{ __('validation.min.numeric', ['attribute' => __('tcp.credits_experience'), 'min' => 0]) }}",
                        max: "{{ __('validation.max.numeric', ['attribute' => __('tcp.credits_experience'), 'max' => 75]) }}",
                    },
                    cat3_score: {
                        required: "{{ __('validation.required_field', ['attribute' => __('tcp.credits_achievement')]) }}",
                        min: "{{ __('validation.min.numeric', ['attribute' => __('tcp.credits_achievement'), 'min' => 0]) }}",
                        max: "{{ __('validation.max.numeric', ['attribute' => __('tcp.credits_achievement'), 'max' => 150]) }}",
                    },
                    cat5_score: {
                        required: "{{ __('validation.required_field', ['attribute' => __('tcp.credits_prof_competence')]) }}",
                        min: "{{ __('validation.min.numeric', ['attribute' => __('tcp.credits_prof_competence'), 'min' => 0]) }}",
                        max: "{{ __('validation.max.numeric', ['attribute' => __('tcp.credits_prof_competence'), 'max' => 175]) }}",
                    },
                };
            } else {
                $('#div_job_outcome').show();
                ruleList = {
                    tcp_prof_cat_id: "required",
                    tcp_appraisal_date: "required",
                    appraisers: "required",
                    staff_payroll: "required",
                    tcp_prof_rank_id: "required",
                    cat1_score: {
                        required: true,
                        min: 0,
                        max: 75,
                    },
                    cat2_score: {
                        required: true,
                        min: 0,
                        max: 90,
                    },
                    cat3_score: {
                        required: true,
                        min: 0,
                        max: 90,
                    },
                    cat4_score: {
                        required: true,
                        min: 0,
                        max: 70,
                    },
                    cat5_score: {
                        required: true,
                        min: 0,
                        max: 175,
                    }
                };

                messageList = {
                    tcp_prof_cat_id: "{{ __('validation.required_field') }}",
                    tcp_appraisal_date: "{{ __('validation.required_field') }}",
                    appraisers: "{{ __('validation.required_field') }}",
                    staff_payroll: "{{ __('validation.required_field') }}",
                    tcp_prof_rank_id: "{{ __('validation.required_field') }}",
                    cat1_score: {
                        required: "{{ __('validation.required_field', ['attribute' => __('tcp.credits_qualification')]) }}",
                        min: "{{ __('validation.min.numeric', ['attribute' => __('tcp.credits_qualification'), 'min' => 0]) }}",
                        max: "{{ __('validation.max.numeric', ['attribute' => __('tcp.credits_qualification'), 'max' => 75 ]) }}",
                    },
                    cat2_score: {
                        required: "{{ __('validation.required_field', ['attribute' => __('tcp.credits_experience')]) }}",
                        min: "{{ __('validation.min.numeric', ['attribute' => __('tcp.credits_experience'), 'min' => 0]) }}",
                        max: "{{ __('validation.max.numeric', ['attribute' => __('tcp.credits_experience'), 'max' => 90]) }}",
                    },
                    cat3_score: {
                        required: "{{ __('validation.required_field', ['attribute' => __('tcp.credits_achievement')]) }}",
                        min: "{{ __('validation.min.numeric', ['attribute' => __('tcp.credits_achievement'), 'min' => 0]) }}",
                        max: "{{ __('validation.max.numeric', ['attribute' => __('tcp.credits_achievement'), 'max' => 90]) }}",
                    },
                    cat4_score: {
                        required: "{{ __('validation.required_field', ['attribute' => __('tcp.credits_job_outcome')]) }}",
                        min: "{{ __('validation.min.numeric', ['attribute' => __('tcp.credits_job_outcome'), 'min' => 0]) }}",
                        max: "{{ __('validation.max.numeric', ['attribute' => __('tcp.credits_job_outcome'), 'max' => 70]) }}",
                    },
                    cat5_score: {
                        required: "{{ __('validation.required_field', ['attribute' => __('tcp.credits_prof_competence')]) }}",
                        min: "{{ __('validation.min.numeric', ['attribute' => __('tcp.credits_prof_competence'), 'min' => 0]) }}",
                        max: "{{ __('validation.max.numeric', ['attribute' => __('tcp.credits_prof_competence'), 'max' => 175]) }}",
                    },
                };
            }

            //Check if not edit then require upload docs
            if (pKh == '') {
                ruleList.cat1_ref_doc = 'required';
                ruleList.cat2_ref_doc = "required";
                ruleList.cat3_ref_doc = "required";
                ruleList.cat5_ref_doc = "required";
                ruleList.appraisal_ref_doc = "required";

                messageList.cat1_ref_doc = "{{ __('validation.required_field') }}";
                messageList.cat2_ref_doc = "{{ __('validation.required_field') }}";
                messageList.cat3_ref_doc = "{{ __('validation.required_field') }}";
                messageList.cat5_ref_doc = "{{ __('validation.required_field') }}";
                messageList.appraisal_ref_doc = "{{ __('validation.required_field') }}";
                //Require if not Edu.Specialist
                if (catId != 3) {
                    ruleList.cat4_ref_doc = "required";
                    messageList.cat4_ref_doc = "{{ __('validation.required_field') }}";
                }
            }
            // Validation
            $("#frmCreateTCPAppraisal").validate({
                rules: ruleList,
                messages: messageList,
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
        }
    });
</script>

@endpush