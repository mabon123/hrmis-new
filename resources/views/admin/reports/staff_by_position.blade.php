@extends('layouts.admin')

@push('styles')
    <style>
        span.sept {padding-left: 10px;padding-right: 10px;}
    </style>
@endpush

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('report.staff_by_positions') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('reports.index', app()->getLocale()) }}">
                            {{ __('menu.report_and_chart') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('report.staff_by_positions') }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row row-box">
        <div class="col-md-6"></div>

        <div class="col-sm-6 text-right">
            <div class="btn-group">
                <a href="{{ route('reports.exportStaffbyPositionPDF', 
                    [app()->getLocale(), $pro_code, $position_from, $position_to, $dis_code, $location_code]) }}" 
                    class="btn btn-sm btn-info" style="width:220px;" target="_blank">
                    <i class="fas fa-file-pdf"></i> {{ __('button.export_to_pdf') }}
                </a>
            </div>
            <div class="btn-group">
                <a href="{{ route('reports.exportStaffbyPositionExcel', 
                    [app()->getLocale(), $pro_code, $position_from, $position_to, $dis_code, $location_code]) }}" 
                    class="btn btn-sm btn-info" style="width:220px;" title="Export to Excel" 
                    onclick="loadModalOverlay(true, 1000);">
                    <i class="far fa-file-excel"></i> {{ __('button.export_to_excel') }}
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('common.payroll_num') }}</th>
                            <th>{{ __('common.name') }}</th>
                            <th>{{ __('common.fullname_en') }}</th>
                            <th>{{ __('common.sex') }}</th>
                            <th>{{ __('common.dob') }}</th>
                            <th>{{ __('common.salary_rank') }}</th>
                            <th>{{ __('common.position') }}</th>
                            <th class="text-center">{{ __('common.teaching') }}</th>
                        </tr>
                    </thead>

                    @php
                        $g_workplace = '';$g_office = '';$row_num = 1; $total_records = count($staffs);
                        $is_teaching_icon = '<i class="fas fa-check-square success"></i>';
                        $no_teaching_icon = '';
                        $colspan = 9;
                    @endphp

                    <tbody>
                        @for ($i=0; $i < $total_records; $i++) 
                            @if($i == $total_records - 1)
                                <tr>
                                    <td colspan="{{ $colspan }}">
                                        <!-- Data Summary -->
                                        @include('admin.reports.partials.data_summary_pos')
                                    </td>
                                </tr>
                            @else
                                @if ($g_workplace !=$staffs[$i]->workplace_kh)
                                    <tr style="background-color: #cdcdcd">
                                        <td class="kh" colspan="{{ $colspan }}">
                                            <!-- Data Workplace -->
                                            @include('admin.reports.partials.data_workplace')
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> {{ $row_num++ }}</td>
                                        <!-- Data Body -->
                                        @include('admin.reports.partials.data_body_position')
                                    </tr>
                                @elseif ($g_workplace == $staffs[$i]->workplace_kh && $g_office != $staffs[$i]->office_kh)
                                    <tr>
                                        <td class="kh" colspan="{{ $colspan }}">
                                            <p style="margin-top:10px;margin-bottom:0px;">
                                                {{ __('ការិយាល័យ៖ ') }} <span
                                                    style="font-family: 'Moul', 'Arial';margin-right:20px;">{{ $staffs[$i]->office_kh }}</span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> {{ $row_num++ }}</td>
                                        <!-- Data Body -->
                                        @include('admin.reports.partials.data_body_position')
                                    </tr>
                                @else
                                    <tr>
                                        <td> {{ $row_num++ }}</td>
                                        <!-- Data Body -->
                                        @include('admin.reports.partials.data_body_position')
                                    </tr>
                                @endif

                            @endif


                            @php
                            $g_workplace = $staffs[$i]->workplace_kh;
                            $g_office = $staffs[$i]->office_kh;
                            @endphp
                            @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(function() {
        $("#reports-page > a").addClass("active");
    });
</script>
@endpush