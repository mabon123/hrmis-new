<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('menu.hrmis_long') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
   
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Moul&family=Moulpali&family=Siemreap&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <style>
        .profile-title{font-family:'Khmer OS Muol Light', Moul !important;width:100%;font-size:17px;margin-bottom:13px;}
        .profile-ministry{font-family:'Khmer OS Muol Light', Moul !important;width:100%;font-size:15px;margin-bottom:13px;}
        .profile-subtitle{font-family:'Khmer OS Muol Light', Moul !important;width:100%;font-size:15px;margin-bottom:25px;}
        span.indent{font-size:14px;padding-left:22px;}
        span.indent-2{font-size:14px;padding-left:35px;}
        .profile-item{margin-bottom:13px;}
        .padding-0{padding-left:0px;padding-right:0px;}
        .table.table-head-fixed thead tr:nth-child(1) th {box-shadow:none;}
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, 
        .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td { border:1px #000000 solid !important; }       
    </style>

    <style type="text/css" media="print">
        /*span.sept { padding-left: 10px; padding-right: 10px; }*/
        @page { size: landscape; }
        @media print {
            td.bg-green {background:#28a745 !important;color:#fff !important;}
            td.bg-red {background:#e36464 !important;color:#fff !important;}
        }
    </style>
</head>

<body class="lang-{{ config('app.locale') }}">
    <div class="container" style="max-width:1530px;">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="row">
                                <h5 class="text-center profile-title" style="margin-bottom:7px; font-size: 16px;">{{ __('ព្រះរាជាណាចក្រកម្ពុជា') }}</h5>
                                <h5 class="text-center profile-title" style="font-size: 15px">{{ __('ជាតិ សាសនា ព្រះមហាក្សត្រ') }}</h5>
                            </div>

                            <div class="row">
                                <h5 class="profile-ministry" style="margin-bottom:7px; font-size: 15px;">{{ $userWorkplace->location_kh }}</h5>
                                <h5 class="" style="margin-bottom:8px; font-size: 15px;">
                                    {{ __('ឈ្មោះគ្រូបន្ទុកថ្នាក់៖ ') }}
                                    <strong>
                                    @if (!empty($tgrade->staff))
                                        {{ $tgrade->staff->sex == 1 ? 'លោកគ្រូ ' : 'អ្នកគ្រូ ' }}
                                        {{ $tgrade->staff->surname_kh.' '.$tgrade->staff->name_kh }}
                                    @endif
                                    </strong>
                                </h5>
                            </div>

                            <div class="row">
                                <h5 class="text-center profile-subtitle" style="margin-bottom:7px;">
                                    {{ __('កាលវិភាគសិស្ស ') . $tgrade->grade->grade_kh . $tgrade->grade_name }}
                                    {{ __('សម្រាប់ឆ្នាំសិក្សា ') . $curAcademicYear->year_kh }}
                                </h5>
                            </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped table-head-fixed text-nowrap" style="">
                                        <thead>
                                            <tr>
                                                <th>{{ __('timetables.hour') }}</th>
                                                @foreach ($tdays as $day)
                                                    <th class="kh" style="width:210px;">{{ $day->day_kh }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($thours as $h_index => $hour)
                                                <tr>
                                                    <td class="kh">{{ $hour->hour_kh }}</td>

                                                    @foreach ($timetables[$h_index] as $timetable)
                                                        <td>
                                                            @if ($timetable)
                                                                {{ 
                                                                    (!empty($timetable->teacherSubject) ? $timetable->teacherSubject->staff->surname_kh : '') . ' ' .
                                                                    (!empty($timetable->teacherSubject) ? $timetable->teacherSubject->staff->name_kh : '') . '('  . 
                                                                    (!empty($timetable->teacherSubject) ? $timetable->teacherSubject->staff->phone : '') . ') - '  .
                                                                    (!empty($timetable->teacherSubject) ? $timetable->teacherSubject->teacher_subject : '')
                                                                }}
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>

                                                <!-- Breaktime -->
                                                @if ($loop->index == 4)
                                                    <tr>
                                                        <td class="kh text-center bg-danger bg-red" colspan="7">{{ __('timetables.break_time') }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row" style="margin-top:0px;">
                                <div class="col align-self-start" style="margin-top: 10px;">
                                   <!-- <p class="text-right">ថ្ងៃ.................ខែ.............ឆ្នាំ.............ព.ស ២៥.......</p>-->
                                    <p class="text-right">...........................,ថ្ងៃទី..........ខែ.............ឆ្នាំ...............</p>
                                    <h5 class="profile-ministry text-center">ប្រធានអង្គភាព</h5>
                                </div>
                                <div class="col align-self-center" ></div>
                                <div class="col align-self-end" style="margin-bottom: 10px;">
                                   <!-- <p class="text-right">ថ្ងៃ.................ខែ.............ឆ្នាំ..............ព.ស ២៥.......</p>-->
                                    <p class="text-right">...........................,ថ្ងៃទី..........ខែ.............ឆ្នាំ...............</p>
                                    <h5 class="profile-ministry text-center">គ្រូបន្ទុកថ្នាក់</h5>
                                </div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="main-footer text-sm text-center d-print-none" style="margin-left:0;">
        Ministry of Education, Youth and Sport | #80, Norodom Blvd. Phnom Penh, Kingdom of Cambodia.
        <strong><a href="#">CPD Management Office</a>.</strong>
    </footer>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript"> $(function() { //window.print(); }); </script>
</body>

</html>
