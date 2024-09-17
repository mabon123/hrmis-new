@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="far fa-list-alt"></i> {{ __('menu.tcp_appraisals_list') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.view_tcp_appraisals') }}</li>
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

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('menu.view_tcp_appraisals') }}</h3>
                </div>

                <div class="card-body custom-card">
                    <form id="frmSearchTCP" action="{{ route('tcp-appraisals.view-tcp-appraisals', app()->getLocale()) }}">
                        <div class="row">
                            <!-- Province -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="pro_code">{{ __('common.province') }}</label>

                                    {{ Form::select('pro_code', $provinces, request()->pro_code ? request()->pro_code : null, 
                                    	['id' => 'pro_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) 
                                    }}
                                </div>
                            </div>
                            <!-- District -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="dis_code">{{ __('common.district') }}</label>

                                    {{ Form::select('dis_code', $districts, request()->dis_code, 
                                        ['id' => 'dis_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) 
                                    }}
                                </div>
                            </div>
                            <!-- Current location -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="location_code">{{ __('tcp.in_workplace') }}</label>

                                    {{ Form::select('location_code', $locations, 
                                        (!empty($userLocationName) ? $userLocationName : request()->location_code), 
                                        ['id' => 'location_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                    }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tcp_prof_cat_id">{{ __('tcp.profession_category') }}</label>
                                    {{ Form::select('tcp_prof_cat_id', 
                                        ['' => __('common.choose').' ...'] + $profCategories, 
                                        request()->tcp_prof_cat_id, 
                                        ['id' => 'tcp_prof_cat_id', 'class' => 'form-control kh select2', 
                                            'style' => 'width:100%;']) 
                                    }}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tcp_prof_rank_id">{{ __('tcp.profession_rank') }}</label>

                                    {{ Form::select('tcp_prof_rank_id', $profRanks, 
                                        request()->tcp_prof_rank_id,  
                                        ['id' => 'tcp_prof_rank_id', 'class' => 'form-control kh select2', 
                                            'style' => 'width:100%;']) 
                                    }}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tcp_status_id">{{ __('tcp.tcp_status') }}</label>

                                    {{ Form::select('tcp_status_id', $tcpStatusList,request()->tcp_status_id, 
                                        ['id' => 'tcp_status_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                    }}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="year">{{ __('tcp.appraisal_year') }}</label>

                                    {{ Form::select('year', $years,request()->year, 
                                        ['id' => 'year', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                                    }}
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-sm-3" style="margin: auto; padding-top: 13px;">
                                <input type="hidden" name="search" value="true">
                                <button type="submit" class="btn btn-info" style="width:180px;" onclick="loading();">
                                    <i class="fa fa-search"></i>&nbsp;{{ __('button.search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="staff_data_list">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> {{ __('menu.tcp_appraisals_list'). ' - '.$status_name }} </h3>
                    @if(count($appraisals) > 0)
                    <button type="button" id="btn_export_tcp" class="btn btn-sm btn-success" style="position: relative; margin-left: 10px; margin-top: -7px;" title="Export to Excel">
                        <i class="far fa-file-excel"></i> {{ __('button.export_to_excel') }}
                    </button>
                    @endif
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" id="div_message"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('tcp.profession_category') }}</th>
                                    <th>{{ __('tcp.staff_name') }}</th>
                                    <th>{{ __('tcp.appraisal_date') }}</th>
                                    <th>{{ __('tcp.in_workplace') }}</th>
                                    <th>{{ __('tcp.appraisal_score') }}</th>
                                    <th>{{ __('tcp.profession_rank') }}</th>
                                    <th>{{ __('tcp.tcp_status') }}</th>
                                    <th></th>
                                    @if($status_id == 2)
                                    <th>
                                        {{ auth()->user()->hasRole('administrator') ? __('common.pass_fail') : '' }}
                                    </th>
                                    <th>{{__('tcp.note_reasons')}}<span class="required">*</span></th>
                                    @elseif($status_id == 3 || $status_id == 4 || $status_id == 'r_doe' || $status_id == 'r_poe')
                                    <th>{{ __('tcp.note_reasons') }}</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody id="data_tbody">

                                @foreach($appraisals as $index => $appraisal)
                                @php
                                $total_score = ($appraisal->cat1_score+$appraisal->cat2_score+$appraisal->cat3_score+$appraisal->cat4_score+$appraisal->cat5_score);
                                $span_class = null;
                                if($appraisal->tcp_status_id == 2) {
                                $span_class = "alert alert-warning";
                                }
                                elseif($appraisal->tcp_status_id == 3 || $appraisal->tcp_status_id == 4) {
                                $span_class = "alert alert-danger";
                                }
                                else {
                                $span_class = "alert alert-success";
                                }
                                @endphp

                                <tr id="record-{{ $appraisal->tcp_appraisal_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="kh"> {{ $appraisal->professionCategory->tcp_prof_cat_kh }}</td>
                                    <td class="kh">{{ $appraisal->staffInfo->surname_kh.' '.$appraisal->staffInfo->name_kh }}</td>
                                    <td>{{ date('d-m-Y', strtotime($appraisal->tcp_appraisal_date)) }}</td>
                                    <td class="kh"> {{ $appraisal->workplace->location_kh }}</td>
                                    <td>{{ $total_score}}</td>
                                    <td class="kh"> {{ $appraisal->professionRank->tcp_prof_rank_kh }}</td>
                                    <td class="kh">
                                        <span class="{{ $span_class }}" style="padding:4px 12px;cursor: pointer;">
                                            {{ $status_name }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a target="_blank" href="{{ route('tcp-appraisals.details', [app()->getLocale(), $appraisal->tcp_appraisal_id]) }}" class="btn btn-xs btn-info" title="View"><i class="far fa-eye"></i> {{ __('button.view') }}</a>
                                    </td>
                                    @if($status_id == 2)
                                    <td>
                                        <div class="form-group clearfix">
                                            <div class="icheck-warning d-inline">
                                                <input type="radio" id="skip_{{$appraisal->tcp_appraisal_id}}" class="skip" name="chk_approve_{{$index}}" value="{{ $appraisal->tcp_appraisal_id }}" checked="" />
                                                <label for="skip_{{$appraisal->tcp_appraisal_id}}">
                                                    {{ __('button.pending') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="icheck-success d-inline">
                                                <input type="radio" id="approve_{{$appraisal->tcp_appraisal_id}}" class="approve" name="chk_approve_{{$index}}" value="{{ $appraisal->tcp_appraisal_id }}" />
                                                <label for="approve_{{$appraisal->tcp_appraisal_id}}">
                                                    {{ auth()->user()->hasRole('administrator') ? __('common.pass') : __('button.approve') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="radio" id="reject_{{$appraisal->tcp_appraisal_id}}" class="reject" name="chk_approve_{{$index}}" value="{{ $appraisal->tcp_appraisal_id }}" data-staff-name="{{ $appraisal->staffInfo->surname_kh.' '.$appraisal->staffInfo->name_kh }}" />
                                                <label for="reject_{{$appraisal->tcp_appraisal_id}}">
                                                    {{ auth()->user()->hasRole('administrator') ? __('common.fail') : __('button.reject') }}
                                                </label>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        {{ Form::textarea('feedback[]', null,
                                        ['class' => 'form-control kh txt_feedback', 'id' => 'feedback_'.$appraisal->tcp_appraisal_id,
                                        'style'=> 'width: 200px; height: 100px', 'disabled' => true ]) }}
                                    </td>
                                    @elseif($status_id == 3 || $status_id == 4 || $status_id == 'r_doe' || $status_id == 'r_poe')
                                    @php
                                    $feedback = '';
                                    if($status_id == 4){
                                    $feedback = $appraisal->admin_note;
                                    }elseif($status_id == 'r_doe' || $appraisal->doe_check_status == 6){
                                    $feedback = $appraisal->doe_note;
                                    }else{
                                    $feedback = $appraisal->poe_note;
                                    }
                                    @endphp
                                    <td class="kh">{{ $feedback }}</td>
                                    @endif

                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($status_id == 2)
    <div class="row">
        <div class="col-md-12">
            <table style="margin:auto;">
                <tr>
                    <td style="padding:5px">
                        <button type="button" id="btn_verify" class="btn btn-info btn-save">
                            <i class="far fa-save"></i> {{ __('button.conf_verification') }}
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endif

</section>

@endsection

@push('scripts')

<script src="{{ asset('js/delete.handler.js') }}"></script>

<script>
    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 10000
        });
        $("#view-tcp-appraisals > a").addClass("active");
        var hasRoleAdmin = '<?php echo auth()->user()->hasRole('administrator'); ?>';
        var lang = '<?php echo app()->getLocale(); ?>';

        $("#tcp_prof_cat_id").change(function() {
            $("#tcp_prof_rank_id").find('option:not(:first)').remove();

            if ($(this).val() != '') {
                $.ajax({
                    type: "GET",
                    url: "/ajax/prof-category/" + $(this).val() + "/prof-ranks",
                    success: function(data) {
                        if (data.length > 0) {
                            for (var index in data) {
                                $("#tcp_prof_rank_id").append('<option value="' + data[index].tcp_prof_rank_id + '">' + data[index].tcp_prof_rank_kh + '</option>');
                            }
                        }
                    },
                    error: function(err) {
                        console.log('Error:', err);
                    }
                });
            }
        });

        $("#pro_code").change(function() {
            if ($(this).val() > 0) {
                loading();

                $.ajax({
                    type: "GET",
                    url: "/provinces/" + $(this).val() + "/locations",
                    success: function(locations) {
                        var locationCount = Object.keys(locations).length;
                        $("#location_code").find('option:not(:first)').remove();

                        if (locationCount > 0) {
                            for (var key in locations) {
                                $("#location_code").append('<option value="' + key + '">' + locations[key] + '</option>');
                            }
                        }
                    },
                    error: function(err) {
                        console.log('Error:', err);
                    }
                });
            }
        });

        // District change -> auto-fill data for location belong to that district
        $("#dis_code").change(function() {
            loadModalOverlay(true, 1000);

            if ($(this).val() > 0) {
                $.ajax({
                    type: "GET",
                    url: "/districts/" + $(this).val() + "/locations",
                    success: function(locations) {
                        var locationCount = Object.keys(locations).length;
                        $("#location_code").find('option:not(:first)').remove();

                        if (locationCount > 0) {
                            for (var key in locations) {
                                $("#location_code").append('<option value="' + key + '">' + locations[key] + '</option>');
                            }
                        }
                    },
                    error: function(err) {
                        console.log('Error:', err);
                    }
                });
            }
        });

        $(document).on('change', 'input[type=radio]', function() {
            if ($(this).is(':checked')) {
                var appraisalId = $(this).val();
                if ($(this).attr('class') == 'reject') {
                    $('#feedback_' + appraisalId).val('');
                    $('#feedback_' + appraisalId).prop("disabled", false);
                    $('#feedback_' + appraisalId).focus();
                } else {
                    $('#feedback_' + appraisalId).val('');
                    $('#feedback_' + appraisalId).prop("disabled", true);
                }
            }
        });

        $("#btn_verify").click(function() {
            var approveIds = [];
            var approveNotes = [];
            var rejectIds = [];
            var rejectNotes = [];

            $("input.approve:checked[type='radio']").each(function() {
                var appraisalId = $(this).val();
                approveIds.push(appraisalId);
                approveNotes.push($('#feedback_' + appraisalId).val());
            });
            $("input.reject:checked[type='radio']").each(function() {
                var appraisalId = $(this).val();
                if ($('#feedback_' + appraisalId).val() == '') {
                    alert('សូមបញ្ជាក់ពីមូលហេតុដែលធ្លាក់ឬបដិសេធរបស់ឈ្មោះ ' + $(this).attr('data-staff-name'));
                    $('#feedback_' + appraisalId).focus();
                    return false;
                }
                rejectIds.push(appraisalId);
                rejectNotes.push($('#feedback_' + appraisalId).val());
            });

            if (approveIds.length == 0 && rejectIds.length == 0) {
                $('#div_message').html('');
                var message = 'សូមជ្រើសរើសជំរើសក្រៅពីរង់ចាំ យ៉ាងហោចណាស់ឱ្យបាន១ដើម្បីផ្ទៀងផ្ទាត់!';
                var divMesage = '<div class="alert alert-warning"><ul style="margin-bottom:0;"><li>' + message + '</li></ul>';
                divMesage += '<button class="close" style="position: relative; top: -22px;" data-dismiss="alert" type="button">×</button></div>';
                $('#div_message').append(divMesage);
            } else {
                loadModalOverlay(true, 1000);
                $.ajax({
                    type: "POST",
                    url: "/" + lang + "/tcp-appraisals/verify",
                    dataType: "json",
                    data: {
                        approve_ids: approveIds,
                        approve_notes: approveNotes,
                        reject_ids: rejectIds,
                        reject_notes: rejectNotes,
                        tcp_prof_cat_id: $('#tcp_prof_cat_id').val(),
                        tcp_prof_rank_id: $('#tcp_prof_rank_id').val(),
                        pro_code: $('#pro_code').val(),
                        dis_code: $('#dis_code').val(),
                        location_code: $('#location_code').val(),
                        year: $('#year').val()
                    },
                    success: function(data) {
                        var dataCount = Object.keys(data).length;
                        if (dataCount > 0) {
                            //clear tbody
                            $('#data_tbody').html('');
                            for (var key in data) {
                                var tbodyHtml = '<tr id="record-' + data[key].tcp_appraisal_id + '"><td>' + (parseInt(key) + 1) + '</td>';
                                tbodyHtml += '<td class="kh">' + data[key].tcp_prof_cat_kh + '</td>';
                                tbodyHtml += '<td class="kh">' + data[key].surname_kh + ' ' + data[key].name_kh + '</td>';
                                tbodyHtml += '<td>' + data[key].tcp_appraisal_date2 + '</td>';
                                tbodyHtml += '<td class="kh">' + data[key].location_kh + '</td>';
                                tbodyHtml += '<td>' + data[key].total_score + '</td>';
                                tbodyHtml += '<td class="kh">' + data[key].tcp_prof_rank_kh + '</td>';
                                tbodyHtml += '<td class="kh">';
                                if (hasRoleAdmin == '1') {
                                    var status_name = lang == 'kh' ? data[key].status_kh : data[key].status_en;
                                    var span_class = "alert alert-warning";
                                    tbodyHtml += '<span class="' + span_class + '" style = "padding:4px 12px;cursor: pointer;" >' + status_name + '</span>';
                                } else {
                                    tbodyHtml += '<span class = "alert alert-warning" style = "padding:4px 12px;cursor: pointer;" >';
                                    tbodyHtml += '<?php echo  __('button.pending'); ?>';
                                }
                                tbodyHtml += '</td>';

                                tbodyHtml += '<td class="text-right">';
                                tbodyHtml += '<a target="_blank" href="/' + lang + '/tcp-appraisals/' + data[key].tcp_appraisal_id + '/view-tcp-details" class="btn btn-xs btn-info" title = "View">';
                                tbodyHtml += '<i class="far fa-eye"></i><?php echo __('button.view'); ?></a ></td>';
                                tbodyHtml += '<td><div class="form-group clearfix"><div class = "icheck-warning d-inline">';
                                tbodyHtml += '<input type="radio" id="skip_' + data[key].tcp_appraisal_id + '" class="skip" name="chk_approve_' + key + '" value="' + data[key].tcp_appraisal_id + '" checked="" / >';
                                tbodyHtml += '<label for="skip_' + data[key].tcp_appraisal_id + '" >';
                                tbodyHtml += '<?php echo __('button.pending'); ?></label></div>';
                                tbodyHtml += '</div><div class="form-group clearfix"><div class = "icheck-success d-inline">';
                                tbodyHtml += '<input type="radio" id="approve_' + data[key].tcp_appraisal_id + '" class="approve" name="chk_approve_' + key + '" value="' + data[key].tcp_appraisal_id + '" / >';
                                tbodyHtml += '<label for = "approve_' + data[key].tcp_appraisal_id + '">';
                                tbodyHtml += hasRoleAdmin == 1 ? '<?php echo __('common.pass'); ?>' : '<?php echo __('button.approve'); ?></label></div> </div>';
                                tbodyHtml += '<div class="form-group clearfix"><div class="icheck-danger d-inline">';
                                tbodyHtml += '<input type="radio" id="reject_' + data[key].tcp_appraisal_id + '" class="reject" name="chk_approve_' + key + '" value="' + data[key].tcp_appraisal_id + '" data-staff-name="' + data[key].surname_kh + ' ' + data[key].name_kh + '" / >';
                                tbodyHtml += '<label for="reject_' + data[key].tcp_appraisal_id + '">';
                                tbodyHtml += hasRoleAdmin == 1 ? '<?php echo __('common.fail'); ?>' : '<?php echo __('button.reject'); ?></label>';
                                tbodyHtml += '</div > </div> </td>';
                                tbodyHtml += '<td><textarea class="form-control kh txt_feedback" id="feedback_' + data[key].tcp_appraisal_id + '" style="width: 200px; height: 100px;" name="feedback[]" disabled="true"></textarea></td>';
                                tbodyHtml += '</tr>';
                                $('#data_tbody').append(tbodyHtml);
                            }
                        } else {
                            //just clear tbody
                            $('#data_tbody').html('');
                        }

                        $('#div_message').html('');
                        var message = 'ទិន្នន័យការវាយតម្លៃគន្លងអាជីព ត្រូវបានរក្សារទុកដោយជោគជ័យ។';
                        var divMesage = '<div class="alert alert-success"><ul style="margin-bottom:0;"><li>' + message + '</li></ul>';
                        divMesage += '<button class="close" style="position: relative; top: -22px;" data-dismiss="alert" type="button">×</button></div>';
                        $('#div_message').append(divMesage);
                    },
                    error: function(err) {
                        console.log('Error:', err);
                    }
                });
            }

        });

        $('#btn_export_tcp').click(function() {
            var query = {
                tcp_prof_cat_id: $('#tcp_prof_cat_id').val(),
                tcp_prof_rank_id: $('#tcp_prof_cat_id').val(),
                pro_code: $('#pro_code').val(),
                dis_code: $('#dis_code').val(),
                location_code: $('#location_code').val(),
                tcp_status_id: $('#tcp_status_id').val(),
                year: $('#year').val()
            }
            var url = "/" + lang + "/tcp-appraisals/export_to_excel?" + $.param(query)
            window.location = url;
        });
    });
</script>

@endpush