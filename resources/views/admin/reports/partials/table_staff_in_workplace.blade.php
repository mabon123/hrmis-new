@extends('layouts.admin')

@push('styles')
   <style>
        table{font-family:'Khmer OS Siemreap',Moul;font-size:13px;font-weight:normal;}
        .table thead>tr>th,.table tbody>tr>th,.table tfoot>tr>th,.table{border:1px solid #2980B9 !important; }
        th, td {vertical-align:middle!important;padding:6px!important;}
        td{font-family:'Khmer OS Siemreap',Moul;font-size:12px!important;}
    </style>
@endpush

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('report.schoolreport') }}</h1>
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
                    <li class="breadcrumb-item active">{{ __('report.schoolreport') }}</li>
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
             <!--    <a href="{{ route('reports.exportStaffOnePageOneWorkplacePDF', 
                    [app()->getLocale(), $pro_code, $dis_code, $location_code]) }}" 
                    class="btn btn-sm btn-info" style="width:220px;" target="_blank">
                    <i class="fas fa-file-pdf"></i> {{ __('button.export_to_pdf') }}
                </a>-->
        </div>
        <div class="btn-group">
            <!--    <a href="{{ route('reports.exportAllStaffExcel', 
                    [app()->getLocale(), $pro_code, $dis_code, $location_code]) }}" 
                    class="btn btn-sm btn-info" style="width:220px;" title="Export to Excel" 
                    onclick="loadModalOverlay(true, 2000);">
                    <i class="far fa-file-excel"></i> {{ __('button.export_to_excel') }}
                </a>-->
        </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table> 
                    @php
                    $total_records = count($staffs);                    
                    @endphp
                        <tr style="border: 1px solid black">
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('#') }} </span></th>
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('school.id') }} </span></th>
                            <th rowspan="2"  style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('common.work_place') }} </span></th>                            
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('common.province') }} </span></th>
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('common.district') }} </span></th>
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('common.commune') }} </span></th>
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ប្រភេទតំបន់') }} </span></th>
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្ថានភាពតំបន់') }} </span></th>
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ចំ.បុគ្គលិក') }} </span></th>
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ចំ.កិច្ចសន្យា') }} </span></th>
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ចំ.បង្រៀន') }} </span></th>
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ចំ.មិនបង្រៀន') }} </span></th>
                            <th rowspan="2" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ភាគរយ.បង្រៀន') }} </span></th>
                            <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('មត្តេយ្យ ') }} </span></th>
                             <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី១ ') }} </span></th>
                             <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី២ ') }} </span></th>
                             <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី៣ ') }} </span></th>
                             <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី៤ ') }} </span></th>
                             <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី៥ ') }} </span></th>
                             <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី៦ ') }} </span></th>
                             <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ពន្លឺនឆ្នាំទី១ ') }} </span></th>
                             <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ពន្លឺនឆ្នាំទី២ ') }} </span></th>
                             <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ពន្លឺនឆ្នាំទី៣ ') }} </span></th>
                            <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី៧ ') }} </span></th>
                            <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី៨ ') }} </span></th>
                            <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី៩ ') }} </span></th>
                            <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី១០ ') }} </span></th>
                            <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី១១ ') }} </span></th>
                            <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់ទី១២ ') }} </span></th> 
                            <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ឆ្នាំសិក្សាទី១ ') }} </span></th>     
                            <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ឆ្នាំសិក្សាទី២ ') }} </span></th> 
                            <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ឆ្នាំសិក្សាទី៣ ') }} </span></th> 
                            <th colspan="3" style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សរុបរួម') }} </span></th> 
                        </tr>
                        <tr style="border: 1px solid black">
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                             <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('សិស្ស') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ស្រី') }} </span></th>
                            <th style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ __('ថ្នាក់') }} </span></th>
                        </tr>
                        @for ($i=0; $i < $total_records; $i++) 
                        <tr style="border: 1px solid black;">
                            <td>{{ $i+1 }}</td>
                            @include('admin.reports.partials.data_workplace_school_infor')
                        </tr>      
                    @endfor
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

    // Academic year event
    $('#academic_year').change(function() {
        $('#btn-search-staff').trigger('click');
    });
});
</script>
@endpush