@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.staff_info') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.personal_list') }}</li>
                </ol>

            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form id="frmSearchStaff" action="{{ route('staffs.index', app()->getLocale()) }}">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('common.search_staffs') }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <input type="hidden" name="search" value="true">

                        <div class="row">
                            <!-- Province -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="pro_code">{{ __('common.province') }}</label>

                                    {{ Form::select('pro_code', $provinces, request()->pro_code, ['id' => 'pro_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 'disabled' => (count($provinces) == 1 ? true : false)]) }}
                                </div>
                            </div>

                            <!-- District -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="dis_code">{{ __('common.district') }}</label>

                                    {{ Form::select(
                                        'dis_code', 
                                        $districts, 
                                        request()->dis_code, 
                                        [
                                            'id' => 'dis_code', 
                                            'class' => 'form-control kh select2', 
                                            'style' => 'width:100%;', 
                                            'disabled' => (auth()->user()->hasRole('doe-admin')
                                                or auth()->user()->hasRole('school-admin','dept-admin')) ? true : 
                                                ((auth()->user()->level_id == 3 or auth()->user()->level_id == 2 or request()->pro_code) ? false : true)
                                        ]) 
                                    }}
                                </div><!-- (request()->pro_code or $districts) ? false : true -->
                            </div>

                            <!-- Current location -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="location_code">{{ __('common.current_location') }}</label>

                                    {{ Form::select('location_code', $locations, request()->location_code, 
                                        ['id' => 'location_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
                                            'disabled' => auth()->user()->hasRole('school-admin', 'dept-admin') ? true : false]) 
                                    }}
                                </div>
                            </div>

                            <!-- Position -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="position_id">{{ __('common.position') }}</label>

                                    {{ Form::select('position_id', ['' => __('common.choose').' ...'] + $positions, request()->position_id, ['id' => 'position_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                                </div>
                            </div>

                            <!-- Filter by -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="filter_by">{{ __('common.filter_by') }}</label>

                                    <?php
                                        $filters = [
                                            'payroll_id' => __('common.payroll_num'),
                                            'surname_kh' => __('common.surname_kh'),
                                            'name_kh' => __('common.name_kh'),
                                            'surname_en' => __('common.surname_latin'),
                                            'name_en' => __('common.name_latin'),
                                            'fullnamekh' => __('common.fullname_kh'),
                                            'fullnameen' => __('common.fullname_en'),
                                        ];
                                    ?>

                                    {{ Form::select('filter_by', $filters, (request()->filter_by ? request()->filter_by : 'payroll_id'), ['class' => 'form-control kh select2', 'style' => 'width:100%;', 'id' => 'filter_dropdown']) }}
                                </div>
                            </div>

                            <!-- Search keyword -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="keyword">{{ __('common.filter_value') }}</label>

                                    {{ Form::text('keyword', request()->keyword, ['id' => 'keyword', 'class' => 'form-control kh', 'autocomplete' => 'off']) }}
                                </div>
                            </div>

                            <!-- Staff status -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="status_id">{{ __('common.current_status') }}</label>

                                    {{ Form::select('status_id', ['' => __('common.choose').' ...'] + $staffStatus, request()->status_id, ['id' => 'status_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <div class="card-footer">
                        <button type="button" id="btn-reset" class="btn btn-danger" style="width:160px;">
                            <i class="fa fa-undo"></i>&nbsp;{{ __('button.reset') }}
                        </button>

                        <button type="submit" class="btn btn-info" style="width:180px;" onclick="loading();">
                            <i class="fa fa-search"></i>&nbsp;{{ __('button.search') }}
                        </button>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </form>


    <!-- Staff listing -->
    @if( count($staffs) > 0 )

        <div class="card">
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
                                <th>{{ __('common.current_status') }}</th>
                                <th>{{ __('common.current_location') }}</th>
                                <th class="text-right">
                                    <span>{{ __('common.total_amount') .':'. $staffs->total() }}</span>
                                    <span style="margin-left:15px;">{{ __('common.female') .':'. $femaleStaffs }}</span>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($staffs as $index => $staff)
                                <tr>
                                    <td>{{ $staffs->firstItem() + $index }}</td>
                                    <td>
                                        <a href="{{ route('staffs.show', [app()->getLocale(), $staff->payroll_id]) }}" 
                                            target="_blank">{{ $staff->payroll_id }}</a>
                                    </td>
                                    <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                    <td>{{ strtoupper($staff->surname_en.' '.$staff->name_en) }}</td>
                                    <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($staff->dob)) }}</td>
                                    <td class="kh">{{ !empty($staff->status) ? $staff->status->status_kh : '---' }}</td>

                                    <td class="kh">{{ !empty($staff->currentWorkPlace()) ? $staff->currentWorkPlace()->location_kh : (!empty($staff->latestWorkPlace()) ? $staff->latestWorkPlace()->location_kh : '---') }}</td>

                                    <td class="text-right">
                                        @if (request()->status_id != 9)
                                            <!-- View -->
                                            <a href="{{ route('staffs.show', [app()->getLocale(), $staff->payroll_id]) }}" 
                                                class="btn btn-xs btn-success" target="_blank">
                                                <i class="fas fa-print"></i> {{ __('button.print') }}
                                            </a>

                                            <!-- Edit -->
                                            @if (auth()->user()->can('edit-staffs'))
                                                @if (request()->status_id != 4 and request()->status_id != 9)
                                                <a href="{{ route('staffs.edit', [app()->getLocale(), $staff->payroll_id]) }}"
                                                 
                                                    class="btn btn-xs btn-info" target="_blank">
                                                    <i class="far fa-edit"></i> {{ __('button.edit') }}
                                                @endif
                                                </a>
                                            @endif
                                        @endif

                                        <!-- Delete -->
                                        @if (auth()->user()->hasRole('administrator'))

                                            <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $staff->payroll_id }}" data-route="{{ route('staffs.destroy', [app()->getLocale(), $staff->payroll_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer text-center">
                <div>
                    @if($staffs->hasPages())
                        {!! $staffs->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
                <h6 class="d-none">T = {{ $mobileUsers }}</h6>
                <h6 class="d-none">F = {{ $mobileFUsers }}</h6>
            </div>
        </div>

    @endif
</section>

@endsection

@push('scripts')
    
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    
    <script type="text/javascript">

        function addValueToPositionDropdown(locationName) {

            if( locationName !== "" ) {

                $.ajax({
                    type: "GET",
                    url: "/locations/" + locationName + "/positions",
                    success: function (positions) {
                        
                        if( positions.length > 0 ) {

                            $("#position_id").find('option:not(:first)').remove();

                            for(var index in positions) {
                                $("#position_id").append('<option value="'+positions[index].position_id+'">'+ positions[index].position_kh +'</option>');
                            }
                        }
                        //else { $("#sys_admin_office_id").prop("disabled", true); }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }
            else {
                $("#position_id").find('option:not(:first)').remove();
            }
        }

        // Filter function
        function keywordFilter() {
            $.ajax({
                type: "GET",
                url: "/staff/filter-keyword/" + $("#filter_dropdown").val(),
                data: {
                    pro_code: $("#pro_code").val(),
                    dis_code: $("#dis_code").val(),
                    location_code: $("#location_code").val(),
                    position_id: $("#position_id").val(),
                    status_id: $("#status_id").val()
                },
                success: function (staffs_info) {
                    //console.log(staffs_info);
                    $("#keyword").autocomplete({
                        source: staffs_info,
                    });
                },
                error: function (err) {
                    console.log('Error:', err);
                }
            });
        }
        
        $(function() {

            $("#staff-info").addClass("menu-open");
            $("#personal-list > a").addClass("active");

            // Current location - Onchange event
            $("#location_code").change(function() {
                var locationName = $(this).val();
                addValueToPositionDropdown(locationName);
            });

            // Filter by keywords
            keywordFilter();

            // Default auto-complete
            //var keywords = JSON.parse($("#keywords").val());
            //$("#keyword").autocomplete({ source:keywords });

            // Filter dropdown event
            $("#filter_dropdown").change(function() {
                if( $(this).val() != "" ) {
                    keywordFilter();
                }
            });

            /*var filter_by = $("#filter_dropdown").val();

            if (filter_by !== "") {
                $.ajax({
                    type: "GET",
                    url: "/filter-by/" + filter_by + "/teacher",
                    success: function (teachers) {
                        $("#keyword").autocomplete({
                            source: teachers,
                        });
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }*/

            // Province change -> auto-fill data for location belong to that province
            $("#pro_code").change(function() {
                $.ajax({
                    type: "GET",
                    url: "/provinces/" + $(this).val() + "/locations",
                    success: function (locations) {
                        var locationCount = Object.keys(locations).length;
                        $("#location_code").find('option:not(:first)').remove();
                        
                        if ( locationCount > 0 ) {
                            for(var key in locations) {
                                $("#location_code").append('<option value="'+key+'">'+ locations[key] +'</option>');
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });

                //if ($(this).val() == "99") { $("#dis_code").prop("disabled", true); }

                // Load filter function
                keywordFilter();
            });

            //if ($("#pro_code").val()) { $("#pro_code").trigger('change'); }

            // District change -> auto-fill data for location belong to that district
            $("#dis_code").change(function() {
                if ($(this).val() > 0) {
                    $.ajax({
                        type: "GET",
                        url: "/districts/" + $(this).val() + "/locations",
                        success: function (locations) {
                            var locationCount = Object.keys(locations).length;
                            $("#location_code").find('option:not(:first)').remove();

                            if ( locationCount > 0 ) {
                                for(var key in locations) {
                                    $("#location_code").append('<option value="'+key+'">'+ locations[key] +'</option>');
                                }
                            }
                        },
                        error: function (err) {
                            console.log('Error:', err);
                        }
                    });

                    // Load filter function
                    keywordFilter();
                }
            });

            // Status event
            $("#status_id").change(function() {
                console.log($(this).val());
                // Load filter function
                keywordFilter();
            });

            // Reset form
            $("#btn-reset").click(function() {
                $("#frmSearchStaff").trigger("reset");
                $("#select2-pro_code-container").text('ជ្រើសរើស ...');
                $("#select2-dis_code-container").text('ជ្រើសរើស ...');
                $("#select2-filter_by-container").text('ជ្រើសរើស ...');
                $("#select2-position_id-container").text('ជ្រើសរើស ...');
                $("#select2-status_id-container").text('ជ្រើសរើស ...');
            });

        });

    </script>

@endpush