@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="far fa-list-alt"></i> {{ __('menu.pending_cpd_offerings_list') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.pending_cpd_offerings_list') }}</li>
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
                    <h3 class="card-title">{{ __('menu.pending_cpd_offerings_list') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('cpd.course') }}</th>
                                <th>{{ __('menu.cpd_provider') }}</th>
                                <th style="text-align: center;">{{ __('cpd.credits') }}</th>
                                <th>{{ __('common.start_date') }}</th>
                                <th>{{ __('common.end_date') }}</th>
                                <th style="text-align: center;">{!! trans('common.participants_planed') !!}</th>
                                <th style="text-align: center;">{!! trans('common.participants_completed') !!}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($offerings as $index => $offering)

                            <tr id="record-{{ $offering->schedule_course_id }}">
                                <td>{{ $offerings->firstItem() + $index }}</td>
                                <td class="kh">
                                    <a href="#" target="_blank" title="View detail">
                                        {{ $offering->cpd_course_kh }}
                                    </a>
                                </td>
                                <td class="kh"> {{ $offering->provider_kh }} </td>
                                <td style="text-align: center;">{{ $offering->credits }}</td>
                                <td>{{ date('d-m-Y', strtotime($offering->start_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($offering->end_date)) }}</td>
                                <td style="text-align: center;">{{ $offering->participant_num }}</td>
                                <td style="text-align: center;">{{ $offering->user_count }}</td>
                                <td class="text-right">
                                    <a href="{{ route('cpd-credits.view-pending-cpd', [app()->getLocale(), $offering->schedule_course_id]) }}" class="btn btn-xs btn-info" title="Edit"><i class="far fa-eye"></i> {{ __('button.view') }}</a>
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    @if($offerings->hasPages())
                    {!! $offerings->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')

<script src="{{ asset('js/delete.handler.js') }}"></script>

<script>
    $(function() {
        $("#cpd-pending-list > a").addClass("active");
    });
</script>

@endpush