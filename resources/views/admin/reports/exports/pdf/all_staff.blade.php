<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('menu.hrmis_long')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Moul&family=Moulpali&family=Siemreap&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <style type="text/css" media="print">
        span.sept { padding-left: 10px; padding-right: 10px; }
        /*@page { size: landscape; }*/
    </style>
</head>

<body class="custom-body hold-transition sidebar-mini layout-navbar-fixed lang-{{ config('app.locale') == 'en' ? 'en' : 'kh' }} sidebar-collapse">
    <div class="wrapper_none">
        <div class="content-wrapper" style="margin-left:0px !important;padding-top: 10px !important;">
            <section class="content">
                <h1 class="text-center">{{ __('report.staff_information') }}</h1>

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
                                        <th>{{ __('ក្របខណ្ឌ') }}</th>
                                        <th>{{ __('common.position') }}</th>
                                        <th>{{ __('common.qualification') }}</th>
                                        <th>{{ __('common.start_date') }}</th>
                                        <th>{{ __('common.current_status') }}</th>
                                        <th class="text-center">{{ __('common.teaching') }}</th>
                                    </tr>
                                </thead>

                                @php
                                $g_workplace = '';$g_office = '';$row_num = 1; $total_records = count($staffs);
                                $total_staff = 0; $female_staff = 0; $teachings = 0; $non_teachings = 0;
                                $leave_no_pay = 0; $con_leave_no_pay = 0; $off_duty = 0;$con_study = 0;
                                $is_teaching_icon = '<i class="fas fa-check-square success"></i>';
                                $no_teaching_icon = '<i class="fas fa-times-circle danger"></i>';
                                $colspan = 12;
                                @endphp
                                <tbody>
                                    @for ($i=0; $i < $total_records; $i++) 
                                        @if($i > 0 && $staffs[$i]->location_code != $staffs[$i-1]->location_code)
                                            <tr>
                                                <td colspan="{{ $colspan }}">
                                                    @include('admin.reports.partials.data_header')
                                                </td>
                                            </tr>
                                            @php
                                                $total_staff = 1; 
                                                $female_staff = $staffs[$i]->sex != 1 ? 1 : 0; 
                                                $teachings = !empty($staffs[$i]->grade_id) ? 1 : 0; 
                                                $non_teachings = empty($staffs[$i]->grade_id) ? 1: 0;
                                                $leave_no_pay = $staffs[$i]->status_id == 2 ? 1 : 0; 
                                                $con_leave_no_pay = $staffs[$i]->status_id == 7 ? 1 : 0; 
                                                $off_duty = $staffs[$i]->status_id == 8 ? 1 : 0;
                                                $con_study = $staffs[$i]->status_id == 10 ? 1: 0;
                                            @endphp
                                        @else
                                            @php $total_staff ++; @endphp
                                            @if($staffs[$i]->sex != 1)
                                                @php $female_staff += 1; @endphp
                                            @endif

                                            @if(!empty($staffs[$i]->grade_id))
                                                @php $teachings += 1;@endphp
                                            @else
                                                @php $non_teachings += 1;@endphp
                                            @endif
                                            
                                            @if($staffs[$i]->status_id == 2)
                                                @php $leave_no_pay += 1;@endphp
                                            @elseif($staffs[$i]->status_id == 7)
                                                @php $con_leave_no_pay += 1;@endphp
                                            @elseif($staffs[$i]->status_id == 8)
                                                @php $off_duty += 1;@endphp
                                            @elseif($staffs[$i]->status_id == 10)
                                                @php $con_study += 1;@endphp
                                            @endif
                                        @endif

                                        @if ($g_workplace !=$staffs[$i]->workplace_kh)
                                            <tr style="background-color: #cdcdcd">
                                                <td class="kh" colspan="{{ $colspan }}">
                                                    <!-- Data Workplace -->
                                                    @include('admin.reports.partials.data_workplace')
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> {{ $row_num++ }}</td>
                                                @include('admin.reports.partials.data_body')
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
                                                @include('admin.reports.partials.data_body')
                                            </tr>
                                        @else
                                            <tr>
                                                <td> {{ $row_num++ }}</td>
                                                @include('admin.reports.partials.data_body')
                                            </tr>
                                        @endif

                                        @if($i == $total_records - 1)
                                            <tr>
                                                <td colspan="{{ $colspan }}">
                                                    @include('admin.reports.partials.data_header')
                                                </td>
                                            </tr>
                                            @php
                                                $total_staff = 0; $female_staff = 0; $teachings = 0; $non_teachings = 0;
                                                $leave_no_pay = 0; $con_leave_no_pay = 0; $off_duty = 0;$con_study = 0;
                                            @endphp

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
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script>
        $(function() {
            window.print();
        });
    </script>
</body>

</html>
