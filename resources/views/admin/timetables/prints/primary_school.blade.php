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
        .profile-title{font-family:'Khmer OS Muol Light', Moul !important;width:100%;font-size:20px;margin-bottom:15px;}
        .profile-ministry{font-family:'Khmer OS Muol Light', Moul !important;width:100%;font-size:16px;margin-bottom:15px;}
        .profile-subtitle{font-family:'Khmer OS Muol Light', Moul !important;width:100%;font-size:16px;margin-bottom:25px;}
        span.indent{font-size:16px;padding-left:22px;}
        span.indent-2{font-size:16px;padding-left:35px;}
        .profile-item{margin-bottom:15px;}
        .padding-0{padding-left:0px;padding-right:0px;}
        .table.table-head-fixed thead tr:nth-child(1) th {box-shadow:none;}
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, 
        .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td { border:1px #000000 solid !important; }
    </style>

    <style type="text/css" media="print">
        @page { size: landscape; }
        @media print {
            td.bg-green {background:#28a745 !important;color:#fff !important;}
            td.bg-red {background:#e36464 !important;color:#fff !important;}
            .pagebreak { page-break-before: always; }
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
                                <h5 class="text-center profile-title">{{ __('ព្រះរាជាណាចក្រកម្ពុជា') }}</h5>
                                <h5 class="text-center profile-title">{{ __('ជាតិ សាសនា ព្រះមហាក្សត្រ') }}</h5>
                            </div>

                            <div class="row">
                                <h5 class="profile-ministry" style="margin-bottom:8px;">
                                    {{ __('រដ្ឋបាលស្រុក') }} 
                                    {{ !empty($userWorkplace->district) ? $userWorkplace->district->name_kh : '' }}</h5>
                                <h5 class="profile-ministry" style="margin-bottom:8px;">ការិយាល័យអប់រំយុវជន និងកីឡា</h5>
                                <h5 class="profile-ministry">{{ __('កម្រង') }} {{ !empty($schoolMaster) ? $schoolMaster->location_kh : '' }}</h5>
                            </div>

                            <!-- Morning -->
                            <div class="row">
                                <h5 class="text-center profile-subtitle" style="margin-bottom:8px;">{{ __('កាលវិភាគប្រចាំសប្តាហ៍') }}</h5>
                                <h5 class="text-center profile-subtitle">
                                    {{ $grade_level == '13' ? __('timetables.grade_1_to_3') : __('timetables.grade_4_to_6') }}
                                    {{ __('ឆ្នាំសិក្សា') . $academicYear->year_kh }}
                                    {{ __('(វេនព្រឹក)') }}</h5>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-center">{{ __('timetables.hour') }}</th>

                                                @foreach ($tdays as $day)
                                                    <th class="text-center kh" style="width:210px;">{{ $day->day_kh }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($thours as $h_index => $thour)
                                                <tr>
                                                    <td class="kh">{{ $thour->hour_kh }}</td>

                                                    @if ($h_index == 0)
                                                        <td class="text-center bg-green" colspan="6" style="background:#28a745;color:#fff;">{{ __('គោរពទង់ជាតិ') }}</td>

                                                    @elseif ($h_index == 3 || $h_index == 5)
                                                        <td class="text-center bg-red" colspan="3" style="background:#e36464;color:#fff;">{{ __('timetables.break_time') }}</td>
                                                        <td class="text-center bg-red" colspan="2" style="background:#e36464;color:#fff;">{{ __('timetables.break_time') }}</td>

                                                    @else
                                                        @foreach ($tdays as $d_index => $tday)
                                                            @if ($tday->day_id < 7)
                                                                @php $slot =  $morningTimetables[$h_index][$d_index]; @endphp

                                                                @if ($h_index == 1 && $d_index == 3)
                                                                    <td class="text-center" rowspan="7" style="vertical-align:middle;font-family:'Moul', 'Arial';">
                                                                        {{ __('បំប៉នបន្ថែម') }}</td>
                                                                
                                                                @elseif ($d_index != 3)
                                                                    <td class="text-center">{{ !empty($slot) ? $slot->subject_kh : '' }}</td>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="pagebreak"></div>

                            <!-- Afternoon -->
                            <div class="row" style="margin-top:30px;">
                                <h5 class="text-center profile-subtitle" style="margin-bottom:8px;line-height:30px;">{{ __('កាលវិភាគប្រចាំសប្តាហ៍') }}</h5>
                                <h5 class="text-center profile-subtitle">
                                    {{ $grade_level == '13' ? __('timetables.grade_1_to_3') : __('timetables.grade_4_to_6') }}
                                    {{ __('ឆ្នាំសិក្សា') . $academicYear->year_kh }}
                                    {{ __('(វេនរសៀល)') }}</h5>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-center">{{ __('timetables.hour') }}</th>

                                                @foreach ($tdays as $day)
                                                    <th class="text-center kh" style="width:210px;">{{ $day->day_kh }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($ahours as $ah_index => $thour)
                                                <tr>
                                                    <td class="kh">{{ $thour->hour_kh }}</td>

                                                    @if ($ah_index == 7)
                                                        <td class="text-center bg-green" colspan="6" style="background:#28a745;color:#fff;">{{ __('គោរពទង់ជាតិ') }}</td>

                                                    @elseif ($ah_index == 2 || $ah_index == 4)
                                                        <td class="text-center bg-red" colspan="3" style="background:#e36464;color:#fff;">{{ __('timetables.break_time') }}</td>
                                                        <td class="text-center bg-red" colspan="2" style="background:#e36464;color:#fff;">{{ __('timetables.break_time') }}</td>

                                                    @else
                                                        @foreach ($tdays as $d_index => $tday)
                                                            @php $slot =  $afternoonTimetables[$ah_index][$d_index]; @endphp

                                                            @if ($ah_index == 0 && $d_index == 3)
                                                                <td class="text-center" rowspan="7" style="vertical-align:middle;font-family:'Moul', 'Arial';">
                                                                    {{ __('បំប៉នបន្ថែម') }}</td>
                                                            
                                                            @elseif ($d_index != 3)
                                                                <td class="text-center">{{ !empty($slot) ? $slot->subject_kh : '' }}</td>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row" style="margin-top:30px;">
                                <div class="col align-self-start" style="margin-top: 60px;"></div>
                                <div class="col align-self-center"></div>
                                <div class="col align-self-end">
                                    <p class="text-right">ថ្ងៃ.................ខែ............ឆ្នាំ..............ព.ស ២៥.......</p>
                                    <p class="text-right">...........................,ថ្ងៃទី..........ខែ.............ឆ្នាំ...............</p>
                                    <h5 class="profile-ministry text-center" style="font-size:14px;">ប្រធានកម្រង</h5>
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
