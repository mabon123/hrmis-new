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
                <h1 class="text-center">{{ __('report.staff_in_Timetable') }}</h1>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            @include('admin.reports.partials.table_staff_in_workplace')
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
