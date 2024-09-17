@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('cpd.cpd_participant_list') }}
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
    <form id="frmSearchTeachers" action="{{ route('cpd-credits.view-pending-cpd', [app()->getLocale(), $schedule_course->schedule_course_id]) }}">
        <div class="row" id="divSearch">
            @php
            $provinceAttributes = ['id' => 'pro_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;'];
            $districtAttributes = ['id' => 'dis_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;'];
            $locationAttributes = ['id' => 'location_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;'];
            @endphp
            <!-- Province -->
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="pro_code">{{ __('common.province') }} </label>
                    {{ Form::select('pro_code', $provinces, request()->pro_code, $provinceAttributes) }}
                </div>
            </div>

            <!-- District -->
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="dis_code">{{ __('common.district') }} </label>
                    {{ Form::select('dis_code', $districts, request()->dis_code, $districtAttributes) }}
                </div>
            </div>

            <!-- Current location -->
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="location_code">{{ __('common.current_location') }} </label>
                    {{ Form::select('location_code', $locations, request()->location_code, $locationAttributes) }}
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="payroll_name">{{ __('common.payroll_num').'/'.__('common.name') }} </label>
                    {{ Form::text('payroll_name', request()->payroll_name, ['id' => 'payroll_name', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-sm-2">
                <input type="hidden" name="search" value="true">
                <button type="submit" class="btn btn-info" style="width:180px; margin-top: 30px" onclick="loading();">
                    <i class="fa fa-search"></i>&nbsp;{{ __('button.search') }}
                </button>
            </div>
        </div>
    </form>


    @if( isset($staffs) && count($staffs) > 0 )
    {!! Form::model($schedule_course,
    ['route' => ['cpd-credits.verify-cpd', [app()->getLocale(), $schedule_course->schedule_course_id]],
    'method' => 'PUT',
    'id' => 'frmVerifyCPD'])
    !!}

    <div class="row" id="staff_data_list">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> {{ $schedule_course->CPDCourse->cpd_course_kh }} </h3>
                    <span style="color:brown;">&nbsp;{{ '('. $schedule_course->provider->provider_kh.')' }}</span>

                    <div>
                        <span class="kh">{{ __('cpd.credits').'='.$schedule_course->CPDCourse->credits}}</span>&nbsp;&nbsp;&nbsp;
                        <span class="kh">{{ __('common.participants_planed').'='.$schedule_course->participant_num}}</span>&nbsp;&nbsp;&nbsp;
                        <span class="kh">{{ __('common.participants_completed').'='.count($staffs)}}</span>&nbsp;&nbsp;&nbsp;
                        <span class="kh">{{ __('cpd.start_date').'='.date('d-m-Y', strtotime($schedule_course->start_date))}}</span>&nbsp;&nbsp;&nbsp;
                        <span class="kh">{{ __('cpd.end_date').'='.date('d-m-Y', strtotime($schedule_course->end_date))}}</span></span>&nbsp;&nbsp;&nbsp;
                        <span class="kh">{{ __('cpd.cpd_activity_type').'='}}</span>
                        <span class="kh">
                            {{ $schedule_course->is_old == 1 ? __('cpd.cpd_type_old') : __('cpd.cpd_type_new') }}
                        </span>
                        <br />
                        <span class="kh">{{ __('cpd.learning_option').'='.$schedule_course->learningOption->learning_option_kh}}</span>&nbsp;&nbsp;&nbsp;
                        @if($schedule_course->learning_option_id == 2)
                        <span class="kh">{{ __('common.province').'='.$schedule_course->province->name_kh }} </span>&nbsp;&nbsp;&nbsp;
                        @if (!empty($schedule_course->dis_code))
                        <span class="kh">{{ __('common.district').'='.$schedule_course->district->name_kh }} </span>&nbsp;&nbsp;&nbsp;
                        @endif

                        @if (!empty($schedule_course->address))
                        <span class="kh">{{ __('common.address').'='.$schedule_course->address }} </span>
                        @endif

                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-body table-responsive p-0" style="height: 350px;">
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
                                    <th>{{ __('cpd.credited_date') }}</th>
                                    <th>{{ __('common.current_location') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staffs as $index => $staff)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="{{ 'chk_'.$staff->payroll_id}}" name="payroll_numbers[]" value="{{ $staff->payroll_id }}">
                                            <label for="{{ 'chk_'.$staff->payroll_id}}" class="custom-control-label"></label>
                                        </div>
                                    </td>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $staff->payroll_id }}</td>
                                    <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                    <td>{{ strtoupper($staff->surname_en.' '.$staff->name_en) }}</td>
                                    <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($staff->dob)) }}</td>
                                    <td class="kh">{{ $staff->position_kh }}</td>
                                    <td>{{ date('d-m-Y', strtotime($staff->completed_date)) }}</td>
                                    <td>{{ $staff->location_kh }}</td>

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
        <div class="col-sm">
            <div class="form-group">
                <label for="remark">@lang('cpd.cpd_notes')</label>
                <textarea class="form-control" rows="3" name="remark" id="remark" style="text-align: left;">
                {{ $schedule_course->remark }}
                </textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table style="margin:auto;">
                <tr>
                    <td style="padding:5px">
                        <button type="submit" class="btn btn-info btn-save">
                            <i class="far fa-save"></i> {{ __('button.conf_verification') }}
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{ Form::close() }}
    @endif
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/delete.handler.js') }}"></script>
<script src="{{ asset('js/custom_validation.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $("#cpd-pending-list > a").addClass("active");

        ruleList = {
            payroll_numbers: "required"
        };
        messageList = {
            payroll_numbers: "{{ __('validation.required_field') }}"
        };
        // Validation
        $("#frmVerifyCPD").validate({
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

        $("#dis_code").change(function() {
            if ($(this).val() > 0) {
                loadModalOverlay(true, 1000);
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

    });

    function checkUncheckAll() {
        var selectAllCheckbox = document.getElementById("chk_all");
        if (selectAllCheckbox.checked == true) {
            var inputs = document.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == "checkbox") {
                    inputs[i].checked = true;
                }
            }
        } else {
            var inputs = document.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == "checkbox") {
                    inputs[i].checked = false;
                }
            }
        }
    }
</script>

@endpush