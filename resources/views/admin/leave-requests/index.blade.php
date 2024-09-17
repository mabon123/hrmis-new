@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('common.short_leave_list') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('common.short_leave_list') }}</li>
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

    <div class="row" id="staff_data_list">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" id="div_message"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-head-fixed">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="width: 120px;">{{ __('common.payroll_num') }}</th>
                                    <th>{{ __('common.name') }}</th>
                                    <th>{{ __('common.sex') }}</th>
                                    <th>{{ __('common.leave_type') }}</th>
                                    <th style="width: 100px;">{{ __('common.start_date') }}</th>
                                    <th style="width: 100px;">{{ __('common.end_date') }}</th>
                                    <th>{{ __('common.description') }}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody id="data_tbody">
                                @foreach($leave_requests as $index => $leave)
                                <tr id="record-{{ $leave->leave_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('staffs.show', [app()->getLocale(), $leave->payroll_id]) }}" target="_blank">{{ $leave->payroll_id }}</a>
                                    </td>
                                    <td class="kh">{{ $leave->staffInfo->surname_kh.' '.$leave->staffInfo->name_kh }}</td>
                                    <td class="kh">{{ $leave->staffInfo->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                    <td class="kh">{{ $leave->leaveType->leave_type_kh }}</td>
                                    <td>{{ date('d-m-Y', strtotime($leave->start_date)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($leave->end_date)) }}</td>
                                    <td class="kh">{{ $leave->description }}</td>
                                    <td class="kh">
                                        <div class="form-group clearfix">
                                            <div class="icheck-warning d-inline">
                                                <input type="radio" id="skip_{{$leave->leave_id}}" class="skip" name="chk_approve_{{$index}}" value="{{ $leave->leave_id }}" checked="" />
                                                <label for="skip_{{$leave->leave_id}}">
                                                    {{ __('button.pending') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="icheck-success d-inline">
                                                <input type="radio" id="approve_{{$leave->leave_id}}" class="approve" name="chk_approve_{{$index}}" value="{{ $leave->leave_id }}" />
                                                <label for="approve_{{$leave->leave_id}}">
                                                    {{ __('button.approve') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="radio" id="reject_{{$leave->leave_id}}" class="reject" name="chk_approve_{{$index}}" value="{{ $leave->leave_id }}" data-staff-name="{{ $leave->staffInfo->surname_kh.' '.$leave->staffInfo->name_kh }}" />
                                                <label for="reject_{{$leave->leave_id}}">
                                                    {{ __('button.reject') }}
                                                </label>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        {{ Form::textarea('reject_reasons[]', null,
                                        ['class' => 'form-control kh txt_reject_reasons', 'id' => 'reject_reasons_'.$leave->leave_id,
                                        'style'=> 'width: 200px; height: 100px', 'disabled' => true ]) }}
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

    <div class="row">
        <div class="col-md-12">
            <table style="margin:auto;">
                <tr>
                    <td style="padding:5px">
                        <button type="button" id="btn_approve_reject" class="btn btn-info btn-save">
                            <i class="far fa-save"></i> {{ __('button.process') }}
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>

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
        var lang = '<?php echo app()->getLocale(); ?>';

        $(document).on('change', 'input[type=radio]', function() {
            if ($(this).is(':checked')) {
                var leaveId = $(this).val();
                if ($(this).attr('class') == 'reject') {
                    $('#reject_reasons_' + leaveId).val('');
                    $('#reject_reasons_' + leaveId).prop("disabled", false);
                    $('#reject_reasons_' + leaveId).focus();
                } else {
                    $('#reject_reasons_' + leaveId).val('');
                    $('#reject_reasons_' + leaveId).prop("disabled", true);
                }
            }
        });

        $("#btn_approve_reject").click(function() {
            var approveIds = [];
            //var approveNotes = [];
            var rejectIds = [];
            var rejectNotes = [];

            $("input.approve:checked[type='radio']").each(function() {
                var leaveId = $(this).val();
                approveIds.push(leaveId);
                //approveNotes.push($('#reject_reasons_' + leaveId).val());
            });
            $("input.reject:checked[type='radio']").each(function() {
                var leaveId = $(this).val();
                if ($('#reject_reasons_' + leaveId).val() == '') {
                    alert('សូមបញ្ជាក់ពីមូលហេតុដែលបដិសេធឈ្មោះ ' + $(this).attr('data-staff-name'));
                    $('#reject_reasons_' + leaveId).focus();
                    return false;
                }
                rejectIds.push(leaveId);
                rejectNotes.push($('#reject_reasons_' + leaveId).val());
            });

            if (approveIds.length == 0 && rejectIds.length == 0) {
                $('#div_message').html('');
                var message = 'សូមជ្រើសរើសជំរើសក្រៅពីរង់ចាំ យ៉ាងហោចណាស់ឱ្យបាន១ដើម្បីដំណើរការ!';
                var divMesage = '<div class="alert alert-warning"><ul style="margin-bottom:0;"><li>' + message + '</li></ul>';
                divMesage += '<button class="close" style="position: relative; top: -22px;" data-dismiss="alert" type="button">×</button></div>';
                $('#div_message').append(divMesage);
            } else {
                loadModalOverlay(true, 1000);
                $.ajax({
                    type: "POST",
                    url: "/" + lang + "/leave-requests/approve-reject",
                    dataType: "json",
                    data: {
                        approve_ids: approveIds,
                        //approve_notes: approveNotes,
                        reject_ids: rejectIds,
                        reject_notes: rejectNotes
                    },
                    success: function(data) {
                        var dataCount = Object.keys(data).length;
                        if (dataCount > 0) {
                            //Update number on top menu
                            $('#span_leave_req').html(dataCount);
                            //clear tbody
                            $('#data_tbody').html('');
                            for (var key in data) {
                                var tbodyHtml = '<tr id="record-' + data[key].leave_id + '"><td>' + (parseInt(key) + 1) + '</td>';
                                tbodyHtml += '<td class="kh">' + data[key].payroll_id + '</td>';
                                tbodyHtml += '<td class="kh">' + data[key].surname_kh + ' ' + data[key].name_kh + '</td>';
                                tbodyHtml += '<td class="kh">' + data[key].sex + '</td>';
                                tbodyHtml += '<td class="kh">' + data[key].leave_type + '</td>';
                                tbodyHtml += '<td>' + data[key].start_date2 + '</td>';
                                tbodyHtml += '<td>' + data[key].end_date2 + '</td>';
                                tbodyHtml += '<td class="kh">' + data[key].description + '</td>';

                                tbodyHtml += '<td class="kh">';
                                tbodyHtml += '<div class="form-group clearfix">';
                                tbodyHtml += '<div class="icheck-warning d-inline">';
                                tbodyHtml += '<input type="radio" id="skip_' + data[key].leave_id + '" class="skip" name="chk_approve_' + key + '" value="' + data[key].leave_id + '" checked="" />';
                                tbodyHtml += '<label for = "skip_' + data[key].leave_id + '"><?php echo __('button.pending'); ?></label>';
                                tbodyHtml += '</div> </div>';
                                tbodyHtml += '<div class = "form-group clearfix" ><div class = "icheck-success d-inline">';
                                tbodyHtml += '<input type = "radio" id = "approve_' + data[key].leave_id + '" class = "approve" name = "chk_approve_' + key + '" value = "' + data[key].leave_id + '" / >';
                                tbodyHtml += '<label for = "approve_' + data[key].leave_id + '" ><?php echo __('button.approve'); ?> </label>';
                                tbodyHtml += '</div> </div>';
                                tbodyHtml += '<div class = "form-group clearfix">';
                                tbodyHtml += '<div class = "icheck-danger d-inline">';
                                tbodyHtml += '<input type = "radio" id = "reject_' + data[key].leave_id + '" class = "reject" name = "chk_approve_' + key + '" value = "' + data[key].leave_id + '" data-staff-name="' + data[key].surname_kh + ' ' + data[key].name_kh + '" / >';

                                tbodyHtml += '<label for="reject_' + data[key].leave_id + '"><?php echo __('button.reject'); ?></label>';

                                tbodyHtml += '</div > </div> </td>';
                                tbodyHtml += '<td><textarea class="form-control kh txt_reject_reasons" id="reject_reasons_' + data[key].leave_id + '" style="width: 200px; height: 100px;" name="reject_reasons[]" disabled="true"></textarea></td>';
                                tbodyHtml += '</tr>';
                                $('#data_tbody').append(tbodyHtml);
                            }
                        } else {
                            //Update number on top menu
                            $('#span_leave_req').html('');
                            //just clear tbody
                            $('#data_tbody').html('');
                        }

                        $('#div_message').html('');
                        var message = 'ទិន្នន័យការស្នើសុំច្បាប់ឈប់រយៈពេលខ្លី ត្រូវបានដំណើរការដោយជោគជ័យ។';
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

    });
</script>

@endpush