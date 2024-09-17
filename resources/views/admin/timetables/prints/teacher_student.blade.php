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
        /*span.sept { padding-left: 10px; padding-right: 10px; }*/
        @page { size: landscape; }
        @media print {
            td.bg-green {background:#28a745 !important;color:#fff !important;}
            td.bg-red {background:#e36464 !important;color:#fff !important;}
        }
    </style>
</head>

<body class="lang-{{ config('app.locale') }}">
    <div class="container" style="width:100%;max-width:100%;">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="row">
                                <h5 class="text-center profile-title" style="margin-bottom:8px;font-size: 13px;">{{ __('ព្រះរាជាណាចក្រកម្ពុជា') }}</h5>
                                <h5 class="text-center profile-title" style="font-size: 12px;">{{ __('ជាតិ សាសនា ព្រះមហាក្សត្រ') }}</h5>
                            </div>

                            <div class="row">
                                <h5 class="profile-ministry" style="margin-bottom:8px;font-size: 12px;">{{ $userWorkplace->location_kh }}</h5>
                            </div>

                            <div class="row">
                                <h5 class="text-center profile-subtitle" style="margin-bottom:8px;font-size: 12px;">
                                    {{ __('កាលវិភាគរួមគ្រូ-សិស្សប្រចាំសប្តាហ៍ក្នុងឆ្នាំសិក្សា ') . $academicYear->year_kh }}
                                </h5>
                            </div>

                            @php $shifts = ['ព្រឹក', 'រសៀល']; @endphp

                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped table-head-fixed text-nowrap" style="font-size: 11px" border="5" bordercolor="#000000">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">{{ __('លរ') }}</th>
                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">{{ __('ថ្នាក់') }}</th>
                                                @foreach ($tdays as $day)
                                                    <th class="text-center" colspan="10">{{ $day->day_kh }}</th>
                                                @endforeach
                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">{{ __('ចំនួន') }}</br>{{ __('ម៉ោង') }}</th>
                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">{{ __('គ្រូទទួលបន្ទុក') }}</th>
                                            </tr>

                                            <tr>
                                                @foreach ($tdays as $day)
                                                    <th class="text-center" colspan="5">{{ $shifts[0] }}</th>
                                                    <th class="text-center" colspan="5">{{ $shifts[1] }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        
                                        <tbody >
                                            @foreach ($grades as $g_index => $tgrade)
                                                <tr style="font-size: 10px;">
                                                    <td class="text-center" style="font-size: 11px; text-align: left;">{{ $g_index + 1 }}</td>
                                                    <td class="text-center" style="font-size: 11px; text-align: left;">
                                                        {{ !empty($tgrade->grade) ? ($tgrade->grade->grade_kh.''.$tgrade->grade_name) : '' }}
                                                    </td>

                                                    @php $totalHour = 0; @endphp

                                                    @foreach ($tdays as $d_index => $tday)
                                                        @foreach ($thours as $h_index => $thour)
                                                            @php $timetableData = $timetables[$g_index][$d_index][$h_index]; @endphp

                                                            <td class="text-center" style="width:30px;padding-left:1px;padding-right:1px; font-size: 11px;">
                                                                @if (!empty($timetableData))
                                                                    {{ $timetableData->teacher_subject }}

                                                                    @php $totalHour += 1; @endphp
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    @endforeach

                                                    <td class="text-center" style="font-size: 11px; text-align: left;">{{ $totalHour > 0 ? $totalHour : '' }}</td>
                                                    <td class="text-center" style="font-size: 11px; text-align: left;">
                                                        {{ !empty($tgrade->staff) ? ($tgrade->staff->surname_kh.' '.$tgrade->staff->name_kh) : '' }}
                                                    </td>
                                                </tr>
                                                @php $totalHour = 0; @endphp
                                            @endforeach
                                            
                                        </tbody>
                                    </table>

                                    <div class="row" style="margin-top:0px;">
                                        <div class="col align-self-start" style="margin-top:30px;"></div>
                                        <div class="col align-self-center" ></div>
                                        <div class="col align-self-end" style="margin-bottom:0px;">
                                            <p class="text-right">ថ្ងៃ.................ខែ.............ឆ្នាំ..............ព.ស ២៥.......</p>
                                            <p class="text-right">...........................,ថ្ងៃទី..........ខែ.............ឆ្នាំ...............</p>
                                            <h5 class="profile-ministry text-right" style="font-size:12px;padding-right:100px;">{{ __('នាយកសាលា') }}</h5>
                                        </div>
                                    </div>       
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
