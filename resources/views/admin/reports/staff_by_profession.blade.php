@extends('layouts.admin')

@push('styles')
<style>
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
                <h1>{{ __('report.staff_by_profession') }}</h1>
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
                    <li class="breadcrumb-item active">{{ __('report.staff_by_profession') }}</li>
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
                <a href="{{ route('reports.exportStaffbyProfessionPDF', 
                    [app()->getLocale(), $pro_code, $dis_code, $location_code]) }}" 
                    class="btn btn-sm btn-info" style="width:220px;" target="_blank">
                    <i class="fas fa-file-pdf"></i> {{ __('button.export_to_pdf') }}
                </a>
            </div>
            <div class="btn-group">
                <a href="{{ route('reports.exportStaffbyProfessionExcel', 
                    [app()->getLocale(), $pro_code, $dis_code, $location_code]) }}" 
                    class="btn btn-sm btn-info" style="width:220px;" title="Export to Excel" 
                    onclick="loadModalOverlay(true, 2000);">
                    <i class="far fa-file-excel"></i> {{ __('button.export_to_excel') }}
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                @include('admin.reports.partials.table_staff_by_profession')
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