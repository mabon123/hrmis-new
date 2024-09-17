@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.add_staff_received_credits') }}
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
    @if ( isset($cpd_schedule_course) )
    {!! Form::model(
    $cpd_schedule_course,
    ['route' => ['cpd-credits.update', [app()->getLocale(), $cpd_schedule_course->schedule_course_id]],
    'method' => 'PUT',
    'id' => 'frmCreateCPDCredits'])
    !!}
    @else
    {!! Form::open(
    ['route' => ['cpd-credits.store', [app()->getLocale()]],
    'method' => 'POST',
    'id' => 'frmCreateCPDCredits'])
    !!}
    @endif

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
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            {{ Form::checkbox('is_mobile', '1', (isset($cpd_schedule_course) ? $cpd_schedule_course->is_mobile : true), ['id' => 'is_mobile']) }}
                                            <label for="is_mobile">@lang('cpd.reged_cpd_via_mobile')</label>
                                            {{ Form::hidden('has_is_mobile', isset($cpd_schedule_course) ? $cpd_schedule_course->is_mobile : true) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group {{ $errors->has('schedule_course_id') ? 'has-error' : null }}">
                                        <label for="schedule_course_id">@lang('cpd.course') <span class="required">*</span></label>

                                        {{ Form::select(
                                            'schedule_course_id', 
                                            ['' => __('common.choose'). '...'] + $offerings, isset($cpd_schedule_course) ? $cpd_schedule_course->schedule_course_id : null, 
                                            ['id' => 'schedule_course_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 'required' => true]) 
                                        }}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="completed_date">@lang('cpd.credited_date') <span class="required">*</span></label>

                                        <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                            {{ Form::text('completed_date', isset($completed_date) ? $completed_date : null, ['required' => true, 'class' => 'form-control datepicker '.($errors->has('completed_date') ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'placeholder' => 'dd-mm-yyyy']) }}
                                            <div class="input-group-addon">
                                                <span class="far fa-calendar-alt"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="divLocation">
                                @php
                                $provinceAttributes = ['id' => 'pro_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;'];
                                $districtAttributes = ['id' => 'dis_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;'];
                                $locationAttributes = ['id' => 'location_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;'];

                                if(isset($cpd_schedule_course)) {
                                $provinceAttributes = ['id' => 'pro_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;'];
                                $districtAttributes = ['id' => 'dis_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;'];
                                $locationAttributes = ['id' => 'location_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;'];
                                }

                                @endphp
                                <!-- Province -->
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="pro_code">{{ __('common.province') }}</label>
                                        {{ Form::select('pro_code', $provinces, null, $provinceAttributes) }}
                                    </div>
                                </div>

                                <!-- District -->
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="dis_code">{{ __('common.district') }}</label>
                                        {{ Form::select('dis_code', $districts, null, $districtAttributes) }}
                                    </div>
                                </div>

                                <!-- Current location -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="location_code">{{ __('common.current_location') }}</label>
                                        {{ Form::select('location_code', $locations, null, $locationAttributes) }}
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="search_payroll_name_top">{{ __('common.payroll_num').'/'.__('common.name') }} <span class="required">*</span></label>
                                        {{ Form::text('search_payroll_name_top', null, ['id' => 'search_payroll_name_top', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" id="btn_search_staff_top" class="btn btn-info" style="width:180px; margin-top: 30px">
                                        <i class="fa fa-search"></i>&nbsp;{{ __('button.search') }}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

    <div class="row" id="staff_search_list">
        @if(isset($registrations) && count($registrations) > 0)
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> {{__('menu.staff_info')}}<span class="required">*</span></h3>
                    <!-- <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 10px">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" onclick="checkUncheckAll()" id="chk_all" value="all">
                                        <label for="chk_all" class="custom-control-label"></label>
                                    </div>
                                </th>
                                <th style="width: 50px">#</th>
                                <th>{{ __('common.payroll_num') }}</th>
                                <th>{{ __('common.name') }}</th>
                                <th>{{ __('common.fullname_en') }}</th>
                                <th>{{ __('common.sex') }}</th>
                                <th>{{ __('common.dob') }}</th>
                                <th>{{ __('common.position') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $index => $staff)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="{{ 'chk_'.$staff->payroll_id }}" name="payroll_numbers[]" value="{{ $staff->payroll_id }}">
                                        <label for="{{ 'chk_'.$staff->payroll_id }}" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td>{{ $staffs->firstItem() + $index }}</td>
                                <td>{{ $staff->payroll_id }}</td>
                                <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                <td>{{ strtoupper($staff->surname_en.' '.$staff->name_en) }}</td>
                                <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                <td>{{ date('d-m-Y', strtotime($staff->dob)) }}</td>
                                <td class="kh">{{ $staff->position_kh }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <table style="margin:auto;">
                <tr>
                    <td style="padding:5px">
                        <button type="submit" class="btn btn-primary btn-save" style="width:150px;">
                            <i class="far fa-save"></i> {{ __('button.save') }}
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br />

    {{ Form::close() }}

    @if(isset($completed_date))
    <form id="frmSearchTeachers" action="{{ route('cpd-credits.edit', [app()->getLocale(), $cpd_schedule_course->schedule_course_id, date('d-m-Y', strtotime($completed_date))]) }}">
        <div class="row" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #ccc;">
            @php
            $provinceAttributes = ['id' => 'search_pro_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;'];
            $districtAttributes = ['id' => 'search_dis_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;'];
            $locationAttributes = ['id' => 'search_location_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;'];
            @endphp
            <!-- Province -->
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="search_pro_code">{{ __('common.province') }} </label>
                    {{ Form::select('search_pro_code', $search_provinces, request()->search_pro_code, $provinceAttributes) }}
                </div>
            </div>

            <!-- District -->
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="search_dis_code">{{ __('common.district') }} </label>
                    {{ Form::select('search_dis_code', $search_districts, request()->search_dis_code, $districtAttributes) }}
                </div>
            </div>

            <!-- Current location -->
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="search_location_code">{{ __('common.current_location') }} </label>
                    {{ Form::select('search_location_code', $search_locations, request()->search_location_code, $locationAttributes) }}
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="search_payroll_name_bottom">{{ __('common.payroll_num').'/'.__('common.name') }} </label>
                    {{ Form::text('search_payroll_name_bottom', request()->search_payroll_name_bottom, ['id' => 'search_payroll_name_bottom', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-sm-2">
                <input type="hidden" name="search" value="true">
                <button type="submit" id="btn_search_staff_bottom" class="btn btn-info" style="width:180px; margin-top: 30px" onclick="loading();">
                    <i class="fa fa-search"></i>&nbsp;{{ __('button.search') }}
                </button>
            </div>
        </div>
    </form>
    @endif

    @if( isset($staffs) && count($staffs) > 0 )
    <div class="row" id="staff_data_list">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> {{ __('cpd.cpd_participant_list') }} </h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('common.payroll_num') }}</th>
                                    <th>{{ __('common.name') }}</th>
                                    <th>{{ __('common.fullname_en') }}</th>
                                    <th>{{ __('common.sex') }}</th>
                                    <th>{{ __('common.dob') }}</th>
                                    <th>{{ __('common.position') }}</th>
                                    <th>{{ __('common.current_location') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staffs as $index => $staff)
                                <tr>
                                    <td>{{ $staffs->firstItem() + $index }}</td>
                                    <td>{{ $staff->payroll_id }}</td>
                                    <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                    <td>{{ strtoupper($staff->surname_en.' '.$staff->name_en) }}</td>
                                    <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($staff->dob)) }}</td>
                                    <td class="kh">{{ $staff->position_kh}}</td>
                                    <td class="kh">{{ $staff->location_kh }}</td>

                                    <td class="text-right">
                                        @if ($staff->is_verified == 1 )
                                        <span class="alert alert-success" style="padding:4px 12px;">{{ __('button.verified') }}</span>
                                        @else
                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $staff->id }}" data-route="{{ route('cpd-credits.destroy', [app()->getLocale(), $staff->id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    @if($staffs->hasPages())
                    {!! $staffs->appends(Request::except('page'))->render() !!}
                    @endif
                </div>

            </div>
        </div>
    </div>
    @else
    @if(isset($completed_date))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <span>{{ __('common.no_data') }}</span>
                <button class="close" data-dismiss="alert" type="button">×</button>
            </div>
        </div>
    </div>
    @endif

    @endif
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

        $("#create-cpd-credit > a").addClass("active");
        var schedule_id = '<?php echo isset($cpd_schedule_course) ? $cpd_schedule_course->schedule_course_id : ''; ?>';

        function checkMobile(checkbox) {
            if (checkbox.is(":checked")) {
                $("#divLocation").hide();
            } else {
                $("#divLocation").show();
            }
        }
        checkMobile($('#is_mobile'));

        function loadCPDOfferings(isMobile = 1) {
            loadModalOverlay(true, 1000);
            $.ajax({
                type: "GET",
                url: "/cpd-credits/" + isMobile + "/get-cpd-offerings",
                success: function(offerings) {
                    var cpdCount = Object.keys(offerings).length;
                    $("#schedule_course_id").find('option:not(:first)').remove();
                    if (cpdCount > 0) {
                        for (var key in offerings) {
                            $("#schedule_course_id").append('<option value="' + key + '">' + offerings[key] + '</option>');
                        }
                    }
                },
                error: function(err) {
                    console.log('Error:', err);
                }
            });
        }

        $('#is_mobile').change(function() {
            var checkbox = $(this);
            $("#staff_search_list").html(''); //clear rows
            if (checkbox.is(":checked")) {
                $("#divLocation").hide();
                loadCPDOfferings(1);
            } else {
                $("#divLocation").show();
                loadCPDOfferings(0);
            }
        });
        var ruleList = {};
        var messageList = {};

        if (schedule_id != '') {
            ruleList = {
                schedule_course_id: "required",
                completed_date: "required"
            };
            messageList = {
                schedule_course_id: "{{ __('validation.required_field') }}",
                completed_date: "{{ __('validation.required_field') }}"
            };
            $("#is_mobile").attr('disabled', 'true');
            $("#schedule_course_id").attr('disabled', 'true');
        } else {
            ruleList = {
                schedule_course_id: "required",
                completed_date: "required",
                // pro_code: "required",
                // dis_code: "required",
                // location_code: "required",
                payroll_numbers: "required"
            };
            messageList = {
                schedule_course_id: "{{ __('validation.required_field') }}",
                completed_date: "{{ __('validation.required_field') }}",
                // pro_code: "{{ __('validation.required_field') }}",
                // dis_code: "{{ __('validation.required_field') }}",
                // location_code: "{{ __('validation.required_field') }}",
                payroll_numbers: "{{ __('validation.required_field') }}"
            };
            $("#is_mobile").removeAttr('disabled');
            $("#schedule_course_id").removeAttr('disabled');
        }
        if ($("#is_mobile").is(":checked")) {
            ruleList = {
                schedule_course_id: "required",
                completed_date: "required"
            };
            messageList = {
                schedule_course_id: "{{ __('validation.required_field') }}",
                completed_date: "{{ __('validation.required_field') }}"
            };
        }
        // Validation
        $("#frmCreateCPDCredits").validate({
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

        // District change -> auto-fill data for location belong to that district
        $("#dis_code, #search_dis_code").change(function() {
            var disId = $(this).attr('id');
            if ($(this).val() > 0) {
                loadModalOverlay(true, 1000);
                $.ajax({
                    type: "GET",
                    url: "/districts/" + $(this).val() + "/locations",
                    success: function(locations) {
                        var locationCount = Object.keys(locations).length;
                        var locSelector = disId == 'search_dis_code' ? $("#search_location_code") : $("#location_code");
                        locSelector.find('option:not(:first)').remove();
                        if (locationCount > 0) {
                            for (var key in locations) {
                                locSelector.append('<option value="' + key + '">' + locations[key] + '</option>');
                            }
                        }
                    },
                    error: function(err) {
                        console.log('Error:', err);
                    }
                });
                loadModalOverlay(false);
            }
        });

        function getStaffInfo(urlPath, params = false) {
            loadModalOverlay(true, 1500);
            $.ajax({
                type: "GET",
                url: urlPath,
                dataType: "json",
                data: params ? {
                    pro_code: $('#pro_code').val(),
                    dis_code: $('#dis_code').val(),
                    location_code: $('#location_code').val(),
                } : null,
                success: function(data) {
                    var staffCount = Object.keys(data).length;
                    if (staffCount > 0) {
                        $("#staff_search_list").html('');
                        var caption = '<?php echo __('menu.staff_info'); ?>';
                        var payrollId = '<?php echo __('common.payroll_num'); ?>';
                        var nameKh = '<?php echo __('common.name'); ?>';
                        var nameEn = '<?php echo __('common.fullname_en'); ?>';
                        var sex = '<?php echo __('common.sex'); ?>';
                        var dob = '<?php echo __('common.dob'); ?>';
                        var position = '<?php echo __('common.position'); ?>';

                        var fullTable = '<div class="col-12"><div class="card"><div class="card-header">' +
                            '<h3 class="card-title">' + caption + ' <span class="required">*</span></h3>' +
                            // '<div class="card-tools"><div class="input-group input-group-sm" style="width: 150px;">' +
                            // '<input type="text" name="table_search" class="form-control float-right" placeholder="Search">' +
                            // '<div class="input-group-append">' +
                            // '<button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>' +
                            // '</div></div></div>' +
                            '</div>' + //End card-header
                            '<div class="card-body table-responsive p-0" style="height: 300px;">' +
                            '<table class="table table-head-fixed text-nowrap">' +
                            '<thead><tr><th style="width: 10px"><div class="custom-control custom-checkbox">' +
                            '<input class="custom-control-input" type="checkbox" onclick="checkUncheckAll()" id="chk_all" value="all">' +
                            '<label for="chk_all" class="custom-control-label"></label>' +
                            '</div></th><th style="width: 50px">#</th> <th>' + payrollId + '</th><th>' + nameKh + '</th><th>' + nameEn + '</th>' +
                            '<th>' + sex + '</th><th>' + dob + '</th><th>' + position + '</th></tr></thead><tbody>';

                        var rows = '';
                        for (var i = 0; i < staffCount; i++) {
                            rows += '<tr><td><div class="custom-control custom-checkbox">' +
                                '<input class="custom-control-input" type="checkbox" id="chk_' + data[i].payroll_id + '" name="payroll_numbers[]" value="' + data[i].payroll_id + '">' +
                                '<label for="chk_' + data[i].payroll_id + '" class="custom-control-label"></label>' +
                                '</div></td>' +
                                '<td>' + (i + 1) + '</td><td>' + data[i].payroll_id + '</td><td>' + data[i].surname_kh + ' ' + data[i].name_kh + '</td>' +
                                '<td>' + data[i].surname_en + ' ' + data[i].name_en + '</td>';
                            var sex_data = data[i].sex == 1 ? 'ប្រុស' : 'ស្រី';
                            rows += '<td>' + sex_data + '</td><td>' + data[i].dob + '</td><td>' + data[i].position_kh + '</td></tr>';
                        }
                        rows += '</tbody></table></div>';

                        fullTable = fullTable + rows + '</div></div>';
                        $("#staff_search_list").append(fullTable);
                        //hideLoading();
                    } else {
                        Toast.fire({
                            icon: 'warning',
                            title: 'មិនមានទិន្នន័យបុគ្គលិក'
                        });
                        //hideLoading();
                    }
                },
                error: function(err) {
                    //hideLoading();
                    console.log('Error:', err);
                }
            });
        }

        $('#location_code').change(function() {
            if ($(this).val() != '') {
                $("#staff_search_list").html('');
                var scheduleId = $("#schedule_course_id").val();
                if (scheduleId != '') {
                    var url = "/cpd-credits/" + $(this).val() + "/" + scheduleId + "/staff-by-location";
                    getStaffInfo(url);
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: 'សូមជ្រើសរើស វគ្គអវប និងបំពេញ ថ្ងៃខែឆ្នាំ ផ្ដល់ក្រេឌីតជាមុនសិន!'
                    })
                }
            }
        });

        $('#btn_search_staff_top').click(function() {
            var scheduleId = $("#schedule_course_id").val();
            var payroll_name_top = $("#search_payroll_name_top").val();
            if (scheduleId === '') {
                Toast.fire({
                    icon: 'warning',
                    title: 'សូមជ្រើសរើសវគ្គអវប និងបំពេញ ថ្ងៃខែឆ្នាំ ផ្ដល់ក្រេឌីត ជាមុនសិន!'
                });
            } else if (payroll_name_top.length === 0) {
                Toast.fire({
                    icon: 'warning',
                    title: 'សូមបំពេញអត្តលេខមន្ត្រី/ឈ្មោះឱ្យបានត្រឹមត្រូវ ជាមុនសិន!'
                });
            } else {
                var url = "/cpd-credits/" + payroll_name_top + "/" + scheduleId + "/staff-by-payroll-name";
                getStaffInfo(url, true);
            }
        });


        $('#schedule_course_id').change(function() {
            if ($(this).val() != '' && $("#is_mobile").is(":checked")) {
                $("#staff_search_list").html('');
                var url = "/cpd-credits/" + $(this).val() + "/staff-mobile-registrations";
                getStaffInfo(url);
            }
        });

    });

    function checkUncheckAll() {
        var selectAllCheckbox = document.getElementById("chk_all");
        if (selectAllCheckbox.checked == true) {
            var inputs = document.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == "checkbox" && inputs[i].name != "is_mobile") {
                    inputs[i].checked = true;
                }
            }
        } else {
            var inputs = document.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == "checkbox" && inputs[i].name != "is_mobile") {
                    inputs[i].checked = false;
                }
            }
        }
    }
</script>

@endpush