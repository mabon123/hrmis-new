@extends('layouts.admin')

@push('styles')
<style type="text/css">
    span.sept {
        padding-left: 10px;
        padding-right: 10px;
    }
</style>
@endpush

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('report.staff_short_leaves') }}</h1>
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
                    <li class="breadcrumb-item active">{{ __('report.staff_short_leaves') }}</li>
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
                <a href="{{ route('reports.exportShortLeavePDF', [app()->getLocale(), $pro_code, $dis_code, $location_code, $start_date, $end_date]) }}" class="btn btn-sm btn-info" style="width:220px;" target="_blank">
                    <i class="fas fa-file-pdf"></i> {{ __('button.export_to_pdf') }}
                </a>
            </div>
            <div class="btn-group">
                <a href="{{ route('reports.exportShortLeaveExcel', [app()->getLocale(), $pro_code, $dis_code, $location_code, $start_date, $end_date]) }}" class="btn btn-sm btn-info" style="width:220px;" title="Export to Excel" onclick="loadModalOverlay(true, 2000);">
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
                            <th>ល.រ</th>
                            <th>{{ __('common.payroll_num') }}</th>
                            <th>{{ __('common.name') }}</th>
                            <th>{{ __('common.sex') }}</th>
                            <th>{{ __('common.dob') }}</th>
                            <th>{{ __('common.position') }}</th>
                            <th>{{ __('ចំនួនថ្ងៃសុំច្បាប់') }}</th>
                            <th>{{ __('common.start_date') }}</th>
                            <th>{{ __('common.end_date') }}</th>
                            <th>{{ __('មូលហេតុ') }}</th>
                            <th>{{ __('common.location') }}</th>
                            <th>{{ __('ផ្សេងៗ') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($staffs as $index => $staff)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $staff->payroll_id }}</td>
                            <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                            <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                            <td>{{ date('d-m-Y', strtotime($staff->dob)) }}</td>
                            <td class="kh">
                                {{ $staff->is_cont_staff == 1 ? $staff->contractPosition()->contract_type_kh : $staff->currentPosition()->position_kh }}
                            </td>
                            <td>{{ $staff->days }}</td>
                            <td>{{ date('d-m-Y', strtotime($staff->start_date)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($staff->end_date)) }}</td>
                            <td class="kh">{{ $staff->description }}</td>
                            <td class="kh">{{ !empty($staff->currentWorkPlace()) ? $staff->currentWorkPlace()->location_kh : (!empty($staff->latestWorkPlace()) ? $staff->latestWorkPlace()->location_kh : '---') }}</td>
                            <td></td>
                        </tr>
                        @endforeach
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
        //$("#reports-menu").addClass("menu-open");
        $("#reports-page > a").addClass("active");

    });
</script>
@endpush