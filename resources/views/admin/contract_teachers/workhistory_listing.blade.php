@extends('layouts.admin')

@section('content')
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <i class="fa fa-file"></i> {{ __('menu.contract_teacher_info') }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>
                                {{ __('menu.home') }}</a></li>
                        <li class="breadcrumb-item active">@lang('menu.contract_teacher_info')</li>
                        <li class="breadcrumb-item active">@lang('menu.work_history')</li>
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

        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card card-info card-tabs">
                    <div class="card-header p-0 pt-1">
                        @include('admin.contract_teachers.header_tab')
                    </div>

                    <div class="card-body custom-card">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-personal_details" role="tabpanel" aria-labelledby="custom-tabs-personal_details-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>
                                            <span class="section-num">{{ __('number.num9').'. ' }}</span>
                                            {{ __('menu.work_history') }}
                                        </h6>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                                                <thead>
                                                    <th>#</th>
                                                    <th>@lang('common.current_location')</th>
                                                    <th>@lang('common.contract_type')</th>
                                                    <th>@lang('common.contract_position')</th>
                                                    <th class="text-center">@lang('common.cur_position')</th>
                                                    <th>@lang('common.start_date')</th>
                                                    <th>@lang('common.end_date')</th>
                                                </thead>

                                                <tbody>
                                                    
                                                    @foreach($workHistories as $index => $workHistory)

                                                        <tr>
                                                            <td>{{ $index +  1 }}</td>

                                                            <td class="kh">{{ !empty($workHistory->location) ? $workHistory->location->location_kh : '' }}</td>

                                                            <td class="kh">{{ !empty($workHistory->contractType) ? $workHistory->contractType->contract_type_kh : '' }}</td>

                                                            <td class="kh">{{ !empty($workHistory->contractPosition) ? $workHistory->contractPosition->cont_pos_kh : '' }}</td>

                                                            <td class="text-center">
                                                                @if( $workHistory->cur_pos == 1 )
                                                                    <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                                                @else
                                                                    <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                                                @endif
                                                            </td>

                                                            <td>{{ $workHistory->start_date > 0 ? date('d-m-Y', strtotime($workHistory->start_date)) : '' }}</td>

                                                            <td>{{ $workHistory->end_date > 0 ? date('d-m-Y', strtotime($workHistory->end_date)) : '' }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="7" style="padding-top:0;"><small><u>{{ __('ការវាយតម្លៃប្រចាំឆ្នាំ') }}</u> : {{ $workHistory->annual_eval }}</small></td>
                                                        </tr>

                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>

    </section>

@endsection


@push('scripts')
    
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>

    <script>
        
        $(function() {

            $("#contract-teacher").addClass("menu-open");
            $("#contract-teacher-listing > a").addClass("active");
            $("#tab-workhistory").addClass("active");

        });

    </script>

@endpush
