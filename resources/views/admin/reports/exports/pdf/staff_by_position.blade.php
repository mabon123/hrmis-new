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
                <h1 class="text-center">{{ __('report.staff_by_positions') }}</h1>

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
                                    $no_teaching_icon = '<i class="fas fa-times-circle danger"></i>';
                                @endphp

                                <tbody>
                                    @for ($i=0; $i < $total_records; $i++) 
                                        @if($i == $total_records - 1)
                                            <tr>
                                                <td colspan="9">
                                                    <!-- Data Summary -->
                                                    @include('admin.reports.partials.data_summary_pos')
                                                </td>
                                            </tr>
                                        @else
                                            @if ($g_workplace !=$staffs[$i]->workplace_kh)
                                                <tr style="background-color: #cdcdcd">
                                                    <td class="kh" colspan="9">
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
                                                    <td class="kh" colspan="9">
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
