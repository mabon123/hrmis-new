@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fa fa-file"></i> {{ __('បុគ្គលិកអប់រំទំនេរគ្មានប្រាក់បៀវត្ស') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('បុគ្គលិកអប់រំទំនេរគ្មានប្រាក់បៀវត្ស') }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
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
                            <th>{{ __('common.current_location') }}</th>
                            <th>{{ __('common.description') }}</th>
                            <th>{{ __('common.start_date') }}</th>
                            <th>{{ __('common.end_date') }}</th>
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
                                <td>{{ $staff->surname_en.' '.$staff->name_en }}</td>
                                <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                <td>{{ date('d-m-Y', strtotime($staff->dob)) }}</td>

                                <td class="kh">
                                    {{ !empty($staff->currentWorkPlace()) ? 
                                        $staff->currentWorkPlace()->location_kh : 
                                        (!empty($staff->latestWorkPlace()) ? $staff->latestWorkPlace()->location_kh : '---') }}
                                </td>
                                
                                <td class="kh">{{ $staff->currentWork->description }}</td>
                                <td>{{ $staff->currentWork->start_date > 0 ? date('d-m-Y', strtotime($staff->currentWork->start_date)) : '' }}</td>
                                <td>{{ $staff->currentWork->end_date > 0 ? date('d-m-Y', strtotime($staff->currentWork->end_date)) : '' }}</td>

                                <td class="text-right">
                                    <!-- View -->
                                    <a href="{{ route('staffs.show', [app()->getLocale(), $staff->payroll_id]) }}" class="btn btn-xs btn-success" target="_blank"><i class="far fa-eye"></i> {{ __('button.view') }}</a>

                                    <!-- Edit -->
                                    <a href="{{ route('staffs.edit', [app()->getLocale(), $staff->payroll_id]) }}" class="btn btn-xs btn-info"><i class="far fa-edit"></i> {{ __('button.edit') }}</a>
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
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
@endpush